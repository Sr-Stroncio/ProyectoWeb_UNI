// los anuncios llegan inyectados desde dashboard-profesor.php

let filtroActivoAnu = 'todos';
let anuncioIdAnu = null;

const listaAnunciosAnu = document.getElementById('listaAnuncios');
const modalFondoAnu = document.getElementById('modalFondoAnu');
const modalTituloAnu = document.getElementById('modalTituloAnu');
const inputTituloAnu = document.getElementById('inputTituloAnu');
const inputDescAnu = document.getElementById('inputDescAnu');
const inputAsigAnu = document.getElementById('inputAsigAnu');
const inputTipoAnu = document.getElementById('inputTipoAnu');
const btnBorrarAnu = document.getElementById('btnBorrarAnuncioAnu');
const btnGuardarAnu = document.getElementById('btnGuardarAnu');

// se pinta la lista de anuncios
function renderListaAnu() {
    listaAnunciosAnu.innerHTML = '';

    for (let i = 0; i < anuncios.length; i++) {
        const anuncio = anuncios[i];
        if (filtroActivoAnu !== 'todos' && anuncio.tipo !== filtroActivoAnu) continue;

        const tagClase = anuncio.tipo === 'mios' ? 'tag-asignatura' : 'tag-general';
        const tagTexto = anuncio.tipo === 'mios' ? 'Asignatura' : 'General';

        let btnEditar = '';
        if (anuncio.propio) {
            btnEditar = '<button class="btn-editar-anuncio"><img src="assets/iconos/pencil.svg" alt="editar"></button>';
        }

        const card = document.createElement('div');
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
    }
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
    // se busca el anuncio
    let anuncio = null;
    for (let i = 0; i < anuncios.length; i++) {
        if (anuncios[i].id === id) {
            anuncio = anuncios[i];
            break;
        }
    }
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
    let titulo = inputTituloAnu.value.trim();
    if (!titulo) {
        alert('El título no puede estar vacío.');
        return;
    }

    let asig = inputAsigAnu.value;
    let tipo = inputTipoAnu.value;
    let desc = inputDescAnu.value.trim();
    const autorTexto = tipo === 'mios' ? 'Tú · ' + asig : 'Tú';
    const idEnviar = anuncioIdAnu !== null ? anuncioIdAnu : '';

    const params = 'id=' + idEnviar +
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
            let anuncio = null;
            for (let i = 0; i < anuncios.length; i++) {
                if (anuncios[i].id === anuncioIdAnu) {
                    anuncio = anuncios[i];
                    break;
                }
            }
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

    const idBorrar = anuncioIdAnu;

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
const botonesFiltroAnu = document.querySelectorAll('.filtro');
for (let i = 0; i < botonesFiltroAnu.length; i++) {
    botonesFiltroAnu[i].addEventListener('click', function() {
        for (let j = 0; j < botonesFiltroAnu.length; j++) {
            botonesFiltroAnu[j].classList.remove('activo');
        }
        this.classList.add('activo');
        filtroActivoAnu = this.getAttribute('data-filtro');
        renderListaAnu();
    });
}

// se realiza el arranque inicial
renderListaAnu();

window.abrirNuevoAnuncioModal = abrirNuevoAnu;