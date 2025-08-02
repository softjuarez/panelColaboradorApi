import { useState } from 'react';

const ColorPicker = ({ name, value, onChange }) => {
  const colors600 = [
    { name: 'Rojo', value: '#dc2626' },
    { name: 'Naranja', value: '#ea580c' },
    { name: 'Ámbar', value: '#d97706' },
    { name: 'Amarillo', value: '#ca8a04' },
    { name: 'Lima', value: '#65a30d' },
    { name: 'Verde', value: '#16a34a' },
    { name: 'Esmeralda', value: '#059669' },
    { name: 'Verde azulado', value: '#0d9488' },
    { name: 'Cian', value: '#0891b2' },
    { name: 'Celeste', value: '#0284c7' },
    { name: 'Azul', value: '#2563eb' },
    { name: 'Índigo', value: '#4f46e5' },
    { name: 'Violeta', value: '#7c3aed' },
    { name: 'Púrpura', value: '#9333ea' },
    { name: 'Fucsia', value: '#c026d3' },
    { name: 'Rosa', value: '#db2777' },
    { name: 'Rosado', value: '#e11d48' },
    { name: 'Pizarra', value: '#475569' },
    { name: 'Gris', value: '#4b5563' },
    { name: 'Cinc', value: '#52525b' },
    { name: 'Neutral', value: '#525252' },
    { name: 'Piedra', value: '#57534e' }
  ];

  const handleChange = (e) => {
    const syntheticEvent = {
      target: {
        name: name,
        value: e.target.value
      }
    };
    onChange(syntheticEvent);
  };

  return (
    <div style={{ maxWidth: '300px' }}>
      <div
        style={{
          backgroundColor: value || '#ffffff',
          height: '60px',
          borderRadius: '8px 8px 0 0',
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          color: '#fff',
          textShadow: '0 1px 2px rgba(0,0,0,0.5)',
          fontWeight: 'bold',
          border: '1px solid #ddd'
        }}
      >
        {'Ejemplo Nodo'}
      </div>

      <select
        name={name}
        value={value || ''}
        onChange={handleChange}
        style={{
          width: '100%',
          padding: '10px',
          borderRadius: '0 0 8px 8px',
          border: `2px solid ${value || '#cccccc'}`,
          outline: 'none',
          cursor: 'pointer'
        }}
      >
        <option value="">Selecciona un color</option>
        {colors600.map((color) => (
          <option
            key={color.value}
            value={color.value}
          >
            {color.name}
          </option>
        ))}
      </select>
    </div>
  );
};

export default ColorPicker;
