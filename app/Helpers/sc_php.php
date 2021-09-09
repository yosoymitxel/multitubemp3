<?php
/*
Librería SC PHP
Fecha de inicio: 11/08/2020

Lista de categorías:

DEV     = Debug
DOM     = Manejo de DOM - HTML
URL     = Manejo de Urls
SQL     = Manejo de SQL
JS      = Opciones de JS
STR     = Manejo de string
FEC     = Manejo de fechas
ARR     = Manejo de Arrays
IS      = Tipo de variable

*/


/*###DEV###*/

function sc_dev_var_dump($obj,$etiqueta='',$id='',$class='',$style=''){
    echo (!sc_dom_etiqueta_inicio($etiqueta)) ?
        "<pre id='$id' class='$class' style='$style'>" :
        "<$etiqueta id='$id' class='$class' style='$style'>";
    var_dump($obj);
    echo (!sc_dom_etiqueta_inicio($etiqueta)) ? '</pre>' : "</$etiqueta>";
    sc_dom_etiqueta_fin($etiqueta);
}

function sc_dev_echo($t,$valor='',$etiqueta='p',$id='',$class='',$style='',$name=''){
        $valor = ($valor != '') ? ' : ' . $valor : '';
        echo("<$etiqueta id='$id' class='$class' style='$style' name='$name'>$t$valor</$etiqueta>");
}

function sc_dev_activar_depurar_global($condicion){
    ini_set('display_errors',$condicion);
    ini_set('display_startup_errors',$condicion);
    error_reporting(E_ALL);
}

function sc_dev_echo_indice($titulo,$texto,$etiqueta='p',$id='',$class='',$style='',$name=''){
    $texto = "$titulo : $texto";
    sc_dom_crear_elemento($etiqueta,$texto,$id,$class,$style,$name);
}

function sc_dev_contador_texto_para_pruebas($texto='Prueba',$valor = false) {
    static $index = 0;
    if($valor===0){
        $index = 0;
    }
    $index++;
    echo "<p id='".sc_str_sin_caracteres_especiales($texto)."-$index' class='m-0 p-0 w-100'>$texto: $index</p>";
}

function sc_dev_echo_oculto($texto,$depurar=false,$id='id-oculto',$clase=''){
    echo "<div style='display: none;' class='$clase' id='$id'>";
    if ($depurar){
        sc_var_dump($texto);
    }else{
        echo "<p>$texto</p>";
    }
    echo '</div>';
}

function sc_dev_depurar($condicion,$obj,$id='id-depuracion'){
    if($condicion){
        sc_dom_etiqueta_inicio('div',"debug-$id",'w-100');
        sc_dom_crear_elemento('h3',$id,"debug-$id");
        if(sc_is_array($obj,1)){
            $i = 0;
            foreach ($obj as $value){
                sc_var_dump($value,null,"var-dump__$id-".++$i);
            }
        }else{
            sc_var_dump($obj,"var-dump__$id");
        }
        sc_dom_etiqueta_fin('div');
    }
}

function sc_dev_obj_a_bool($obj,$depurar=false){
    sc_dev_depurar($depurar,$obj,'sc_dev_obj_a_bool');
    return !(!$obj);
}

function sc_var_dump($obj,$etiqueta='',$id='',$class='',$style=''){
    sc_dev_var_dump($obj,$etiqueta,$id,$class,$style);
}

function sc_echo($t,$valor='',$etiqueta='p',$id='',$class='',$style='',$name=''){
    sc_dev_echo($t,$valor,$etiqueta,$id,$class,$style,$name);
}



/*###DOM###*/

