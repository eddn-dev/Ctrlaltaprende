<main class="auth">
    <div class="auth__wrapper">
        <div class="auth__imagen">
            <!-- La imagen se aplica vía CSS -->
        </div>

        <div class="auth__contenido">
            <h2 class="auth__heading"><?php echo $titulo; ?></h2>
            <p class="auth__texto">
                Es necesario confirmar tu cuenta, por favor revisa tu bandeja de 
                correo electrónico para hacerlo
            </p>
            
            <!-- Si no requieres formulario, basta con alerts y texto -->
            <?php require_once __DIR__ . '/../templates/alerts.php'; ?>
            
            <!-- Opcionalmente, un enlace de volver o algo similar -->
            <div class="acciones">
                <a href="/login" class="acciones__enlace">Iniciar sesión</a>
            </div>
        </div><!-- .auth__contenido -->
    </div><!-- .auth__wrapper -->
</main>
