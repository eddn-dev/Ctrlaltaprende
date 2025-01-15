(function() {
    'use strict';
  
    document.addEventListener('DOMContentLoaded', function() {
      const codeBlocks = document.querySelectorAll('.code-block');
      codeBlocks.forEach((block) => {
        const copyBtn = block.querySelector('.code-block__copy-btn');
        if(!copyBtn) return;
  
        // Al hacer clic => copiamos todo el contenido (unido) del .code-block__lines
        copyBtn.addEventListener('click', () => {
          const lines = block.querySelectorAll('.code-block__line');
          let textToCopy = '';
          lines.forEach(line => {
            textToCopy += line.textContent;
          });
  
          // Usamos la API del portapapeles
          navigator.clipboard.writeText(textToCopy)
            .then(() => {
              // Podrías mostrar un mensaje “Copiado!”
              copyBtn.textContent = 'Copiado!';
              setTimeout(() => {
                copyBtn.textContent = 'Copiar';
              }, 2000);
            })
            .catch(err => {
              console.error('Error al copiar: ', err);
            });
        });
      });
    });
  })();
  