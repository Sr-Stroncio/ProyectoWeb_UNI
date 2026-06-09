// los eventos llegan inyectados desde dashboard-profesor.php (tareas y examenes)

const calMesAnio = document.getElementById('calMesAnio');
const calCuerpo = document.getElementById('calCuerpo');
const calProximos = document.getElementById('calProximos');
const calEsteMes = document.getElementById('calEsteMes');

const nombresMes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
const nombresMesCorto = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];

// mes y anio que se estan mostrando ahora mismo (empieza en el mes actual)
let fechaHoy = new Date();
let mesMostrado = fechaHoy.getMonth();
let anioMostrado = fechaHoy.getFullYear();

function dosDigitos(n) {
    if (n < 10) return '0' + n;
    return '' + n;
}

// devuelve la fecha de hoy en formato AAAA-MM-DD para poder comparar
function hoyTexto() {
    return fechaHoy.getFullYear() + '-' + dosDigitos(fechaHoy.getMonth() + 1) + '-' + dosDigitos(fechaHoy.getDate());
}

function etiquetaTipo(tipo) {
    if (tipo === 'examen') return 'Examen';
    return 'Tarea';
}

function claseTagTipo(tipo) {
    if (tipo === 'examen') return 'cal-tag-examen';
    return 'cal-tag-tarea';
}

function renderCalendario() {
    calMesAnio.textContent = nombresMes[mesMostrado] + ' ' + anioMostrado;

    // primer dia del mes y cuantos dias tiene (con lunes como primer dia de la semana)
    const primerDia = new Date(anioMostrado, mesMostrado, 1);
    let diaSemana = (primerDia.getDay() + 6) % 7;
    const diasDelMes = new Date(anioMostrado, mesMostrado + 1, 0).getDate();
    const diasMesAnterior = new Date(anioMostrado, mesMostrado, 0).getDate();

    // se juntan las fechas que tienen algun evento este mes
    const diasConEvento = {};
    for (let i = 0; i < eventos.length; i++) {
        diasConEvento[eventos[i].fecha] = true;
    }

    const hoy = hoyTexto();

    let html = '';
    let diaActual = 1;
    let diaSiguiente = 1;

    // se pintan 6 semanas como mucho para que entre cualquier mes
    for (let semana = 0; semana < 6; semana++) {
        let fila = '<tr>';

        for (let col = 0; col < 7; col++) {
            const celda = semana * 7 + col;

            if (celda < diaSemana) {
                // dias del mes anterior que rellenan el principio
                const num = diasMesAnterior - diaSemana + celda + 1;
                fila += '<td class="cal-dia cal-dia-otro">' + num + '</td>';
            } else if (diaActual > diasDelMes) {
                // dias del mes siguiente que rellenan el final
                fila += '<td class="cal-dia cal-dia-otro">' + diaSiguiente + '</td>';
                diaSiguiente++;
            } else {
                const fechaCelda = anioMostrado + '-' + dosDigitos(mesMostrado + 1) + '-' + dosDigitos(diaActual);
                let clases = 'cal-dia';
                let punto = '';

                if (fechaCelda === hoy) {
                    clases += ' cal-dia-hoy';
                }
                if (diasConEvento[fechaCelda]) {
                    clases += ' cal-dia-evento';
                    punto = '<span class="cal-dia-punto"></span>';
                }

                fila += '<td class="' + clases + '">' + diaActual + punto + '</td>';
                diaActual++;
            }
        }

        fila += '</tr>';
        html += fila;

        // si ya se han pintado todos los dias no hace falta otra semana
        if (diaActual > diasDelMes) {
            break;
        }
    }

    calCuerpo.innerHTML = html;
}

