<main class="auth">
    <div class="auth__wrapper">
        <div class="auth__imagen">
            <!-- La imagen se aplica vía CSS -->
        </div>

        <div class="auth__contenido">
            <h2 class="auth__heading"><?php echo $titulo; ?></h2>
            <p class="auth__texto">Por favor sigue los pasos para cambiar tu contraseña</p>
            
            <?php require_once __DIR__ . '/../templates/alerts.php'; ?>
            
            <?php if($token_valido) { ?>
                <form class="form" method="POST">
                    <div class="form__campo">
                        <label for="password" class="form__label">Nueva contraseña:</label>
                        <input 
                            type="password" 
                            class="form__input" 
                            placeholder="Ingresa tu nueva contraseña"
                            id="password"
                            name="password"
                        >
                    </div>

                    <div class="form__campo">
                        <label for="password2" class="form__label">Confirmar nueva contraseña:</label>
                        <input 
                            type="password" 
                            class="form__input" 
                            placeholder="Confirma tu nueva contraseña"
                            id="password2"
                            name="password2"
                        >
                    </div>

                    <input type="submit" class="form__submit" value="Confirmar cambios">
                </form>
            <?php } ?>

            <div class="acciones">
                <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Inicia sesión</a>
                <a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Obtén una</a>
            </div>
        </div><!-- .auth__contenido -->
    </div><!-- .auth__wrapper -->
</main>
