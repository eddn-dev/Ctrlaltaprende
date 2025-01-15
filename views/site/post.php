<div class="forum">
<aside class="forum__aside">
    <h2 class="forum__aside-title">Foro</h2>

    <div class="forum__aside-quick-access">
      <h3>Accesos Rápidos</h3>
      <ul>
        <li><a href="/foro" title="Volver al Listado">Listado de Publicaciones</a></li>
        <li><a href="/faq" title="Preguntas Frecuentes">Preguntas Frecuentes</a></li>
        <li><a href="/contacto" title="Contacto">Contacto</a></li>
      </ul>
    </div>
    
    <div class="forum__aside-cta">
      <?php if(!$sesionIniciada): ?>
        <p>No has iniciado sesión.</p> 
        <a href="/login" class="forum__btn">Inicia sesión</a> 
        <p> para crear publicaciones.</p>
      <?php else: ?>
        <a class="forum__btn" href="/foro?new=1">Nueva Publicación</a>
      <?php endif; ?>
    </div>
  </aside>

  <main class="forum__main">
    <h1 class="forum__title">Detalle de la Publicación</h1>

    <?php if(!$publicacion): ?>
      <p>La publicación no existe o ha sido eliminada.</p>
    <?php else: ?>
      <article class="post-detail">
        <!-- Encabezado: autor, fecha, etc. -->
        <header class="post-detail__header">
          <?php 
            $fotoAutor = $publicacion->autor->profile 
                         ? $publicacion->autor->profile 
                         : '/build/img/default-user.jpg';
          ?>
          <div style="display: flex; align-items: center; gap: 1rem;">
            <img src="<?php echo htmlspecialchars('/profiles/'.$fotoAutor); ?>"
                 alt="Foto de <?php echo htmlspecialchars($publicacion->autor->nombre); ?>"
                 style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;" />

            <div>
              <a href="/perfil?id=<?php echo $publicacion->autor->id; ?>" 
                 class="post-detail__author">
                <?php echo htmlspecialchars($publicacion->autor->nombre); ?>
              </a>
              <br>
              <span class="post-detail__date">
                <?php echo htmlspecialchars($publicacion->fecha_formateada); ?>
              </span>
            </div>
          </div>
        </header>

        <!-- Título -->
        <h2 class="post-detail__title">
          <?php echo htmlspecialchars($publicacion->titulo); ?>
        </h2>

        <!-- Texto completo -->
        <div class="post-detail__body">
          <?php 
            // Convertir saltos de línea en <br>
            echo nl2br(htmlspecialchars($publicacion->texto));
          ?>
        </div>

        <!-- Media (si existe) -->
        <?php 
        if($publicacion->media) {
          $mediaItems = parseMedia($publicacion->media);
          if(!empty($mediaItems)) {
            echo '<div class="post-detail__media">';
            echo '<h3>Contenido Adicional</h3>';
            echo '<ul class="media-list">';
            foreach($mediaItems as $mi) {
              $tipo = $mi['tipo'];
              $ruta = $mi['ruta'];

              if($tipo === 'image') {
                // Podrías mostrar la imagen <img> o un enlace
                echo '<li class="media-list__item">';
                echo '  <p><strong>Imagen:</strong></p>';
                echo '  <img src="/'.htmlspecialchars($ruta).'" alt="Media image" style="max-width:200px;">';
                echo '</li>';
              } elseif($tipo === 'code') {
                $filePath = __DIR__ . "/../../public/" . $ruta;
                if(is_file($filePath)) {
                  $contenido = file_get_contents($filePath);
                  // Separamos en líneas
                  $lineas = explode("\n", $contenido);
              
                  echo '<div class="code-block">';
                  echo '  <button class="code-block__copy-btn">Copiar</button>';
                  echo '  <div class="code-block__lines">';
              
                  foreach($lineas as $line) {
                    // Escapamos HTML
                    $lineSafe = htmlspecialchars($line);
                    echo '<span class="code-block__line">' . $lineSafe . '</span>';
                  }
              
                  echo '  </div>';
                  echo '</div>';
                } else {
                  echo '<p><em>No se encontró el archivo de código</em></p>';
                }
              } elseif($tipo === 'file') {
                // Un archivo genérico
                echo '<li class="media-list__item">';
                echo '  <p><strong>Archivo:</strong></p>';
                echo '  <a href="/'.htmlspecialchars($ruta).'" target="_blank">Abrir / Descargar</a>';
                echo '</li>';
              } else {
                // Otro tipo
                echo '<li class="media-list__item">';
                echo '  <span>Tipo desconocido: '.htmlspecialchars($tipo).'</span> ';
                echo '  <a href="/'.htmlspecialchars($ruta).'" target="_blank">Ver</a>';
                echo '</li>';
              }
            }
            echo '</ul>';
            echo '</div>';
          }
        }
        ?>

        <!-- Botón "Editar" si es autor -->
        <?php if($sesionIniciada && $usuario->id == $publicacion->usuario_id): ?>
          <div class="post-detail__actions">
            <a href="/foro/editar?id=<?php echo $publicacion->id; ?>" 
               class="post-card__btn post-card__btn--edit">
              Editar Publicación
            </a>
          </div>
        <?php endif; ?>
      </article>

      <!-- Sección de comentarios -->
      <section class="post-comments" data-publicacionid="<?php echo $publicacion->id; ?>">
        <h3>Comentarios</h3>

        <div class="post-comments__list">
          <?php if(!empty($comentarios)): ?>
            <?php renderComments($comentarios, $sesionIniciada, 0); ?>
          <?php else: ?>
            <p>No hay comentarios aún.</p>
          <?php endif; ?>
        </div>

        <!-- Botón "Comentar" la publicación -->
        <?php if($sesionIniciada): ?>
          <button class="post-comments__comment-btn">
            Comentar esta Publicación
          </button>
        <?php else: ?>
          <p>Debes <a href="/login">iniciar sesión</a> para comentar.</p>
        <?php endif; ?>
      </section>
    <?php endif; ?>
  </main>
</div>
<!-- Modal (si $newPostModal && $sesionIniciada) -->
<?php if($newPostModal && $sesionIniciada): ?>
<div class="forum-modal" style="display:flex;">
  <div class="forum-modal__content">
    <button class="forum-modal__close" id="closeForumModal">&times;</button>
    <h2 class="forum-modal__title">Crear Nueva Publicación</h2>

    <form 
      action="/foro/crear" 
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
        <!-- Bloques extra de código o imágenes -->
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
