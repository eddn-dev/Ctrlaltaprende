<?php 
// Supongamos que tenemos las siguientes variables en la vista:
// $publicacion, $sesionIniciada, $usuario
// El controlador ya verificó que $publicacion exista y que el usuario sea el autor.
// parseMedia($publicacion->media) se encarga de descomponer la cadena en [tipo => code|image|file, ruta => "forum/..."]
?>

<div class="forum">
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
  <div class="post-edit__content">
    <!-- Botón "Regresar" o "Cancelar" (en lugar de la 'X' del modal) -->
    <button class="post-edit__close" id="cancelEditPostBtn">&times;</button>

    <h2 class="post-edit__title">Editar Publicación</h2>

    <!-- Formulario -->
    <form 
      action="/foro/editar?id=<?php echo $publicacion->id; ?>" 
      method="POST" 
      enctype="multipart/form-data" 
      class="post-edit__form" 
      id="editPostForm"
    >
      <!-- Título -->
      <label for="titulo" class="post-edit__label">Título de la Publicación:</label>
      <input 
        type="text" 
        id="titulo" 
        name="titulo" 
        class="post-edit__input"
        value="<?php echo htmlspecialchars($publicacion->titulo); ?>" 
        required
      >

      <!-- Texto -->
      <label for="texto" class="post-edit__label">Contenido (texto principal):</label>
      <textarea 
        id="texto" 
        name="texto" 
        rows="6" 
        class="post-edit__textarea" 
        required
      ><?php echo htmlspecialchars($publicacion->texto); ?></textarea>

      <!-- Media existente (si lo hay) -->
      <?php 
        $mediaItems = parseMedia($publicacion->media ?? '');
        if(!empty($mediaItems)):
      ?>
        <div class="post-edit__dynamic-sections">
          <h3 class="post-edit__subtitle">Contenido Multimedia Actual</h3>
          <?php foreach($mediaItems as $idx => $item): ?>
            <div class="post-edit__dynamic-item">
              <button 
                type="button" 
                class="post-edit__remove-item-btn"
                data-media="<?php echo htmlspecialchars($item['ruta']); ?>"
              >
                &times;
              </button>

              <?php if($item['tipo'] === 'image'): ?>
                <label>Imagen:</label>
                <img 
                  src="/<?php echo htmlspecialchars($item['ruta']); ?>" 
                  alt="Imagen actual" 
                  class="post-edit__image-preview"
                >
              <?php elseif($item['tipo'] === 'code'): ?>
                <label>Código (editable):</label>
                <?php
                  $filePath = __DIR__ . '/../../public/' . $item['ruta'];
                  $codigo = '';
                  if(is_file($filePath)) {
                    $codigo = file_get_contents($filePath);
                  }
                ?>
                <textarea 
                  rows="6" 
                  class="post-edit__code-snippet" 
                  name="update_code[<?php echo htmlspecialchars($item['ruta']); ?>]"
                ><?php echo htmlspecialchars($codigo); ?></textarea>
              <?php elseif($item['tipo'] === 'file'): ?>
                <label>Archivo:</label>
                <a href="/<?php echo htmlspecialchars($item['ruta']); ?>" target="_blank">
                  Abrir / Descargar
                </a>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- Nuevo archivo principal (opcional) -->
      <label for="media" class="post-edit__label">Nuevo archivo principal (opcional):</label>
      <input type="file" id="media" name="media" class="post-edit__input-file">

      <!-- Sección dinámica para +Código / +Imagen -->
      <div class="post-edit__dynamic-sections" id="dynamicSections">
        <!-- Agregaremos items dinámicos aquí vía JS -->
      </div>

      <!-- Botones finales -->
      <div class="post-edit__buttons">
        <button type="button" class="post-edit__btn" id="addCodeBlockBtn">+ Código</button>
        <button type="button" class="post-edit__btn" id="addImageBtn">+ Imagen</button>

        <button type="submit" class="post-edit__btn post-edit__btn--primary">
          Actualizar Publicación
        </button>

        <!-- Botón para eliminar toda la publicación -->
        <button 
          type="button" 
          class="post-edit__btn post-edit__btn--delete"
          id="deletePostBtn"
        >
          Eliminar Publicación
        </button>
      </div>
    </form>
  </div>
</div>
