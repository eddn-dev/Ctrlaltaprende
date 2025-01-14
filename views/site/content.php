<div class="content-container">
  <!-- Barra lateral (sidebar) -->
  <aside class="content-container__sidebar">
    <h2 class="content-container__sidebar-title">Materias</h2>

    <!-- Estructura de acordeón (Materia -> Unidad -> Temas) -->
    <ul class="accordion">
      <!-- Materia 1 -->
      <li class="accordion__item">
        <!-- Botón que al hacer clic despliega la unidad -->
        <button class="accordion__header">
          Materia 1
        </button>
        <!-- Panel interno con unidades -->
        <ul class="accordion__panel">
          <!-- Unidad 1 -->
          <li class="accordion__item">
            <button class="accordion__header">
              Unidad  1
            </button>
            <!-- Panel con los temas -->
            <ul class="accordion__panel">
              <li><a href="#" class="content-container__sidebar-link">Tema 1</a></li>
              <li><a href="#" class="content-container__sidebar-link">Tema 2</a></li>
              <li><a href="#" class="content-container__sidebar-link">Tema 3</a></li>
            </ul>
          </li>
          <!-- Unidad 2 -->
          <li class="accordion__item">
            <button class="accordion__header">
              Unidad  2
            </button>
            <ul class="accordion__panel">
              <li><a href="#" class="content-container__sidebar-link">Tema 1</a></li>
              <li><a href="#" class="content-container__sidebar-link">Tema 2</a></li>
            </ul>
          </li>
        </ul>
      </li>

      <!-- Materia 2 -->
      <li class="accordion__item">
        <button class="accordion__header">Materia 2</button>
        <ul class="accordion__panel">
          <li class="accordion__item">
            <button class="accordion__header">
              Unidad  1
            </button>
            <ul class="accordion__panel">
              <li><a href="#" class="content-container__sidebar-link">Tema 1</a></li>
              <li><a href="#" class="content-container__sidebar-link">Tema 2</a></li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </aside>

  <!-- Contenido principal -->
  <main class="content-container__main">
    <nav class="content-container__breadcrumb">
      <a href="#" class="content-container__breadcrumb-link">Secciones</a> 
      &gt; 
      <span class="content-container__breadcrumb-current">Tema 1</span>
    </nav>
    <h1 class="content-container__title">Tema 1</h1>
    <p class="content-container__intro">
      Explora los conceptos clave de este tema. A continuación, verás los subtemas relacionados.
      Lorem ipsum dolor sit amet consectetur adipisicing.
      Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dicta nemo dolores eveniet nesciunt voluptatem iusto voluptates sed facere sequi illo, nulla repellendus ratione asperiores vero esse itaque, provident temporibus. Ipsam.
      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Earum eos maiores aliquid optio necessitatibus minus nisi corporis quae quas, quam cumque, impedit blanditiis ex magni est culpa maxime laudantium. Dicta.
      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sequi, consequuntur sit! Illo veritatis eum magni at voluptatum incidunt voluptatibus, repellat, atque natus, sunt aspernatur commodi debitis facilis qui assumenda quae!
      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti ducimus voluptas porro accusantium, quasi ratione quo molestiae aliquam, accusamus provident id beatae, consequatur culpa iure sit modi earum voluptatum at.
      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum dolorum voluptates provident quasi reiciendis quia non similique sint error. A deleniti facere autem nostrum est. Veritatis eos nulla voluptas hic.
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ab, neque amet nostrum nobis omnis sunt placeat ea asperiores delectus error dolor odit cumque praesentium ullam numquam illum dolore, dicta qui.
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis facere cum magnam reprehenderit, officia ipsa itaque? Officiis veritatis labore natus asperiores voluptates quo cupiditate ab, repellat pariatur vel ut perferendis.
    </p>

    <div class="learning-card">
      <h2 class="learning-card__title">Subtemas</h2>
      <ul class="learning-card__list">
        <li class="learning-card__item">Subtema 1: Introducción</li>
        <li class="learning-card__item">Subtema 2: Conceptos básicos</li>
        <li class="learning-card__item">Subtema 3: Ejemplos prácticos</li>
        <li class="learning-card__item">Subtema 4: Resumen</li>
      </ul>
    </div>

    <!-- Secciones de subtemas -->
    <section class="content-container__section">
      <h2 class="content-container__section-title">Subtema 1: Introducción</h2>
      <p class="content-container__section-text">
        Este subtema abarca los conceptos iniciales necesarios para entender el resto del tema.
      </p>
    </section>
    <!-- etc... -->
  </main>
</div>
