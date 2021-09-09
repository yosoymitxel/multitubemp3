<section class="rounded-xl sm:rounded shadow-xl bg-white p-4 my-4" id="busqueda-form">

</section>

<section id="juegos-gratis" class="rounded-xl sm:rounded shadow-xl bg-white p-4 my-4">
    <header class="juegos-gratis__header">
        <h2>Juegos en oferta gratis</h2>
        <hr class="my-4">
    </header>

    <div id="juegos-gratis__contenedor" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 overflow-auto scrollbar" style="max-height: 500px">
        @foreach (json_decode(sc_url_curl('https://www.gamerpower.com/api/giveaways?type=game')) as $game)
            @if($game->worth != 'N/A')
                <div class="h-full rounded-sm flex flex-col overflow-hidden">
                    <img class="md:w-48 rounded-t-md mx-auto" src="{{ $game->thumbnail }}" alt="" width="" height="120">
                    <p class="text-lg font-semibold">{{ sc_str_reemplazar_expresion_regular($game->title,'(\Free\s)|(Get\s)|(\s?on\sPC)|\(PC\)|(for FREE(\s\W)?)|(!$)','') }}</p>
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
