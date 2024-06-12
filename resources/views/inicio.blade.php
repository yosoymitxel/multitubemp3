<style>
    .check-container{
        width: 136%;
        margin-top: 25px;
    }
    input[type=checkbox] {
        position: absolute;
        cursor: pointer;
        width: 0px;
        height: 0px;
    }

    input[type=checkbox]:checked:before {
        content: "";
        display: block;
        position: absolute;
        width: 34px;
        height: 34px;
        border: 4px solid #10B981;
        border-radius: 20px;
        background-color: #ffffff;
        transition: all 0.2s linear;
    }


    input[type=checkbox]:before {
        content: "";
        display: block;
        position: absolute;
        width: 34px;
        height: 34px;
        border: 4px solid #10B981;
        border-radius: 3px;
        background-color: #ffffff;
    }


    input[type=checkbox]:after {
        content: "";
        display: block;
        width: 0px;
        height: 0px;
        border: solid #10B981;
        border-width: 0 0px 0px 0;
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
        position: absolute;
        top: 0px;
        left: 50px;
        transition: all 0.2s linear;
    }

    input[type=checkbox]:checked:after {
        content: "";
        display: block;
        width: 12px;
        height: 21px;
        border: solid #10B981;
        border-width: 0 5px 5px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        position: absolute;
        top: 2px;
        left: 14px;
    }
</style>

@extends('layouts.app')

@section('title', 'Descargar múltiples MP3 de Youtube')
@section('descripcion', 'Descargar múltiples MP3 de Youtube')

@section('content')

<?php
define('REGEX_YOUTUBE', '(https?:\/\/)?(www\.)?(music\.)?(youtube\.com\/watch\?v=(\w+|\-)+|youtu\.be\/(\w+|\-)+)');
$seBusca = (isset($_GET)) ? sc_arr_incluye_expresion_regular($_GET,REGEX_YOUTUBE):false;
$enlaces = [];

if(isset($_GET['isplaylist']) && $_GET['isplaylist'] == 'on'){
    foreach ($_GET as $enlace){
        //sc_var_dump('ENlace'.$enlace);
        
        if(sc_str_incluye_expresion_regular($enlace,REGEX_YOUTUBE)){
            $enlaces[] = sc_url_youtube_extraer_enlaces_de_video_lista_de_reproduccion($enlace);
        }
    }
    $enlaces = $enlaces[0];
}else{
    $enlaces = $_GET;
}

?>

