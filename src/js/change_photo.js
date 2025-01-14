(function() {
    'use strict';
  
    document.addEventListener('DOMContentLoaded', function() {
      // Seleccionar los elementos necesarios
      const inputPhoto = document.querySelector('#profile_photo_input');
      const previewImg = document.querySelector('#photoPreview');
  
      // Verificar que existan en el DOM
      if(!inputPhoto || !previewImg) return;
  
      // Al cambiar el input (seleccionar archivo)
      inputPhoto.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if(file) {
          // Usamos FileReader para generar un DataURL y mostrarlo en <img>
          const reader = new FileReader();
          reader.onload = function(event) {
            previewImg.src = event.target.result; // asignamos la ruta al src de #photoPreview
          };
          reader.readAsDataURL(file);
        }
      });
    });
  })();
  