<main class="auth">
    <div class="auth__wrapper">
        <div class="auth__imagen">
            <!-- La imagen se aplica vía CSS -->
        </div>

        <div class="auth__contenido">
            <h2 class="auth__heading"><?php echo $titulo; ?></h2>
            <p class="auth__texto">Tu cuenta en Ctrl Alt Aprende</p>
            
            <?php require_once __DIR__ . '/../templates/alerts.php'; ?>  

            <!-- Si se muestra un mensaje de éxito, podemos mostrar un botón de inicio de sesión -->
            <?php if(isset($alertas['exito'])) { ?>
                <div class="acciones">
                    <a href="/login" class="acciones__enlace">Iniciar sesión</a>
                </div>
            <?php } ?>
        </div><!-- .auth__contenido -->
    </div><!-- .auth__wrapper -->
</main>