<section id="formulario-enlaces" class="">
    <div class="container">
        <div class="row justify-content-center">
            <header id="div-titulo-formulario" class="col-12">
                <h2 class="text-center"> Descarga múltiple de <span class="span_h2"> YouTube  </span></h2>
                <hr class="my-4">
            </header>
            <div id="div-formulario-enlaces" class="col-12 d-flex justify-content-center">
                <form class="needs-validation row justify-content-center" onsubmit="validacionEnlaces(true)" novalidate>
                    <div id="contenedor-es-playlist">
                        <div class="switch">
                            <h2 class="mb-3">Descargar también músicas relacionadas? <input id="isplaylist" name="isplaylist" type="checkbox" class="ml-2"></h2>
                        </div>
                    </div>
                    <div id="div-form-container" class="col-11 pr-3 pr-sm-0">
                        <div id="form-div-enlace-01"class="col-md-12 mb-3 pr-3 pr-sm-0">
                            <label for="enlace-01">Link de vídeo de YouTube Nr. 1</label>
                            <input type="text" class="form-control" id="enlace-01" name="enlace-01" placeholder="https://www.youtube.com/watch?v=sFlxgZ8kgMI" value="" pattern="<?php echo REGEX_YOUTUBE; ?>" required>
                            <div class="valid-feedback">
                                !El enlace es correcto!
                            </div>
                            <div class="invalid-feedback">
                                No es un enlace de Youtube válido
                            </div>
                        </div>
                    </div>
                    <div id="from-div-agregar"  class="form-group align-self-end pl-3 col-12 col-sm-1 col-md-1 col-xl-1 text-center">
                        <button type="button" class="px-2 py-1 pt-2 rounded-circle button is-secondary text-white" onclick="agregarEnlaces();">
                            <i class="material-icons">add</i>
                        </button>
                    </div>
                    <div id="from-div-descargar" class="form-group align-content-center pr-3 col-12 col-sm-4 col-xl-4 text-center">
                        <button class="button is-primary " type="submit">Descargar</button>
                    </div>
                </form>
            </div>
            <?php
            if ($seBusca){
                $i = 0;
                sc_dom_etiqueta_inicio('div','div-descargas-container-'.$i,'col-12 d-flex justify-content-center');
                sc_dom_etiqueta_inicio('div','div-descargas-container-row-'.$i,'row justify-content-center text-center');
                sc_dom_crear_elemento('h2','Enlaces de <span class="span_h2 font-semibold">descarga</span>',false,'h1-descargas-titulo-'.$i,'center header my-2');
                ?>
                <div class="col-12">
                    <hr class="my-3">
                </div>
                <?php
                foreach ($enlaces as $enlace){
                    if(sc_str_incluye_expresion_regular($enlace,REGEX_YOUTUBE)){
                        $i++;
                        $enlace = sc_url_get_id_youtube($enlace);

                        sc_dom_etiqueta_inicio('div','div-iframe-descarga-'.$i,'col-12 my-2');
                        echo "<h5 id='titulo-musica-$i' class='center header text_h5 mb-4'>$i - ".sc_url_get_youtube_title($enlace)."</h5>";
                        ?>
                        <div id="check-video-{{$i}}" class="absolute z-index-1 check-container d-none"> <div>
                                <input type="checkbox" class="form-checkbox">
                            </div>
                        </div>
                        <?php
                            sc_dom_etiqueta_inicio('div','div-iframe-descarga__contenedor-'.$i,'grid grid-cols-4 px-2');
                                echo
                                    '<iframe id="iframe-break-'.$i.'"scrolling="no" class="col-span-3 iframe-youtube"
                                                                    src="https://loader.to/api/button/?url=https://www.youtube.com/watch?v='.$enlace.'&f=mp3&color=3B82F6#">
                                                                </iframe>';
                                echo
                                    '<iframe id="iframe-youtube-'.$i.'" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="col-span-1 iframe-youtube" allowfullscreen
                                                                    src="https://www.youtube.com/embed/'.$enlace.'">
                                                                </iframe>
                                                            ';
                                sc_dom_etiqueta_fin('div');
                            sc_dom_etiqueta_fin('div');
                        ?>
                        <div class="row justify-content-center m-0 w-50" id="enlaces-alternativos-<?php echo $enlace?>">
                            <div class="col toggle">
                                <p class="mb-3 pt-2">
                                    <a href="#enlaces-alternativos-<?php echo $enlace?>__div" class="collapsed text-blue-500" aria-expanded="false" aria-controls="enlaces-alternativos-<?php echo $enlace?>__div" data-toggle="collapse">¿No descarga? Aquí hay alternativas</a>
                                </p>
                                <div class="grid grid-cols-2 gap-2 justify-content-center m-0 mt-3 collapse" id="enlaces-alternativos-<?php echo $enlace?>__div" style="">
                                    <?php
                                    // https://www.youtubegomp3.com/watch?v=pOmu0LtcI6Y
                                    $listaEnlaces = array(
                                        'Y2mate'        => "https://www.y2mate.com/es/youtube/$enlace",
                                        'X2convert'     => "https://www.youtubex2.com/watch?v=$enlace",
                                        'Savefrom'      => "https://www.ssyoutube.com/watch?v=$enlace",
                                        'Flvto'         => "https://www.flyoutube.com/watch?v=$enlace",
                                    );
                                    foreach ($listaEnlaces as $key => $valor) {
                                        sc_dom_etiqueta_inicio('div', 'div-enlaces-alternativos-' . $enlace, 'col-span-1 button is-primary p-0 d-flex justify-content-center align-items-center','height: 50px ');
                                        sc_dom_crear_elemento_personalizado('a', $key,
                                            array('id',
                                                'class',
                                                'href',
                                                'target'),
                                            array("link-alternativo-$enlace-$key",
                                                ' w-100 h-100 d-flex justify-content-center align-items-center ',
                                                $valor,
                                                '_blank'
                                            )
                                        );
                                        sc_dom_etiqueta_fin('div');
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                sc_dom_etiqueta_fin('div');
                sc_dom_etiqueta_fin('div');
            }?>
        </div>
    </div>
</section>
<script>
    window.onload = function() {
        $('.check-container').addClass('d-block')
        $('.check-container').removeClass('d-none')
        $('.check-container').css('width',(($('#iframe-break-1').width()*2)-12)+'px')
    };

</script>
@endsection