function sc_dom_get_atributos($arrayAtributos,$depurar=false){
    if(sc_is_array($arrayAtributos)){
        $atributos = '';
        sc_dev_depurar(
            $depurar,
            array(
                $arrayAtributos
            ),
            'sc_dom_get_atributos'
        );

        foreach ($arrayAtributos as $atributo => $valor){
            if($depurar){
                sc_var_dump($atributo.' : '.$valor,'p');
            }
            $atributos .= ($valor)? $atributo.'="'.$valor.'", ' : '';
        }

        $atributos = implode(' ',(explode(',',$atributos)));
        return $atributos;
    }
    return false;
}

function sc_dom_crear_elemento($etiqueta,$contenido,$depurar=false,$id='',$class='',$style='',$name=''){
    if(sc_is_string($etiqueta,1)){
        $atributos = array('id'=>$id,'class'=>$class,'style'=>$style,'name'=>$name);
        $elemento  = "<$etiqueta ".sc_dom_get_atributos($atributos,$depurar);
        echo $elemento.">$contenido</$etiqueta>";
        return true;
    }

    return false;
}

function sc_dom_crear_elemento_sin_cerrar($etiqueta,$depurar=false,$value='',$id='',$class='',$style='',$name='',$type='',$src='',$alt=''){
    if(sc_is_string($etiqueta,1)){
        $atributos = array('id'=>$id,'class'=>$class,'style'=>$style,'name'=>$name,'value'=>$value,'type'=>$type,'src'=>$src,'alt'=>$alt);
        $elemento  = "<$etiqueta ".sc_dom_get_atributos($atributos,$depurar);
        echo $elemento.">";
        return true;
    }

    return false;
}

function sc_dom_crear_elemento_personalizado($etiqueta,$contenido,$arrayTipoAtributos,$arrayValorAtributos,$etiquetaCerrada=true,$depurar=false){
    sc_dev_depurar($depurar,
        array('etiqueta'=>$etiqueta,
            'Contenido'          =>$contenido,
            'arrayTipoAtributos' =>$arrayTipoAtributos,
            'arrayValorAtributos'=>$arrayValorAtributos,
            'cerradoAbierto'     =>$etiquetaCerrada
        ),'sc_dom_crear_elemento_personalizado');

    $arrayTemp = array_combine($arrayTipoAtributos,$arrayValorAtributos);
    $atributos = sc_dom_get_atributos($arrayTemp);
    echo "<$etiqueta $atributos>$contenido";
    if($etiquetaCerrada){
        echo "</$etiqueta>";
    }
}

function sc_dom_crear_elemento_input($type='text',$value='',$id='',$name='',$class='',$style=''){
    $name = (isset($name[1]))?$name:$id;
    sc_dom_crear_elemento_sin_cerrar('input',false,$value,$id,$class,$style,$name,$type);
}

function sc_dom_etiqueta_inicio($etiqueta='',$id='',$class='',$style='',$name=''){
    if(isset($etiqueta[1])){
        $atributos = array('id'=>$id,'class'=>$class,'style'=>$style,'name'=>$name);
        $elemento  = "<$etiqueta ";
        foreach ($atributos as $atributo => $valor){
            $elemento .= ($atributo)? $atributo.'="'.$valor.'" ' : '';
        }
        echo $elemento.">";
        return true;
    }
    return false;
}

function sc_dom_etiqueta_fin($etiqueta){
    if(isset($etiqueta[1])){
        echo "</$etiqueta>";
        return true;
    }
    return false;
}

function sc_dom_cdn($id,$link,$tipo='css',$depurar=false){
    sc_dev_depurar($depurar,array($id,$link,$tipo),'sc_dom_cdn');
    switch ($tipo){
        case 'js':
        case 'javascript':
        case 'script':
            sc_dom_crear_elemento_personalizado('script',null,array('id','src'),array($id,$link));
            break;
        case 'css':
        default:
            sc_dom_crear_elemento_personalizado('link',null,array('id','rel','href'),array($id,'stylesheet',$link),false);
            break;
    }
}

