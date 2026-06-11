var sidebar = document.getElementById('sidebar');
var btnMenu = document.getElementById('btnMenu');
var overlay = document.getElementById('overlay');

btnMenu.addEventListener('click', function() {
    sidebar.classList.toggle('abierto');
    overlay.classList.toggle('activo');
});

overlay.addEventListener('click', function() {
    sidebar.classList.remove('abierto');
    overlay.classList.remove('activo');
});

function cerrarModales() {
    var fondos = document.querySelectorAll('.modal-fondo');
    for (var i = 0; i < fondos.length; i++) {
        fondos[i].classList.remove('activo');
    }
}

function abrirModal(idBoton, idModal) {
    var btn = document.getElementById(idBoton);
    if (btn) {
        btn.addEventListener('click', function() {
            document.getElementById(idModal).classList.add('activo');
        });
    }
}

abrirModal('btnNuevoGrado', 'modalNuevoGrado');
abrirModal('btnNuevoAlumno', 'modalNuevoAlumno');
abrirModal('btnEditarAlumno', 'modalEditarAlumno');
abrirModal('btnEditarAsignaturas', 'modalEditarAsignaturas');
abrirModal('btnNuevoProfesor', 'modalNuevoProfesor');
abrirModal('btnEditarProfesor', 'modalEditarProfesor');
abrirModal('btnEditarMaterias', 'modalEditarMaterias');
abrirModal('btnAddAlumno', 'modalAddAlumno');
abrirModal('btnAddProfesor', 'modalAddProfesor');

var cierres = [
    'btnCerrarModal', 'btnCancelarModal',
    'btnCerrarModalAlumno', 'btnCancelarModalAlumno',
    'btnCerrarModalEditar', 'btnCancelarModalEditar',
    'btnCerrarModalAsig', 'btnCancelarModalAsig',
    'btnCerrarModalProfesor', 'btnCancelarModalProfesor',
    'btnCerrarModalEditarProfesor', 'btnCancelarModalEditarProfesor',
    'btnCerrarModalMaterias', 'btnCancelarModalMaterias',
    'btnCerrarAddAlumno', 'btnCancelarAddAlumno',
    'btnCerrarAddProfesor', 'btnCancelarAddProfesor'
];

for (var i = 0; i < cierres.length; i++) {
    var btnCierre = document.getElementById(cierres[i]);
    if (btnCierre) {
        btnCierre.addEventListener('click', cerrarModales);
    }
}

var buscador = document.getElementById('buscadorAlumnos');

if (buscador) {
    buscador.addEventListener('input', function() {
        var texto = buscador.value.toLowerCase();
        var filas = document.querySelectorAll('#tablaAlumnos tbody tr');
        for (var i = 0; i < filas.length; i++) {
            if (filas[i].textContent.toLowerCase().indexOf(texto) !== -1) {
                filas[i].style.display = '';
            } else {
                filas[i].style.display = 'none';
            }
        }
    });
}

var buscadorProf = document.getElementById('buscadorProfesores');

if (buscadorProf) {
    buscadorProf.addEventListener('input', function() {
        var texto = buscadorProf.value.toLowerCase();
        var filas = document.querySelectorAll('#tablaProfesores tbody tr');
        for (var i = 0; i < filas.length; i++) {
            if (filas[i].textContent.toLowerCase().indexOf(texto) !== -1) {
                filas[i].style.display = '';
            } else {
                filas[i].style.display = 'none';
            }
        }
    });
}

function eliminarAlumno(idAlumno) {
    if (!confirm('¿Seguro que quieres eliminar este alumno?')) return;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'utils/eliminar-alumno.php';
    var i1 = document.createElement('input');
    i1.type = 'hidden'; i1.name = 'id_alumno'; i1.value = idAlumno;
    form.appendChild(i1);
    document.body.appendChild(form);
    form.submit();
}

function eliminarAlumnoGrado(idAlumno, idGrado) {
    if (!confirm('¿Seguro que quieres eliminar este alumno del grado?')) return;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'utils/eliminar-alumno-grado.php';
    var i1 = document.createElement('input');
    i1.type = 'hidden'; i1.name = 'id_alumno'; i1.value = idAlumno;
    var i2 = document.createElement('input');
    i2.type = 'hidden'; i2.name = 'id_grado'; i2.value = idGrado;
    form.appendChild(i1); form.appendChild(i2);
    document.body.appendChild(form);
    form.submit();
}

function eliminarProfesor(idProfesor, idGrado) {
    if (!confirm('¿Seguro que quieres eliminar este profesor del grado?')) return;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'utils/eliminar-profesor-grado.php';
    var i1 = document.createElement('input');
    i1.type = 'hidden'; i1.name = 'id_profesor'; i1.value = idProfesor;
    var i2 = document.createElement('input');
    i2.type = 'hidden'; i2.name = 'id_grado'; i2.value = idGrado;
    form.appendChild(i1); form.appendChild(i2);
    document.body.appendChild(form);
    form.submit();
}

function eliminarMateria(idMateria, idGrado) {
    if (!confirm('¿Seguro que quieres eliminar esta materia del grado?')) return;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'utils/eliminar-materia-grado.php';
    var i1 = document.createElement('input');
    i1.type = 'hidden'; i1.name = 'id_materia'; i1.value = idMateria;
    var i2 = document.createElement('input');
    i2.type = 'hidden'; i2.name = 'id_grado'; i2.value = idGrado;
    form.appendChild(i1); form.appendChild(i2);
    document.body.appendChild(form);
    form.submit();
}

function eliminarProfesorAdmin(idProfesor) {
    if (!confirm('¿Seguro que quieres eliminar este profesor?')) return;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'utils/eliminar-profesor.php';
    var i1 = document.createElement('input');
    i1.type = 'hidden'; i1.name = 'id_profesor'; i1.value = idProfesor;
    form.appendChild(i1);
    document.body.appendChild(form);
    form.submit();
}
