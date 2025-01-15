<?php
// Variables recibidas:
// - $publicaciones => array de Publicacion con:
//   ->autor (objeto Usuario con 'nombre', 'profile') 
//   ->total_comentarios (int)
//   ->fecha_formateada (string formateado)
// - $sesionIniciada => boolean
// - $usuario => si logueado (objeto Usuario del actual)
// - $newPostModal => boolean (si se debe mostrar la modal de Nueva Publicación)
?>

<div class="forum">
  <!-- ASIDE (barra lateral) -->
  <aside class="forum__aside">
    <h2 class="forum__aside-title">Foro</h2>

    <div class="forum__aside-quick-access">
      <h3>Accesos Rápidos</h3>
      <ul>
        <li><a href="/reglas" title="Reglas del Foro">Reglas del Foro</a></li>
        <li><a href="/faq" title="Preguntas Frecuentes">Preguntas Frecuentes</a></li>
        <li><a href="/contacto" title="Contacto">Contacto</a></li>
      </ul>
    </div>
    <div class="forum__aside-cta">
      <?php if(!$sesionIniciada): ?>
        <p>No has iniciado sesión.</p> <a href="/login" class="forum__btn">Inicia sesión</a> <p> para crear publicaciones.</p>
      <?php else: ?>
        <a class="forum__btn" href="/foro?new=1">Nueva Publicación</a>
      <?php endif; ?>
    </div>
  </aside>

  <!-- MAIN (contenido principal) -->
  <main class="forum__main">
    <h1 class="forum__title">Publicaciones</h1>

    <div class="forum__posts">
      <?php if(!empty($publicaciones)): ?>
        <?php foreach($publicaciones as $post): ?>
          <div class="post-card">
            
            <!-- Encabezado: foto (mini) + nombre autor + fecha -->
            <div class="post-card__meta">
              <?php 
                // Foto de perfil (mini)
                $fotoAutor = $post->autor->profile 
                             ? $post->autor->profile 
                             : '/build/img/default-user.jpg';
              ?>
              <div style="display: flex; align-items: center; gap: 1rem;">
                <img src="<?php echo htmlspecialchars('/profiles/' . $fotoAutor); ?>" 
                     alt="Foto perfil de <?php echo htmlspecialchars($post->autor->nombre); ?>" 
                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;" />

                <div>
                  <a class="post-card__author" href="/perfil?id=<?php echo $post->autor->id; ?>">
                    <?php echo htmlspecialchars($post->autor->nombre); ?>
                  </a>
                  <br>
                  <span class="post-card__date">
                    <?php echo htmlspecialchars($post->fecha_formateada); ?>
                  </span>
                </div>
              </div>
            </div>

            <!-- Título de la publicación -->
            <a class="post-card__title" href="/foro/publicacion?id=<?php echo $post->id; ?>">
              <?php echo htmlspecialchars($post->titulo); ?>
            </a>

            <!-- Extracto del texto -->
            <div class="post-card__text">
              <?php 
                // Hacemos un extracto de 120 caracteres
                $extracto = mb_substr($post->texto, 0, 120, 'UTF-8');
                echo nl2br(htmlspecialchars($extracto));
                if(mb_strlen($post->texto, 'UTF-8') > 120) {
                  echo '...';
                }
              ?>
            </div>

            <!-- Pie: Fecha, Comentarios, Botones de Acción -->
            <div class="post-card__footer" 
                 style="display: flex; justify-content: space-between; align-items: center;">
              
              <div class="post-card__footer-info">
                <span class="post-card__footer-date">
                  <?php echo htmlspecialchars($post->fecha_formateada); ?>
                </span>
                &bull;
                <span class="post-card__footer-comments">
                  Comentarios: <?php echo $post->total_comentarios; ?>
                </span>
              </div>
              
              <div class="post-card__actions" style="display: flex; gap: 0.5rem;">
                <!-- Botón "Ver más" -->
                <a href="/foro/publicacion?id=<?php echo $post->id; ?>" 
                   class="post-card__btn">
                  Ver más
                </a>

                <!-- Si el usuario logueado es el autor, botón de Editar -->
                <?php if($sesionIniciada && $usuario->id === $post->usuario_id): ?>
                  <a href="/foro/editar?id=<?php echo $post->id; ?>"
                     class="post-card__btn post-card__btn--edit">
                    Editar
                  </a>
                <?php endif; ?>

              </div>
            </div>
          </div> <!-- .post-card -->
        <?php endforeach; ?>
      <?php else: ?>
        <p>No hay publicaciones todavía. Sé el primero en crear una.</p>
      <?php endif; ?>
    </div>
  </main>
</div>

<?php if($newPostModal && $sesionIniciada): ?>
<div class="forum-modal" style="display:flex;">
  <div class="forum-modal__content">
    <button class="forum-modal__close" id="closeForumModal">&times;</button>
    <h2 class="forum-modal__title">Crear Nueva Publicación</h2>

    <form 
      action="/foro" 
      method="POST" 
      class="forum-modal__form" 
      enctype="multipart/form-data" 
      id="newPostForm"
    >
      <label for="titulo">Título:</label>
      <input type="text" id="titulo" name="titulo" required>

      <label for="texto">Contenido (texto principal):</label>
      <textarea id="texto" name="texto" rows="6" required></textarea>

      <label for="media">Contenido Multimedia (opcional, 1 archivo):</label>
      <input type="file" id="media" name="media">

      <div class="forum-modal__dynamic-sections" id="dynamicSections">
        <!-- Bloques añadidos dinámicamente irán aquí -->
      </div>

      <div class="forum-modal__buttons">
        <button type="button" class="forum-modal__btn" id="addCodeBlockBtn">+ Código</button>
        <button type="button" class="forum-modal__btn" id="addImageBtn">+ Imagen</button>

        <button type="submit" class="forum-modal__btn">Publicar</button>
        <button type="button" class="forum-modal__btn forum-modal__btn--secondary" 
          id="cancelNewPostBtn">Cancelar</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>
