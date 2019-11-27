<!DOCTYPE html>
<html>

<head>
    <title>Aqua Load - POrtal ITC</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        .arquivo {
            width: 100%;
            background-color: #fff;
        }

        /*search box css start here*/
        .search-sec {
            padding: 2rem;
        }

        .search-slt {
            display: block;
            width: 100%;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #55595c;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            height: calc(3rem + 2px) !important;
            border-radius: 0;
        }

        .wrn-btn {
            width: 100%;
            font-size: 16px;
            font-weight: 400;
            text-transform: capitalize;
            height: calc(3rem + 2px) !important;
            border-radius: 0;
        }

        @media (min-width: 992px) {
            .search-sec {
                position: relative;
                top: -399px;
                background: rgba(26, 70, 104, 0.51);
            }
        }

        @media (max-width: 992px) {
            .search-sec {
                background: #1A4668;
            }
        }
    </style>
</head>

<body>
    <section>
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="http://portal.aquaload.com.br/images/fundo_busca.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
        </div>
    </section>
    <section class="search-sec">
        <div class="container">
            <div id='arquivosretorno'>
            </div>
            <form action="" method="post" id="busca_al" novalidate="novalidate">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 p-0">
                                <input type="text" name="codigo_app" class="form-control search-slt" placeholder="Pedido">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 p-0">
                                <input type="text" name="arquivo_app" class="form-control search-slt" placeholder="Entre com a AL">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 p-0">
                                <button type="submit" class="btn btn-primary wrn-btn">Busca</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

</body>
<script>
    function fechar() {
        mesnagem = '';
        document.getElementById("arquivosretorno").innerHTML = mesnagem;
    }

    jQuery(document).ready(function() {
        //função insert
        jQuery('#busca_al').submit(function() {
            var dados = jQuery(this).serialize();
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: "busca_app.php",
                data: dados,
                success: function(data) {
                    //se for sucesso vem aqui
                    if (data.ARQUIVO == 'ARQUIVO_NAO_EXISTE') {
                        var mesnagem = `
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Não exite o arquivo solicitado!
                        <button type="button" onclick="fechar()" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>                  
                        `;
                        document.getElementById("arquivosretorno").innerHTML = mesnagem;
                    } else if (data.ARQUIVO == 'FALTA_INFO') {
                        var mesnagem = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Falta campo!</strong> Preencha todos os campos!
                        <button type="button" onclick="fechar()" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>                  
                        `;
                        document.getElementById("arquivosretorno").innerHTML = mesnagem;
                    } else if (data.ARQUIVO == 'CODIGO_NAO_EXISTE') {
                        var mesnagem = `
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Numero de pedido não disponível!
                        <button type="button" onclick="fechar()" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>                  
                        `;
                        document.getElementById("arquivosretorno").innerHTML = mesnagem;

                    } else {
                        var mesnagem = `
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        Baixe seu arquivo!`+ data.ARQUIVO +`
                        <button type="button" onclick="fechar()" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>                  
                        `;
                        document.getElementById("arquivosretorno").innerHTML = mesnagem;
                    }

                }
            });
            return false;
        });
    });
</script>

</html>