<!-- modal para editar calificaciones del alumno seleccionado -->
<div class="modal-fondo" id="modalFondo">
    <div class="modal">
        <div class="modal-cabecera">
            <h3 id="modalTitulo">Editar calificaciones</h3>
            <button class="modal-cerrar" id="modalCerrar">&#10005;</button>
        </div>

        <div class="modal-cuerpo">
            <h4 id="modalNombreAlumno" style="margin: 0 0 16px 0; color: #222222;"></h4>
            
            <div class="notas-fila">
                <div class="nota-grupo">
                    <label class="campo-label">Parcial 1</label>
                    <input class="campo-input" type="number" id="inputP1" placeholder="—" min="0" max="10" step="0.1">
                </div>
                <div class="nota-grupo">
                    <label class="campo-label">Parcial 2</label>
                    <input class="campo-input" type="number" id="inputP2" placeholder="—" min="0" max="10" step="0.1">
                </div>
                <div class="nota-grupo">
                    <label class="campo-label">Final</label>
                    <input class="campo-input" type="number" id="inputFinal" placeholder="—" min="0" max="10" step="0.1">
                </div>
            </div>

            <div class="media-preview" style="margin-top: 20px;">
                <span class="media-label">Media calculada</span>
                <span class="media-valor" id="mediaPreview">—</span>
            </div>
        </div>

        <div class="modal-pie">
            <button class="btn-modal-borrar" id="btnBorrarAlumno" style="display: none;">Eliminar alumno</button>
            <div class="modal-pie-derecha">
                <button class="btn-modal-cancelar" id="btnCancelar">Cancelar</button>
                <button class="btn-modal-guardar" id="btnGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<main>
    <!-- VISTA 1: LISTADO DE ALUMNOS DE LA ASIGNATURA -->
    <div id="vista-lista-alumnos">
        <div class="main-cabecera">
            <div>
                <h2>Calificaciones</h2>
                <p class="main-sub" id="subtitulo">Programación · 28 alumnos</p>
            </div>
            <!-- seleccionador de asignatura -->
            <div class="pills">
                <button class="pill activo" data-asig="prog">Programación</button>
                <button class="pill" data-asig="bd">Bases de Datos</button>
                <button class="pill" data-asig="hci">HCI</button>
            </div>
        </div>

        <div class="tabla-wrapper">
            <div class="tabla-top">
                <span class="tabla-titulo">ALUMNOS MATRICULADOS</span>
                <div class="tabla-acciones">
                    <button class="btn-accion" id="btnExportarCSV">Exportar CSV</button>
                </div>
            </div>
            <div class="tabla-cabecera">
                <span class="col-alumno">ALUMNO</span>
                <span class="col-email" style="flex: 2;">CORREO INSTITUCIONAL</span>
                <span class="col-accion"></span>
            </div>
            <div id="cuerpoTablaAlumnos"></div>
        </div>
    </div>

    <!-- VISTA 2: DETALLE DE EXÁMENES / NOTAS DEL ALUMNO SELECCIONADO -->
    <div id="vista-detalle-alumno" style="display: none;">
        <div class="main-cabecera" style="margin-bottom: 16px;">
            <div>
                <button class="btn-accion" id="btnVolverLista" style="margin-bottom: 12px;">← Volver al listado</button>
                <h2 id="detalleNombreAlumno">Lief Simants</h2>
                <p class="main-sub" id="detalleEmailAlumno">l.simdre@epsg.upv.es</p>
            </div>
            <button class="btn-nuevo" id="btnEditarNotasAlumno">Editar calificaciones</button>
        </div>

        <!-- tabla de calificaciones laid out normally -->
        <div class="tabla-wrapper">
            <div class="tabla-top">
                <span class="tabla-titulo">CALIFICACIONES DETALLADAS</span>
            </div>
            <div class="tabla-cabecera">
                <span style="flex: 2; font-weight: 700; color: #888888;">EXAMEN / PRUEBA</span>
                <span style="flex: 1; font-weight: 700; color: #888888; text-align: center;">CALIFICACIÓN</span>
            </div>
            
            <div class="tabla-fila" style="cursor: default;">
                <span style="flex: 2;">Examen Parcial 1</span>
                <span id="detalleNotaP1" style="flex: 1; text-align: center; font-weight: 600;">—</span>
            </div>
            <div class="tabla-fila" style="cursor: default;">
                <span style="flex: 2;">Examen Parcial 2</span>
                <span id="detalleNotaP2" style="flex: 1; text-align: center; font-weight: 600;">—</span>
            </div>
            <div class="tabla-fila" style="cursor: default;">
                <span style="flex: 2;">Examen Final Ordinario</span>
                <span id="detalleNotaFinal" style="flex: 1; text-align: center; font-weight: 600;">—</span>
            </div>
            <div class="tabla-fila" style="cursor: default; background-color: #fafafa; border-top: 2px solid #e0e0e0;">
                <span style="flex: 2; font-weight: 700;">PROMEDIO GENERAL</span>
                <span id="detalleNotaMedia" style="flex: 1; text-align: center; font-weight: 700; color: #222222; font-size: 16px;">—</span>
            </div>
        </div>
    </div>
</main>
