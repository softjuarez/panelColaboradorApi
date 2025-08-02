import React from 'react';
import ReactDOM from 'react-dom/client';
import OrgChartView from '../components/OrgChartView';

export function initOrgChartView(elementId) {
    const element = document.getElementById(elementId);
    if (!element) return;

    if (element._reactRoot) return;

    const root = ReactDOM.createRoot(element);
    root.render(
        <React.StrictMode>
            <div className="">
                <OrgChartView organigramaId={window.organigramaId} />
            </div>
        </React.StrictMode>
    );

    element._reactRoot = true;
}
