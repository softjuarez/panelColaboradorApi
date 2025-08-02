import React from 'react';

const Modal = ({ isOpen, onClose, children }) => {
  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div className="bg-white rounded-lg w-full max-w-2xl">
        <div class="bg-gray-800 py-4 px-4 flex justify-between items-center rounded-t-lg">
            <button onClick={onClose} className="top-4 right-4 text-white hover:text-gray-100">
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div className='px-6 py-4'>
        {children}
        </div>
      </div>
    </div>
  );
};

export default Modal;
