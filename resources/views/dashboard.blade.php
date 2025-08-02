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
                
                <div id="newsDetail" class="w-2/3 p-6 overflow-y-auto">
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
                        <h3 class="text-2xl font-bold">${news.titulo}</h3>
                        <div class="flex justify-between items-center text-sm text-gray-600">
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
