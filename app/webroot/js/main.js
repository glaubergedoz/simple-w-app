$(document).ready(function(){

    $("body").on("click", ".btn-salvar", function (e) {

        e.preventDefault();

        var html123 = '<div class="overlay loading009"><i class="fa fa-refresh fa-spin"></i></div>';
        $('.loading_bg').prepend(html123);

        var FormSourceData = $(this).closest("form");
        var FormUrl = $(this).closest("form");
        var type = "POST";
        var UrlRoot = FormUrl.data("url");

        if($(this).prop('href') && $(this).prop('href')!='')
        {
            //a : tela pesquisar

            UrlRoot = $(this).prop('href');
            type = 'GET';

        } else if($(this).data('url') && $(this).data('url')!='') {

            //button : modal ecluir

            UrlRoot = $(this).data('url');

        } else {

            //button : form

            var disabled = FormSourceData.find(":input:disabled").removeAttr('disabled');
            var formData = FormSourceData.serialize();
            disabled.attr('disabled','disabled');
        }

        $.ajax({
            type: type,
            url: UrlRoot,
            data: formData,
            dataType: 'json',
            success: function (data) {

                $('.loading009').remove();

                var id_sufix = '_1';

                if(data.id_sufix && data.id_sufix!='')
                {
                    id_sufix = data.id_sufix
                }

                var UrlClose = data.url_close;
                var mensagem_geral = data.mensagem_geral;
                var mensagem_erro = data.mensagem_erro;
                var resultado = data.resultado;

                $('#myModal'+id_sufix+' .btn-confirma').data('url', '');

                if(resultado=='sucesso')
                {
                    $('#myModal'+id_sufix+' .message').html(mensagem_geral);

                    $('#myModal'+id_sufix).on('hidden.bs.modal', function (e) {
                        $('.loading_bg').prepend(html123);
                        location.replace(UrlClose);
                    });

                    $('#myModal'+id_sufix).modal('show');

                } else if(resultado=='erro_validacao') {

                    var errors = mensagem_erro;

                    var html='';
                    $.each(errors, function(index, value)
                    {
                        html += '<li>'+value+'</li>';
                    });
                    $(".alert-danger ul").html(html);
                    $(".alert-danger").show();

                } else if(resultado=='confirma') {

                    $('#myModal'+id_sufix+' .message').html(mensagem_geral);

                    $('#myModal'+id_sufix+' .btn-padrao').addClass('hide');
                    $('#myModal'+id_sufix+' .btn-cancela').removeClass('hide');
                    $('#myModal'+id_sufix+' .btn-confirma').removeClass('hide');

                    $('#myModal'+id_sufix+' .btn-confirma').data('url', UrlClose);

                    $('#myModal'+id_sufix).on('hidden.bs.modal', function (e) {
                        return false;
                    });

                    $('#myModal'+id_sufix).modal('show');

                } else {

                    $('#myModal'+id_sufix+' .message').html(mensagem_geral);
                    $('#myModal'+id_sufix).modal('show');
                }

                $('.loading009').remove();
            },
            error: function (data) {
                $('.loading009').remove();
            }
        });
    });

    $('.todo-list').sortable({

        items: "> li.situacao_feita",

        stop: function(event, ui){

            var html123 = '<div class="overlay loading009"><i class="fa fa-refresh fa-spin"></i></div>';
            $('.loading_bg').prepend(html123);

            var Url = $(this).data('url');
            var id = ui.item.data('id');
            var index_destino = ui.item.index();
            var data = 'id='+id+'&index_destino='+index_destino;

            $.ajax({
                type: 'POST',
                url: Url,
                data: data,
                dataType: 'json',
                success: function (data) {
                    location.replace(data.url_close);
                    //$('.loading009').remove();
                }
            });
        }
    });
});