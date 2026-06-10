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
            if ($asig_nombre === 'Programación') {
                $autor = 'Tú · Prog';
            } elseif ($asig_nombre === 'Bases de Datos') {
                $autor = 'Tú · BD';
            } else {
                $autor = 'Tú · HCI';
            }
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

    // nombre corto de la asignatura para la tabla
    if ($nombre_asig === 'Programación') {
        $asig_corta = 'Programación';
    } elseif ($nombre_asig === 'Bases de Datos') {
        $asig_corta = 'BD';
    } else {
        $asig_corta = 'HCI';
    }

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
            'asig' => $asig_corta,
            'cierre' => substr($t['Fecha_limite'], 0, 10),
            'total' => $total_cnt,
            'entregas' => $entregas_cnt,
            'estado' => $estado,
            'desc' => $t['Descripcion'],
            'archivo' => $t['Archivo_URL'] ? $t['Archivo_URL'] : ''
        ];
    }
}

// se obtienen los recursos del profesor
$recursos_js = [];
foreach ($asignaturas_ids as $asig_id) {
    $stmt_as = mysqli_prepare($conexion, "SELECT Nombre FROM Asignatura WHERE ID = ?");
    mysqli_stmt_bind_param($stmt_as, "i", $asig_id);
    mysqli_stmt_execute($stmt_as);
    $row_as = mysqli_fetch_row(mysqli_stmt_get_result($stmt_as));
    $nombre_asig = $row_as[0];

    // nombre corto igual que en las tareas
    if ($nombre_asig === 'Programación') {
        $asig_corta = 'Programación';
    } elseif ($nombre_asig === 'Bases de Datos') {
        $asig_corta = 'BD';
    } else {
        $asig_corta = 'HCI';
    }

    $stmt_r = mysqli_prepare($conexion, "SELECT * FROM Recurso WHERE ID_asignatura = ?");
    mysqli_stmt_bind_param($stmt_r, "i", $asig_id);
    mysqli_stmt_execute($stmt_r);
    $recursos_raw = mysqli_fetch_all(mysqli_stmt_get_result($stmt_r), MYSQLI_ASSOC);

    foreach ($recursos_raw as $r) {
        $recursos_js[] = [
            'id' => (int)$r['ID'],
            'titulo' => $r['Titulo'],
            'desc' => $r['Descripcion'],
            'asig' => $asig_corta,
            'estado' => $r['Estado'],
            'url' => $r['Archivo_URL']
        ];
    }
}

// se obtienen los alumnos, los examenes y las calificaciones (dinamico)
$calificaciones_js = [
    'prog' => [],
    'bd' => [],
    'hci' => []
];

$examenes_js = [
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

    // se obtienen los examenes de la asignatura (sin auto-crear nada)
    $stmt_ex = mysqli_prepare($conexion, "SELECT ID, Titulo, Fecha_examen FROM Examen WHERE ID_asignatura = ? ORDER BY Fecha_examen");
    mysqli_stmt_bind_param($stmt_ex, "i", $asig_id);
    mysqli_stmt_execute($stmt_ex);
    $examenes = mysqli_fetch_all(mysqli_stmt_get_result($stmt_ex), MYSQLI_ASSOC);

    foreach ($examenes as $ex) {
        $examenes_js[$key][] = [
            'id' => (int)$ex['ID'],
            'titulo' => $ex['Titulo'],
            'fecha' => $ex['Fecha_examen']
        ];
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

        // se montan las notas como un diccionario id_examen => nota
        $notas = [];
        foreach ($examenes as $ex) {
            $stmt_n = mysqli_prepare($conexion, "SELECT Nota FROM Nota_Examen WHERE ID_examen = ? AND ID_alumno = ?");
            mysqli_stmt_bind_param($stmt_n, "ii", $ex['ID'], $al_id);
            mysqli_stmt_execute($stmt_n);
            $row_n = mysqli_fetch_row(mysqli_stmt_get_result($stmt_n));
            $id_ex_str = (string)$ex['ID'];
            $notas[$id_ex_str] = $row_n && $row_n[0] !== null ? (float)$row_n[0] : null;
        }

        $calificaciones_js[$key][] = [
            'id' => (int)$u['ID'],
            'nombre' => $u['Nombre'] . ' ' . $u['Apellido'],
            'email' => $u['Email'],
            'notas' => $notas
        ];
    }
}

// se montan los eventos del calendario a partir de las tareas y los examenes
$eventos_js = [];
foreach ($asignaturas_ids as $asig_id) {
    $stmt_as = mysqli_prepare($conexion, "SELECT Nombre FROM Asignatura WHERE ID = ?");
    mysqli_stmt_bind_param($stmt_as, "i", $asig_id);
    mysqli_stmt_execute($stmt_as);
    $row_as = mysqli_fetch_row(mysqli_stmt_get_result($stmt_as));
    $nombre_asig = $row_as[0];

    // cada tarea es un evento en su fecha limite
    $stmt_te = mysqli_prepare($conexion, "SELECT ID, Titulo, Fecha_limite FROM Tarea WHERE ID_asignatura = ? AND Fecha_limite IS NOT NULL");
    mysqli_stmt_bind_param($stmt_te, "i", $asig_id);
    mysqli_stmt_execute($stmt_te);
    $tareas_ev = mysqli_fetch_all(mysqli_stmt_get_result($stmt_te), MYSQLI_ASSOC);

    foreach ($tareas_ev as $te) {
        $eventos_js[] = [
            'id' => (int)$te['ID'],
            'titulo' => $te['Titulo'],
            'asig' => $nombre_asig,
            'fecha' => substr($te['Fecha_limite'], 0, 10),
            'hora' => '',
            'tipo' => 'tarea'
        ];
    }

    // cada examen es un evento en su fecha
    $stmt_exe = mysqli_prepare($conexion, "SELECT ID, Titulo, Fecha_examen FROM Examen WHERE ID_asignatura = ? AND Fecha_examen IS NOT NULL");
    mysqli_stmt_bind_param($stmt_exe, "i", $asig_id);
    mysqli_stmt_execute($stmt_exe);
    $examenes_ev = mysqli_fetch_all(mysqli_stmt_get_result($stmt_exe), MYSQLI_ASSOC);

    foreach ($examenes_ev as $exe) {
        $eventos_js[] = [
            'id' => (int)$exe['ID'],
            'titulo' => $exe['Titulo'],
            'asig' => $nombre_asig,
            'fecha' => substr($exe['Fecha_examen'], 0, 10),
            'hora' => substr($exe['Fecha_examen'], 11, 5),
            'tipo' => 'examen'
        ];
    }
}
