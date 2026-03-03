@if(!empty($recaptchaEnabled) && !empty($recaptchaSiteKey))
<script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}" async defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form[data-recaptcha-action]');
    if (!form) return;
    var action = form.getAttribute('data-recaptcha-action') || 'submit';
    var siteKey = '{{ $recaptchaSiteKey }}';
    form.addEventListener('submit', function(e) {
        var input = form.querySelector('input[name="recaptcha_token"]');
        if (!input || input.value) return;
        e.preventDefault();
        if (typeof grecaptcha === 'undefined') {
            form.submit();
            return;
        }
        grecaptcha.ready(function() {
            grecaptcha.execute(siteKey, { action: action }).then(function(token) {
                input.value = token;
                form.submit();
            }).catch(function() {
                form.submit();
            });
        });
    });
});
</script>
@endif
