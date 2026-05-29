<main class="cal-main">
    <div class="main-cabecera">
        <h2>Calendario</h2>
    </div>

    <div class="cal-layout">
        <div class="cal-bloque-grande">
            <div class="cal-nav">
                <button class="cal-btn-flecha">&#8249;</button>
                <h3>Mayo 2026</h3>
                <button class="cal-btn-flecha">&#8250;</button>
            </div>

            <table class="cal-tabla">
                <thead>
                    <tr>
                        <th>L</th>
                        <th>M</th>
                        <th>X</th>
                        <th>J</th>
                        <th>V</th>
                        <th>S</th>
                        <th>D</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- semana 1: dias del mes anterior + 1, 2, 3 -->
                    <tr>
                        <td class="cal-dia cal-dia-otro">27</td>
                        <td class="cal-dia cal-dia-otro">28</td>
                        <td class="cal-dia cal-dia-otro">29</td>
                        <td class="cal-dia cal-dia-otro">30</td>
                        <td class="cal-dia">1</td>
                        <td class="cal-dia">2</td>
                        <td class="cal-dia">3</td>
                    </tr>

                    <!-- semana 2 -->
                    <tr>
                        <td class="cal-dia cal-dia-evento">4<span class="cal-dia-punto"></span></td>
                        <td class="cal-dia">5</td>
                        <td class="cal-dia">6</td>
                        <td class="cal-dia">7</td>
                        <td class="cal-dia cal-dia-evento">8<span class="cal-dia-punto"></span></td>
                        <td class="cal-dia">9</td>
                        <td class="cal-dia">10</td>
                    </tr>

                    <!-- semana 3 -->
                    <tr>
                        <td class="cal-dia">11</td>
                        <td class="cal-dia">12</td>
                        <td class="cal-dia">13</td>
                        <td class="cal-dia">14</td>
                        <td class="cal-dia cal-dia-evento">15<span class="cal-dia-punto"></span></td>
                        <td class="cal-dia">16</td>
                        <td class="cal-dia">17</td>
                    </tr>

                    <!-- semana 4 -->
                    <tr>
                        <td class="cal-dia">18</td>
                        <td class="cal-dia">19</td>
                        <td class="cal-dia">20</td>
                        <td class="cal-dia">21</td>
                        <td class="cal-dia cal-dia-evento">22<span class="cal-dia-punto"></span></td>
                        <td class="cal-dia">23</td>
                        <td class="cal-dia">24</td>
                    </tr>

                    <!-- semana 5: dia 29 es hoy (viernes) -->
                    <tr>
                        <td class="cal-dia cal-dia-evento">25<span class="cal-dia-punto"></span></td>
                        <td class="cal-dia">26</td>
                        <td class="cal-dia">27</td>
                        <td class="cal-dia">28</td>
                        <td class="cal-dia cal-dia-hoy cal-dia-evento">29<span class="cal-dia-punto"></span></td>
                        <td class="cal-dia">30</td>
                        <td class="cal-dia">31</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="cal-panel-eventos">
            <div class="cal-bloque-chico">
                <p class="cal-bloque-titulo">PRÓXIMOS EVENTOS</p>

                <div class="cal-evento-card">
                    <div class="cal-evento-info">
                        <p class="cal-evento-titulo">Defensa final proyecto</p>
                        <p class="cal-evento-hora">12:00 – 14:00</p>
                    </div>
                    <span class="cal-tag cal-tag-asignatura">Asignatura</span>
                </div>

                <div class="cal-evento-card">
                    <div class="cal-evento-info">
                        <p class="cal-evento-titulo">Tutoría grupal</p>
                        <p class="cal-evento-hora">16:00 – 17:00</p>
                    </div>
                    <span class="cal-tag cal-tag-tutoria">Tutoría</span>
                </div>
            </div>

            <div class="cal-bloque-chico">
                <p class="cal-bloque-titulo">ESTE MES</p>

                <div class="cal-evento-card cal-evento-mes">
                    <div class="cal-fecha-circulo">
                        <span class="cal-fecha-dia">4</span>
                        <span class="cal-fecha-mes">MAY</span>
                    </div>
                    <div class="cal-evento-info">
                        <p class="cal-evento-titulo">Examen Matemáticas</p>
                        <p class="cal-evento-asig">Matemáticas</p>
                    </div>
                    <span class="cal-tag cal-tag-examen">Examen</span>
                </div>

                <div class="cal-evento-card cal-evento-mes">
                    <div class="cal-fecha-circulo">
                        <span class="cal-fecha-dia">8</span>
                        <span class="cal-fecha-mes">MAY</span>
                    </div>
                    <div class="cal-evento-info">
                        <p class="cal-evento-titulo">Entrega Proyecto BD</p>
                        <p class="cal-evento-asig">Bases de Datos</p>
                    </div>
                    <span class="cal-tag cal-tag-tarea">Tarea</span>
                </div>

                <div class="cal-evento-card cal-evento-mes">
                    <div class="cal-fecha-circulo">
                        <span class="cal-fecha-dia">15</span>
                        <span class="cal-fecha-mes">MAY</span>
                    </div>
                    <div class="cal-evento-info">
                        <p class="cal-evento-titulo">Tutoría Física</p>
                        <p class="cal-evento-asig">Física II</p>
                    </div>
                    <span class="cal-tag cal-tag-tutoria">Tutoría</span>
                </div>

                <div class="cal-evento-card cal-evento-mes">
                    <div class="cal-fecha-circulo">
                        <span class="cal-fecha-dia">22</span>
                        <span class="cal-fecha-mes">MAY</span>
                    </div>
                    <div class="cal-evento-info">
                        <p class="cal-evento-titulo">Reunión de Grado</p>
                        <p class="cal-evento-asig">GTI · Coordinación</p>
                    </div>
                    <span class="cal-tag cal-tag-general">General</span>
                </div>

                <div class="cal-evento-card cal-evento-mes">
                    <div class="cal-fecha-circulo">
                        <span class="cal-fecha-dia">25</span>
                        <span class="cal-fecha-mes">MAY</span>
                    </div>
                    <div class="cal-evento-info">
                        <p class="cal-evento-titulo">Defensa Práctica</p>
                        <p class="cal-evento-asig">Sistemas Interactivos</p>
                    </div>
                    <span class="cal-tag cal-tag-asignatura">Asignatura</span>
                </div>
            </div>
        </div>
    </div>
</main>
