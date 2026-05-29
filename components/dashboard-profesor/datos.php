<?php
// se obtienen las asignaturas del profesor
$stmt_asig = mysqli_prepare($conexion, "SELECT ID_asignatura FROM Profesor_Asignatura WHERE ID_profesor = ?");
mysqli_stmt_bind_param($stmt_asig, "i", $id_profesor);
mysqli_stmt_execute($stmt_asig);
$res_asig = mysqli_stmt_get_result($stmt_asig);
$asignaturas_ids = [];
while ($row = mysqli_fetch_row($res_asig)) {
    $asignaturas_ids[] = (int)$row[0];
}

// se obtienen los anuncios
$res_an = mysqli_query($conexion, "SELECT * FROM Anuncio ORDER BY Fecha_publicacion DESC");
$anuncios_raw = mysqli_fetch_all($res_an, MYSQLI_ASSOC);

$anuncios_js = [];
foreach ($anuncios_raw as $an) {
    $propio = ($an['ID_autor'] == $id_profesor);

    if ($propio) {
        $autor = 'Tú';
    } else {
        $stmt_aut = mysqli_prepare($conexion, "SELECT Nombre, Apellido, Rol FROM Usuario WHERE ID = ?");
        mysqli_stmt_bind_param($stmt_aut, "i", $an['ID_autor']);
        mysqli_stmt_execute($stmt_aut);
        $aut = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_aut));
        if ($aut && $aut['Rol'] === 'admin') {
            $autor = 'Secretaría';
        } else {
            $autor = $aut ? $aut['Nombre'] . ' ' . $aut['Apellido'] : 'Sistema';
        }
    }

    $asig_nombre = '';
    if ($an['ID_asignatura']) {
        $stmt_as = mysqli_prepare($conexion, "SELECT Nombre FROM Asignatura WHERE ID = ?");
        mysqli_stmt_bind_param($stmt_as, "i", $an['ID_asignatura']);
        mysqli_stmt_execute($stmt_as);
        $row_as = mysqli_fetch_row(mysqli_stmt_get_result($stmt_as));
        $asig_nombre = $row_as[0];
        if ($propio) {
            $autor = 'Tú · ' . ($asig_nombre === 'Programación' ? 'Prog' : ($asig_nombre === 'Bases de Datos' ? 'BD' : 'HCI'));
        }
    }

    $anuncios_js[] = [
        'id' => (int)$an['ID'],
        'propio' => $propio,
        'autor' => $autor,
        'asig' => $asig_nombre,
        'tiempo' => 'Hace unos días',
        'titulo' => $an['Titulo'],
        'desc' => $an['Contenido'],
        'tipo' => $an['Tipo'] === 'global' ? 'general' : 'mios'
    ];
}

// se obtienen las tareas
$tareas_js = [];
foreach ($asignaturas_ids as $asig_id) {
    $stmt_as = mysqli_prepare($conexion, "SELECT Nombre FROM Asignatura WHERE ID = ?");
    mysqli_stmt_bind_param($stmt_as, "i", $asig_id);
    mysqli_stmt_execute($stmt_as);
    $row_as = mysqli_fetch_row(mysqli_stmt_get_result($stmt_as));
    $nombre_asig = $row_as[0];

    $stmt_t = mysqli_prepare($conexion, "SELECT * FROM Tarea WHERE ID_asignatura = ?");
    mysqli_stmt_bind_param($stmt_t, "i", $asig_id);
    mysqli_stmt_execute($stmt_t);
    $tareas_raw = mysqli_fetch_all(mysqli_stmt_get_result($stmt_t), MYSQLI_ASSOC);

    foreach ($tareas_raw as $t) {
        $stmt_ent = mysqli_prepare($conexion, "SELECT COUNT(*) FROM Entrega_Tarea WHERE ID_tarea = ?");
        mysqli_stmt_bind_param($stmt_ent, "i", $t['ID']);
        mysqli_stmt_execute($stmt_ent);
        $row_ent = mysqli_fetch_row(mysqli_stmt_get_result($stmt_ent));
        $entregas_cnt = (int)$row_ent[0];

        $stmt_tot = mysqli_prepare($conexion, "SELECT COUNT(*) FROM Alumno_Asignatura WHERE ID_asignatura = ?");
        mysqli_stmt_bind_param($stmt_tot, "i", $asig_id);
        mysqli_stmt_execute($stmt_tot);
        $row_tot = mysqli_fetch_row(mysqli_stmt_get_result($stmt_tot));
        $total_cnt = (int)$row_tot[0];

        $estado = strtotime($t['Fecha_limite']) < time() ? 'cerrada' : 'abierta';

        $tareas_js[] = [
            'id' => (int)$t['ID'],
            'nombre' => $t['Titulo'],
            'asig' => $nombre_asig === 'Programación' ? 'Programación' : ($nombre_asig === 'Bases de Datos' ? 'BD' : 'HCI'),
            'cierre' => substr($t['Fecha_limite'], 0, 10),
            'total' => $total_cnt,
            'entregas' => $entregas_cnt,
            'estado' => $estado,
            'desc' => $t['Descripcion']
        ];
    }
}

