/*
// Ação reCaptcha
var captchar = false;
var caixaReCaptchar = $('#caixa-capche');

var onLoadCallback = function () {
    grecaptcha.render('recaptchaContainer', {
    'sitekey': '6LfARUMUAAAAAN96-NSEDHVvgqtbYnUQfAOTgqYm',
    'theme' : 'light',
    'expired-callback': resetar,
    'callback': liberar
    });
};
            
function resetar(){
    grecaptcha.reset();
    captchar = false;
}
            
 function liberar(){
    captchar = true;
    caixaReCaptchar.removeClass('alertCaptchar');
}
*/