"""
Analyzes a single fire-report photo for the Verifyre metadata validation panel.

Usage:
    python analyze_photo.py <absolute_path_to_image>

Prints one JSON object to stdout. Never raises - on any failure it still
prints a JSON object with an "error" key, so the calling PHP process always
gets parseable output.

What this does and does not claim to do:
- exifread: reads real embedded EXIF tags (camera make/model, original
  capture datetime, GPS lat/lng) IF the image file actually has them.
  Canvas-captured screenshots typically have none of these - that's
  reported honestly as null/empty, not guessed.
- OpenCV + numpy: runs on the actual pixel data regardless of EXIF
  presence. This gives a blur estimate (Laplacian variance) and a
  "warm color ratio" (rough proportion of red/orange/yellow pixels).
  The warm color ratio is a basic heuristic, not real fire detection -
  it's reported as supporting/informational data, not a verdict.
"""

import sys
import json
import datetime

import numpy as np
import cv2
import exifread


def parse_exif(file_path):
    """Returns (exif_dict, datetime_original, gps_dict) - all may be empty/None."""
    exif_dict = {}
    datetime_original = None
    gps = None

    try:
        with open(file_path, "rb") as f:
            tags = exifread.process_file(f, details=False)
    except Exception as e:
        return exif_dict, datetime_original, gps, str(e)

    for key, value in tags.items():
        exif_dict[str(key)] = str(value)

    raw_dt = tags.get("EXIF DateTimeOriginal") or tags.get("Image DateTime")
    if raw_dt:
        try:
            datetime_original = datetime.datetime.strptime(
                str(raw_dt), "%Y:%m:%d %H:%M:%S"
            ).isoformat()
        except ValueError:
            datetime_original = None

    lat_tag = tags.get("GPS GPSLatitude")
    lng_tag = tags.get("GPS GPSLongitude")
    lat_ref = tags.get("GPS GPSLatitudeRef")
    lng_ref = tags.get("GPS GPSLongitudeRef")

    if lat_tag and lng_tag and lat_ref and lng_ref:
        try:
            lat = dms_to_decimal(lat_tag.values, str(lat_ref))
            lng = dms_to_decimal(lng_tag.values, str(lng_ref))
            gps = {"lat": lat, "lng": lng}
        except Exception:
            gps = None

    return exif_dict, datetime_original, gps, None


def dms_to_decimal(dms_values, ref):
    """Converts an EXIF [deg, min, sec] Ratio triple to a signed decimal degree."""
    parts = np.array([float(v.num) / float(v.den) for v in dms_values], dtype=np.float64)
    weights = np.array([1.0, 1.0 / 60.0, 1.0 / 3600.0], dtype=np.float64)
    decimal = float(np.dot(parts, weights))

    if ref in ("S", "W"):
        decimal = -decimal

    return round(decimal, 7)


def analyze_image(file_path):
    """Runs OpenCV-based checks on the raw pixel data. Returns a dict."""
    img = cv2.imread(file_path)

    if img is None:
        return {"is_valid": False, "width": None, "height": None,
                "blur_score": None, "is_blurry": None, "warm_color_ratio": None}

    height, width = img.shape[:2]

    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    blur_score = float(cv2.Laplacian(gray, cv2.CV_64F).var())
    is_blurry = bool(blur_score < 50.0)

    hsv = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)
    h, s, v = hsv[:, :, 0], hsv[:, :, 1], hsv[:, :, 2]

    warm_mask = (
        (((h <= 30) | (h >= 170)) & (s > 80) & (v > 80))
    )
    warm_color_ratio = float(np.count_nonzero(warm_mask)) / float(warm_mask.size)

    return {
        "is_valid": True,
        "width": int(width),
        "height": int(height),
        "blur_score": round(blur_score, 2),
        "is_blurry": is_blurry,
        "warm_color_ratio": round(warm_color_ratio, 4),
    }


def main():
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No file path provided"}))
        return

    file_path = sys.argv[1]
    result = {
        "exif": {},
        "datetime_original": None,
        "gps": None,
        "image": None,
        "error": None,
    }

    exif_dict, datetime_original, gps, exif_error = parse_exif(file_path)
    result["exif"] = exif_dict
    result["datetime_original"] = datetime_original
    result["gps"] = gps
    if exif_error:
        result["error"] = f"EXIF read failed: {exif_error}"

    try:
        result["image"] = analyze_image(file_path)
    except Exception as e:
        result["image"] = {"is_valid": False, "width": None, "height": None,
                            "blur_score": None, "is_blurry": None, "warm_color_ratio": None}
        result["error"] = (result["error"] or "") + f" | OpenCV analysis failed: {e}"

    print(json.dumps(result))


if __name__ == "__main__":
    main()
