<?php

    require_once "library/Database.php";

    $db = new Database();

    if (isset($_GET['acao']) && $_GET['acao'] === 'getLocaisPorTipo') {
        $tipo_local_id = isset($_GET['tipo_local_id']) ? intval($_GET['tipo_local_id']) : 0;
        
        if ($tipo_local_id > 0) {
            $query = "SELECT id, nome_local FROM local WHERE tipo_local = ?";
            $locais = $db->dbSelect($query, 'all', [$tipo_local_id]);
            
            echo json_encode($locais);
        } else {
            echo json_encode([]);
        }
    }

    if (isset($_GET['acao']) && $_GET['acao'] === 'getHorariosPorLocal') {
        $local_id = isset($_GET['local_id']) ? intval($_GET['local_id']) : 0;
        $dia_semana = isset($_GET['dia_semana']) ? intval($_GET['dia_semana']) : 0;
    
        if ($local_id > 0) {
            $query = "SELECT id, dia_semana, hora_inicio, hora_fim FROM horario_disponivel WHERE local_id = ? AND statusRegistro = 1 AND dia_semana = ?";
            $horarios = $db->dbSelect($query, 'all', [$local_id, $dia_semana]);
            header('Content-Type: application/json');
            echo json_encode($horarios);
        } else {
            echo json_encode([]);
        }
    }

    if ($_GET['acao'] == 'getLocalDetalhes' && isset($_GET['local_id'])) {
        $localId = intval($_GET['local_id']);
        
        $db = new Database();
        $local = $db->dbSelect("SELECT * FROM local WHERE id = ?", 'first', [$localId]);
        
        echo json_encode($local);
        exit;
    }
    
    
?>
