<!-- Contenido Principal -->
<main class="main-content"> 
    <h1 class="main-header">
        <i class="admin-header fas fa-chalkboard-user"></i>
        BIENVENIDX ADMINISTRADORX
    </h1>
    <h3 id="admin-content-title" class="admin-content-h">GESTIÓN DE CONTENIDO</h3>

    <!-- Artículos Generados Dinámicamente -->
    <section class="admin-content scrollbar-black"> 
        <?php for ($i = 0; $i < 5; $i++): ?>
            <div class="articles-container"> 
                <?php for ($j = 0; $j < 2; $j++): ?>
                    <div class="articles-column">
                        <article class="article-card"> 
                            <div class="article-header">
                                <h3>NombreArtículo</h3>
                                <div class="article-actions">
                                    <button><i class="fas fa-edit"></i></button>
                                    <button><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="article-footer">
                                <p>
                                    <span class="author">UsuarioAutor</span> | 
                                    <span class="comments"># Comentarios</span>
                                </p>
                                <div class="article-actions">
                                    <button><i class="fas fa-eye"></i></button>
                                    <button><i class="fas fa-star"></i></button>
                                </div>
                            </div>
                        </article>                    
                    </div>
                <?php endfor; ?>
            </div>
        <?php endfor; ?>
    </section>

    <!-- Usuarios Administrativos -->
    <section class="admin-users scrollbar-black">
        <div class="users-container">
            <?php for ($i = 0; $i < 20; $i++):  ?>
                <div class="user-card">
                    <img src="user-avatar.jpg" alt="Avatar de Usuario" class="user-avatar">
                    <div class="user-info_admin">
                        <h3 class="user-name">Usuario <?php echo $i + 1; ?></h3>
                        <p class="user-role">Administrador</p>
                    </div>
                    <div class="user-actions">
                        <button class="btn edit-user"><i class="fas fa-edit"></i></button>
                        <button class="btn delete-user"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </section>


    <!-- Navegación -->
    <div class="navigation-arrows">
        <button id="prev-section"><i class="fas fa-arrow-left"></i></button>
        <button id="next-section"><i class="fas fa-arrow-right"></i></button>
    </div>
</main>
