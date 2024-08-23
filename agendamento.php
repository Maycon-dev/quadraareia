<?php

    require_once "helpers/Formulario.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";
    require_once "comuns/cabecalho.php";

    // Obtém dados para exemplo inicial
    $db = new Database();

    $dados = $db->dbSelect("SELECT 
        l.id AS local_id,
        l.nome_local,
        l.capacidade,
        l.descricao AS descricao_local,
        l.preco_hora,
        l.statusRegistro AS status_local,
        tl.id AS tipo_local_id,
        tl.nome AS nome_tipo_local,
        tl.descricao AS descricao_tipo_local,
        tl.statusRegistro AS status_tipo_local
    FROM 
        local l
    INNER JOIN 
        tipo_local tl ON l.tipo_local = tl.id
    WHERE 
        l.id = ?;
    ", 'first', [1]);

    $dados_tipo_local = $db->dbSelect("SELECT * FROM tipo_local WHERE statusRegistro = 1");

    $dados_horario_local = $db->dbSelect("SELECT * FROM horario_disponivel WHERE statusRegistro = 1");

?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php if (isset($_GET['msgSucesso'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?= $_GET['msgSucesso'] ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['msgError'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?= $_GET['msgError'] ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12"> <!-- Aqui, o formulário ocupa toda a largura disponível -->
                <div class="text-center mt-5 mb-4">
                    <h4 class="page-title">Marcar horário</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="<?= $_GET['acao'] ?>Agendamento.php" method="POST">
                            <div class="form-row">
                                <!-- Campo Tipo de Local -->
                                <div class="form-group col-md-6">
                                    <label for="search_tipo_local" class="form-label">Tipo de local</label>
                                    <select class="form-control" name="local_id" id="search_tipo_local" required>
                                        <option value="" <?= isset($dados->id) ? ($dados->id == "" ? "selected" : "") : "" ?>>...</option>
                                        <?php foreach ($dados_tipo_local as $tipo_local): ?>
                                            <option <?= (isset($dados->tipo_local) ? ($dados->tipo_local == $tipo_local['id'] ? 'selected' : '') : "") ?> 
                                            value="<?= $tipo_local['id'] ?>"><?= $tipo_local['nome'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                
                                <div class="form-group col-md-6">
                                    <label for="tipo_local_id" class="form-label">Local</label>
                                    <select class="form-control" name="tipo_local_id" id="tipo_local_id" required>
                                        <option value="" selected disabled>Vazio</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <!-- Campo Dia da Semana -->
                                <div class="form-group col-md-6">
                                    <label for="dia_semana" class="form-label">Dia da semana  <span class="text-danger">*</span></label>
                                    <select name="dia_semana" id="dia_semana" class="form-control" required>
                                        <option value="" <?= isset($dados->dia_semana) ? $dados->dia_semana == "" ? "selected" : "" : "" ?>>...</option>
                                        <option value="1" <?= isset($dados->dia_semana) ? $dados->dia_semana == 1 ? "selected" : "" : "" ?>>Domingo</option>
                                        <option value="2" <?= isset($dados->dia_semana) ? $dados->dia_semana == "2" ? "selected" : "" : "" ?>>Segunda</option>
                                        <option value="3" <?= isset($dados->dia_semana) ? $dados->dia_semana == 3 ? "selected" : "" : "" ?>>Terça</option>
                                        <option value="4" <?= isset($dados->dia_semana) ? $dados->dia_semana == 4 ? "selected" : "" : "" ?>>Quarta</option>
                                        <option value="5" <?= isset($dados->dia_semana) ? $dados->dia_semana == 5 ? "selected" : "" : "" ?>>Quinta</option>
                                        <option value="6" <?= isset($dados->dia_semana) ? $dados->dia_semana == 6 ? "selected" : "" : "" ?>>Sexta</option>
                                        <option value="7" <?= isset($dados->dia_semana) ? $dados->dia_semana == 7 ? "selected" : "" : "" ?>>Sábado</option>
                                    </select>
                                </div>

                                <!-- Campo Horário -->
                                <div class="form-group col-md-6">
                                    <label for="horario_id" class="form-label">Horário</label>
                                    <select class="form-control" name="horario_id" id="horario_id" required>
                                        <option value="" selected disabled>Selecione um horário</option>
                                    </select>
                                </div>
                            </div>
                        
                            <div class="form-row">
                                <!-- Campo CPF -->
                                <div class="form-group col-md-6">
                                    <label for="cpf">CPF <span class="text-danger">*</span></label>
                                    <input class="form-control" name="cpf" id="cpf" type="text" value="<?= isset($dados->cpf) ? $dados->cpf : "" ?>" required>
                                    <span id="cpf-error" class="text-danger" style="display: none;">CPF inválido!</span>
                                </div>

                                <!-- Campo Telefone -->
                                <div class="form-group col-md-6">
                                    <label for="telefone">Telefone <span class="text-danger">*</span></label>
                                    <input class="form-control" name="telefone" id="telefone" type="text" value="<?= isset($dados->telefone) ? $dados->telefone : "" ?>" required>
                                </div>
                            </div>
                            
                            <div class="container justify-content-center text-center mt-4">
                                <h4>Detalhes do Local</h4>
                                <p><strong>Nome:</strong> <span id="nome_local"></span></p>
                                <p><strong>Capacidade:</strong> <span id="capacidade"></span></p>
                                <p><strong>Descrição:</strong> <span id="descricao_local"></span></p>
                                <p><strong>Preço por Hora:</strong> <span id="preco_hora"></span></p>
                            </div>

                            <input type="hidden" name="usuario_id" value="<?= isset($dados->usuario_id) ? $dados->usuario_id : "" ?>">

                            <div class="d-flex justify-content-center text-center mt-4">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(function() {
    function resetForm() {
        // Limpa todos os campos do formulário
        $('#tipo_local_id').html('<option value="" selected disabled>Escolha um local</option>');
        $('#horario_id').html('<option value="" selected disabled>Selecione um local e dia da semana primeiro</option>');
        $('#nome_local').text('');
        $('#capacidade').text('');
        $('#descricao_local').text('');
        $('#preco_hora').text('');
        $('#valor').val('');
    }

    $('#search_tipo_local').change(function() {
        var tipoLocalId = $(this).val();

        resetForm();
        
        if (tipoLocalId) {
            $('#tipo_local_id').hide();
            $('.carregando').show();

            $.getJSON('getInfoAgendamento.php?acao=getLocaisPorTipo&tipo_local_id=' + encodeURIComponent(tipoLocalId))
            .done(function(data) {
                var options = '<option value="" selected disabled>Escolha o local</option>';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].id + '">' + data[i].nome_local + '</option>';
                    }
                } else {
                    options = '<option value="" selected disabled>Nenhum local encontrado</option>';
                }
                $('#tipo_local_id').html(options).show();
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Erro ao carregar locais:", textStatus, errorThrown);
                $('#tipo_local_id').html('<option value="" selected disabled>Erro ao carregar locais</option>').show();
            })
            .always(function() {
                $('.carregando').hide();
            });
        } else {
            resetForm();
        }
    });

    $('#dia_semana').change(function() {
        var dia_semana = $(this).val();
        var local_id = $('#tipo_local_id').val();

        if (local_id && dia_semana) {
            $.ajax({
                url: 'getInfoAgendamento.php',
                type: 'GET',
                dataType: 'json',
                data: { 
                    acao: 'getHorariosPorLocal', 
                    local_id: local_id,
                    dia_semana: dia_semana
                },
                success: function(data) {
                    var options = '<option value="" selected disabled>Selecione um horário</option>';
                    var today = new Date();
                    var diaAtual = today.getDate().toString().padStart(2, '0');
                    var mesAtual = (today.getMonth() + 1).toString().padStart(2, '0');
                    var anoAtual = today.getFullYear();

                    if (data.length > 0) {
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].id + '">' + diaAtual + '/' + mesAtual + '/' + anoAtual + ' - ' + data[i].hora_inicio + ' às ' + data[i].hora_fim + '</option>';
                        }
                    } else {
                        options = '<option value="" selected disabled>Nenhum horário disponível</option>';
                    }
                    $('#horario_id').html(options).show();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erro ao carregar horários:", textStatus, errorThrown);
                    $('#horario_id').html('<option value="" selected disabled>Erro ao carregar horários</option>');
                }
            });
        } else {
            resetForm();
        }
    });

    $('#tipo_local_id').change(function() {
        var localId = $(this).val();

        if (localId) {
            $.ajax({
                url: 'getInfoAgendamento.php',
                type: 'GET',
                dataType: 'json',
                data: { 
                    acao: 'getLocalDetalhes', 
                    local_id: localId
                },
                success: function(data) {
                    if (data) {
                        $('#nome_local').text(data.nome_local);
                        $('#capacidade').text(data.capacidade);
                        $('#descricao_local').text(data.descricao);
                        $('#preco_hora').text(data.preco_hora);
                    } else {
                        console.error("Local não encontrado");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erro ao carregar detalhes do local:", textStatus, errorThrown);
                }
            });
        } else {
            resetForm();
        }
    });

    $(document).ready(function() {
        $('#tipo_local_id').change(function() {
            var precoHora = $(this).find('option:selected').data('preco');
            $('#valor').val(precoHora);
        });
    });
});



    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, ''); // Remove tudo que não é dígito

        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
            return false; // Verifica se o CPF tem 11 dígitos ou se todos os dígitos são iguais
        }

        var soma = 0;
        var resto;

        // Verifica o primeiro dígito verificador
        for (var i = 1; i <= 9; i++) {
            soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
        }
        resto = (soma * 10) % 11;

        if (resto === 10 || resto === 11) {
            resto = 0;
        }
        if (resto !== parseInt(cpf.substring(9, 10))) {
            return false;
        }

        soma = 0;

        // Verifica o segundo dígito verificador
        for (var i = 1; i <= 10; i++) {
            soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
        }
        resto = (soma * 10) % 11;

        if (resto === 10 || resto === 11) {
            resto = 0;
        }
        if (resto !== parseInt(cpf.substring(10, 11))) {
            return false;
        }

        return true; // Se passou por todas as verificações, o CPF é válido
    }

    document.getElementById('cpf').addEventListener('blur', function() {
        var cpf = this.value;
        var cpfError = document.getElementById('cpf-error');

        if (!validarCPF(cpf)) {
            cpfError.style.display = 'block';
            this.classList.add('is-invalid'); // Adiciona classe de erro
        } else {
            cpfError.style.display = 'none';
            this.classList.remove('is-invalid'); // Remove classe de erro
        }
    });

    // Função para formatar CPF
    function formatarCPF(cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let cpf = cpfInput.value.replace(/\D/g, '');
            if (cpf.length > 11) {
                cpf = cpf.slice(0, 11);
            }

            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            cpfInput.value = cpf;
        });
    }

    // Função para formatar Telefone
    function formatarTelefone(telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let telefone = telefoneInput.value.replace(/\D/g, '');
            if (telefone.length > 11) {
                telefone = telefone.slice(0, 11);
            }

            telefone = telefone.replace(/(\d{2})(\d)/, '($1) $2');
            telefone = telefone.replace(/(\d{5})(\d{1,4})$/, '$1-$2');
            telefoneInput.value = telefone;
        });
    }

    // Chamar as funções quando a página estiver carregada
    document.addEventListener('DOMContentLoaded', function() {
        const cpfInput = document.getElementById('cpf');
        const telefoneInput = document.getElementById('telefone');

        formatarCPF(cpfInput);
        formatarTelefone(telefoneInput);
    });

</script>

<?php
    // carrega o rodapé
    require_once "comuns/rodape.php";
?>
