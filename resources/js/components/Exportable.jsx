import React, { useState } from 'react';
import { Panel, useReactFlow } from 'reactflow';
import { toPng } from 'html-to-image';
import { jsPDF } from 'jspdf';
import { FaSpinner, FaFileExport, FaFilePdf, FaFileImage } from 'react-icons/fa';

const PANEL_SELECTOR = '[data-testid="export-panel"]';
const MINIMAP_SELECTOR = '.react-flow__minimap';

function DownloadButton() {
  const { getNodes, fitView } = useReactFlow();
  const [isExporting, setIsExporting] = useState(false);
  const [showOptions, setShowOptions] = useState(false);

  const exportFlow = async (format = 'png') => {
    if (isExporting) return;

    const flowElement = document.querySelector('.react-flow');
    const panelElement = document.querySelector(PANEL_SELECTOR);
    const controlsElement = document.querySelector('.react-flow__controls');
    const minimapElement = document.querySelector(MINIMAP_SELECTOR);

    if (!flowElement) {
      console.error('No se pudo encontrar el elemento .react-flow');
      return;
    }

    setIsExporting(true);
    setShowOptions(false);

    const overlay = document.createElement('div');
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
    overlay.style.display = 'flex';
    overlay.style.justifyContent = 'center';
    overlay.style.alignItems = 'center';
    overlay.style.zIndex = '1000';
    overlay.innerHTML = '<div style="font-size: 1.5rem; font-weight: bold;">Exportando organigrama...</div>';
    document.body.appendChild(overlay);

    const originalEdgeStyles = [];
    const flowViewport = flowElement.querySelector('.react-flow__viewport');
    const originalTransform = flowViewport ? flowViewport.style.transform : '';

    try {
      // Tu lógica de exportación (perfecta como está)
      const nodes = getNodes();
      if (nodes.length === 0) {
        setIsExporting(false);
        document.body.removeChild(overlay);
        return;
      }

      let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;
      nodes.forEach(node => {
        const nodeWidth = node.width || 200;
        const nodeHeight = node.height || 50;
        minX = Math.min(minX, node.position.x);
        minY = Math.min(minY, node.position.y);
        maxX = Math.max(maxX, node.position.x + nodeWidth);
        maxY = Math.max(maxY, node.position.y + nodeHeight);
      });

      const padding = 50;
      const imageWidth = Math.round((maxX - minX) + padding * 2);
      const imageHeight = Math.round((maxY - minY) + padding * 2);

      if (panelElement) panelElement.style.visibility = 'hidden';
      if (controlsElement) controlsElement.style.visibility = 'hidden';
      if (minimapElement) minimapElement.style.visibility = 'hidden';

      const edges = flowElement.querySelectorAll('.react-flow__edge-path');
      edges.forEach(edge => {
        originalEdgeStyles.push({ element: edge, style: edge.style.cssText });
        edge.style.stroke = '#555';
        edge.style.strokeWidth = '1.5px';
        edge.style.opacity = '1';
      });

      flowElement.style.width = `${imageWidth}px`;
      flowElement.style.height = `${imageHeight}px`;
      if(flowViewport) {
        flowViewport.style.transform = `translate(${-minX + padding}px, ${-minY + padding}px) scale(1)`;
      }

      await new Promise(resolve => setTimeout(resolve, 300));

      const dataUrl = await toPng(flowElement, {
        backgroundColor: '#ffffff',
        width: imageWidth,
        height: imageHeight,
        pixelRatio: 2.5,
        cacheBust: true,
        filter: (node) => !node.classList || !node.classList.contains('react-flow__minimap'),
      });

      if (format === 'png') {
        const a = document.createElement('a');
        a.href = dataUrl;
        a.download = 'organigrama.png';
        a.click();
      } else {
        const pdf = new jsPDF({
          orientation: imageWidth > imageHeight ? 'landscape' : 'portrait',
          unit: 'mm',
          format: 'a4'
        });
        const pdfMargin = 15;
        const pdfPageWidth = pdf.internal.pageSize.getWidth() - pdfMargin * 2;
        const pdfPageHeight = pdf.internal.pageSize.getHeight() - pdfMargin * 2;
        const imageAspectRatio = imageWidth / imageHeight;
        const pageAspectRatio = pdfPageWidth / pdfPageHeight;
        let pdfImageWidth, pdfImageHeight;
        if (imageAspectRatio > pageAspectRatio) {
          pdfImageWidth = pdfPageWidth;
          pdfImageHeight = pdfPageWidth / imageAspectRatio;
        } else {
          pdfImageHeight = pdfPageHeight;
          pdfImageWidth = pdfPageHeight * imageAspectRatio;
        }
        const x = pdfMargin + (pdfPageWidth - pdfImageWidth) / 2;
        const y = pdfMargin + (pdfPageHeight - pdfImageHeight) / 2;
        pdf.addImage(dataUrl, 'PNG', x, y, pdfImageWidth, pdfImageHeight);
        pdf.save('organigrama.pdf');
      }

    } catch (error) {
      console.error('Error durante la exportación:', error);
      alert('Ocurrió un error al exportar el organigrama.');
    } finally {
      // 5. Restaurar DOM
      if (panelElement) panelElement.style.visibility = 'visible';
      if (controlsElement) controlsElement.style.visibility = 'visible';
      if (minimapElement) minimapElement.style.visibility = 'visible';

      originalEdgeStyles.forEach(({ element, style }) => {
        element.style.cssText = style;
      });

      flowElement.style.width = '100%';
      flowElement.style.height = '100%';

      if (flowViewport) {
        flowViewport.style.transform = originalTransform;
      }

      // La magia está aquí: esperamos un instante antes de centrar.
      setTimeout(() => {
        fitView({ padding: 0.2, duration: 400 });
      }, 100);

      setIsExporting(false);
      document.body.removeChild(overlay);
    }
  };

  return (
    <Panel position="top-right" data-testid="export-panel">
       {/* El JSX de tu panel sigue igual, es perfecto */}
      <div style={{
        display: 'flex',
        flexDirection: showOptions ? 'column' : 'row',
        gap: '8px',
        padding: '10px',
        background: 'white',
        borderRadius: '5px',
        boxShadow: '0 0 10px rgba(0,0,0,0.1)',
        alignItems: 'center'
      }}>
        {showOptions ? (
          <>
            <button
              className="download-btn"
              onClick={() => exportFlow('png')}
              disabled={isExporting}
              title="Exportar a PNG"
            >
              {isExporting ? <FaSpinner className="spin" /> : <><FaFileImage /> PNG</>}
            </button>
            <button
              className="download-btn"
              onClick={() => exportFlow('pdf')}
              disabled={isExporting}
              title="Exportar a PDF"
            >
              {isExporting ? <FaSpinner className="spin" /> : <><FaFilePdf /> PDF</>}
            </button>
          </>
        ) : (
          <button
            className="download-btn"
            onClick={() => setShowOptions(true)}
            title="Opciones de exportación"
          >
            <FaFileExport />
          </button>
        )}
      </div>
      <style jsx>{`
        .download-btn {
          background-color: #f0f0f0;
          border: 1px solid #ccc;
          padding: 8px 12px;
          border-radius: 4px;
          cursor: pointer;
          font-weight: bold;
          transition: background-color 0.2s, opacity 0.2s;
          display: flex;
          align-items: center;
          gap: 6px;
          min-width: ${showOptions ? '100px' : 'auto'};
        }
        .download-btn:hover:not(:disabled) {
          background-color: #e0e0e0;
        }
        .download-btn:disabled {
          cursor: not-allowed;
          opacity: 0.6;
        }
        .spin {
          animation: spin 1s linear infinite;
        }
        @keyframes spin {
          from { transform: rotate(0deg); }
          to { transform: rotate(360deg); }
        }
      `}</style>
    </Panel>
  );
}

export default DownloadButton;
