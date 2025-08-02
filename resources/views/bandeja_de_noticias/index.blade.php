<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Noticias') }}
        </a>
    </li>
    @endsection


    <div class="max-w-[100rem] mx-auto p-4">        
        <div class="flex flex-col md:flex-row items-stretch gap-6">
            <div class="w-full md:w-1/3 bg-white rounded-lg shadow self-start overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-700 mr-2">Listado</h2>
                    <div class="flex items-center gap-x-3">
                        <label for="hs-xs-switch" class="text-sm text-gray-500 dark:text-neutral-400">Mostrar notificaciones al ingresar?</label>

                        <label for="hs-xs-switch" class="relative inline-block w-9 h-5 cursor-pointer">
                          <input type="checkbox" id="hs-xs-switch" onchange="actualizarEstado()" class="peer sr-only" @checked(auth()->user()->configuracion->mostrar_bandeja_noticias == 'S')>
                          <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                          <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-4 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                        </label>
                    </div>
                </div>
                <div id="notifications-list" class="pb-2 divide-y divide-gray-200 overflow-y-auto max-h-[600px]">
                </div>
            </div>
            
            <div class="w-full md:w-2/3 bg-white rounded-lg shadow self-start">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-700">Detalle de Notificación</h2>
                </div>
                <div id="notification-detail" class="px-6 py-4 relative">

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationsList = document.getElementById('notifications-list');
            const notificationDetail = document.getElementById('notification-detail');
            
            let notifications = [];
            let isLoading = false;
            let error = null;

            async function loadNotifications() {
                isLoading = true;
                error = null;
                updateLoadingState();
                
                try {
                    const response = await fetch("{{ route('noticias.listado') }}");
                    
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    notifications = Array.isArray(data) ? data : [];
                                        
                    renderNotificationsList();
                    
                    const unread = notifications.find(n => !n.read);
                    if (unread) {
                        showNotificationDetail(unread.id);
                    }
                } catch (err) {
                    console.error('Error al cargar notificaciones:', err);
                    error = err.message;
                    showErrorMessage();
                } finally {
                    isLoading = false;
                    updateLoadingState();
                }
            }

            function updateLoadingState() {
                if (isLoading) {
                    notificationsList.innerHTML = `
                        <div class="p-8 flex flex-col items-center justify-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mb-2"></div>
                            <p class="text-gray-600">Cargando notificaciones...</p>
                        </div>
                    `;
                    notificationDetail.innerHTML = `
                        <div class="p-6 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p>Selecciona una notificación para ver su contenido</p>
                        </div>
                    `;
                }
            }

            function showErrorMessage() {
                notificationsList.innerHTML = `
                    <div class="p-6 text-center text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-medium">Error al cargar notificaciones</p>
                        <p class="text-sm mt-1 text-red-500">${error || 'Error desconocido'}</p>
                        <button onclick="loadNotifications()" class="mt-4 px-4 py-2 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100 transition-colors">
                            Reintentar
                        </button>
                    </div>
                `;
            }

            function renderNotificationsList() {
                if (!notifications.length) {
                    notificationsList.innerHTML = `
                        <div class="p-6 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p>No hay notificaciones disponibles</p>
                        </div>
                    `;
                    return;
                }
                
                notificationsList.innerHTML = '';
                
                notifications.forEach(notification => {
                    const notificationElement = document.createElement('div');
                    notificationElement.className = `px-4 py-2 hover:bg-gray-50 cursor-pointer transition-colors ${notification.read == 'true' ? 'bg-white' : 'bg-blue-50'}`;
                    notificationElement.dataset.id = notification.id;
                    
                    notificationElement.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <h3 class="flex items-center text-sm font-medium ${notification.read == 'true' ? 'text-gray-600' : 'text-blue-800'} truncate">
                                    ${notification.read == 'false' ? '<div class="mr-2 w-2 h-2 bg-blue-500 rounded-full"></div>' : ''}
                                    ${notification.titulo || 'Sin título'}
                                </h3>
                                <p class="text-xs ${notification.read == 'true' ? 'text-gray-500' : 'text-blue-600'}">Generado por ${notification.creador.name}</p>
                            </div>
                            <span class="ml-2 text-xs ${notification.read == 'true' ? 'text-gray-400' : 'text-blue-500'}">${formatDate(notification.created_at)}</span>
                        </div>
                    `;
                    
                    notificationElement.addEventListener('click', () => showNotificationDetail(notification.id));
                    notificationsList.appendChild(notificationElement);
                });
            }

            function showNotificationDetail(id) {
                const notification = notifications.find(n => n.id === id);
                
                if (!notification) return;
                
                notification.read = 'true';
                renderNotificationsList();
                
                notificationDetail.innerHTML = `
                    <div class="space-y-2">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-800">${notification.titulo || 'Sin título'}</h3>
                                <span class="text-sm text-gray-500">${formatDate(notification.created_at)}</span>
                            </div>
                            <button id="maximizeNotificationBtn" onclick="maximizeNotificationDetail(${notification.id})"
                                    class="ml-4 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 flex-shrink-0"
                                    title="Maximizar para lectura">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex items-center">
                            <span class="px-2 text-xs rounded-full bg-blue-100 text-blue-800">
                                Noticia
                            </span>
                            <span class="px-2 ml-1 text-xs rounded-full bg-green-100 text-green-800">Leída</span>
                        </div>

                        <iframe id="miIframe" class="w-full h-96 border-0"></iframe>
                    </div>
                `;

                const iframe = document.getElementById('miIframe');
                iframe.srcdoc = notification.contenido;

                updateNotificationStatus(notification.id)
            }

            function formatDate(dateString) 
            {
                if (!dateString) return 'Sin fecha';
                
                try {
                    const options = { year: 'numeric', month: 'short', day: 'numeric' };
                    return new Date(dateString).toLocaleDateString('es-ES', options);
                } catch {
                    return dateString;
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

            // Make maximize functions globally accessible
            window.maximizeNotificationDetail = function(notificationId) {
                console.log('maximizeNotificationDetail called with notificationId:', notificationId);
                console.log('notifications:', notifications);
                const notification = notifications.find(n => n.id === notificationId);
                console.log('found notification:', notification);
                if (!notification) return;

            // Create fullscreen overlay
            const fullscreenOverlay = document.createElement('div');
            fullscreenOverlay.id = 'notificationFullscreenOverlay';
            fullscreenOverlay.className = 'fixed inset-0 bg-white z-[60] flex flex-col transition-opacity duration-300 opacity-0';

            fullscreenOverlay.innerHTML = `
                <div class="flex-shrink-0 border-b border-gray-200 p-4 bg-white">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <h2 class="text-xl font-bold text-gray-800">Modo Lectura</h2>
                            <span class="ml-3 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Noticia</span>
                        </div>
                        <button id="minimizeNotificationBtn" onclick="minimizeNotificationDetail()"
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
                            <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">${notification.titulo || 'Sin título'}</h1>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 pb-6 border-b border-gray-200">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Publicado: ${formatDate(notification.created_at)}
                                </span>
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Autor: ${notification.creador ? notification.creador.name : 'Sistema'}
                                </span>
                            </div>
                        </div>
                        <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                            <iframe id="fullscreenIframe" class="w-full min-h-[600px] border-0"></iframe>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(fullscreenOverlay);

            // Set iframe content
            const fullscreenIframe = document.getElementById('fullscreenIframe');
            fullscreenIframe.srcdoc = notification.contenido;

            // Trigger animation
            setTimeout(() => {
                fullscreenOverlay.classList.remove('opacity-0');
                fullscreenOverlay.classList.add('opacity-100');
            }, 10);

            // Prevent body scroll
            document.body.style.overflow = 'hidden';

            // Add keyboard support
            document.addEventListener('keydown', handleNotificationFullscreenKeydown);
            };

            window.minimizeNotificationDetail = function() {
                console.log('minimizeNotificationDetail called');
                const overlay = document.getElementById('notificationFullscreenOverlay');
            if (overlay) {
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');

                setTimeout(() => {
                    overlay.remove();
                    document.body.style.overflow = '';
                    document.removeEventListener('keydown', handleNotificationFullscreenKeydown);
                }, 300);
            }
            };

            function handleNotificationFullscreenKeydown(event) {
                if (event.key === 'Escape') {
                    window.minimizeNotificationDetail();
                }
            }

            loadNotifications();

            // Verify functions are attached
            console.log('Bandeja functions attached:', {
                maximizeNotificationDetail: typeof window.maximizeNotificationDetail,
                minimizeNotificationDetail: typeof window.minimizeNotificationDetail
            });
        });

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
</x-app-layout>