/*###URL###*/
function get_youtube_title($video_id){
    $url = "http://www.youtube.com/watch?v=".$video_id;

    $str = file_get_contents($url);
    if(strlen($str)>0){
        $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
        preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
        return (sc_is_array($title,1)) ?
            sc_str_reemplazar_expresion_regular($title[1],'/( \- YouTube)/','') :
            'Título no encontrado';
    }
}

function sc_url_link_descarga_youtube($video_id){
    $html = file_get_html('https://www.yt-download.org/file/mp3/'.$video_id);
    // Find all links
    foreach($html->find('a') as $element){
        if (sc_str_contiene($element->href,'/192/')){
            return $element->href;
        }
    }
}

function sc_url_informacion_sitio_actual(){
    $indicesServer = array('PHP_SELF',
        'argv',
        'argc',
        'GATEWAY_INTERFACE',
        'SERVER_ADDR',
        'SERVER_NAME',
        'SERVER_SOFTWARE',
        'SERVER_PROTOCOL',
        'REQUEST_METHOD',
        'REQUEST_TIME',
        'REQUEST_TIME_FLOAT',
        'QUERY_STRING',
        'DOCUMENT_ROOT',
        'HTTP_ACCEPT',
        'HTTP_ACCEPT_CHARSET',
        'HTTP_ACCEPT_ENCODING',
        'HTTP_ACCEPT_LANGUAGE',
        'HTTP_CONNECTION',
        'HTTP_HOST',
        'HTTP_REFERER',
        'HTTP_USER_AGENT',
        'HTTPS',
        'REMOTE_ADDR',
        'REMOTE_HOST',
        'REMOTE_PORT',
        'REMOTE_USER',
        'REDIRECT_REMOTE_USER',
        'SCRIPT_FILENAME',
        'SERVER_ADMIN',
        'SERVER_PORT',
        'SERVER_SIGNATURE',
        'PATH_TRANSLATED',
        'SCRIPT_NAME',
        'REQUEST_URI',
        'PHP_AUTH_DIGEST',
        'PHP_AUTH_USER',
        'PHP_AUTH_PW',
        'AUTH_TYPE',
        'PATH_INFO',
        'ORIG_PATH_INFO') ;

    echo '<table cellpadding="10">' ;
    foreach ($indicesServer as $arg) {
        if (isset($_SERVER[$arg])) {
            echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
        }
        else {
            echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
        }
    }
    echo '</table>' ;
}

function sc_url_get_url_actual(){
    return $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

function sc_url_get_ip_remoto(){
    return $_SERVER['REMOTE_ADDR'];
}

function sc_url_direcciones(){
    return $_SERVER['PHP_SELF'];
}

function sc_url_metodo_get(){
    return $_SERVER['HTTP_GET_VARS'];
}

function sc_url_metodo_post(){
    return $_SERVER['HTTP_POST_VARS'];
}

function sc_url_metodo_cookies(){
    return $_SERVER['HTTP_COOKIE_VARS'];
}

function sc_url_get_servidor($url){
    $url = explode('.',$url);

    if(sc_str_existe_en_string($url[0],'www')){
        $urlProcesada = $url[1];
    }else{
        $urlProcesada = str_replace('https://','',$url[0]);
        $urlProcesada = str_replace('http://','',$urlProcesada);
    }
    return $urlProcesada;
}

function sc_url_borrar_cookies($depurar=false){
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name  = trim($parts[0]);
            setcookie($name, '', time()-1000);
            setcookie($name, '', time()-1000, '/');
        }
    }
}

function sc_url_get_youtube_title($video_id){
    $url = "http://www.youtube.com/watch?v=".$video_id;

    $str = file_get_contents($url);
    if(strlen($str)>0){
        $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
        preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
        return sc_str_reemplazar_expresion_regular($title[1],'/( \- YouTube)/','');
    }
}

