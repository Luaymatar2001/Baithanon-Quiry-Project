import './bootstrap'; // bootstrap فقط، بدون Flowbite

// import Alpine from 'alpinejs';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid';
import './../../vendor/power-components/livewire-powergrid/dist/tailwind.css' // [!code ++] // bootstrap5.css

import flatpickr from "flatpickr";
import 'flatpickr/dist/flatpickr.css';
import { Arabic } from "flatpickr/dist/l10n/ar.js";

// window.Alpine = Alpine;
// Alpine.start();


window.flatpickr = flatpickr;

flatpickr.localize(Arabic);

