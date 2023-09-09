<section class="rounded-xl sm:rounded shadow-xl bg-white p-4 my-4" id="acerca-de">
    <header class="juegos-gratis__header">
        <h2>¿Qué es MultitubeMP3?</h2>
        <hr class="my-4">
    </header>

    <div id="acerca-de__contenedor" class="text-justify">
        <p>MultitubeMP3 funciona como la típica página <span class="font-semibold">"Youtube to mp3 converter"</span> <i>(Convetidor de Youtube a mp3)</i> con la diferencia de que te permite <span class="font-semibold">descargar varias músicas al mismo tiempo</span></p>
        <h2 class="mt-4">¿Alguna vez te preguntaste cómo descargar una playlist de Youtube?</h2>
        <hr class="my-4">
        <p>Pues resulta que he aquí la respuesta, <span class="font-semibold">MultitubeMP3 te permite descargar varios videos de youtube en lista</span> para no tener que entrar una y otra vez al mismo sitio. Así te ahorras tiempo y no te comes tantos anuncios</p>
        <h2 class="text-muted text-sm mt-3">Descarga múltiples mp3 con MultitubeMP3</h2>
    </div>
</section>

<?php
$arrJuegos = json_decode(sc_url_curl('https://www.gamerpower.com/api/giveaways?type=game'))
?>
@if(sc_is_array($arrJuegos))
    <section id="juegos-gratis" class="rounded-xl sm:rounded shadow-xl bg-white p-4 my-4">
        <header class="juegos-gratis__header">
            <h2>Juegos en oferta gratis</h2>
            <hr class="my-4">
        </header>

        <div id="juegos-gratis__contenedor" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 overflow-auto scrollbar" style="max-height: 500px">

            @foreach ( $arrJuegos as $game)
                @if($game->worth != 'N/A')
                    <div class="h-full rounded-sm flex flex-col overflow-hidden">
                        <img class="md:w-48 rounded-t-md mx-auto" src="{{ $game->thumbnail }}" alt="" width="" height="120">
                        <p class="text-lg font-semibold">{{ sc_str_reemplazar_expresion_regular($game->title,'(Free\s)|(Get\s)|(\s?on\sPC)|\(PC\)|(for FREE(\s\W)?)|(!$)','') }}</p>
                        <p class=""><span class="text-sm font-semibold line-through text-red-600">{{ $game->worth }}</span> <span class="font-semibold text-green-500">Gratis</span></p>
                        <a class="flex items-center mt-auto block button is-primary p-1 justify-content-center rounded-xl" target="_blank" href="{{ $game->open_giveaway_url }}">Ver oferta</a>
                    </div>
                @endif
            @endforeach
        </div>
        <footer id="juegos-gratis__footer" class="bg-transparent">
            <hr class="my-4">
            <p class="text-muted">Datos obtenidos de <a target="_blank" class="text-muted font-semibold " href="//www.gamerpower.com/">www.gamerpower.com</a></p>
        </footer>
    </section>
@else
<script id="get-games">
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
@endif
