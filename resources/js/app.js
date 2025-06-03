import './bootstrap';

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
Alpine.plugin(persist);
window.Alpine = Alpine;

Alpine.start();


import chart01 from "./components/chart-01";
import chart02 from "./components/chart-02";
import chart03 from "./components/chart-03";

document.addEventListener('DOMContentLoaded', () => {
    chart01();
    chart02();
    chart03();
})
