@extends('layouts.app')
@section('title', 'Education')

@section('content')
<section class="vf-section vf-edu">
    <div class="vf-edu-header">
        <span class="vf-edu-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M12 2c1 3-3 4-3 8a3 3 0 0 0 6 0c0-1-1-2-1-2 1 0 3 2 3 5a5 5 0 0 1-10 0c0-5 4-6 5-11z"/></svg>
            Fire Safety 101
        </span>
        <h1>Fire Safety Education</h1>
        <p>Know what to do before, during, and after a fire. Tap any section below to expand it.</p>
    </div>

    <details class="vf-edu-feature" open>
        <summary>
            <span class="vf-edu-feature__num">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M12 2c1 3-3 4-3 8a3 3 0 0 0 6 0c0-1-1-2-1-2 1 0 3 2 3 5a5 5 0 0 1-10 0c0-5 4-6 5-11z"/></svg>
            </span>
            <span class="vf-edu-feature__title">What to do when there is a fire</span>
            <span class="vf-edu-chevron">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M6 9l6 6 6-6"/></svg>
            </span>
        </summary>
        <div class="vf-edu-feature__body">
            <ol class="vf-edu-list">
                <li>Stay calm and alert others immediately by shouting "Fire!" or activating a fire alarm.</li>
                <li>Evacuate right away through the nearest exit. Never use elevators during a fire.</li>
                <li>If there is smoke, stay low and crawl beneath it &mdash; cleaner air is near the floor.</li>
                <li>Close doors behind you as you leave to help slow the fire's spread.</li>
                <li>Once outside and safe, call <strong>911</strong> or your local Bureau of Fire Protection (BFP) station.</li>
                <li>If you're trapped, stay near a window, signal for help, and seal door gaps with cloth to block smoke.</li>
                <li>Never go back inside for belongings &mdash; wait for firefighters to confirm it's safe.</li>
            </ol>
        </div>
    </details>

    <div class="vf-edu-grid">

        <details class="vf-edu-box vf-edu-box--gold">
            <summary>
                <span class="vf-edu-box__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
                </span>
                <span class="vf-edu-box__title">Fire Prevention Tips</span>
                <span class="vf-edu-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M6 9l6 6 6-6"/></svg>
                </span>
            </summary>
            <div class="vf-edu-box__body">
                <ul class="vf-edu-list">
                    <li>Avoid overloading electrical outlets or using makeshift "octopus" wiring connections.</li>
                    <li>Turn off and unplug appliances when they're not in use.</li>
                    <li>Never leave cooking unattended on the stove.</li>
                    <li>Keep flammable materials (rags, paper, gas containers) away from heat sources.</li>
                    <li>Install smoke detectors and test them regularly.</li>
                    <li>Keep a fire extinguisher accessible and make sure your household knows how to use it.</li>
                </ul>
            </div>
        </details>

        <details class="vf-edu-box vf-edu-box--ember">
            <summary>
                <span class="vf-edu-box__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M8 4h6l-1 2H9l-1-2z"/><rect x="9" y="6" width="6" height="3" rx="1"/><path d="M9 9h6l1 11a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2L9 9z"/><path d="M15 9l5-3"/><path d="M17.5 7.5l1 2"/></svg>
                </span>
                <span class="vf-edu-box__title">Using a Fire Extinguisher (PASS Method)</span>
                <span class="vf-edu-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M6 9l6 6 6-6"/></svg>
                </span>
            </summary>
            <div class="vf-edu-box__body">
                <ul class="vf-edu-list">
                    <li><strong>Pull</strong> the safety pin.</li>
                    <li><strong>Aim</strong> the nozzle at the base of the fire, not the flames.</li>
                    <li><strong>Squeeze</strong> the handle slowly and evenly.</li>
                    <li><strong>Sweep</strong> side to side until the fire is out.</li>
                    <li>Only attempt this on small, contained fires &mdash; evacuate if it's spreading.</li>
                </ul>
            </div>
        </details>

        <details class="vf-edu-box vf-edu-box--crimson">
            <summary>
                <span class="vf-edu-box__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M12 4l9 16H3L12 4z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg>
                </span>
                <span class="vf-edu-box__title">Common Causes of Fire</span>
                <span class="vf-edu-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M6 9l6 6 6-6"/></svg>
                </span>
            </summary>
            <div class="vf-edu-box__body">
                <ul class="vf-edu-list">
                    <li>Faulty electrical wiring or overloaded circuits.</li>
                    <li>Unattended cooking equipment.</li>
                    <li>Carelessly discarded cigarettes or other smoking materials.</li>
                    <li>Unattended candles or other open flames.</li>
                    <li>Improper storage or handling of flammable liquids and gas.</li>
                </ul>
            </div>
        </details>

        <details class="vf-edu-box vf-edu-box--maroon">
            <summary>
                <span class="vf-edu-box__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/><path d="M9 20v-6h6v6"/></svg>
                </span>
                <span class="vf-edu-box__title">Creating a Home Fire Escape Plan</span>
                <span class="vf-edu-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M6 9l6 6 6-6"/></svg>
                </span>
            </summary>
            <div class="vf-edu-box__body">
                <ul class="vf-edu-list">
                    <li>Identify at least two ways out of every room.</li>
                    <li>Agree on a meeting point outside, a safe distance from the house.</li>
                    <li>Practice the escape plan with everyone in the household, including children.</li>
                    <li>Keep exits, hallways, and stairwells clear and unlocked at all times.</li>
                </ul>
            </div>
        </details>

        <details class="vf-edu-box vf-edu-box--rust">
            <summary>
                <span class="vf-edu-box__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><rect x="6" y="4" width="12" height="17" rx="2"/><path d="M9 4V3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1"/><path d="M9 13l2 2 4-4"/></svg>
                </span>
                <span class="vf-edu-box__title">After a Fire</span>
                <span class="vf-edu-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M6 9l6 6 6-6"/></svg>
                </span>
            </summary>
            <div class="vf-edu-box__body">
                <ul class="vf-edu-list">
                    <li>Do not re-enter the building until firefighters confirm it's safe.</li>
                    <li>Report the incident to your barangay and the nearest BFP station if you haven't already.</li>
                    <li>Document damage with photos for insurance and official reports.</li>
                    <li>Have an electrician and structural inspection done before resuming normal use of the property.</li>
                </ul>
            </div>
        </details>

        <details class="vf-edu-box vf-edu-box--coral">
            <summary>
                <span class="vf-edu-box__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><circle cx="12" cy="12" r="9"/><path d="M5.5 5.5l13 13"/></svg>
                </span>
                <span class="vf-edu-box__title">Fire Safety Mistakes to Avoid</span>
                <span class="vf-edu-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M6 9l6 6 6-6"/></svg>
                </span>
            </summary>
            <div class="vf-edu-box__body">
                <ul class="vf-edu-list">
                    <li>Don't use water on electrical or grease/oil fires &mdash; it can spread the fire or cause electrocution.</li>
                    <li>Don't hide in a closet or bathroom instead of evacuating.</li>
                    <li>Don't ignore a smoke detector's low-battery chirp &mdash; replace batteries right away.</li>
                    <li>Don't block fire exits, stairwells, or hallways with furniture or storage.</li>
                    <li>Don't attempt to fight a large or spreading fire alone &mdash; evacuate and call for help instead.</li>
                </ul>
            </div>
        </details>

    </div>
