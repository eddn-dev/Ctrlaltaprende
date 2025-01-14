<?php
/**
 * Ejemplo de “site/content.php”
 * Recibe variables:
 *  - $materias  (para el índice - acordeón)
 *  - $temaId    (el id del tema actual)
 *  - $contenido (array decodificado del JSON)
 */
?>

<div class="content-container">
  <!-- Barra lateral (sidebar) -->
  <aside class="content-container__sidebar">
    <h2 class="content-container__sidebar-title">Materias</h2>
    <ul class="accordion">
      <?php foreach($materias as $materia): ?>
      <li class="accordion__item">
        <button class="accordion__header">
          <?php echo htmlspecialchars($materia->nombre); ?>
        </button>
        <ul class="accordion__panel">
          <?php foreach($materia->unidades as $unidad): ?>
          <li class="accordion__item">
            <button class="accordion__header">
              <?php echo htmlspecialchars($unidad->nombre); ?>
            </button>
            <ul class="accordion__panel">
              <?php foreach($unidad->temas as $tema): ?>
              <li>
                <a 
                  href="/content?id=<?php echo $tema->id; ?>" 
                  class="content-container__sidebar-link"
                >
                  <?php echo htmlspecialchars($tema->titulo); ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </li>
          <?php endforeach; ?>
        </ul>
      </li>
      <?php endforeach; ?>
    </ul>
  </aside>

  <!-- Contenido principal -->
  <main class="content-container__main">
    <?php
    // 1) Mostrar breadcrumb y título
    //    (Opcional: $contenido['topic'] o $temaId para mostrar)
    ?>
    <nav class="content-container__breadcrumb">
      <a href="#" class="content-container__breadcrumb-link">Secciones</a> 
      &gt; 
      <span class="content-container__breadcrumb-current">
        <?php echo !empty($contenido['topic']) 
          ? htmlspecialchars($contenido['topic']) 
          : 'Tema ' . htmlspecialchars($temaId); 
        ?>
      </span>
    </nav>

    <h1 class="content-container__title">
      <?php 
      // Si tu JSON tiene "topic", lo usas como título
      echo !empty($contenido['topic']) 
        ? htmlspecialchars($contenido['topic']) 
        : 'Tema ' . htmlspecialchars($temaId);
      ?>
    </h1>

    <?php 
    // 2) Mostrar metadata: autor, fecha, etc. (opcional)
    if(!empty($contenido['metadata'])): 
      $author = $contenido['metadata']['author'] ?? '';
      $createdAt = $contenido['metadata']['createdAt'] ?? '';
    ?>
      <p class="content-container__intro">
        <strong>Autor:</strong> <?php echo htmlspecialchars($author); ?> 
        <br>
        <strong>Fecha:</strong> <?php echo htmlspecialchars($createdAt); ?>
      </p>
    <?php endif; ?>

    <?php
    // 3) Renderizar cada bloque de "content"
    //    creamos una función auxiliar para generar HTML según el 'type'
    function renderBlock($block) {
      switch($block['type']) {
        case 'heading':
          // block['level'] = 1,2,3,4,5,6
          $lvl = isset($block['level']) ? (int)$block['level'] : 2; 
          // Asegurarnos de no pasarnos de h6
          if($lvl < 1 || $lvl > 6) $lvl = 2;
          $text = htmlspecialchars($block['content'] ?? '');
          echo "<h{$lvl}>{$text}</h{$lvl}>";
          break;

        case 'paragraph':
          $text = nl2br(htmlspecialchars($block['content'] ?? ''));
          echo "<p>{$text}</p>";
          break;

        case 'code':
          // Podrías detectar un lenguaje y usar un <pre><code> 
          // O sólo <pre>
          $code = htmlspecialchars($block['content'] ?? '');
          echo "<pre class='code-block'><code>{$code}</code></pre>";
          break;

        case 'list-unord':
          // Lista sin orden
          $items = $block['content'] ?? [];
          echo "<ul>";
          foreach($items as $item) {
            echo "<li>" . htmlspecialchars($item) . "</li>";
          }
          echo "</ul>";
          break;

        case 'list-ord':
          // Lista ordenada
          $items = $block['content'] ?? [];
          echo "<ol>";
          foreach($items as $item) {
            echo "<li>" . htmlspecialchars($item) . "</li>";
          }
          echo "</ol>";
          break;

        case 'image':
          // block['src'] es un array de rutas. block['alt'] block['caption']
          $srcArr = $block['src'] ?? [];
          $alt = htmlspecialchars($block['alt'] ?? '');
          $caption = htmlspecialchars($block['caption'] ?? '');
          // Podrías mostrar múltiples imágenes si es un array
          foreach($srcArr as $imgRoute) {
            $imgRouteEsc = htmlspecialchars($imgRoute);
            echo "<figure class='content-image'>";
            echo "<img src='{$imgRouteEsc}' alt='{$alt}'>";
            if($caption) {
              echo "<figcaption>{$caption}</figcaption>";
            }
            echo "</figure>";
          }
          break;

        case 'videos':
          // block['src'] es un array de URLs
          $videos = $block['src'] ?? [];
          $alt = htmlspecialchars($block['alt'] ?? '');
          $caption = htmlspecialchars($block['caption'] ?? '');
          echo "<div class='content-videos'>";
          foreach($videos as $vidUrl) {
            $vidUrlEsc = htmlspecialchars($vidUrl);
            // Podrías incrustar un <iframe> 
            // o un simple <a href="...">
            echo "<p><a href='{$vidUrlEsc}' target='_blank'>Ver video</a></p>";
          }
          if($caption) {
            echo "<p><em>{$caption}</em></p>";
          }
          echo "</div>";
          break;

        default:
          // Tipo no reconocido
          // Podrías ignorarlo o mostrar un texto
          // echo "<!-- Tipo desconocido: " . htmlspecialchars($block['type']) . " -->";
          break;
      }
    }

    // 4) Recorrer $contenido['content'] y renderizar cada bloque
    if(!empty($contenido['content']) && is_array($contenido['content'])) {
      foreach($contenido['content'] as $block) {
        renderBlock($block);
      }
    } else {
      echo "<p>No hay contenido disponible para este tema.</p>";
    }
    ?>
  </main>
</div>
