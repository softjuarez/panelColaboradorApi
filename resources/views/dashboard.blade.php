<x-dashboard-layout>
    <x-toast :show="session('status') != '' ? true : false" :type="session('status')" :message="session('message')"/>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-500 overflow-hidden shadow-sm sm:rounded-lg p-6">
                Bievenido(a) {{ auth()->user()->name }}
            </div>
        </div>
    </div>

    @if(isset($showNotificationsModal) && $showNotificationsModal && auth()->user()->configuracion->mostrar_bandeja_noticias == 'S')
    <div id="newsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-4/5 h-4/5 flex flex-col">
            <div class="border-b p-4 flex justify-between items-center">
                <div class="flex items-center">
                    <h2 class="text-xl font-bold mr-2">Últimas Noticias</h2>
                    <div class="flex items-center gap-x-3">
                        <label for="hs-xs-switch" class="relative inline-block w-9 h-5 cursor-pointer">
                          <input type="checkbox" id="hs-xs-switch" onchange="actualizarEstado()" class="peer sr-only" @checked(auth()->user()->configuracion->mostrar_bandeja_noticias == 'S')>
                          <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                          <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-4 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                        </label>
                        <label for="hs-xs-switch" class="text-sm text-gray-500 dark:text-neutral-400">Mostrar notificaciones al ingresar?</label>
                    </div>
                </div>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="flex flex-1 overflow-hidden">
                <div class="w-1/3 border-r overflow-y-auto">
                    <ul id="newsList" class="divide-y divide-gray-200">
                    </ul>
                </div>
                
                <div id="newsDetail" class="w-2/3 p-6 overflow-y-auto relative">
                    <div class="text-center py-10 text-gray-400">
                        Selecciona una noticia para ver su contenido
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('newsModal');
        const openModalBtn = document.getElementById('openModal');
        const closeModalBtn = document.getElementById('closeModal');
        const newsList = document.getElementById('newsList');
        const newsDetail = document.getElementById('newsDetail');

        const newsData = @json($notificationsToShow);

        modal.classList.remove('hidden');
        loadNewsList();

        closeModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        function loadNewsList() {
            newsList.innerHTML = '';
            newsData.forEach(news => {
                const li = document.createElement('li');
                li.className = 'px-4 py-2 hover:bg-gray-50 cursor-pointer';
                li.innerHTML = `
                    <h3 class="font-bold">${news.titulo}</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">${news.created}</span>
                        <span class="text-xs text-gray-500">${news.creador.name}</span>
                    </div>
                `;
                li.addEventListener('click', () => showNewsDetail(news.id));
                newsList.appendChild(li);
            });
        }

        function showNewsDetail(newsId) {
            const news = newsData.find(item => item.id === newsId);
            if (news) {
                newsDetail.innerHTML = `
                    <div class="mb-6">
                        <div class="flex justify-between items-start">
                            <h3 class="text-2xl font-bold flex-1">${news.titulo}</h3>
                            <button id="maximizeNewsBtn" onclick="maximizeNewsDetail(${newsId})"
                                    class="ml-4 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 flex-shrink-0"
                                    title="Maximizar para lectura">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-between items-center text-sm text-gray-600 mt-2">
                            <span>Publicado: ${news.created}</span>
                            <span>Autor: ${news.creador.name}</span>
                        </div>
                    </div>
                    <div class="prose max-w-none">${news.contenido}</div>
                `;
                
                const items = newsList.querySelectorAll('li');
                items.forEach(item => {
                    item.classList.remove('bg-blue-50', 'border-l-4', 'border-blue-500');
                });
                
                const selectedItem = newsList.querySelector(`li:nth-child(${newsData.findIndex(n => n.id === newsId) + 1})`);
                if (selectedItem) {
                    selectedItem.classList.add('bg-blue-50', 'border-l-4', 'border-blue-500');
                }

                updateNotificationStatus(newsId)
            }
        }

        window.maximizeNewsDetail = function(newsId) {
            console.log('maximizeNewsDetail called with newsId:', newsId);
            console.log('newsData:', newsData);
            const news = newsData.find(item => item.id === newsId);
            console.log('found news:', news);
            if (!news) return;

            // Create fullscreen overlay
            const fullscreenOverlay = document.createElement('div');
            fullscreenOverlay.id = 'newsFullscreenOverlay';
            fullscreenOverlay.className = 'fixed inset-0 bg-white z-[60] flex flex-col transition-opacity duration-300 opacity-0';

            fullscreenOverlay.innerHTML = `
                <div class="flex-shrink-0 border-b border-gray-200 p-4 bg-white">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <h2 class="text-xl font-bold text-gray-800">Modo Lectura</h2>
                            <span class="ml-3 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Noticia</span>
                        </div>
                        <button id="minimizeNewsBtn" onclick="minimizeNewsDetail()"
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                                title="Minimizar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M16 8l4 4-4 4M8 16l-4-4 4-4" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <div class="max-w-4xl mx-auto p-8">
                        <div class="mb-8">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">${news.titulo}</h1>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 pb-6 border-b border-gray-200">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Publicado: ${news.created}
                                </span>
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Autor: ${news.creador.name}
                                </span>
                            </div>
                        </div>
                        <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                            ${news.contenido}
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(fullscreenOverlay);

            // Trigger animation
            setTimeout(() => {
                fullscreenOverlay.classList.remove('opacity-0');
                fullscreenOverlay.classList.add('opacity-100');
            }, 10);

            // Prevent body scroll
            document.body.style.overflow = 'hidden';

            // Add keyboard support
            document.addEventListener('keydown', handleFullscreenKeydown);
        };

        window.minimizeNewsDetail = function() {
            console.log('minimizeNewsDetail called');
            const overlay = document.getElementById('newsFullscreenOverlay');
            if (overlay) {
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');

                setTimeout(() => {
                    overlay.remove();
                    document.body.style.overflow = '';
                    document.removeEventListener('keydown', handleFullscreenKeydown);
                }, 300);
            }
        };

        function handleFullscreenKeydown(event) {
            if (event.key === 'Escape') {
                window.minimizeNewsDetail();
            }
        }

        // Verify functions are attached
        console.log('Dashboard functions attached:', {
            maximizeNewsDetail: typeof window.maximizeNewsDetail,
            minimizeNewsDetail: typeof window.minimizeNewsDetail
        });

        async function updateNotificationStatus(id)
        {
            try {
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch("{{ route('noticias.vista') }}", {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json",
                        "Content-Type": "application/json" 
                    },
                    body: JSON.stringify({ 'id': id })
                });
                
                if (!response.ok) {
                    throw new Error('Error al actualizar notificación');
                }
            } catch (err) {
                console.error('Error:', err);
            }
        }

        async function actualizarEstado() 
        {
            try {
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let estado = document.getElementById('hs-xs-switch').checked ? 'S' : 'N';

                const response = await fetch("{{ route('configuracion.bandeja_noticias') }}", {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json",
                        "Content-Type": "application/json" 
                    },
                    body: JSON.stringify({ 'estado': estado })
                });
                
                if (!response.ok) {
                    throw new Error('Error al actualizar notificación');
                }
            } catch (err) {
                console.error('Error:', err);
            }
        }
        
    </script>
    @endif
</x-dashboard-layout>
