<main class="cal-main">
    <div class="main-cabecera">
        <h2>Calendario</h2>
    </div>

    <div class="cal-layout">
        <div class="cal-bloque-grande">
            <div class="cal-nav">
                <button class="cal-btn-flecha" id="calBtnAnterior">&#8249;</button>
                <h3 id="calMesAnio">Mes</h3>
                <button class="cal-btn-flecha" id="calBtnSiguiente">&#8250;</button>
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
                <tbody id="calCuerpo">
                    <!-- las semanas se rellenan desde calendario-profesor.js -->
                </tbody>
            </table>
        </div>

        <div class="cal-panel-eventos">
            <div class="cal-bloque-chico">
                <p class="cal-bloque-titulo">PRÓXIMOS EVENTOS</p>
                <div id="calProximos">
                    <!-- proximos eventos rellenados desde calendario-profesor.js -->
                </div>
            </div>

            <div class="cal-bloque-chico">
                <p class="cal-bloque-titulo">ESTE MES</p>
                <div id="calEsteMes">
                    <!-- eventos del mes rellenados desde calendario-profesor.js -->
                </div>
            </div>
        </div>
    </div>
</main>
