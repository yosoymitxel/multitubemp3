<header id="header" class="w-full header__contenedor align-self-start bg-gradient-to-r from-blue-500 to-green-500 py-3">
    <div id="header__contenido" x-data="{ open: false }" class="flex flex-col px-0 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
        <div id="boton-logo" class="px-4 flex flex-row items-center justify-between">
            <a id="logo__contenedor"class="" href="/">
                <a href="#" id="logo-container" class="brand-logo">Multi<span class=" text-blue-700 font-semibold">Tube</span>MP3</a>
            </a>
            <button id="btn-fill" class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
                <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                    <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <nav id="navbar" :class="{'flex': open, 'hidden': !open}" class="flex-col flex-grow md:pb-0 hidden md:flex md:justify-end md:flex-row">
            <a href="/" class="navbar-item">Inicio</a>
            <a class="navbar-item pb-3" href="http://www.linkea.ga/" target="_blank">Linkea</a>
            <a class="navbar-item pb-3" href="https://github.com/yosoymitxel/" target="_blank">Desarrollador</a>
            <a href="https://github.com/yosoymitxel/mutitubemp3.git" class="flex bg-white rounded-sm p-1 px-4 mr-2 text-green-700 font-weight-bold">
                <span class="justify-content-center align-self-center">Proyecto Open Source</span>
            </a>
        </nav>
    </div>
</header>


