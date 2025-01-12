<main class="auth">
    <div class="auth__wrapper">
        <!-- Imagen de fondo (insertada vía CSS) -->
        <div class="auth__imagen"></div>

        <!-- Contenido (encabezados, formulario, enlaces) -->
        <div class="auth__contenido">
            <h2 class="auth__heading"><?php echo $titulo; ?></h2>
            <p class="auth__texto">Recupera el acceso a tu cuenta</p>

            <?php require_once __DIR__ . '/../templates/alerts.php'; ?>

            <form class="form" method="POST" action="/olvide">
                <div class="form__campo">
                    <label for="email" class="form__label">Correo:</label>
                    <input 
                        type="email" 
                        class="form__input" 
                        placeholder="Tu dirección de correo"
                        id="email"
                        name="email"
                    >
                </div>

                <input type="submit" class="form__submit" value="Enviar instrucciones">
            </form>

            <div class="acciones">
                <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Inicia sesión</a>
                <a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Obtén una</a>
            </div>
        </div> <!-- .auth__contenido -->
    </div><!-- .auth__wrapper -->
</main>
