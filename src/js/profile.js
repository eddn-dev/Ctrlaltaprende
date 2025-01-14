(function(){
    'use strict';
  
    document.addEventListener('DOMContentLoaded', function() {
      // ========== A) Editar Descripción ==========
  
      // Verificar si existe el botón "editDescriptionBtn" y el contenedor
      const editDescBtn = document.querySelector('#editDescriptionBtn');
      const descriptionContainer = document.querySelector('#profileDescription');
      const descriptionContent = document.querySelector('#descriptionContent');
  
      if(editDescBtn && descriptionContainer && descriptionContent) {
        editDescBtn.addEventListener('click', function() {
          // 1. Ocultar el p (descriptionContent)
          descriptionContent.style.display = 'none';
          editDescBtn.style.display = 'none';
  
          // 2. Crear un textarea con el contenido actual
          const textArea = document.createElement('textarea');
          textArea.classList.add('profile-container__description-textarea');
          textArea.value = descriptionContent.textContent.trim();
          textArea.rows = 5;
  
          // 3. Botones de guardar/cancelar
          const saveBtn = document.createElement('button');
          saveBtn.textContent = 'Guardar';
          saveBtn.type = 'button';
          saveBtn.classList.add('profile-container__description-save');
  
          const cancelBtn = document.createElement('button');
          cancelBtn.textContent = 'Cancelar';
          cancelBtn.type = 'button';
          cancelBtn.classList.add('profile-container__description-cancel');
  
          // Insertarlos en el DOM
          descriptionContainer.appendChild(textArea);
          descriptionContainer.appendChild(saveBtn);
          descriptionContainer.appendChild(cancelBtn);
  
          // Manejo de click en "Guardar"
          saveBtn.addEventListener('click', function() {
            const nuevaDescripcion = textArea.value.trim();
            
            // Enviar POST al backend
            fetch('/perfil', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: new URLSearchParams({
                'description': nuevaDescripcion
              })
            })
            .then(resp => resp.text())
            .then(data => {
              // Podrías redirigir o actualizar la descripción en la página
              // sin recargar. Ej:
              descriptionContent.textContent = nuevaDescripcion || 'Sin descripción';
              // Limpiar
              textArea.remove();
              saveBtn.remove();
              cancelBtn.remove();
              descriptionContent.style.display = 'block';
              editDescBtn.style.display = 'block';
            })
            .catch(err => console.error(err));
          });
  
          // Manejo de click en "Cancelar"
          cancelBtn.addEventListener('click', function() {
            // Restaurar
            textArea.remove();
            saveBtn.remove();
            cancelBtn.remove();
            descriptionContent.style.display = 'block';
            editDescBtn.style.display = 'block';
          });
        });
      }
  
      // ========== B) Vista Previa de Foto ==========
  
      const inputPhoto = document.querySelector('#profile_photo_input');
      const previewImg = document.querySelector('#photoPreview');
  
      if(inputPhoto && previewImg) {
        inputPhoto.addEventListener('change', function(e) {
          const file = e.target.files[0];
          if(file) {
            const reader = new FileReader();
            reader.onload = function(event) {
              previewImg.src = event.target.result;
            };
            reader.readAsDataURL(file);
          }
        });
      }
    });
  })();
  