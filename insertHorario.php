<?php

// require_once "helpers/protectNivel.php";
require_once "library/Database.php";
require_once "library/Funcoes.php";

if (isset($_POST['local_id'])) {

    $db = new Database();

    try {
        // Conexão ao banco de dados
        $db = new Database();   

        // Obtém o intervalo de dias da configuração
        $intervalo_dias = $db->dbSelect("SELECT intervalo_dias, data_ultima_atualizacao FROM configuracoes_intervalo ORDER BY id DESC LIMIT 1", 'first');

        // Configuração do intervalo de dias e horários
        $intervaloDias = isset($intervalo_dias->intervalo_dias) ? (int)$intervalo_dias->intervalo_dias : 7;

        $horaInicio = $_POST['hora_inicio']; // Exemplo: '10:02'
        $horaFim = $_POST['hora_fim'];       // Exemplo: '11:02'
        $local_id = $_POST['local_id'];
        $statusRegistro = $_POST['statusRegistro'];
        $diaSemanaSelecionado = $_POST['dia_semana']; // Dia da semana selecionado pelo usuário

        // Data atual
        $dataAtual = new DateTime();

        // Loop para adicionar os horários dos próximos dias com base no intervalo configurado
        for ($i = 0; $i <= $intervaloDias; $i++) {
            // Calcula o dia específico
            $dia = clone $dataAtual;
            $dia->modify("+$i days");
            $diaSemana = $dia->format('N'); // Obtém o dia da semana (1=segunda, 7=domingo)

            // Verifica se o dia da semana corresponde ao selecionado pelo usuário
            if ($diaSemana == $diaSemanaSelecionado) {

                // Formata a data e as horas para inserção no banco de dados
                $horaInicioCompleta = $dia->format('Y-m-d') . ' ' . $horaInicio . ':00';
                $horaFimCompleta = $dia->format('Y-m-d') . ' ' . $horaFim . ':00';

                // Verifica se o horário já existe no banco de dados
                $horarioExistente = $db->dbSelect(
                    "SELECT COUNT(*) as total FROM horario_disponivel WHERE local_id = ? AND dia_semana = ? AND hora_inicio = ? AND hora_fim = ?",
                    'first',
                    [
                        $local_id,       // ID do local
                        $diaSemana,      // Dia da semana
                        $horaInicioCompleta, // Hora de início no formato DATETIME
                        $horaFimCompleta     // Hora de fim no formato DATETIME
                    ]
                );

                if ($horarioExistente->total == 0) {
                    // Inserir horário no banco de dados se ainda não existir
                    $result = $db->dbInsert(
                        "INSERT INTO horario_disponivel (local_id, dia_semana, hora_inicio, hora_fim, statusRegistro) VALUES (?, ?, ?, ?, ?)", 
                        [
                            $local_id,       // ID do local
                            $diaSemana,      // Dia da semana
                            $horaInicioCompleta, // Hora de início no formato DATETIME
                            $horaFimCompleta,    // Hora de fim no formato DATETIME
                            2  // Status do registro
                        ]
                    );

                    // Verifica o resultado e redireciona com a mensagem apropriada
                    if ($result) {
                        header("Location: listaHorario.php?msgSucesso=Registro inserido com sucesso.");
                    } else {
                        header("Location: listaHorario.php?msgError=Falha ao tentar inserir o registro.");
                    }
                } else {
                    // Se o horário já existe, apenas continua para o próximo
                    continue;
                }
            }
        }

        exit; // Importante para evitar continuar a execução após o redirecionamento

    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }
    
} else {
    header("Location: listaHorario.php");
    exit; // Importante para evitar continuar a execução após o redirecionamento
}
?>
