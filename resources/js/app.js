import './bootstrap';

//import {Alpine, Livewire} from "../../vendor/livewire/livewire/dist/livewire.esm";
//import Alpine from "alpinejs";
import persist from "@alpinejs/persist";

//window.Alpine = Alpine;
//window.Livewire = Livewire;

//Livewire.start()
//Alpine.start();

document.addEventListener('alpine:init', function () {
    Alpine.plugin(persist);
})


import chart01 from "./components/chart-01";
import chart02 from "./components/chart-02";
import chart03 from "./components/chart-03";

document.addEventListener('DOMContentLoaded', () => {
    chart01();
    chart02();
    chart03();
})