</section>
@endsection

@push('styles')
<style>
    .vf-edu-feature,
    .vf-edu-box {
        border-radius: var(--vf-radius);
        box-shadow: var(--vf-shadow-sm);
        overflow: hidden;
        transition: box-shadow 0.25s ease, transform 0.25s ease, background 0.25s ease;
    }

    .vf-edu-feature {
        margin-bottom: 32px;
        background: linear-gradient(135deg, #fff 55%, var(--vf-red-tint) 100%);
        border: 1px solid var(--vf-line);
        border-top: 5px solid var(--vf-red);
    }

    .vf-edu-feature:hover {
        box-shadow: 0 14px 30px rgba(229, 57, 53, 0.22);
        transform: translateY(-2px);
    }

    .vf-edu-box:hover {
        box-shadow: 0 14px 28px color-mix(in srgb, var(--vf-edu-accent, var(--vf-red)) 30%, transparent);
        transform: translateY(-3px) scale(1.01);
    }

    .vf-edu-feature summary,
    .vf-edu-box summary {
        cursor: pointer;
        list-style: none;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 22px 26px;
        font-weight: 800;
        user-select: none;
    }

    .vf-edu-feature summary::-webkit-details-marker,
    .vf-edu-box summary::-webkit-details-marker {
        display: none;
    }

    .vf-edu-feature__num {
        flex-shrink: 0;
        width: 38px;
        height: 38px;
        padding: 9px;
        border-radius: 50%;
        background: var(--vf-red);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 14px rgba(229, 57, 53, 0.4);
    }

    .vf-edu-feature__title {
        flex: 1;
        font-size: 21px;
        color: var(--vf-ink);
    }

    .vf-edu-box {
        background: var(--vf-surface);
        border: 1px solid var(--vf-line);
        border-left: 5px solid var(--vf-edu-accent, var(--vf-red));
    }

    .vf-edu-box[open] {
        background: linear-gradient(180deg, var(--vf-edu-accent-tint, var(--vf-red-tint)) 0%, var(--vf-surface) 140px);
    }

    .vf-edu-box__icon {
        transition: transform 0.25s ease;
    }

    .vf-edu-box summary:hover .vf-edu-box__icon {
        transform: scale(1.15) rotate(-6deg);
    }

    .vf-edu-box__title {
        flex: 1;
        font-size: 16px;
        color: var(--vf-ink);
    }

    .vf-edu-chevron {
        flex-shrink: 0;
        width: 16px;
        height: 16px;
        color: var(--vf-edu-accent, var(--vf-red));
        transition: transform 0.25s ease;
    }

    .vf-edu-feature[open] > summary .vf-edu-chevron,
    .vf-edu-box[open] > summary .vf-edu-chevron {
        transform: rotate(180deg);
    }

    .vf-edu-feature__body {
        padding: 0 26px 26px 78px;
        animation: vfEduReveal 0.2s ease;
    }

    .vf-edu-box__body {
        padding: 0 22px 22px 22px;
        animation: vfEduReveal 0.2s ease;
    }

    @keyframes vfEduReveal {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .vf-edu-list {
        margin: 0;
        padding-left: 20px;
        color: var(--vf-ink);
        line-height: 1.75;
    }

    .vf-edu-list li {
        margin-bottom: 8px;
    }

    .vf-edu-list li::marker {
        color: var(--vf-edu-accent, var(--vf-red));
        font-weight: 800;
    }

    .vf-edu-grid {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    @media (max-width: 700px) {
        .vf-edu-feature summary,
        .vf-edu-box summary {
            padding: 16px 18px;
            gap: 10px;
        }

        .vf-edu-feature__title {
            font-size: 17px;
        }

        .vf-edu-feature__num,
        .vf-edu-box__icon {
            width: 32px;
            height: 32px;
            font-size: 15px;
        }

        .vf-edu-feature__num,
        .vf-edu-box__icon {
            padding: 7px;
        }

        .vf-edu-feature__body {
            padding: 0 18px 20px 60px;
        }

        .vf-edu-box__body {
            padding: 0 18px 18px;
        }

        .vf-edu-box:hover {
            transform: translateY(-1px);
        }
    }
</style>
@endpush
