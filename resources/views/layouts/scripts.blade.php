
<script id="dev-validador-formularios">
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script id="dev-agregar">
    function agregarEnlaces(){
        let cantidadEnlaces = ($('[id^=form-div-enlace-]').length)+1;
        let enlace = `<div id="form-div-enlace-0${cantidadEnlaces}"class="col-md-12 mb-3 pr-4 pr-sm-0">
                                <label for="enlace-0${cantidadEnlaces}">Link de vídeo de YouTube Nr. ${cantidadEnlaces}</label>
                                <input type="text" class="form-control" id="enlace-0${cantidadEnlaces}" name="enlace-0${cantidadEnlaces}" placeholder="https://www.youtube.com/watch?v=sFlxgZ8kgMI" value=""  pattern="(https?://)?(www\\.)?(youtube\\.com/watch\\?v=(\\w+|-)+|youtu\\.be/(\\w+|-)+)"  required>
                                <div class="valid-feedback">
                                    !El enlace es correcto!
                                </div>
                                <div class="invalid-feedback">
                                    No es un enlace de Youtube válido
                                </div>
                            </div>`;
        $(`#div-form-container`).append(enlace);
        validacionEnlaces();
    }

    function validacionEnlaces(submit=false){
        let cantidadEnlaces = ($('[id^=form-div-enlace-]').length);

        for(let i=0; i<cantidadEnlaces;i++){
            let valorEnlace = dev_str_quitar_espacios_blancos(dev_dom_value(`#enlace-0${i+1}`));
            if ( dev_is_string(dev_dom_value(`#enlace-0${i+1}`),1)){
                if($('#isplaylist').val() != 'on'){
                    $(`#enlace-0${i+1}`).val(dev_str_reemplazar_expresion_regular(valorEnlace,'(&(\\w+)=(\\w+))',''));
                }
                if(submit && !dev_is_string($(`#enlace-0${i+1}`).val(),3)){
                    $(`#form-div-enlace-0${i+1}`).remove()
                }
            }
        }

    }

    function getGames() {
        $.ajax({
            url: 'https://gamerpower.p.rapidapi.com/api/giveaways?type=game',
            dataType: 'json',
            headers: {
                'X-RapidAPI-Key': 'a011259af4mshbfc3b1375ec8dcdp16897bjsn632c0e6f5730',
                'X-RapidAPI-Host': 'gamerpower.p.rapidapi.com'
            },
            success: function(data) {
            if (Array.isArray(data)) {
                $('#acerca-de').append('<div id="juegos-gratis__contenedor" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 overflow-auto scrollbar" style="max-height: 500px"></div>') 
                var juegosContenedor = $('#juegos-gratis__contenedor');
                juegosContenedor.empty();
                console.log(data)
                juegosContenedor.append('<h2 class="mt-2 col-span-full">Juegos en oferta</h2>');
                data.forEach(function(game) {
                if (game.worth != 'N/A') {
                    var juego = $('<div>', {class: 'h-full rounded-sm flex flex-col overflow-hidden'});
                    var imagen = $('<img>', {class: 'md:w-48 rounded-t-md mx-auto', src: game.thumbnail, alt: '', height: 120});
                    var titulo = $('<p>', {class: 'text-lg font-semibold', text: game.title.replace(/(Free\s)|(Get\s)|(\s?on\sPC)|\(PC\)|(for FREE(\s\W)?)|(!\$)/g, '')});
                    var precio = $('<p>', {class: '', html: '<span class="text-sm font-semibold line-through text-red-600">' + game.worth + '</span> <span class="font-semibold text-green-500">Gratis</span>'});
                    var oferta = $('<a>', {class: 'flex items-center mt-auto block button is-primary p-1 justify-content-center rounded-xl', target: '_blank', href: game.open_giveaway_url, text: 'Ver oferta'});
                    juego.append(imagen, titulo, precio, oferta);
                    juegosContenedor.append(juego);
                }
                });
            }
            },
            error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
            }
        });
        }

</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-175741564-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-175741564-2');
</script>
