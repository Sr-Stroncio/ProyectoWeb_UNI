if (typeof anuncios === 'undefined') {
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
}

var nextIdAnu = 6;
var filtroActivoAnu = 'todos';
var anuncioIdAnu = null;

var listaAnunciosAnu = document.getElementById('listaAnuncios');
var modalFondoAnu = document.getElementById('modalFondoAnu');
var modalTituloAnu = document.getElementById('modalTituloAnu');
var inputTituloAnu = document.getElementById('inputTituloAnu');
var inputDescAnu = document.getElementById('inputDescAnu');
var inputAsigAnu = document.getElementById('inputAsigAnu');
var inputTipoAnu = document.getElementById('inputTipoAnu');
var btnBorrarAnu = document.getElementById('btnBorrarAnuncioAnu');
var btnGuardarAnu = document.getElementById('btnGuardarAnu');

// se renderiza la lista de anuncios usando forEach
function renderListaAnu() {
    listaAnunciosAnu.innerHTML = '';

    anuncios.forEach(function(anuncio) {
        if (filtroActivoAnu !== 'todos' && anuncio.tipo !== filtroActivoAnu) return;

        var tagClase = anuncio.tipo === 'mios' ? 'tag-asignatura' : 'tag-general';
        var tagTexto = anuncio.tipo === 'mios' ? 'Asignatura' : 'General';

        var btnEditar = '';
        if (anuncio.propio) {
            btnEditar = '<button class="btn-editar-anuncio"><img src="assets/iconos/pencil.svg" alt="editar"></button>';
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
                abrirEditarAnu(anuncio.id);
            });

            card.querySelector('.btn-editar-anuncio').addEventListener('click', function(e) {
                e.stopPropagation();
                abrirEditarAnu(anuncio.id);
            });
        }

        listaAnunciosAnu.appendChild(card);
    });
}

function abrirNuevoAnu() {
    anuncioIdAnu = null;
    modalTituloAnu.textContent = 'Nuevo anuncio';
    inputTituloAnu.value = '';
    inputDescAnu.value = '';
    inputAsigAnu.value = 'Programación';
    inputTipoAnu.value = 'mios';
    btnBorrarAnu.classList.add('oculto');
    btnGuardarAnu.textContent = 'Publicar';
    modalFondoAnu.classList.add('visible');
}

function abrirEditarAnu(id) {
    // se busca el anuncio usando find
    var anuncio = anuncios.find(function(a) { return a.id === id; });
    if (!anuncio) return;

    anuncioIdAnu = id;
    modalTituloAnu.textContent = 'Editar anuncio';
    inputTituloAnu.value = anuncio.titulo;
    inputDescAnu.value = anuncio.desc;
    inputAsigAnu.value = anuncio.asig || 'Programación';
    inputTipoAnu.value = anuncio.tipo;
    btnBorrarAnu.classList.remove('oculto');
    btnGuardarAnu.textContent = 'Guardar';
    modalFondoAnu.classList.add('visible');
}

function cerrarModalAnu() {
    modalFondoAnu.classList.remove('visible');
    anuncioIdAnu = null;
}

function guardarAnu() {
    var titulo = inputTituloAnu.value.trim();
    if (!titulo) {
        alert('El título no puede estar vacío.');
        return;
    }

    var asig = inputAsigAnu.value;
    var tipo = inputTipoAnu.value;
    var desc = inputDescAnu.value.trim();
    var autorTexto = tipo === 'mios' ? 'Tú · ' + asig : 'Tú';
    var idEnviar = anuncioIdAnu !== null ? anuncioIdAnu : '';

    var params = 'id=' + idEnviar +
                 '&titulo=' + encodeURIComponent(titulo) +
                 '&desc=' + encodeURIComponent(desc) +
                 '&asig=' + encodeURIComponent(asig) +
                 '&tipo=' + tipo;

    fetch('utils/guardar-anuncio.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params
    })
    .then(function(r) { return r.text(); })
    .then(function(respuesta) {
        if (anuncioIdAnu === null) {
            anuncios.unshift({
                id: parseInt(respuesta),
                propio: true,
                autor: autorTexto,
                asig: asig,
                tiempo: 'Ahora',
                titulo: titulo,
                desc: desc,
                tipo: tipo
            });
        } else {
            var anuncio = anuncios.find(function(a) { return a.id === anuncioIdAnu; });
            if (anuncio) {
                anuncio.titulo = titulo;
                anuncio.desc = desc;
                anuncio.asig = asig;
                anuncio.tipo = tipo;
                anuncio.autor = autorTexto;
            }
        }
        cerrarModalAnu();
        renderListaAnu();
    });
}

function borrarAnuncioAnu() {
    if (anuncioIdAnu === null) return;
    if (!confirm('¿Seguro que quieres eliminar este anuncio?')) return;

    var idBorrar = anuncioIdAnu;

    fetch('utils/borrar-anuncio.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + idBorrar
    })
    .then(function() {
        anuncios = anuncios.filter(function(a) { return a.id !== idBorrar; });
        cerrarModalAnu();
        renderListaAnu();
    });
}

document.getElementById('btnNuevoAnuncio').addEventListener('click', abrirNuevoAnu);
document.getElementById('modalCerrarAnu').addEventListener('click', cerrarModalAnu);
document.getElementById('btnCancelarAnu').addEventListener('click', cerrarModalAnu);
btnGuardarAnu.addEventListener('click', guardarAnu);
btnBorrarAnu.addEventListener('click', borrarAnuncioAnu);

modalFondoAnu.addEventListener('click', function(e) {
    if (e.target === modalFondoAnu) cerrarModalAnu();
});

// se configuran los botones de filtro
var botonesFiltroAnu = document.querySelectorAll('.filtro');
botonesFiltroAnu.forEach(function(btn) {
    btn.addEventListener('click', function() {
        botonesFiltroAnu.forEach(function(b) {
            b.classList.remove('activo');
        });
        btn.classList.add('activo');
        filtroActivoAnu = btn.getAttribute('data-filtro');
        renderListaAnu();
    });
});

// se realiza el arranque inicial
renderListaAnu();

window.abrirNuevoAnuncioModal = abrirNuevoAnu;