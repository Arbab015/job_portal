import './bootstrap';

import Alpine from 'alpinejs';
// jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

// DataTables JS + CSS
import 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
window.Alpine = Alpine;

Alpine.start();
