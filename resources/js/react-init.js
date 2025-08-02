
import { initOrgChart } from './pages/OrgChartPage';
import { initOrgChartView } from './pages/OrgChartViewPage';


const initializeReact = () => {
    // Espera un breve momento para asegurar que Alpine está listo
    if (window.Alpine) {
        initOrgChart('org-chart-container');
        initOrgChartView('org-chart-view-container');
    } else {
        setTimeout(initializeReact, 50);
    }
};

// Dos métodos de inicialización para cubrir todos los casos
document.addEventListener('alpine:init', initializeReact);
document.addEventListener('DOMContentLoaded', initializeReact);
