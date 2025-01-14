<nav class="main-nav">
  <div class="main-nav__content container">
    <!-- LOGO -->
    <div class="main-nav__logo">
      <a href="/" class="main-nav__logo-link">
        <img src="/build/img/logo.avif" alt="Ctrl Alt Aprende" />
      </a>
    </div>

    <!-- BOTÓN HAMBURGUESA (para pantallas pequeñas) -->
    <button 
      class="main-nav__toggle" 
      type="button" 
      aria-label="Abrir Menú de Navegación"
    >
      <i class="fa fa-bars"></i>
    </button>

    <!-- LINKS PRINCIPALES (se muestran en desktop, en mobile se suelen ocultar o quedar dentro de un menú lateral) -->
    <div class="main-nav__links">
      <a href="/" 
         class="main-nav__link 
         <?php echo ($_SERVER['PATH_INFO'] ?? '/') === '/' ? 'main-nav__link--active' : ''; ?>">
        Inicio
      </a>
      <a href="/content" 
         class="main-nav__link 
         <?php echo ($_SERVER['PATH_INFO'] ?? '/') === '/content' ? 'main-nav__link--active' : ''; ?>">
        Aprende
      </a>
      <a href="/foro" 
         class="main-nav__link 
         <?php echo ($_SERVER['PATH_INFO'] ?? '/') === '/foro' ? 'main-nav__link--active' : ''; ?>">
        Foro
      </a>
    </div>

    <!-- ÁREA DE USUARIO (avatar o login) -->
    <div class="main-nav__actions">
      <?php if(isset($_SESSION['id'])): ?>
        <!-- USUARIO LOGUEADO: Mostrar avatar o un ícono -->
        <button 
          class="main-nav__avatar-btn" 
          type="button" 
          aria-label="Abrir Panel de Usuario"
        >

          <img 
            src="<?php echo $_SESSION['profile'] 
                      ? '/profiles/' . $_SESSION['profile']
                      : '/build/img/profile-default.avif'; ?>" 
            alt="Tu perfil" 
            class="main-nav__avatar-img"
          >
        </button>
      <?php else: ?>
        <!-- USUARIO NO LOGUEADO: Botón de login -->
        <a href="/login" class="main-nav__login-btn">
          Iniciar Sesión
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<aside class="mobile-menu" id="mobileMenu">
  <div class="mobile-menu__content">
    <!-- Cerrar menú en mobile -->
    <button 
      class="mobile-menu__close" 
      type="button" 
      aria-label="Cerrar Menú"
    >
      <i class="fa fa-times"></i>
    </button>

    <nav class="mobile-menu__nav">
      <a href="/" class="mobile-menu__link">Inicio</a>
      <a href="/foro" class="mobile-menu__link">Foro de Discusión</a>
      <?php if(isset($_SESSION['id'])): ?>
        <button 
          class="mobile-menu__avatar-btn" 
          type="button"
        >
          <img 
            src="/build/img/profile-default.jpg" 
            alt="Tu perfil" 
            class="mobile-menu__avatar-img"
          >
        </button>
      <?php else: ?>
        <a href="/login" class="mobile-menu__link">Iniciar Sesión</a>
      <?php endif; ?>
    </nav>
  </div>
</aside>

<aside class="user-panel" id="userPanel">
  <div class="user-panel__content">
    <button 
      class="user-panel__close" 
      type="button" 
      aria-label="Cerrar Panel de Usuario"
    >
      <i class="fa fa-times"></i>
    </button>
    <?php if(isset($_SESSION['id'])): ?>
      <!-- Si es administrador, muestra un link extra -->
      <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1): ?>
          <a href="/admin" class="user-panel__link">
              <i class="fa fa-user-cog"></i> Administrador
          </a>
      <?php endif; ?>
      
      <a href="/perfil" class="user-panel__link">
          <i class="fa fa-user"></i> Tu Perfil
      </a>
      
      <form action="/logout" method="POST" class="user-panel__form-logout">
          <button type="submit" class="user-panel__link user-panel__link--logout">
              <i class="fa fa-sign-out-alt"></i> Cerrar Sesión
          </button>
      </form>
  <?php else: ?>
      <!-- Usuario NO logueado -->
      <a href="/login" class="user-panel__link">
          <i class="fa fa-sign-in-alt"></i> Iniciar Sesión
      </a>
  <?php endif; ?>
  </div>
</aside>