// se obtienen los alumnos y sus calificaciones
$calificaciones_js = [
    'prog' => [],
    'bd' => [],
    'hci' => []
];

foreach ($asignaturas_ids as $asig_id) {
    $stmt_as = mysqli_prepare($conexion, "SELECT Nombre FROM Asignatura WHERE ID = ?");
    mysqli_stmt_bind_param($stmt_as, "i", $asig_id);
    mysqli_stmt_execute($stmt_as);
    $row_as = mysqli_fetch_row(mysqli_stmt_get_result($stmt_as));
    $nombre_asig = $row_as[0];

    if (stripos($nombre_asig, 'programación') !== false) {
        $key = 'prog';
    } elseif (stripos($nombre_asig, 'bases de datos') !== false) {
        $key = 'bd';
    } else {
        $key = 'hci';
    }

    // se obtienen los examenes
    $stmt_ex = mysqli_prepare($conexion, "SELECT ID, Titulo FROM Examen WHERE ID_asignatura = ?");
    mysqli_stmt_bind_param($stmt_ex, "i", $asig_id);
    mysqli_stmt_execute($stmt_ex);
    $examenes = mysqli_fetch_all(mysqli_stmt_get_result($stmt_ex), MYSQLI_ASSOC);

    // si no hay examenes se crean
    if (empty($examenes)) {
        $titulos = ['Examen Parcial 1', 'Examen Parcial 2', 'Examen Final Ordinario'];
        foreach ($titulos as $titulo) {
            $stmt_ins = mysqli_prepare($conexion, "INSERT INTO Examen (ID_asignatura, ID_profesor, Titulo, Fecha_examen) VALUES (?, ?, ?, NOW())");
            mysqli_stmt_bind_param($stmt_ins, "iis", $asig_id, $id_profesor, $titulo);
            mysqli_stmt_execute($stmt_ins);
        }

        mysqli_stmt_execute($stmt_ex);
        $examenes = mysqli_fetch_all(mysqli_stmt_get_result($stmt_ex), MYSQLI_ASSOC);
    }

    // se obtienen los alumnos
    $stmt_al = mysqli_prepare($conexion, "SELECT ID_alumno FROM Alumno_Asignatura WHERE ID_asignatura = ?");
    mysqli_stmt_bind_param($stmt_al, "i", $asig_id);
    mysqli_stmt_execute($stmt_al);
    $res_al = mysqli_stmt_get_result($stmt_al);
    $alumnos_ids = [];
    while ($row = mysqli_fetch_row($res_al)) {
        $alumnos_ids[] = (int)$row[0];
    }

    foreach ($alumnos_ids as $al_id) {
        $stmt_u = mysqli_prepare($conexion, "SELECT ID, Nombre, Apellido, Email FROM Usuario WHERE ID = ?");
        mysqli_stmt_bind_param($stmt_u, "i", $al_id);
        mysqli_stmt_execute($stmt_u);
        $u = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_u));

        if (!$u) continue;

        $p1 = null;
        $p2 = null;
        $final = null;

        foreach ($examenes as $ex) {
            $stmt_n = mysqli_prepare($conexion, "SELECT Nota FROM Nota_Examen WHERE ID_examen = ? AND ID_alumno = ?");
            mysqli_stmt_bind_param($stmt_n, "ii", $ex['ID'], $al_id);
            mysqli_stmt_execute($stmt_n);
            $row_n = mysqli_fetch_row(mysqli_stmt_get_result($stmt_n));
            $nota = $row_n ? $row_n[0] : null;

            if (strpos(strtolower($ex['Titulo']), 'parcial 1') !== false) {
                $p1 = $nota;
            } elseif (strpos(strtolower($ex['Titulo']), 'parcial 2') !== false) {
                $p2 = $nota;
            } elseif (strpos(strtolower($ex['Titulo']), 'final') !== false) {
                $final = $nota;
            }
        }

        $calificaciones_js[$key][] = [
            'id' => (int)$u['ID'],
            'nombre' => $u['Nombre'] . ' ' . $u['Apellido'],
            'email' => $u['Email'],
            'p1' => $p1 !== null ? (float)$p1 : null,
            'p2' => $p2 !== null ? (float)$p2 : null,
            'final' => $final !== null ? (float)$final : null
        ];
    }
}
