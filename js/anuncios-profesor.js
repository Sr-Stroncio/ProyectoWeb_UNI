var anuncios = [
    {
        id: 1,
        propio: true,
        autor: 'Tú · Programación',
        asig: 'Programación',
        tiempo: 'Hace 2h',
        titulo: 'Examen parcial – cambio de fecha',
        desc: 'El examen del día 20 se traslada al 22. Misma aula.',
        tipo: 'mios'
    },
    {
        id: 2,
        propio: false,
        autor: 'Secretaría',
        asig: '',
        tiempo: 'Ayer',
        titulo: 'Período de matrícula abierto',
        desc: 'Del 15 al 30 de mayo podéis formalizar la matrícula.',
        tipo: 'general'
    },
    {
        id: 3,
        propio: true,
        autor: 'Tú · BD',
        asig: 'BD',
        tiempo: 'Hace 2d',
        titulo: 'Material adicional unidad 3',
        desc: 'He subido los apuntes de la sesión del martes.',
        tipo: 'mios'
    },
    {
        id: 4,
        propio: true,
        autor: 'Tú · HCI',
        asig: 'HCI',
        tiempo: 'Hace 3d',
        titulo: 'Recordatorio entrega prototipo',
        desc: 'La fecha límite es el 20 de mayo a las 23:59.',
        tipo: 'mios'
    },
    {
        id: 5,
        propio: false,
        autor: 'Dirección',
        asig: '',
        tiempo: 'Hace 5d',
        titulo: 'Semana cultural — participación voluntaria',
        desc: 'Del 27 al 31 de mayo se celebra la semana cultural del centro.',
        tipo: 'general'
    }
];

var nextId = 6;
var filtroActivo = 'todos';
var anuncioId = null;

var listaAnuncios = document.getElementById('listaAnuncios');
var modalFondo = document.getElementById('modalFondo');
var modalTitulo = document.getElementById('modalTitulo');
var inputTitulo = document.getElementById('inputTitulo');
var inputDesc = document.getElementById('inputDesc');
var inputAsig = document.getElementById('inputAsig');
var inputTipo = document.getElementById('inputTipo');
var btnBorrar = document.getElementById('btnBorrarAnuncio');
var btnGuardar = document.getElementById('btnGuardar');


function renderLista() {
    listaAnuncios.innerHTML = '';

    anuncios.forEach(function(anuncio) {
        if (filtroActivo !== 'todos' && anuncio.tipo !== filtroActivo) return;

        var tagClase = anuncio.tipo === 'mios' ? 'tag-asignatura' : 'tag-general';
        var tagTexto = anuncio.tipo === 'mios' ? 'Asignatura' : 'General';

        var btnEditar = '';
        if (anuncio.propio) {
            btnEditar = '<button class="btn-editar-anuncio"><img src="assets/icons/edit.svg" alt="editar"></button>';
        }

        var card = document.createElement('div');
        card.className = 'anuncio-card' + (anuncio.propio ? ' propio' : '');
        card.setAttribute('data-id', anuncio.id);
        card.innerHTML =
            '<div class="anuncio-top">' +
                '<span class="anuncio-autor">' + anuncio.autor + '</span>' +
                '<div class="anuncio-derecha">' +
                    '<span class="anuncio-tiempo">' + anuncio.tiempo + '</span>' +
                    btnEditar +
                '</div>' +
            '</div>' +
            '<p class="anuncio-titulo">' + anuncio.titulo + '</p>' +
            '<p class="anuncio-desc">' + anuncio.desc + '</p>' +
            '<span class="anuncio-tag ' + tagClase + '">' + tagTexto + '</span>';

        if (anuncio.propio) {
            card.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-editar-anuncio') || e.target.tagName === 'IMG') return;
                abrirEditar(anuncio.id);
            });

            card.querySelector('.btn-editar-anuncio').addEventListener('click', function(e) {
                e.stopPropagation();
                abrirEditar(anuncio.id);
            });
        }

        listaAnuncios.appendChild(card);
    });
}

function abrirNuevo() {
    anuncioId = null;
    modalTitulo.textContent = 'Nuevo anuncio';
    inputTitulo.value = '';
    inputDesc.value = '';
    inputAsig.value = 'Programación';
    inputTipo.value = 'mios';
    btnBorrar.classList.add('oculto');
    btnGuardar.textContent = 'Publicar';
    modalFondo.classList.add('visible');
}

function abrirEditar(id) {
    var anuncio = anuncios.find(function(a) { return a.id === id; });
    if (!anuncio) return;

    anuncioId = id;
    modalTitulo.textContent = 'Editar anuncio';
    inputTitulo.value = anuncio.titulo;
    inputDesc.value = anuncio.desc;
    inputAsig.value = anuncio.asig || 'Programación';
    inputTipo.value = anuncio.tipo;
    btnBorrar.classList.remove('oculto');
    btnGuardar.textContent = 'Guardar';
    modalFondo.classList.add('visible');
}

function cerrarModal() {
    modalFondo.classList.remove('visible');
    anuncioId = null;
}

function guardar() {
    var titulo = inputTitulo.value.trim();
    if (!titulo) {
        alert('El título no puede estar vacío.');
        return;
    }

    var asig = inputAsig.value;
    var tipo = inputTipo.value;
    var autorTexto = tipo === 'mios' ? 'Tú · ' + asig : 'Tú';

    if (anuncioId === null) {
        anuncios.unshift({
            id: nextId++,
            propio: true,
            autor: autorTexto,
            asig: asig,
            tiempo: 'Ahora',
            titulo: titulo,
            desc: inputDesc.value.trim(),
            tipo: tipo
        });
    } else {
        var anuncio = anuncios.find(function(a) { return a.id === anuncioId; });
        if (anuncio) {
            anuncio.titulo = titulo;
            anuncio.desc = inputDesc.value.trim();
            anuncio.asig = asig;
            anuncio.tipo = tipo;
            anuncio.autor = autorTexto;
        }
    }

    cerrarModal();
    renderLista();
}

function borrarAnuncio() {
    if (anuncioId === null) return;
    if (!confirm('¿Seguro que quieres eliminar este anuncio?')) return;

    anuncios = anuncios.filter(function(a) { return a.id !== anuncioId; });
    cerrarModal();
    renderLista();
}

document.getElementById('btnNuevoAnuncio').addEventListener('click', abrirNuevo);
document.getElementById('modalCerrar').addEventListener('click', cerrarModal);
document.getElementById('btnCancelar').addEventListener('click', cerrarModal);
btnGuardar.addEventListener('click', guardar);
btnBorrar.addEventListener('click', borrarAnuncio);

modalFondo.addEventListener('click', function(e) {
    if (e.target === modalFondo) cerrarModal();
});

// botones de filtro
document.querySelectorAll('.filtro').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filtro').forEach(function(b) {
            b.classList.remove('activo');
        });
        btn.classList.add('activo');
        filtroActivo = btn.getAttribute('data-filtro');
        renderLista();
    });
});

renderLista();