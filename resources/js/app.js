import './bootstrap';
import flatpickr from "flatpickr"
import { Indonesian } from "flatpickr/dist/l10n/id.js";
import Quill from "quill";
import "quill/dist/quill.snow.css";

window.flatpickr = flatpickr;
window.flatpickr_local_id = Indonesian;

window.Quill = Quill;

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (!sidebar || !overlay) return;

    sidebar.classList.toggle('-translate-x-full');
    sidebar.classList.toggle('translate-x-0');
    overlay.classList.toggle('hidden');
}

function initSidebar() {
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const overlay = document.getElementById('sidebar-overlay');

    if (hamburgerBtn) {
        hamburgerBtn.removeEventListener('click', toggleSidebar);
        hamburgerBtn.addEventListener('click', toggleSidebar);
    }
    if (overlay) {
        overlay.removeEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    }
}

// saat load awal
document.addEventListener('DOMContentLoaded', initSidebar);

// setiap selesai wire:navigate
document.addEventListener('livewire:navigated', initSidebar);