function sc_url_get_id_youtube($urlYoutube){
    $expresionUrl     = sc_str_corregir_expresion_regular('(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=(\w+|\-)+|youtu\.be\/(\w+|\-)+)');
    $expresionIdVideo = sc_str_corregir_expresion_regular('(((\?v=)[\w\-]+)|be\/\w+)');
    return (sc_str_incluye_expresion_regular($urlYoutube,$expresionUrl)) ?
        substr(sc_str_extraer_expresion_regular($urlYoutube, $expresionIdVideo),3) :
        false;
}

function sc_url_generar_iframe_youtube($link,$return=false,$altura='30vh',$ancho='100%',$class="pt-2",$depurar=false){
    sc_dev_depurar($depurar,array($link,$altura,$ancho),'sc_url_generar_iframe_youtube');
    $enlace = sc_url_get_id_youtube(sc_str_quitar_espacios_blancos($link));
    if($enlace){
        $altura = sc_str_incluye_expresion_regular($altura,'\d+(\%|px|vh|vmin|vw)')?($altura):($altura.'px');
        $ancho   = sc_str_incluye_expresion_regular($ancho  ,'\d+(\%|px|vh|vmin|vw)')?($ancho)  :  ($ancho.'px');
        $iframe = '
            <div id="contenedor-iframe-yt-'.$enlace.'" class="'.$class.'">
                <iframe id="iframe-yt-'.$enlace.'" style="width:'.$ancho.'; height:'.$altura.';" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen 
                    src="https://www.youtube.com/embed/'.$enlace.'">
                </iframe>
            </div>
        ';
        if ($return){
            return $iframe;
        }
        echo $iframe;
        return true;
    }else{
        return false;
    }
}

function dev_url_descargar_imagen_al_servidor($url,$direccionCarpeta='assets/archivos/logos'){
    $url = (sc_str_inicia_con($url,'http://') || sc_str_inicia_con($url,'https://'))?
        $url :
        'http://'.$url ;
    $url = parse_url($url)['host'];
    $nombreImagen = (sc_str_inicia_con($url,'www.'))?
        $url :
        'www.'.$url ;
    $nombreImagen = urlencode($nombreImagen);
    //sc_dev_echo_indice($url,$direccionCarpeta);
    //sc_var_dump(is_file(SERVERURL . "$direccionCarpeta/$nombreImagen"));

    if (!is_file(SERVERURL . "$direccionCarpeta/$nombreImagen")) {
        //abrimos un fichero donde guardar la descarga de la web
        //sc_var_dump("$direccionCarpeta/$nombreImagen.png");
        $fp = fopen("$direccionCarpeta/$nombreImagen.png", "w");
        //sc_var_dump("https://www.google.com/s2/favicons?domain=$url");

        if($fp){
            // Se crea un manejador CURL
            $ch=curl_init();

            // Se establece la URL y algunas opciones
            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/s2/favicons?domain=$url");
            //determina donde guardar el fichero
            curl_setopt($ch, CURLOPT_FILE, $fp);

            // Se obtiene la URL indicada
            curl_exec($ch);

            // Se cierra el recurso CURL y se liberan los recursos del sistema
            curl_close($ch);

            //se cierra el manejador de ficheros
            fclose($fp);
            //sc_var_dump('Subió',null,'w-100');
            return true;
        }

    }
    //sc_var_dump('No subió',null,'w-100');
    return false;
}

function sc_url_buscar_imagenes_google($busqueda){
    $img_pattern = '/<img[^>]+>/i';
    //$datos = array();
    if ($busqueda != '') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com.ar/search?q=".urlencode($busqueda.' -vertical -portada')."&source=lnms&tbm=isch&sa=X");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //Execute the session, returning the results to $curlout, and close.
        $curlout = curl_exec($ch);
        curl_close($ch);
        preg_match_all($img_pattern, $curlout, $img_tags);
    }
    return $img_tags;
}

