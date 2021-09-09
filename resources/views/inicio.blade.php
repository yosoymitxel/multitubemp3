@extends('layouts.app')

@section('title', 'Descargar múltiples MP3 de Youtube')
@section('descripcion', 'Descargar múltiples MP3 de Youtube')

@section('content')

<?php
$seBusca = (isset($_GET))?sc_arr_incluye_expresion_regular($_GET,'(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=(\w+|\-)+|youtu\.be\/\(w+|\-)+'):false;
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
                    <div id="div-form-container" class="col-11 pr-3 pr-sm-0">
                        <div id="form-div-enlace-01"class="col-md-12 mb-3 pr-3 pr-sm-0">
                            <label for="enlace-01">Link de vídeo de YouTube Nr. 1</label>
                            <input type="text" class="form-control" id="enlace-01" name="enlace-01" placeholder="https://www.youtube.com/watch?v=sFlxgZ8kgMI" value="" pattern="(https?://)?(www\.)?(youtube\.com/watch\?v=(\w+|-)+|youtu\.be/(\w+|-)+)" required>
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
            foreach ($_GET as $enlace){
            if(sc_str_incluye_expresion_regular($enlace,'(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=(\w+|\-)+|youtu\.be\/(\w+|\-)+)')){
            $i++;
            $enlace = sc_url_get_id_youtube($enlace);

            sc_dom_etiqueta_inicio('div','div-iframe-descarga-'.$i,'col-12 my-2');
            echo "<h5 id='titulo-musica-$i' class='center header text_h5 mb-4'>$i - ".get_youtube_title($enlace)."</h5>";
                sc_dom_etiqueta_inicio('div','div-iframe-descarga__contenedor-'.$i,'grid grid-cols-4 px-2');
                /*echo
                    '<iframe id="iframe-break-'.$i.'"scrolling="no" class="col-span-3 iframe-youtube"
                                                    src="https://break.tv/widget/button/?link=https://www.youtube.com/watch?v='.$enlace.'&color=4391D0&text=fff">
                                                 </iframe>';*/
                echo "<a href='".sc_url_link_descarga_youtube($enlace)."' class='flex justify-content-center align-items-center font-semibold text-white col-span-3 iframe-youtube button is-secondary'>Descargar</a>";
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

                        $listaEnlaces = array(
                            'Y2mate'        => "https://www.y2mate.com/es/youtube/$enlace",
                            'Flvto'         => "https://www.flyoutube.com/watch?v=$enlace",
                            'Savefrom'      => "https://www.ssyoutube.com/watch?v=$enlace",
                            'X2convert'     => "https://www.youtubex2.com/watch?v=$enlace",
                        );
                        foreach ($listaEnlaces as $key => $valor) {
                            sc_dom_etiqueta_inicio('div', 'div-enlaces-alternativos-' . $enlace, 'col-span-1 button is-primary');
                            sc_dom_crear_elemento_personalizado('a', $key,
                                array('id',
                                    'class',
                                    'href',
                                    'target'),
                                array("link-alternativo-$enlace-$key",
                                    ' w-100 mb-2',
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

@endsection
