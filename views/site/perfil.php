<?php
// Asumimos variables pasadas por el controlador:
// $usuario, $puedeEditar (bool), $skills (array), $edit_skills, $edit_photo
?>

<div class="profile-container">
  <!-- Foto de portada (fija) -->
  <div class="profile-container__cover">
    <img 
      src="<?php echo '/build/img/cover.avif'; ?>"
      alt="Foto de portada" 
      class="profile-container__cover-img"
    >
  </div>

  <!-- Encabezado del perfil -->
  <div class="profile-container__header">
    <div class="profile-container__photo-wrapper">
      <img 
        src="<?php echo $usuario->profile 
                      ? '/profiles/' . $usuario->profile
                      : '/build/img/profile-default.avif'; ?>"
        alt="Foto de perfil"
        class="profile-container__photo"
      >
      
      <?php if($puedeEditar): ?>
      <a href="/perfil?edit_photo=1" class="profile-container__edit-btn">
        <i class="fas fa-pencil-alt"></i>
      </a>
      <?php endif; ?>
    </div>
    
    <h1 class="profile-container__title">
      <?php echo htmlspecialchars($usuario->nombre); ?>
    </h1>
  </div>

  <!-- Descripción -->
  <div class="profile-container__description" id="profileDescription">
    <p id="descriptionContent">
      <?php 
        echo $usuario->descripcion 
          ? htmlspecialchars($usuario->descripcion)
          : 'Sin descripción';
      ?>
    </p>

    <!-- Si puede editar, mostramos un botón para editar la descripción -->
    <?php if($puedeEditar): ?>
      <button class="profile-container__description-btn" id="editDescriptionBtn">
        <i class="fas fa-edit"></i> Editar Descripción
      </button>
    <?php endif; ?>
  </div>

  <!-- Seguidores (valores fijos por ahora) -->
  <div class="profile-container__followers">
    <div><strong>120</strong> seguidores</div>
    <div><strong>180</strong> seguidos</div>
  </div>

  <!-- Sección de habilidades -->
  <div class="profile-container__skills">
    <div class="profile-container__skills-header">
      <h2 class="profile-container__skills-title">Habilidades</h2>

      <!-- Si se puede editar, mostrar el enlace para abrir el modal -->
      <?php if($puedeEditar): ?>
        <a href="/perfil?edit_skills=1" class="profile-container__skills-edit">
          Editar Habilidades
        </a>
      <?php endif; ?>
    </div>

    <?php if(!empty($skills)): ?>
      <ul class="skill__tags">
        <?php foreach($skills as $skill): ?>
          <li class="skill__tag">
            <?php echo htmlspecialchars($skill); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No se han definido habilidades.</p>
    <?php endif; ?>
  </div>
</div>

<!-- Modal Condicional para Editar Skills -->
<?php if($puedeEditar && $edit_skills == 1): ?>
<div class="modal-overlay" id="skillsModal">
  <div class="modal-overlay__content">
    <button class="modal-overlay__close" id="closeModal">&times;</button>
    <h3 class="modal-overlay__title">Editar Habilidades</h3>
    
    <form action="/perfil" method="POST" class="modal-overlay__form" id="skillsForm">
      <input 
        type="hidden" 
        name="tags"
        value="<?php echo implode(',', $skills); ?>" 
      />

      <label for="tags_input" class="modal-overlay__label">
        Agrega Habilidades:
      </label>
      <input 
        type="text" 
        id="tags_input" 
        class="modal-overlay__input" 
        placeholder="Ej: PHP, JavaScript, etc." 
      />

      <ul class="skill__tags" id="tags"></ul>

      <div class="modal-overlay__buttons">
        <button type="submit" class="modal-overlay__btn">Guardar</button>
        <a href="/perfil" class="modal-overlay__btn modal-overlay__btn--cancel">
          Cancelar
        </a>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal Condicional para Cambiar Foto de Perfil -->
<?php if($puedeEditar && isset($edit_photo) && $edit_photo == 1): ?>
<div class="modal-overlay" id="photoModal">
  <div class="modal-overlay__content">
    <button class="modal-overlay__close" id="closePhotoModal">&times;</button>
    <h3 class="modal-overlay__title">Cambiar Foto de Perfil</h3>
    
    <form 
      action="/perfil" 
      method="POST" 
      class="modal-overlay__form" 
      id="photoForm"
      enctype="multipart/form-data"
    >
      <div class="modal-overlay__photo-preview">
        <img id="photoPreview" 
             src="<?php echo $usuario->profile 
                          ? '/profiles/' . $usuario->profile 
                          : '/build/img/profile-default.avif'; ?>" 
             alt="Vista previa"
        >
      </div>

      <label for="profile_photo_input" class="modal-overlay__label">
        Selecciona una imagen:
      </label>
      <input 
        type="file"
        class="modal-overlay__input"
        accept="image/*"
        id="profile_photo_input"
        name="profile_photo"
      />

      <div class="modal-overlay__buttons">
        <button type="submit" class="modal-overlay__btn">Guardar</button>
        <a href="/perfil" class="modal-overlay__btn modal-overlay__btn--cancel">
          Cancelar
        </a>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>