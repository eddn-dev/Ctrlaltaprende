<main class="auth">
    <div class="auth__wrapper">
        <div class="auth__imagen">
            <!-- La imagen se aplica vía CSS -->
        </div>

        <div class="auth__contenido">
            <h2 class="auth__heading"><?php echo $titulo; ?></h2>
            <p class="auth__texto">Inicia sesión en Ctrl Alt Aprende</p>

            <?php require_once __DIR__ . '/../templates/alerts.php'; ?>

            <form class="form" method="POST" action="login">
                <div class="form__campo">
                    <label for="correo" class="form__label">Correo:</label>
                    <input 
                        type="email" 
                        class="form__input" 
                        placeholder="Tu dirección de correo"
                        id="email"
                        name="email"
                        value="<?php ?>"
                    >
                </div>
                <div class="form__campo">
                    <label for="password" class="form__label">Contraseña:</label>
                    <input 
                        type="password" 
                        class="form__input" 
                        placeholder="Tu contraseña"
                        id="password"
                        name="password"
                    >
                </div>

                <input type="submit" class="form__submit" value="Iniciar Sesión">
            </form>

            <div class="acciones">
                <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Obtén una</a>
                <a href="/olvide" class="acciones__enlace">¿Olvidaste tu contraseña?</a>
            </div>
        </div><!-- .auth__contenido -->
    </div><!-- .auth__wrapper -->
</main>
