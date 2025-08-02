import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'preline';


import Toastify from 'toastify-js';
import "toastify-js/src/toastify.css";

window.Toastify = Toastify;

import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
window.flatpickr = flatpickr;

import tinymce from 'tinymce/tinymce';
window.tinymce = tinymce; // Hacerlo disponible globalmente

/** Import tinymce main files */

import 'tinymce/skins/ui/oxide/skin';
import 'tinymce/skins/ui/oxide/content';
import 'tinymce/skins/content/default/content';
import 'tinymce/icons/default/icons';
import 'tinymce/themes/silver/theme';
import 'tinymce/models/dom/model';

/** Import all plugin */
import 'tinymce/plugins/autosave';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/table';
import 'tinymce/plugins/autoresize';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/wordcount';


import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';

(function (global) {
    global.FullCalendar = {
      Calendar: function (elt, options) {
        return new Calendar(elt, Object.assign({
          plugins: [ dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin ],
          /*locales: allLocales,*/
        }, options))
      }
    }
  })(window);

