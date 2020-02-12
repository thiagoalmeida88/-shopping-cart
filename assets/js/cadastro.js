
window.goTop = function () {
    $('body, html').animate({scrollTop: 0}, '500', 'swing');
};

window.goTopModal = function () {
    $('.modal-body').animate({scrollTop: 0}, '500', 'swing');
};

$(window).bind('beforeunload', function () {
    if (window.formSairSemSalvar === false) {
        if (window.disableAlert === false) {
            return "As alterações serão perdidas. Deseja continuar?";
        }
    }
});

window.formSairSemSalvar = true;

function sairSemSalvar(form) {
    var obj = '#' + form;
    $(obj + " input, " + obj + " textarea").on('keyup', function (e) {
        if (e.keyCode != 13) {
            window.formSairSemSalvar = false;
        }
    });

    $(obj + " select, " + obj + " input").on('change', function (e) {
        if (e.keyCode != 13) {
            window.formSairSemSalvar = false;
        }
    });
}

function limpaTimeOut() {
    window.clearTimeout(window.timer);
}

function setTimeOutDiv() {
    delete window.timer;

    window.timer = window.setTimeout(function () {
        $('#mensagem-alerta, .mensagem-alerta').slideUp('slow', function () {
            $(this).html('');
        });
    }, 5000);
}

function mostraAlertaOK(mensagem) {

    mensagem = $.trim(mensagem) == "" ? "Salvo com sucesso." : mensagem;

    var string = '<div class="alert alert-success fade in">';
    string += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
    string += '<i class="glyphicon glyphicon-ok">&nbsp;</i>';
    string += '<strong>OK!</strong> ' + mensagem;
    string += '</div>';

    $('#mensagem-alerta, .mensagem-alerta').html(string).slideDown();

    goTop();

    limpaTimeOut();

    setTimeOutDiv();
}
