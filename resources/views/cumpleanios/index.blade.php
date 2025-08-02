<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Cumpleaños') }}
        </a>
    </li>
    @endsection

    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 1rem;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            padding-top: 100px;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.6);
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            width: 300px;
            border-radius: 8px;
            text-align: center;
        }

        .close {
            float: right;
            color: #aaa;
            font-size: 24px;
            cursor: pointer;
        }
    </style>

<h2 style="text-align:center;">🎂Cumpleañeros del Mes🎂 </h2>
<div id='calendar'></div>

<!-- Modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" id="cerrar-modal">&times;</span>
        <h3>🎈 ¡Feliz cumpleaños!</h3>
        <p id="nombre-cumpleanero"></p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            events: "{{ route('cumpleanios.listado') }}",
            eventClick: function (info) {
                document.getElementById('nombre-cumpleanero').textContent = info.event.title;
                document.getElementById('modal').style.display = 'block';
            }
        });

        calendar.render();

        document.getElementById('cerrar-modal').onclick = function () {
            document.getElementById('modal').style.display = 'none';
        }

        window.onclick = function (event) {
            if (event.target == document.getElementById('modal')) {
                document.getElementById('modal').style.display = 'none';
            }
        }
    });
</script>
</x-app-layout>