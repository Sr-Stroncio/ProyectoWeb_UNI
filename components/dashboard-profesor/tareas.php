<!-- modal para editar/crear tareas -->
<div class="modal-fondo" id="modalFondoTar">
    <div class="modal">
        <div class="modal-cabecera">
            <h3 id="modalTituloTar">Nueva tarea</h3>
            <button class="modal-cerrar" id="modalCerrarTar">&#10005;</button>
        </div>

        <div class="modal-cuerpo">
            <label class="campo-label">Nombre de la tarea</label>
            <input class="campo-input" type="text" id="inputNombreTar" placeholder="Ej: Práctica 3 — Algoritmos">

            <label class="campo-label">Asignatura</label>
            <select class="campo-input" id="inputAsigTar">
                <option value="Programación">Programación</option>
                <option value="BD">Bases de Datos</option>
                <option value="HCI">HCI</option>
            </select>

            <label class="campo-label">Fecha de cierre</label>
            <input class="campo-input" type="date" id="inputCierreTar">

            <label class="campo-label">Descripción</label>
            <textarea class="campo-input campo-textarea" id="inputDescTar" placeholder="Instrucciones de la tarea..."></textarea>

            <!-- extender plazo (solo visible al editar) -->
            <div class="extender-bloque" id="extenderBloqueTar">
                <label class="campo-label">Extender plazo</label>
                <div class="extender-controles">
                    <input class="campo-input extender-input" type="number" id="inputExtenderTar" placeholder="5" min="1">
                    <select class="campo-input extender-unidad" id="inputExtenderUnidadTar">
                        <option value="MINUTE">minutos</option>
                        <option value="HOUR">horas</option>
                        <option value="DAY">días</option>
                    </select>
                    <button class="btn-extender" id="btnExtenderTar" type="button">Extender</button>
                </div>
            </div>
        </div>

        <div class="modal-pie">
            <button class="btn-modal-borrar" id="btnBorrarTareaTar">Eliminar tarea</button>
            <div class="modal-pie-derecha">
                <button class="btn-modal-cancelar" id="btnCancelarTar">Cancelar</button>
                <button class="btn-modal-guardar" id="btnGuardarTar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<main>
    <div class="main-cabecera">
        <div>
            <h2>Tareas</h2>
            <p class="main-sub" id="subtituloTar">Todas las asignaturas</p>
        </div>
        <button class="btn-nuevo" id="btnNuevaTarea">+ Nueva tarea</button>
    </div>

    <div class="filtros">
        <button class="filtro activo" data-filtro="todas">Todas</button>
        <button class="filtro" data-filtro="abierta">Abiertas</button>
        <button class="filtro" data-filtro="cerrada">Cerradas</button>
        <button class="filtro" data-filtro="futura">Futuras</button>
    </div>

    <div class="tabla-wrapper">
        <div class="tabla-cabecera">
            <span class="col-tarea">TAREA</span>
            <span class="col-asig">ASIGNATURA</span>
            <span class="col-cierre">CIERRE</span>
            <span class="col-entregas">ENTREGAS</span>
            <span class="col-estado">ESTADO</span>
            <span class="col-accion"></span>
        </div>
        <div id="cuerpoTabla"></div>
    </div>
</main>
