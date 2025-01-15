(function(){
  'use strict';

  document.addEventListener('DOMContentLoaded', function() {
    // Seleccionamos .forum-modal
    const modal = document.querySelector('.forum-modal');
    if(!modal) return; // Si no hay modal, no hacemos nada

    const closeBtn = document.getElementById('closeForumModal');
    const cancelBtn = document.getElementById('cancelNewPostBtn');
    const addCodeBlockBtn = document.getElementById('addCodeBlockBtn');
    const addImageBtn = document.getElementById('addImageBtn');
    const dynamicSections = document.getElementById('dynamicSections');

    // Cerrar modal => redirige a /foro
    if(closeBtn) {
      closeBtn.addEventListener('click', () => {
        window.location.href = '/foro';
      });
    }
    if(cancelBtn) {
      cancelBtn.addEventListener('click', () => {
        window.location.href = '/foro';
      });
    }

    // Agregar bloque de código
    if(addCodeBlockBtn && dynamicSections) {
      addCodeBlockBtn.addEventListener('click', () => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('forum-modal__dynamic-item');

        // Botón para eliminar este bloque
        const removeBtn = document.createElement('button');
        removeBtn.classList.add('remove-item-btn');
        removeBtn.innerHTML = '&times;';
        removeBtn.addEventListener('click', () => {
          itemDiv.remove();
        });
        itemDiv.appendChild(removeBtn);

        const label = document.createElement('label');
        label.textContent = 'Bloque de código:';
        itemDiv.appendChild(label);

        // textarea para el código, estilo monospace
        const textarea = document.createElement('textarea');
        textarea.name = 'blocks_code[]';
        textarea.rows = 6;
        textarea.classList.add('code-snippet');
        itemDiv.appendChild(textarea);

        dynamicSections.appendChild(itemDiv);
      });
    }

    // Agregar imagen extra (con vista previa)
    if(addImageBtn && dynamicSections) {
      addImageBtn.addEventListener('click', () => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('forum-modal__dynamic-item');

        // Botón para eliminar este bloque
        const removeBtn = document.createElement('button');
        removeBtn.classList.add('remove-item-btn');
        removeBtn.innerHTML = '&times;';
        removeBtn.addEventListener('click', () => {
          itemDiv.remove();
        });
        itemDiv.appendChild(removeBtn);

        const label = document.createElement('label');
        label.textContent = 'Imagen adicional:';
        itemDiv.appendChild(label);

        const inputFile = document.createElement('input');
        inputFile.type = 'file';
        inputFile.name = 'blocks_images[]';
        itemDiv.appendChild(inputFile);

        // contenedor de vista previa
        const previewDiv = document.createElement('div');
        previewDiv.classList.add('image-preview-container');
        itemDiv.appendChild(previewDiv);

        // Al cambiar el input file => vista previa
        inputFile.addEventListener('change', (e) => {
          const file = e.target.files[0];
          if(file) {
            const reader = new FileReader();
            reader.onload = (event) => {
              previewDiv.innerHTML = '';
              const img = document.createElement('img');
              img.src = event.target.result;
              previewDiv.appendChild(img);
            };
            reader.readAsDataURL(file);
          } else {
            previewDiv.innerHTML = '';
          }
        });

        dynamicSections.appendChild(itemDiv);
      });
    }

  });
})();
