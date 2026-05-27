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

var modales = {
    'btnNuevoGrado':        'modalNuevoGrado',
    'btnNuevoAlumno':       'modalNuevoAlumno',
    'btnEditarAlumno':      'modalEditarAlumno',
    'btnEditarAsignaturas': 'modalEditarAsignaturas'
};

Object.keys(modales).forEach(function(btnId) {
    var btn = document.getElementById(btnId);
    var modal = document.getElementById(modales[btnId]);
    if (btn && modal) {
        btn.addEventListener('click', function() {
            modal.classList.add('activo');
        });
    }
});

var cierres = [
    'btnCerrarModal', 'btnCancelarModal',
    'btnCerrarModalAlumno', 'btnCancelarModalAlumno',
    'btnCerrarModalEditar', 'btnCancelarModalEditar',
    'btnCerrarModalAsig', 'btnCancelarModalAsig'
];

cierres.forEach(function(id) {
    var btn = document.getElementById(id);
    if (btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.modal-fondo').forEach(function(m) {
                m.classList.remove('activo');
            });
        });
    }
});

var buscador = document.getElementById('buscadorAlumnos');

if (buscador) {
    buscador.addEventListener('input', function() {
        var texto = buscador.value.toLowerCase();
        document.querySelectorAll('#tablaAlumnos tbody tr').forEach(function(fila) {
            fila.style.display = fila.textContent.toLowerCase().includes(texto) ? '' : 'none';
        });
    });
}

function eliminarAlumno(idAlumno) {
    if (!confirm('¿Seguro que quieres eliminar este alumno?')) return;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '/utils/eliminar-alumno.php';
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
    form.action = '/utils/eliminar-alumno-grado.php';
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
    form.action = '/utils/eliminar-profesor-grado.php';
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
    form.action = '/utils/eliminar-materia-grado.php';
    var i1 = document.createElement('input');
    i1.type = 'hidden'; i1.name = 'id_materia'; i1.value = idMateria;
    var i2 = document.createElement('input');
    i2.type = 'hidden'; i2.name = 'id_grado'; i2.value = idGrado;
    form.appendChild(i1); form.appendChild(i2);
    document.body.appendChild(form);
    form.submit();
}
