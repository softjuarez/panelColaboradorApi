import React, { useState } from 'react';
import * as LucideIcons from 'lucide-react';

const ICON_LIST = [
  'Home', 'User', 'Settings', 'Mail', 'Calendar', 'Search',
  'Bell', 'MessageSquare', 'Heart', 'Star', 'Plus', 'Minus',
  'Check', 'X', 'ArrowRight', 'ArrowLeft', 'Download', 'Upload',
  'Image', 'Camera', 'Music', 'Video', 'File', 'Folder'
];

const IconSelector = ({ onIconSelect, defaultSize = 24 }) => {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedIcon, setSelectedIcon] = useState(null);
  const [size, setSize] = useState(defaultSize);

  const filteredIcons = ICON_LIST.filter(iconName =>
    iconName.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const handleIconClick = (iconName) => {
    const iconData = {
      name: iconName,
      component: LucideIcons[iconName],
      size
    };
    setSelectedIcon(iconData);
    onIconSelect?.(iconData);
  };

  return (
    <div style={styles.container}>
      {/* Barra de búsqueda */}
      <div style={styles.searchBar}>
        <LucideIcons.Search size={18} />
        <input
          type="text"
          placeholder="Buscar icono..."
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)}
          style={styles.input}
        />
      </div>

      {/* Selector de tamaño */}
      <div style={styles.sizeControl}>
        <label>Tamaño: </label>
        <input
          type="range"
          min="16"
          max="48"
          value={size}
          onChange={(e) => setSize(parseInt(e.target.value))}
        />
        <span>{size}px</span>
      </div>

      {/* Grid de iconos */}
      <div style={styles.iconsGrid}>
        {filteredIcons.map(iconName => {
          const IconComponent = LucideIcons[iconName];
          return (
            <div
              key={iconName}
              onClick={() => handleIconClick(iconName)}
              style={{
                ...styles.iconItem,
                ...(selectedIcon?.name === iconName && styles.selectedIcon)
              }}
              title={iconName}
            >
              {IconComponent && <IconComponent size={size} />}
              <span style={styles.iconName}>{iconName}</span>
            </div>
          );
        })}
      </div>


    </div>
  );
};


const styles = {
  container: {
    maxWidth: '800px',
    margin: '0 auto',
    padding: '20px',
    fontFamily: 'Arial, sans-serif'
  },
  searchBar: {
    display: 'flex',
    alignItems: 'center',
    marginBottom: '20px',
    padding: '10px',
    border: '1px solid #ddd',
    borderRadius: '5px'
  },
  input: {
    flex: 1,
    marginLeft: '10px',
    border: 'none',
    outline: 'none',
    fontSize: '16px'
  },
  sizeControl: {
    display: 'flex',
    alignItems: 'center',
    gap: '10px',
    marginBottom: '20px'
  },
  iconsGrid: {
    display: 'grid',
    gridTemplateColumns: 'repeat(auto-fill, minmax(100px, 1fr))',
    gap: '15px',
    maxHeight: '400px',
    overflowY: 'auto',
    padding: '10px',
    border: '1px solid #eee',
    borderRadius: '5px'
  },
  iconItem: {
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    padding: '15px 5px',
    cursor: 'pointer',
    borderRadius: '5px',
    transition: 'all 0.2s'
  },
  selectedIcon: {
    backgroundColor: '#e6f7ff',
    border: '1px solid #91d5ff'
  },
  iconName: {
    marginTop: '8px',
    fontSize: '12px',
    textAlign: 'center'
  },
  preview: {
    marginTop: '30px',
    padding: '20px',
    backgroundColor: '#f9f9f9',
    borderRadius: '5px',
    textAlign: 'center'
  },
  codePreview: {
    marginTop: '15px',
    padding: '10px',
    backgroundColor: '#333',
    color: '#fff',
    borderRadius: '5px',
    fontFamily: 'monospace',
    overflowX: 'auto'
  }
};

export default IconSelector;