function sc_url_curl($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

/*###SQL###*/

function sc_sql_lookup($sql){
    //echo $sql;
    global $pdoLibreria;
    $query = $pdoLibreria->prepare($sql);

    try {
        $sqlResult = $query->execute(array());

        if ($sqlResult) {
            $sqlResult = $query->fetchAll(PDO::FETCH_ASSOC);
            return $sqlResult;
        }else{
            return false;
        }
    } catch (Exception $e) {
        return '<p class="alert-danger">No funcionó</p>';
    }
}

function sc_sql_secure_lookup($sql,$array=null,$depurar=false){
    global $pdoLibreria;
    $query = $pdoLibreria->prepare($sql);
    $sqlResult[0][0] = false;

    try {
        $sqlResult = $query->execute($array);

        if ($sqlResult) {
            $sqlResult = $query->fetchAll(PDO::FETCH_ASSOC);
            $query = null;

            if ($depurar){
                sc_echo('Debug de sc_sql_secure_lookup (3):');
                sc_var_dump($sql);
                sc_var_dump($array);
                sc_var_dump($sqlResult);
            }

            if (count($sqlResult)==0){
                foreach ($array as &$valor){
                    $valor = htmlentities($valor);
                }
            }

            return count($sqlResult)!=0?$sqlResult:false;
        }else{
            return $datos[0][0] = false;
        }
    } catch (Exception $e) {
        sc_var_dump('Hubo un error: ');
        sc_var_dump($e);
        return false;
    }
}

function sc_sql_exec_sql($sql,$array=null){
    global $pdoLibreria;
    $query = $pdoLibreria->prepare($sql);

    foreach ( $array as &$valor){
        $valor = (is_string($valor)) ? nl2br( htmlentities($valor) ) : $valor;
    }

    try {
        return $query->execute($array);
    } catch (Exception $exception) {
        echo $exception;
        return false;
    }
}


/*###JS###*/

function sc_js_alert($texto){
    echo "<script>alert('" . $texto . "' );</script>";
}

function sc_js_console_log($texto){
    echo "<script>console.log('" . $texto . "' );</script>";
}


/*###STR###*/
function sc_str_existe_en_string($texto,$busqueda,$depurar=false){
    sc_dev_depurar($depurar,$texto,'sc_str_existe_en_string');
    return (strpos($texto,$busqueda) !== false);
}

function sc_str_quitar_espacios_y_lower($texto,$depurar=false){
    sc_dev_depurar($depurar,$texto,'sc_str_existe_en_string');
    return strtolower(preg_replace('/(\n|\r|\t|\s)/','',$texto));
}

function sc_str_resaltar_texto($t,$busqueda,$class=null){
    return (isset($t[1]) && isset($busqueda[1]))?str_replace($busqueda,"<b class='$class'>$busqueda</b>",$t):false;
}

function sc_str_generar_enlaces_html_de_string($texto,$depurar=false){
    sc_dev_depurar($depurar,
        array(
            $texto,
            preg_replace(
                '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
                "<a href=\"$1\" target=\"_blank\">$3</a>$4",
                $texto
            )
        ),
        'sc_str_generar_enlaces_html_de_string');
    $texto = sc_str_reemplazar_expresion_regular($texto,'&amp;','&');
    return preg_replace(
        '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
        "<a href=\"$1\" target=\"_blank\">$3</a>$4",
        $texto
    );
}

function sc_str_reemplazar_expresion_regular($t,$expresion,$reemplazo,$depurar=false){
    $expresion = sc_str_corregir_expresion_regular($expresion);
    sc_dev_depurar($depurar,"t : $t expresion : $expresion reemplazo : $reemplazo ",'sc_str_reemplazar_expresion_regular');
    return preg_replace(
        $expresion,
        $reemplazo,
        $t
    );
}

function sc_str_incluye_expresion_regular($t,$expresion,$depurar=false){
    $expresion = sc_str_corregir_expresion_regular($expresion);
    sc_dev_depurar($depurar,array($t,$expresion),'sc_str_incluye_expresion_regular');
    return preg_match($expresion,$t);
}

function sc_str_corregir_expresion_regular($expresion,$depurar=false){
    sc_dev_depurar($depurar,array($expresion),'sc_str_corregir_expresion_regular');
    return (sc_str_inicia_con($expresion,'/') && sc_str_finaliza_con($expresion,'/')) ?
        $expresion :
        '/'.$expresion.'/';
}

function sc_str_extraer_expresion_regular($t,$expresion,$depurar=false){
    sc_dev_depurar($depurar,array($t,$expresion),'sc_str_extraer_expresion_regular');
    $expresion     = sc_str_corregir_expresion_regular($expresion);
    $coincidencias = false;

    if(sc_str_incluye_expresion_regular($t,$expresion)){
        preg_match_all($expresion,$t,$coincidencias,PREG_OFFSET_CAPTURE);
        $arrayResutl = array();

        for ($i=0,$iMax=count($coincidencias[0]);$i<$iMax;$i++ ){
            $valor=$coincidencias[0];
            for ($j=0 ;$j<$iMax;$j++){
                $arrayResutl[$j] = ($valor[$j][0]);
            }
        }

        $coincidencias = count($arrayResutl)>1? $arrayResutl : $arrayResutl[0];
    }
    return $coincidencias;
}

function sc_str_inicia_con($t,$busqueda,$depurar=false){
    sc_dev_depurar($depurar,$t,'sc_str_inicia_con');
    return (strpos($t, $busqueda) === 0);
}

function sc_str_finaliza_con($t,$busqueda,$depurar=false){
    sc_dev_depurar($depurar,$t,'sc_str_finaliza_con');
    $cantidadCaracteres = strlen ($busqueda);
    return ($cantidadCaracteres && substr($t, -$cantidadCaracteres) == $busqueda);
}

function sc_str_contiene($t,$busqueda,$depurar=false){
    return sc_str_existe_en_string($t,$busqueda,$depurar);
}

function sc_str_quitar_espacios_extra($t,$depurar=false){
    sc_dev_depurar($depurar,$t,'sc_str_quitar_espacios_extra');
    return trim(sc_str_reemplazar_expresion_regular($t,'/(\n|\s)+/',' '));
}

function sc_str_quitar_espacios_blancos($t,$depurar=false){
    sc_dev_depurar($depurar,$t,'sc_str_quitar_espacios_blancos');
    return trim(sc_str_reemplazar_expresion_regular($t,'(\n|\s|\t|\r)+',''));
}

function sc_str_sin_caracteres_especiales($texto,$quitarTodos=true){
    if(isset($texto[1])){
        //Aquí añades las letras que no quieres que se usen
        $vocalesNoPermitidas    = array('á','é','í','ó','ú','ñ');
        $vocalesNoPermitidasMay = array('Á','É','Í','Ó','Ú','Ñ');

        //Aquí añades las letras que quieres que se usen
        $vocalesPermitidas      = array('a','e','i','o','u','ni');

        //Aquí añades los caracteres que no quieres que se usen
        $caracteresNoPermitidos = array('?','\"','\'');

        $texto = strtolower($texto);

        for($i=0, $iMax = count($vocalesNoPermitidas); $i< $iMax; $i++){
            $texto = str_replace($vocalesNoPermitidas   [$i], $vocalesPermitidas[$i], $texto);
            $texto = str_replace($vocalesNoPermitidasMay[$i], $vocalesPermitidas[$i], $texto);
        }

        for($i=0, $iMax = count($caracteresNoPermitidos); $i< $iMax; $i++){
            $texto = str_replace($caracteresNoPermitidos[$i], '_', $texto);
        }

        //Esta parte reemplaza los espacios en blanco " " y los guiones "-" por guiones bajos "_"
        $texto = sc_str_reemplazar_expresion_regular($texto,'(\s+|\-+|_+)+',"_");

        if($quitarTodos){
            $texto = sc_str_reemplazar_expresion_regular($texto,'\W','');
            $texto = sc_str_reemplazar_expresion_regular($texto,'(\s+|\-+|_+)+',"_");
        }
    }
    return $texto;
}

function sc_str_to_oracion($t,$depurar=false){
    sc_dev_depurar($depurar,$t,'sc_str_to_oracion');
    return sc_is_string($t,1) && strtolower($t) === $t ? ucfirst($t) : $t;
}

/*###FEC###*/
function sc_fec_formatear($fecha,$formato='Y-m-d H:i:s',$depurar=false){
    sc_dev_depurar($depurar,array($fecha,$formato),'sc_fec_formatear');
    return date($formato, strtotime($fecha));
}


/*###ARR###*/
function sc_arr_incluye_expresion_regular($array,$expresion,$depurar=false){
    sc_dev_depurar($depurar,array($array,$expresion),'sc_arr_incluye_expresion_regular');

    if (is_array($array) && isset($expresion[1])){
        $expresion = sc_str_corregir_expresion_regular($expresion);
        foreach ($array as $valor){
            if (sc_str_incluye_expresion_regular($valor,$expresion)){
                return true;
            }
        }
    }

    return false;
}

function sc_arr_to_json($arr,$arrayKeys=null,$depurar=false){
    sc_dev_depurar($depurar,array($arr,$arrayKeys),'sc_arr_poner_keys');
    if(sc_is_array($arr,1)){
        if(!sc_arr_contiene_keys($arr) && sc_arr_contiene_keys($arr) ){
            $lista = '';

            foreach ($arr as $valor){
                $lista .= json_encode($valor).' , ';

            }

            return '['.substr($lista,0,-3).']';
        }

        if(sc_is_array($arrayKeys,1) && !sc_arr_contiene_keys($arr)){
            $arr = sc_arr_poner_keys($arrayKeys,$arr);
        }
        return json_encode($arr);
    }
    return false;
}

function sc_arr_contiene_keys($arr,$depurar=false){
    sc_dev_depurar($depurar,$arr,'sc_arr_contiene_keys');
    $arr = array_keys($arr);
    return (int) preg_grep('/(\D)+/',$arr);
}

function sc_arr_poner_keys($arrayKeys,$arr,$depurar=false){
    sc_dev_depurar($depurar,array($arrayKeys,$arr),'sc_arr_poner_keys');
    if (sc_is_array($arrayKeys) && sc_is_array($arr)){
        return array_combine($arrayKeys, $arr);
    }
    return false;
}

function sc_arr_unir($arr1,$arr2,$depurar=false){
    sc_dev_depurar($depurar,array($arr1,$arr2),'sc_arr_unir');
    if (sc_is_array($arr1,1) && sc_is_array($arr2,1) ){
        return array_merge($arr1, $arr2);
    }
    return false;
}

/*###IS###*/
function sc_is_string($t,$longitud=0,$depurar=false){
    sc_dev_depurar(
        $depurar,
        array(
            $t,
            $longitud,
            ( is_string($t) && isset($t[$longitud]) )
        ),
        'sc_is_string'
    );
    $longitud = ($longitud!=0) ? $longitud-1 : $longitud;
    return is_string($t) && isset($t[$longitud]);
}

function sc_is_url($url,$depurar=false){
    sc_dev_depurar($depurar,$url,'sc_is_url');
    if (sc_is_string($url,3)){
       return filter_var($url,FILTER_VALIDATE_URL);
    }
    return false;
}

function sc_is_array($array,$count=0,$depurar=false){
    sc_dev_depurar($depurar,array($array,$count),'sc_is_array');
    return is_array($array) &&  count($array) >= $count;
}

function sc_is_bool($obj,$depurar=false){
    sc_dev_depurar($depurar,$obj,'sc_is_bool');
    return is_bool($obj);
}


?>
