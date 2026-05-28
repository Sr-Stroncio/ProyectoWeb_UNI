// calificaciones
// se cargan los datos de php
if (typeof calificaciones === 'undefined') {
    var calificaciones = {
        prog: [
            { id: 1, nombre: 'Lief Simants', email: 'l.simdre@epsg.upv.es', p1: 7.5, p2: 8.2, final: 9.1 },
            { id: 2, nombre: 'Merline Kirdsch', email: 'm.kirkam@epsg.upv.es', p1: 6.0, p2: 7.0, final: 8.0 },
            { id: 3, nombre: 'Debora Rawstorne', email: 'd.rawabc@epsg.upv.es', p1: 9.0, p2: 8.8, final: 9.5 }
        ],
        bd: [
            { id: 1, nombre: 'Lief Simants', email: 'l.simdre@epsg.upv.es', p1: 6.5, p2: 7.0, final: 8.5 },
            { id: 2, nombre: 'Merline Kirdsch', email: 'm.kirkam@epsg.upv.es', p1: 8.0, p2: 7.5, final: 9.0 }
        ],
        hci: [
            { id: 1, nombre: 'Lief Simants', email: 'l.simdre@epsg.upv.es', p1: 8.5, p2: 9.0, final: 8.0 }
        ]
    };
}

var subtitulosCal = {
    prog: 'Programación · 28 alumnos',
    bd: 'Bases de Datos · 24 alumnos',
    hci: 'HCI · 25 alumnos'
};

var asigActivaCal = 'prog';
var alumnoIdCal = null;

// se calcula la media
function calcularMediaCal(p1, p2, final) {
    var suma = 0;
    var total = 0;
    if (p1 !== null && p1 !== '' && !isNaN(p1)) {
        suma = suma + parseFloat(p1);
        total = total + 1;
    }
    if (p2 !== null && p2 !== '' && !isNaN(p2)) {
        suma = suma + parseFloat(p2);
        total = total + 1;
    }
    if (final !== null && final !== '' && !isNaN(final)) {
        suma = suma + parseFloat(final);
        total = total + 1;
    }

    if (total === 0) return '—';

    var calculo = suma / total;
    return Math.round(calculo * 10) / 10;
}

function mostrarNotaCal(val) {
    if (val === null || val === '' || isNaN(val)) return '—';
    return val;
}

// se pinta la lista de alumnos
function renderTablaCal() {
    var cuerpo = document.getElementById('cuerpoTablaAlumnos');
    if (!cuerpo) return;
    cuerpo.innerHTML = '';
    
    var lista = calificaciones[asigActivaCal];
    if (!lista) return;

    lista.forEach(function(alumno) {
        var fila = document.createElement('div');
        fila.className = 'tabla-fila';
        fila.style.cursor = 'pointer';
        
        fila.innerHTML =
            '<span class="col-alumno">' + alumno.nombre + '</span>' +
            '<span class="col-email" style="flex: 2;">' + alumno.email + '</span>' +
            '<span class="col-accion"><button class="btn-editar" style="background: none; border: none; color: #ff9e00; cursor: pointer; font-weight: 600;">&#9998; Ver/Editar</button></span>';

        // se abre el detalle al hacer click
        fila.addEventListener('click', function() {
            mostrarDetalleCal(alumno.id);
        });

        cuerpo.appendChild(fila);
    });
}

// se selecciona la asignatura desde el hash
window.seleccionarAsignaturaHash = function(asig) {
    asigActivaCal = asig;
    
    var pestanas = document.querySelectorAll('.pill');
    pestanas.forEach(function(p) {
        if (p.getAttribute('data-asig') === asig) {
            p.classList.add('activo');
        } else {
            p.classList.remove('activo');
        }
    });

    if (document.getElementById('subtitulo')) {
        document.getElementById('subtitulo').textContent = subtitulosCal[asig];
    }
    
    // se vuelve al listado
    if (document.getElementById('vista-detalle-alumno')) {
        document.getElementById('vista-detalle-alumno').style.display = 'none';
    }
    if (document.getElementById('vista-lista-alumnos')) {
        document.getElementById('vista-lista-alumnos').style.display = 'block';
    }
    
    renderTablaCal();
};

// se muestran los detalles del alumno
function mostrarDetalleCal(id) {
    var lista = calificaciones[asigActivaCal];
    var alumno = lista.find(function(a) { return a.id === id; });
    if (!alumno) return;

    alumnoIdCal = id;

    document.getElementById('detalleNombreAlumno').textContent = alumno.nombre;
    document.getElementById('detalleEmailAlumno').textContent = alumno.email;

    document.getElementById('detalleNotaP1').textContent = mostrarNotaCal(alumno.p1);
    document.getElementById('detalleNotaP2').textContent = mostrarNotaCal(alumno.p2);
    document.getElementById('detalleNotaFinal').textContent = mostrarNotaCal(alumno.final);

    var media = calcularMediaCal(alumno.p1, alumno.p2, alumno.final);
    document.getElementById('detalleNotaMedia').textContent = media;

    // se oculta el listado
    document.getElementById('vista-lista-alumnos').style.display = 'none';
    document.getElementById('vista-detalle-alumno').style.display = 'block';
}

