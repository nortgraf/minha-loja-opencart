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
//$(".maskHora").mask('99:99:99');
$('#input-telephone').mask("(99) 9999-99999").focusout(maskTelefoneFocusOut);
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

//region Maskmoney

$('input[class=currency]').on('input', function(event) {
    if (event.keyCode < 48 || event.keyCode > 57)
        return false;
});

$('.medida').maskMoney({
    thousands: '.',
    decimal: ',',
    precision: 2
});
$('.peso').maskMoney({
    thousands: '.',
    decimal: ',',
    precision: 3
});

$('.peso_acabamento').maskMoney({
    thousands: ',',
    decimal: '.',
    precision: 5
});

$('.currency').each(function() {
    var val, $field;
    $field = $(this);
    /*
     * Transforma um decimal BR em float.
     * >>> formata_decimal('15,00')
     * 15.00
     * >>> formata_decimal('1.125,35')
     * 1125.35
     */
    val = $field.val();
    val = val.replace(/[^\d\.-]/g, '');
    val *= 100;
    val = Math.round(val);
    val /= 100;
    // Retira qualquer ponto de milhar.
    val = val.toFixed(2);
    $field.val(val);

    $field.maskMoney({
        symbol: 'R$',
        thousands: '.',
        decimal: ',',
        precision: 2,
        showSymbol: true,
        allowZero: false,
        defaultZero: false,
        symbolStay: true,
        affixesStay: false
    }).maskMoney('mask');
});

//Metodo adicionado para tela de cupom 9NÃ£o sabia se o mÃ©toro era usado em outros locais)
$('.currencyCupom').each(function() {
    var val, $field;
    $field = $(this);
    /*
     * Transforma um decimal BR em float.
     * >>> formata_decimal('15,00')
     * 15.00
     * >>> formata_decimal('1.125,35')
     * 1125.35
     */
    val = $field.val();
    // val = val.replace('.', '');
    // val = val.replace(',', '.');
    $field.val(parseFloat(val).toFixed(2).replace('.', ','));
    //val = val.replace(/[^\d\.-]/g, '');
    //val *= 100;
    //val = Math.round(val);
    //val /= 100;
    // Retira qualquer ponto de milhar.
    //val = val.toFixed(2);
    //$field.val(val);

    $field.maskMoney({
        symbol: 'R$',
        thousands: '.',
        decimal: ',',
        precision: 2,
        showSymbol: true,
        allowZero: false,
        defaultZero: false,
        symbolStay: true,
        affixesStay: false
    }).maskMoney('mask');
});

$('.money').each(function() {
    var val, $field;
    $field = $(this);

    val = $field.val();
    if(val.indexOf(",") != -1 && val.indexOf(".") != -1)
        val = val.replace('.', '');
    val = val.replace(',', '.');
    $field.val(parseFloat(val).toFixed(2).replace('.', ','));

    $field.maskMoney({
        symbol: 'R$',
        thousands: '.',
        decimal: ',',
        precision: 2,
        showSymbol: true,
        allowZero: false,
        defaultZero: false,
        symbolStay: true,
        affixesStay: false
    }).maskMoney('mask');
});
$('.money2').each(function() {
    var val, $field;
    $field = $(this);

    val = $field.val();
    if(val.indexOf(",") != -1 && val.indexOf(".") != -1)
        val = val.replace('.', '');
    val = val.replace(',', '.');
    $field.val(parseFloat(val).toFixed(2).replace('.', ','));

    $field.maskMoney({
        symbol: 'R$',
        thousands: '.',
        decimal: ',',
        precision: 2,
        showSymbol: true,
        allowZero: true,
        defaultZero: false,
        symbolStay: true,
        affixesStay: false
    }).maskMoney('mask');
});

$('.money3').each(function() {
    var val, $field;
    $field = $(this);

    val = $field.val();
    if(val.indexOf(",") != -1 && val.indexOf(".") != -1)
        val = val.replace('.', '');
    val = val.replace(',', '.');
    $field.val(parseFloat(val).toFixed(2).replace('.', ','));

    $field.maskMoney({
        symbol: 'R$',
        thousands: '.',
        decimal: ',',
        precision: 3,
        showSymbol: true,
        allowZero: false,
        defaultZero: false,
        symbolStay: true,
        affixesStay: false
    }).maskMoney('mask');
});

//endregion