
<button id="open-modal" class="btn">Crear Post</button>

<!-- Ventana Modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Crear post</h2>
            <button id="close-modal" class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
            <label for="topics">Selecciona temas o materias relacionados</label>
            <select id="topics">
                <option value="tema1">Tema 1</option>
                <option value="tema2">Tema 2</option>
                <option value="materia1">Materia 1</option>
            </select>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" data-tab="text">Texto</button>
                <button class="tab" data-tab="images">Imágenes & Video</button>
                <button class="tab" data-tab="link">Link</button>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <div id="text" class="tab-pane active">
                    <input type="text" id="title" placeholder="Título*" maxlength="100">
                    <textarea id="content" placeholder="Texto"></textarea>
                </div>
                <div id="images" class="tab-pane">
                    <p>Sube tus imágenes o videos aquí.</p>
                    <input type="file" accept="image/*,video/*">
                </div>
                <div id="link" class="tab-pane">
                    <input type="url" id="link-url" placeholder="Pega tu enlace aquí">
                </div>
            </div>

            <!-- Nueva sección para descripción -->
            <div class="description-section">
                <label for="description">Descripción:</label>
                <textarea id="description" placeholder="Añade una descripción breve..." maxlength="300"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn save-btn">Guardar</button>
            <button class="btn publish-btn">Publicar</button>
        </div>
    </div>
</div>