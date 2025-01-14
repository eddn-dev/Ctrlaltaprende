<div class="foro-container">
    <!-- Barra lateral -->
    <aside class="sidebar">
        <nav class="nav_foro">
            <div class="buscador-contenedor">
                <button class="buscador-boton">
                    <i class="fas fa-search"></i>                        
                </button>
                <input type="text" placeholder="Buscar..." class="buscador">
            </div>
            <button class="new-topic-btn">Añadir nuevo tema/comentario<i class="fas fa-plus"></i></button>
            <ul>
                <li><a href="foro.html"><i class="fas fa-house-laptop"></i> Inicio</a></li>
                <li><a href="foro.html"><i class="fas fa-fire"></i> Temas más hablados</a></li>
                <li><a href="preguntas.html"><i class="fas fa-question-circle"></i> Preguntas</a></li>
            </ul>
            <div class="button-container">
                <button class="loginforo-btn">Iniciar sesión</button>
                <div class="separator">o</div>
                <button class="signupforo-btn">Registrarse</button>
            </div>
        </nav>
    </aside>

    <!-- Contenido Principal -->
    <main class="foro_main-content">
        <h1 class="foro_main-header">BIENVENIDX AL FORO</h1>
        <section class="topics">
            <?php
            // Artículos dinámicos (simulados)
            $articles = [
                [
                    'img' => './img/user1.jpeg',
                    'title' => '¿Cómo solucionar errores comunes en C++?',
                    'author' => 'Usuario1',
                    'date' => '20/11/2024',
                    'responses' => 10,
                    'views' => 150
                ],
                [
                    'img' => './img/user2.jpeg',
                    'title' => 'Cliqué máximo, un problema NP-Completo',
                    'author' => 'Usuario2',
                    'date' => '14/10/2024',
                    'responses' => 5,
                    'views' => 18
                ],
                [
                    'img' => './img/user3.jpeg',
                    'title' => 'Optimizando LL(1) con Tablas Hash',
                    'author' => 'Usuario3',
                    'date' => '09/11/2024',
                    'responses' => 35,
                    'views' => 60
                ],
                [
                    'img' => './img/user4.jpeg',
                    'title' => 'Tutorial básico de Python para principiantes',
                    'author' => 'Usuario4',
                    'date' => '29/11/2024',
                    'responses' => 52,
                    'views' => 143
                ]
            ];

            foreach ($articles as $article): ?>
                <a href="articulo.html">
                    <article class="topic-card">
                        <img src="<?php echo $article['img']; ?>" alt="Imagen de <?php echo $article['author']; ?>">
                        <div>
                            <h4><?php echo $article['title']; ?></h4>
                            <p>Publicado por <span><?php echo $article['author']; ?></span> el <?php echo $article['date']; ?></p>
                            <div class="topic-stats">
                                <span class="icon-card"><i class="fas fa-comments"></i> <?php echo $article['responses']; ?> Respuestas</span>
                                <span class="icon-card"><i class="fas fa-eye"></i> <?php echo $article['views']; ?> Vistas</span>
                            </div>
                        </div>
                    </article>
                </a>
            <?php endforeach; ?>
        </section>
    </main>
</div>    