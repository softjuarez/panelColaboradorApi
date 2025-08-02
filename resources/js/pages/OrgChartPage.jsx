import React from 'react';
import ReactDOM from 'react-dom/client';
import OrgChart from '../components/OrgChart';

export function initOrgChart(elementId) {
    const element = document.getElementById(elementId);
    if (!element) return;

    if (element._reactRoot) return;

    const root = ReactDOM.createRoot(element);
    root.render(
        <React.StrictMode>
            <div className="">
                <OrgChart organigramaId={window.organigramaId} />
            </div>
        </React.StrictMode>
    );

    element._reactRoot = true;
}
