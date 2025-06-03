//region Mascaras

function maskTelefoneFocusOut(event) {
    var target, phone
    /** @type {HTMLInputElement} */
    var element;

    target = (event.currentTarget) ? event.currentTarget : event.srcElement;
    phone = target.value.replace(/\D/g, '');
    element = $(target);

    if (phone.length < 10) {
        element.value = '';
        return;
    }

    var novaMascara = (phone.length > 10) ?
            "(99) 99999-9999" :
            "(99) 9999-99999";

    element.unmask();
    element.mask(novaMascara);
    element.value = phone;
}

$('#input-telephone').mask("(99) 99999-9999");
//$('.maskCm').mask("99,999");
$('#input-postcode1').mask("99999-999");
$("#input-custom-field7").mask("999.999.999-99");
$("#input-tax").mask("999.999.999-99");
$("#input-custom-field2").mask("99.999.999/9999-99");
$("#input-ncm2").mask('9999.99.99');
$("#input-cores2").mask('9x9');
//$(".maskCartao").mask('9999 9999 9999 9999');
//$(".maskCodigoSeguranca").mask('999');
$("#input-custom-field10").mask('99/99/9999');
//$("#input-date-added").mask('99/99/9999');
//$("#input-date-modified").mask('99/99/9999');
//$(".maskHora").mask('99:99:99');
$('#input-telephone').mask("(99) 99999-9999").focusout(maskTelefoneFocusOut);
$('#input-telephone').each(function() {
    $(this).trigger('focusout');
});

function formatarCampo(campoTexto) {
    if (campoTexto.value.length > 11) {
        campoTexto.value = mascaraCnpj(campoTexto.value);
    } else {
        campoTexto.value = mascaraCpf(campoTexto.value);
    }
}
function retirarFormatacao(campoTexto) {
    campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g,"");
}
function mascaraCpf(valor) {
    return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g,"\$1.\$2.\$3\-\$4");
}
function mascaraCnpj(valor) {
    return valor.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g,"\$1.\$2.\$3\/\$4\-\$5");
}

//endregion
