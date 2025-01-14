document.addEventListener('DOMContentLoaded', () => {
    const headers = document.querySelectorAll('.accordion__header');
  
    headers.forEach(header => {
      header.addEventListener('click', () => {
        // Toggle en el header
        header.classList.toggle('is-open');
  
        // El panel es el siguiente hermano
        const panel = header.nextElementSibling;
        if(panel && panel.classList.contains('accordion__panel')) {
          panel.classList.toggle('is-open');
        }
      });
    });
  });
  