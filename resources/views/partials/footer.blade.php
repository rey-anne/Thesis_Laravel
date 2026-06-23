<footer class="vf-footer">
    <div class="vf-stripe"></div>
    <div class="vf-footer__bar">
        <div class="vf-footer__inner">
            <div class="vf-footer__brand">
                <strong>VeriFyre</strong>
                <p>Innovision, FEU Institute of Technology</p>
            </div>

            <div class="vf-footer__contact">
                <strong>Contact the Team</strong>
                <p>{{ env('SITE_CONTACT_NUMBER', '+63 900 000 0000') }}</p>
                <p>{{ env('SITE_CONTACT_EMAIL', 'innovision.verifyre@gmail.com') }}</p>
            </div>

            <div class="vf-footer__rights">
                <p>&copy; {{ date('Y') }} VeriFyre. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>
