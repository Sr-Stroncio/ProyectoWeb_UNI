<!-- modal para crear/editar anuncios -->
<div class="modal-fondo" id="modalFondoAnu">
    <div class="modal">
        <div class="modal-cabecera">
            <h3 id="modalTituloAnu">Nuevo anuncio</h3>
            <button class="modal-cerrar" id="modalCerrarAnu">&#10005;</button>
        </div>

        <div class="modal-cuerpo">
            <label class="campo-label">Título</label>
            <input class="campo-input" type="text" id="inputTituloAnu" placeholder="Ej: Cambio de aula">

            <label class="campo-label">Descripción</label>
            <textarea class="campo-input campo-textarea" id="inputDescAnu" placeholder="Escribe el contenido del anuncio..."></textarea>

            <label class="campo-label">Asignatura</label>
            <select class="campo-input" id="inputAsigAnu">
                <option value="Programación">Programación</option>
                <option value="BD">Bases de Datos</option>
                <option value="HCI">HCI</option>
            </select>

            <label class="campo-label">Tipo</label>
            <select class="campo-input" id="inputTipoAnu">
                <option value="mios">Asignatura</option>
                <option value="general">General</option>
            </select>
        </div>

        <div class="modal-pie">
            <button class="btn-modal-borrar oculto" id="btnBorrarAnuncioAnu">Eliminar anuncio</button>
            <div class="modal-pie-derecha">
                <button class="btn-modal-cancelar" id="btnCancelarAnu">Cancelar</button>
                <button class="btn-modal-guardar" id="btnGuardarAnu">Publicar</button>
            </div>
        </div>
    </div>
</div>

<main>
    <div class="main-cabecera">
        <h2>Anuncios</h2>
        <button class="btn-nuevo" id="btnNuevoAnuncio">+ Nuevo anuncio</button>
    </div>

    <div class="filtros">
        <button class="filtro activo" data-filtro="todos">Todos</button>
        <button class="filtro" data-filtro="mios">Mis anuncios</button>
        <button class="filtro" data-filtro="general">General</button>
    </div>

    <div class="lista-anuncios" id="listaAnuncios"></div>
</main>
