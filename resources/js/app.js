// Third Party Libraries
import 'flowbite'

import Alpine from 'alpinejs'
import $ from 'jquery'
import Swal from 'sweetalert2'

import Chart from 'chart.js/auto'
import ChartDataLabels from 'chartjs-plugin-datalabels'

// Handmade Modules
import Modal from './modal'
import Toast from './toast'
import initSearchableDropdowns from './searchable-dropdown';
import initToggleList from './toggle-list';

const toast = new Toast();

// Global Expose
window.Alpine = Alpine
window.$ = $
window.jQuery = $
window.Swal = Swal
window.Chart = Chart
window.ChartDataLabels = ChartDataLabels
window.closeToast = () => toast.close();
window.Modal = Modal
window.Toast = Toast

// Register Chart plugin (penting)
Chart.register(ChartDataLabels)

// Initialize Custom Scripts
document.addEventListener("DOMContentLoaded", () => {
    Modal.init()
    initSearchableDropdowns();
    initToggleList();
})

// Start Alpine
Alpine.start()