function actualizarMediaCal() {
    var p1 = document.getElementById('inputP1').value;
    var p2 = document.getElementById('inputP2').value;
    var finalVal = document.getElementById('inputFinal').value;
    
    var media = calcularMediaCal(p1, p2, finalVal);
    document.getElementById('mediaPreview').textContent = media;
}

function abrirEditarCal() {
    if (alumnoIdCal === null) return;
    
    var lista = calificaciones[asigActivaCal];
    var alumno = lista.find(function(a) { return a.id === alumnoIdCal; });
    if (!alumno) return;

    document.getElementById('modalNombreAlumno').textContent = alumno.nombre;
    document.getElementById('inputP1').value = alumno.p1 !== null ? alumno.p1 : '';
    document.getElementById('inputP2').value = alumno.p2 !== null ? alumno.p2 : '';
    document.getElementById('inputFinal').value = alumno.final !== null ? alumno.final : '';

    actualizarMediaCal();
    document.getElementById('modalFondo').classList.add('visible');
}

function cerrarModalCal() {
    document.getElementById('modalFondo').classList.remove('visible');
}

function guardarCal() {
    if (alumnoIdCal === null) return;

    var p1Val = document.getElementById('inputP1').value;
    var p2Val = document.getElementById('inputP2').value;
    var finVal = document.getElementById('inputFinal').value;

    var p1 = p1Val !== '' ? parseFloat(p1Val) : null;
    var p2 = p2Val !== '' ? parseFloat(p2Val) : null;
    var fin = finVal !== '' ? parseFloat(finVal) : null;

    var lista = calificaciones[asigActivaCal];
    var alumno = lista.find(function(a) { return a.id === alumnoIdCal; });
    if (alumno) {
        alumno.p1 = p1;
        alumno.p2 = p2;
        alumno.final = fin;
    }

    // se envían los datos por POST
    var params = 'alumno_id=' + alumnoIdCal +
                 '&asignatura=' + asigActivaCal +
                 '&p1=' + (p1 !== null ? p1 : '') +
                 '&p2=' + (p2 !== null ? p2 : '') +
                 '&final=' + (fin !== null ? fin : '');

    fetch('utils/guardar-notas-profesor.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: params
    });

    cerrarModalCal();
    mostrarDetalleCal(alumnoIdCal);
}

function exportarCSVCal() {
    var lista = calificaciones[asigActivaCal];
    var filas = ['Alumno,Correo,Parcial 1,Parcial 2,Final,Media'];

    lista.forEach(function(alumno) {
        var media = calcularMediaCal(alumno.p1, alumno.p2, alumno.final);
        var linea = alumno.nombre + ',' +
                    alumno.email + ',' +
                    mostrarNotaCal(alumno.p1) + ',' +
                    mostrarNotaCal(alumno.p2) + ',' +
                    mostrarNotaCal(alumno.final) + ',' +
                    media;
        filas.push(linea);
    });

    var contenido = filas.join('\n');
    var blob = new Blob([contenido], { type: 'text/csv;charset=utf-8;' });
    var url = URL.createObjectURL(blob);
    var enlace = document.createElement('a');
    enlace.href = url;
    enlace.download = 'calificaciones-' + asigActivaCal + '.csv';
    enlace.click();
}

// se configuran los escuchadores de eventos
document.getElementById('btnVolverLista').addEventListener('click', function() {
    document.getElementById('vista-detalle-alumno').style.display = 'none';
    document.getElementById('vista-lista-alumnos').style.display = 'block';
    renderTablaCal();
});

document.getElementById('btnEditarNotasAlumno').addEventListener('click', abrirEditarCal);
document.getElementById('modalCerrar').addEventListener('click', cerrarModalCal);
document.getElementById('btnCancelar').addEventListener('click', cerrarModalCal);
document.getElementById('btnGuardar').addEventListener('click', guardarCal);

document.getElementById('inputP1').addEventListener('input', actualizarMediaCal);
document.getElementById('inputP2').addEventListener('input', actualizarMediaCal);
document.getElementById('inputFinal').addEventListener('input', actualizarMediaCal);

var modalFondoCal = document.getElementById('modalFondo');
modalFondoCal.addEventListener('click', function(e) {
    if (e.target === modalFondoCal) cerrarModalCal();
});

document.getElementById('btnExportarCSV').addEventListener('click', exportarCSVCal);

var pestanasCal = document.querySelectorAll('.pill');
pestanasCal.forEach(function(pill) {
    pill.addEventListener('click', function() {
        pestanasCal.forEach(function(p) {
            p.classList.remove('activo');
        });
        pill.classList.add('activo');
        asigActivaCal = pill.getAttribute('data-asig');
        document.getElementById('subtitulo').textContent = subtitulosCal[asigActivaCal];
        
        // se vuelve a la lista
        document.getElementById('vista-detalle-alumno').style.display = 'none';
        document.getElementById('vista-lista-alumnos').style.display = 'block';
        
        renderTablaCal();
    });
});

// se realiza el renderizado inicial
renderTablaCal();