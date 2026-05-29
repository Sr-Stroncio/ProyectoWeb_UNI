<!-- modal para crear/editar recursos -->
<div class="modal-fondo" id="modalFondoRec">
    <div class="modal">
        <div class="modal-cabecera">
            <h3 id="modalTituloRec">Nuevo recurso</h3>
            <button class="modal-cerrar" id="modalCerrarRec">&#10005;</button>
        </div>

        <div class="modal-cuerpo">
            <label class="campo-label">Título</label>
            <input class="campo-input" type="text" id="inputTituloRec" placeholder="Ej: Diapositivas Tema 1">

            <label class="campo-label">Descripción</label>
            <textarea class="campo-input campo-textarea" id="inputDescRec" placeholder="Sobre qué trata este recurso..."></textarea>

            <label class="campo-label">Asignatura</label>
            <select class="campo-input" id="inputAsigRec">
                <option value="Programación">Programación</option>
                <option value="BD">Bases de Datos</option>
                <option value="HCI">HCI</option>
            </select>

            <label class="campo-label">Enlace del archivo</label>
            <input class="campo-input" type="text" id="inputUrlRec" placeholder="https://...">

            <label class="campo-label">Estado</label>
            <select class="campo-input" id="inputEstadoRec">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        <div class="modal-pie">
            <button class="btn-modal-borrar oculto" id="btnBorrarRecursoRec">Eliminar recurso</button>
            <div class="modal-pie-derecha">
                <button class="btn-modal-cancelar" id="btnCancelarRec">Cancelar</button>
                <button class="btn-modal-guardar" id="btnGuardarRec">Guardar</button>
            </div>
        </div>
    </div>
</div>

<main>
    <div class="main-cabecera">
        <div>
            <h2>Recursos</h2>
            <p class="main-sub" id="subtituloRec">Todas las asignaturas</p>
        </div>
        <button class="btn-nuevo" id="btnNuevoRecurso">+ Nuevo recurso</button>
    </div>

    <div class="lista-recursos" id="listaRecursos"></div>
</main>
