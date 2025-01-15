(function() {
  'use strict';

  document.addEventListener('DOMContentLoaded', function() {
    // 1) Detectar la sección de comentarios
    const postCommentsSection = document.querySelector('.post-comments');
    if (!postCommentsSection) return;

    // Leer el ID de la publicación desde un data-attribute
    const publicacionIdAttr = postCommentsSection.getAttribute('data-publicacionid');
    const publicacionId = publicacionIdAttr ? parseInt(publicacionIdAttr) : null;
    if (!publicacionId) {
      console.warn('No se encontró un data-publicacionid en la sección .post-comments');
    }

    // 2) Botón "Comentar esta Publicación" (top-level)
    const topLevelCommentBtn = postCommentsSection.querySelector('.post-comments__comment-btn');
    if (topLevelCommentBtn) {
      topLevelCommentBtn.addEventListener('click', () => {
        let topForm = postCommentsSection.querySelector('.post-comments__top-form');
        if (!topForm) {
          // Crear el formulario top-level si no existe
          topForm = createTopLevelForm(publicacionId);
          postCommentsSection.appendChild(topForm);
        }

        // Toggléa la visibilidad
        toggleVisibility(topForm);
      });
    }

    // 3) Botones "Responder" en cada comentario usando Event Delegation
    postCommentsSection.addEventListener('click', function(event) {
      if (event.target && event.target.classList.contains('comment-card__responder-btn')) {
        event.preventDefault();
        event.stopPropagation(); // Evita que el evento se propague a otros listeners

        const responderBtn = event.target;
        const commentCard = responderBtn.closest('.comment-card');
        if (!commentCard) return;

        const commentId = commentCard.dataset.commentid;
        if (!commentId) {
          console.warn('El comentario no tiene un data-commentid válido.');
          return;
        }

        console.log('Responder clickeado en comentario ID:', commentId);

        // Buscar el formulario de respuesta específico usando data-formid
        let replyForm = commentCard.querySelector(`.comment-card__reply-form[data-formid="reply-form-${commentId}"]`);

        if (!replyForm) {
          // Crear el formulario de respuesta si no existe
          replyForm = createReplyForm(publicacionId, commentId);
          commentCard.appendChild(replyForm);
          console.log('Formulario de respuesta creado para comentario ID:', commentId);
        }

        // Toggléa la visibilidad de este replyForm
        toggleVisibility(replyForm);
        console.log('Estado del formulario después del toggle:', replyForm.style.display === 'none' ? 'Oculto' : 'Visible');
      }
    });

    // ============ FUNCIONES AUXILIARES ===========

    /**
     * Función para enviar un comentario o respuesta
     */
    function comentar(publicacionId, parentId, texto) {
      // Construimos el body => x-www-form-urlencoded
      const bodyData = new URLSearchParams();
      bodyData.append('publicacion_id', publicacionId);
      if (parentId) {
        bodyData.append('parent_comment_id', parentId);
      }
      bodyData.append('texto', texto);

      // Realizar la solicitud POST
      return fetch(`/foro/publicacion?id=${publicacionId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: bodyData.toString()
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text(); // o .json() si devuelves algo en JSON
      });
    }

    /**
     * Crear el formulario para comentarios de nivel superior
     */
    function createTopLevelForm(publicacionId) {
      const topForm = document.createElement('div');
      topForm.classList.add('post-comments__top-form');
      topForm.style.marginTop = '1rem';
      topForm.style.display = 'none'; // Inicialmente oculto

      const textArea = document.createElement('textarea');
      textArea.rows = 4;
      textArea.placeholder = 'Escribe tu comentario...';
      textArea.style.width = '100%';
      textArea.style.marginBottom = '0.5rem';

      const sendBtn = document.createElement('button');
      sendBtn.type = 'button';
      sendBtn.textContent = 'Enviar';
      sendBtn.classList.add('btn', 'btn-primary'); // Utiliza clases CSS para estilos
      sendBtn.style.cursor = 'pointer';

      sendBtn.addEventListener('click', () => {
        const text = textArea.value.trim();
        if (!text) {
          alert('Por favor, escribe algo antes de enviar.');
          return;
        }
        comentar(publicacionId, null, text)
          .then(() => {
            window.location.reload();
          })
          .catch(err => {
            console.error('Error al comentar:', err);
            alert('Error al comentar');
          });
      });

      topForm.appendChild(textArea);
      topForm.appendChild(sendBtn);
      return topForm;
    }

    /**
     * Crear el formulario para responder a un comentario específico
     */
    function createReplyForm(publicacionId, parentId) {
      const replyForm = document.createElement('div');
      replyForm.classList.add('comment-card__reply-form');
      replyForm.setAttribute('data-formid', `reply-form-${parentId}`);
      replyForm.style.marginTop = '1rem';
      replyForm.style.display = 'none'; // Inicialmente oculto

      const textArea = document.createElement('textarea');
      textArea.rows = 4;
      textArea.placeholder = 'Escribe tu respuesta...';
      textArea.style.width = '100%';
      textArea.style.marginBottom = '0.5rem';

      const sendBtn = document.createElement('button');
      sendBtn.type = 'button';
      sendBtn.textContent = 'Enviar';
      sendBtn.classList.add('btn', 'btn-success'); // Utiliza clases CSS para estilos
      sendBtn.style.cursor = 'pointer';

      sendBtn.addEventListener('click', () => {
        const text = textArea.value.trim();
        if (!text) {
          alert('Por favor, escribe algo antes de enviar.');
          return;
        }
        comentar(publicacionId, parentId, text)
          .then(() => {
            window.location.reload();
          })
          .catch(err => {
            console.error('Error al responder:', err);
            alert('Error al responder');
          });
      });

      replyForm.appendChild(textArea);
      replyForm.appendChild(sendBtn);
      return replyForm;
    }

    /**
     * Función para togglear la visibilidad de un elemento
     */
    function toggleVisibility(element) {
      if (element.style.display === 'none' || element.style.display === '') {
        element.style.display = 'block';
      } else {
        element.style.display = 'none';
      }
    }

  });
})();
