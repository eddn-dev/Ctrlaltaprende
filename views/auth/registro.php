<main class="auth">
    <div class="auth__wrapper">

        <!-- Imagen de fondo (vía CSS) -->
        <div class="auth__imagen"></div>

        <!-- Contenido: Título, formulario y secciones de rango/héroes -->
        <div class="auth__contenido">

            <h2 class="auth__heading">
                <?php echo isset($titulo) ? $titulo : '¡Registrate en Ctrl Alt Aprende!'; ?>
            </h2>
            <p class="auth__texto">Completa tus datos para comenzar</p>

            <?php require_once __DIR__ . '/../templates/alerts.php'; ?>

            <!-- Form principal (datos de usuario) -->
            <form class="form" method="POST" action="/registro" id="registroForm">
                <!-- Campo: Nombre -->
                <div class="form__campo">
                    <label for="nombre" class="form__label">Nombre completo:</label>
                    <input 
                        type="text" 
                        class="form__input" 
                        id="nombre" 
                        name="nombre" 
                        placeholder="Escribe tu nombre"
                        required
                    >
                </div>

                <!-- Campo: Correo -->
                <div class="form__campo">
                    <label for="correo" class="form__label">Correo electrónico institucional:</label>
                    <input 
                        type="email" 
                        class="form__input" 
                        id="email" 
                        name="email" 
                        placeholder="Escribe tu correo, ej. correo@alumno.ipn.mx" 
                        required
                    >
                </div>

                <div class="form__campo">
                    <label for="boleta" class="form__label">Boleta:</label>
                    <input 
                        type="text" 
                        class="form__input" 
                        id="number" 
                        name="number" 
                        placeholder="Escribe tu boleta institucional" 
                        required
                    >
                </div>

                <!-- Campo: Contraseña -->
                <div class="form__campo">
                    <label for="password" class="form__label">Ingresa una contraseña:</label>
                    <input 
                        type="password" 
                        class="form__input" 
                        id="password" 
                        name="password" 
                        placeholder="Escribe tu contraseña" 
                        required
                    >
                </div>

                <!-- Campo: Confirmar Contraseña -->
                <div class="form__campo">
                    <label for="password2" class="form__label">Vuelve a repetir tu contraseña:</label>
                    <input 
                        type="password" 
                        class="form__input" 
                        id="password2" 
                        name="password2" 
                        placeholder="Repite tu contraseña" 
                        required
                    >
                </div>
            </form>
            <!-- Botón de envío final (enviar todo el formulario) -->
            <div class="form__campo form__campo--submit">
                <input 
                    type="submit" 
                    class="form__submit" 
                    value="Registrarse" 
                    form="registroForm" 
                >
            </div>

            <div class="acciones">
                <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Inicia sesión</a>
                <a href="/olvide" class="acciones__enlace">¿Olvidaste tu contraseña?</a>
            </div>
        </div><!-- .auth__contenido -->
    </div><!-- .auth__wrapper -->
</main>
