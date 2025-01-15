(function(){
    'use strict';
  
    document.addEventListener('DOMContentLoaded', function() {
      // 1) Botón para "Cancelar" o regresar
      const cancelBtn = document.getElementById('cancelEditPostBtn');
      if(cancelBtn) {
        cancelBtn.addEventListener('click', () => {
          // Redirigir a /foro o la URL que consideres para cancelar
          window.location.href = '/foro';
        });
      }
  
      // 2) Botón "Eliminar Publicación"
      const deletePostBtn = document.getElementById('deletePostBtn');
      if(deletePostBtn) {
        deletePostBtn.addEventListener('click', () => {
          const confirmacion = confirm('¿Deseas eliminar esta publicación? No se puede deshacer.');
          if(!confirmacion) return;
          // Redirigir, p.ej. a /foro/eliminar?id=XX
          const postId = "<?php echo $publicacion->id; ?>";
          window.location.href = "/foro/eliminar?id=" + postId;
        });
      }
  
      // 3) Remover media existente
      const removeItemBtns = document.querySelectorAll('.post-edit__remove-item-btn');
      const editForm = document.getElementById('editPostForm');
      removeItemBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          const mediaPath = btn.dataset.media;
          if(!mediaPath) return;
          // ocultar o remover el div
          const item = btn.closest('.post-edit__dynamic-item');
          if(item) item.style.display = 'none';
  
          // Crear un input hidden para indicar al backend que se elimine
          const hiddenInput = document.createElement('input');
          hiddenInput.type = 'hidden';
          hiddenInput.name = 'remove_media[]';
          hiddenInput.value = mediaPath;
          editForm.appendChild(hiddenInput);
        });
      });
  
      // 4) Lógica para añadir bloques de código / imagen => similar a tu modal
      const addCodeBlockBtn = document.getElementById('addCodeBlockBtn');
      const addImageBtn = document.getElementById('addImageBtn');
      const dynamicSections = document.getElementById('dynamicSections');
  
      if(addCodeBlockBtn && dynamicSections) {
        addCodeBlockBtn.addEventListener('click', () => {
          const itemDiv = document.createElement('div');
          itemDiv.classList.add('post-edit__dynamic-item');
  
          // Botón para eliminar
          const removeBtn = document.createElement('button');
          removeBtn.type = 'button';
          removeBtn.classList.add('post-edit__remove-item-btn');
          removeBtn.innerHTML = '&times;';
          removeBtn.addEventListener('click', () => itemDiv.remove());
          itemDiv.appendChild(removeBtn);
  
          // Etiqueta
          const label = document.createElement('label');
          label.textContent = 'Bloque de código (nuevo):';
          itemDiv.appendChild(label);
  
          // Textarea
          const textarea = document.createElement('textarea');
          textarea.name = 'blocks_code[]';
          textarea.rows = 6;
          textarea.classList.add('post-edit__code-snippet');
          itemDiv.appendChild(textarea);
  
          dynamicSections.appendChild(itemDiv);
        });
      }
  
      if(addImageBtn && dynamicSections) {
        addImageBtn.addEventListener('click', () => {
          const itemDiv = document.createElement('div');
          itemDiv.classList.add('post-edit__dynamic-item');
  
          // Botón para eliminar
          const removeBtn = document.createElement('button');
          removeBtn.type = 'button';
          removeBtn.classList.add('post-edit__remove-item-btn');
          removeBtn.innerHTML = '&times;';
          removeBtn.addEventListener('click', () => itemDiv.remove());
          itemDiv.appendChild(removeBtn);
  
          // Etiqueta
          const label = document.createElement('label');
          label.textContent = 'Imagen adicional (nueva):';
          itemDiv.appendChild(label);
  
          // Input file
          const inputFile = document.createElement('input');
          inputFile.type = 'file';
          inputFile.name = 'blocks_images[]';
          itemDiv.appendChild(inputFile);
  
          // Vista previa
          const previewDiv = document.createElement('div');
          previewDiv.classList.add('post-edit__image-preview-container');
          itemDiv.appendChild(previewDiv);
  
          // Al cambiar el input, mostramos una vista previa
          inputFile.addEventListener('change', e => {
            const file = e.target.files[0];
            if(file) {
              const reader = new FileReader();
              reader.onload = evt => {
                previewDiv.innerHTML = '';
                const img = document.createElement('img');
                img.src = evt.target.result;
                img.classList.add('post-edit__image-preview');
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