function renderProximos() {
    const hoy = hoyTexto();

    // se cogen los eventos de hoy en adelante y se ordenan por fecha
    const proximos = [];
    for (let i = 0; i < eventos.length; i++) {
        if (eventos[i].fecha >= hoy) {
            proximos.push(eventos[i]);
        }
    }
    // se ordenan por fecha y hora del mas cercano al mas lejano
    for (let i = 0; i < proximos.length; i++) {
        for (let j = 0; j < proximos.length - 1 - i; j++) {
            let claveA = proximos[j].fecha + proximos[j].hora;
            let claveB = proximos[j + 1].fecha + proximos[j + 1].hora;
            if (claveA > claveB) {
                let temp = proximos[j];
                proximos[j] = proximos[j + 1];
                proximos[j + 1] = temp;
            }
        }
    }

    let html = '';
    for (let i = 0; i < proximos.length && i < 4; i++) {
        const ev = proximos[i];
        const partes = ev.fecha.split('-');
        const dia = parseInt(partes[2]);
        const mesCorto = nombresMesCorto[parseInt(partes[1]) - 1];
        let cuando = dia + ' ' + mesCorto;
        if (ev.hora) {
            cuando += ' · ' + ev.hora;
        }

        html +=
            '<div class="cal-evento-card">' +
                '<div class="cal-evento-info">' +
                    '<p class="cal-evento-titulo">' + ev.titulo + '</p>' +
                    '<p class="cal-evento-hora">' + cuando + '</p>' +
                '</div>' +
                '<span class="cal-tag ' + claseTagTipo(ev.tipo) + '">' + etiquetaTipo(ev.tipo) + '</span>' +
            '</div>';
    }

    if (html === '') {
        html = '<p class="cal-vacio">No hay eventos próximos.</p>';
    }

    calProximos.innerHTML = html;
}

function renderEsteMes() {
    const prefijo = anioMostrado + '-' + dosDigitos(mesMostrado + 1);

    // se cogen los eventos cuyo mes y anio coinciden con el que se muestra
    const delMes = [];
    for (let i = 0; i < eventos.length; i++) {
        if (eventos[i].fecha.indexOf(prefijo) === 0) {
            delMes.push(eventos[i]);
        }
    }
    // se ordenan por fecha de menor a mayor
    for (let i = 0; i < delMes.length; i++) {
        for (let j = 0; j < delMes.length - 1 - i; j++) {
            if (delMes[j].fecha > delMes[j + 1].fecha) {
                let temp = delMes[j];
                delMes[j] = delMes[j + 1];
                delMes[j + 1] = temp;
            }
        }
    }

    let html = '';
    for (let i = 0; i < delMes.length; i++) {
        const ev = delMes[i];
        const partes = ev.fecha.split('-');
        const dia = parseInt(partes[2]);
        const mesCorto = nombresMesCorto[parseInt(partes[1]) - 1];

        html +=
            '<div class="cal-evento-card cal-evento-mes">' +
                '<div class="cal-fecha-circulo">' +
                    '<span class="cal-fecha-dia">' + dia + '</span>' +
                    '<span class="cal-fecha-mes">' + mesCorto + '</span>' +
                '</div>' +
                '<div class="cal-evento-info">' +
                    '<p class="cal-evento-titulo">' + ev.titulo + '</p>' +
                    '<p class="cal-evento-asig">' + ev.asig + '</p>' +
                '</div>' +
                '<span class="cal-tag ' + claseTagTipo(ev.tipo) + '">' + etiquetaTipo(ev.tipo) + '</span>' +
            '</div>';
    }

    if (html === '') {
        html = '<p class="cal-vacio">No hay eventos este mes.</p>';
    }

    calEsteMes.innerHTML = html;
}

function pintarTodo() {
    renderCalendario();
    renderProximos();
    renderEsteMes();
}

function mesAnterior() {
    mesMostrado--;
    if (mesMostrado < 0) {
        mesMostrado = 11;
        anioMostrado--;
    }
    renderCalendario();
    renderEsteMes();
}

function mesSiguiente() {
    mesMostrado++;
    if (mesMostrado > 11) {
        mesMostrado = 0;
        anioMostrado++;
    }
    renderCalendario();
    renderEsteMes();
}

document.getElementById('calBtnAnterior').addEventListener('click', mesAnterior);
document.getElementById('calBtnSiguiente').addEventListener('click', mesSiguiente);

// se expone para que tareas pueda refrescar el calendario al guardar
window.refrescarCalendario = pintarTodo;

pintarTodo();
