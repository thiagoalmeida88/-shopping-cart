$(document).ready(function () {
    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.cel').mask('(00) 00000-0000');
    $('.tel').mask('(00) 0000-0000');
    $('.phone_us').mask('(000) 000-0000');
    $('.mixed').mask('AAA 000-S0S');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.num').keypress(function (event) {
        var tecla = (window.event) ? event.keyCode : event.which;
        if ((tecla > 47 && tecla < 58))
            return true;
        else {
            if (tecla != 8)
                return false;
            else
                return true;
        }
    });
    
    var cpfMascara = function (val) {
    return val.replace(/\D/g, '').length > 11 ? '00.000.000/0000-00' : '000.000.000-009';
    },
    cpfOptions = {
       onKeyPress: function(val, e, field, options) {
          field.mask(cpfMascara.apply({}, arguments), options);
       }
    };
    
    $('.cnpjcpf').mask(cpfMascara, cpfOptions);
    
    $('.celpree').focusout(function () {
        if ($('.cel').val().length < 15)
            $('.cel').val('');                        
    });
    $('.telpree').focusout(function () {
        if ($('.tel').val().length < 14)
            $('.tel').val('');                        
    });
    $(".datapree").focusout(function () {
        if ($('.date').val().length < 10)
            $('.date').val('');
    });
    $(".cnpjpree").focusout(function () {
        if ($('.cnpj').val().length < 18)
            $('.cnpj').val('');
    });
    $(".cnpjcpfpree").focusout(function () {
        if ($('.cnpjcpf').val().length < 14 || ($('.cnpjcpf').val().length > 14 && $('.cnpjcpf').val().length < 18))
            $('.cnpjcpf').val('');
        
    });
    
   
});