(function() {
    'use strict';
  
    // Esperar a que el DOM esté cargado (buena práctica si el script se carga en el <head>)
    document.addEventListener('DOMContentLoaded', function() {
  
      // BOTÓN HAMBURGUESA (abre el menú mobile)
      const btnToggle = document.querySelector('.main-nav__toggle');
      // MENÚ LATERAL MÓVIL
      const mobileMenu = document.getElementById('mobileMenu');
      // BOTÓN PARA CERRAR MENÚ MÓVIL
      const btnCloseMobile = document.querySelector('.mobile-menu__close');
      
      // BOTÓN AVATAR (abre panel de usuario)
      const btnAvatar = document.querySelector('.main-nav__avatar-btn');
      // PANEL DE USUARIO
      const userPanel = document.getElementById('userPanel');
      // BOTÓN PARA CERRAR PANEL DE USUARIO
      const btnCloseUserPanel = document.querySelector('.user-panel__close');
  
  
      // --- Lógica para abrir/cerrar MENÚ MÓVIL ---
  
      // Abre el menú móvil al hacer click en el botón hamburguesa
      if (btnToggle && mobileMenu) {
        btnToggle.addEventListener('click', () => {
          mobileMenu.classList.add('mobile-menu--open');
        });
      }
  
      // Cierra el menú móvil al hacer click en el botón "X"
      if (btnCloseMobile && mobileMenu) {
        btnCloseMobile.addEventListener('click', () => {
          mobileMenu.classList.remove('mobile-menu--open');
        });
      }
  
  
      // --- Lógica para abrir/cerrar PANEL DE USUARIO ---
  
      // Abre el panel de usuario al hacer click en el avatar
      if (btnAvatar && userPanel) {
        btnAvatar.addEventListener('click', () => {
          userPanel.classList.add('user-panel--open');
        });
      }
  
      // Cierra el panel de usuario al hacer click en el botón "X"
      if (btnCloseUserPanel && userPanel) {
        btnCloseUserPanel.addEventListener('click', () => {
          userPanel.classList.remove('user-panel--open');
        });
      }
  
      // Opcional: podrías cerrar el panel si se hace click fuera del mismo, etc.
    });
  })();
  