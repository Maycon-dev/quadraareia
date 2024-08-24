<?php

    /**
     * subTitulo
     *
     * @param string $acao 
     * @return string
     */
    function subTitulo($acao)
    {
        // Pega a ação e altera para o devido nome em português
        if ($acao == "insert") {
            return " - Inclusão";
        } elseif ($acao == "update") {
            return " - Alteração";
        } elseif ($acao == "delete") {
            return " - Exclusão";
        } elseif ($acao == "view") {
            return " - Visualização";
        }
    }

    /**
     * getNivelDescricao
     *
     * @param int $nivel 
     * @return string
     */
    function getNivelDescricao($nivel)
    {
        // muda o nome para nivel 1 = "Administrador" e 2 "Usuário"
        if ($nivel == 1) {
            return "Administrador";
        } elseif ($nivel == 2) {
            return "Usuário";
        } else {
            return "...";
        }
    }

    /**
     * getStatusDescricao
     *
     * @param int $status 
     * @return string
     */
    function getStatusDescricao($status)
    {
        // muda o statusRegistro para 1 = "Ativo" e 2 "Inativo"
        if ($status == 1) {
            return "Ativo";
        } elseif ($status == 2) {
            return "Inativo";
        } else {
            return "...";
        }
    }

        /**
     * getStatusDescricao
     *
     * @param int $status 
     * @return string
     */
    function getDiaSemana($status)
    {
        // muda o statusRegistro para 1 = "Ativo" e 2 "Inativo"
        if ($status == 1) {
            return "Domingo";
        } elseif ($status == 2) {
            return "Segunda";
        } elseif ($status == 3) {
            return "Terça";
        } elseif ($status == 4) {
            return "Quarta";
        } elseif ($status == 5) {
            return "Quinta";
        } elseif ($status == 6) {
            return "Sexta";
        } elseif ($status == 7) {
            return "Sabado";
        } else {
            return "...";
        }
    }

    function getStatusComanda($status)
    {
        // muda o statusRegistro para 1 = "Aberto" e 2 "Pago"
        if ($status == 1) {
            return "Aberto";
        } elseif ($status == 2) {
            return "Pago";
        } else {
            return "...";
        }
    }

    function situacaoMesa($situacao)
    {
        // muda o situacao para 1 = "Ativo" e 2 "Inativo"
        if ($situacao == 1) {
            return "Disponivel";
        } else {
            return "Indisponivel";
        }
    }

    /**
     * getDataTables
     *
     * @param string $table_id 
     * @return string
     */
    function dataTables($table_id)
    {
        return '
            <script src="assets/DataTables/datatables.min.js"></script>       
            <style>
                .dataTables_wrapper {
                    position: relative;
                    clear: both;
                }
                
                .dataTables_filter {
                    float: right;
                    margin-bottom: 5px;
                }
                
                .dataTables_paginate {
                    float: right;
                    margin: 0;
                }
                
                .dataTables_paginate .pagination {
                    margin: 0;
                    padding: 0;
                    list-style: none;
                    white-space: nowrap; /* Evita que a paginação quebre em várias linhas */
                }
                
                .dataTables_paginate .pagination .page-link {
                    border: none;
                    outline: none;
                    box-shadow: none;
                    margin: 0 2px; /* Espaçamento entre os botões de paginação */
                }
                
                .dataTables_paginate .pagination .page-item.disabled .page-link {
                    pointer-events: none;
                    color: #aaa;
                }
                
                .dataTables_paginate .pagination .page-item.active .page-link {
                    background-color: #007bff;
                    color: #fff;
                }
                
                .dataTables_paginate .pagination .page-link:hover {
                    background-color: #0056b3;
                    color: #fff;
                }
            </style>
    
            <script>
                $(document).ready( function() {
                    $("#' . $table_id . '").DataTable( {
                        "order": [],
                        "columnDefs": [{
                            "targets": "no-sort",
                            "orderable": false,                       
                        }],
                        language: {
                            "sEmptyTable":      "Nenhum registro encontrado",
                            "sInfo":            "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                            "sInfoEmpty":       "Mostrando 0 até 0 de 0 registros",
                            "sInfoFiltered":    "(Filtrados de _MAX_ registros)",
                            "sInfoPostFix":     "",
                            "sInfoThousands":   ".",
                            "sLengthMenu":      "_MENU_ resultados por página",
                            "sLoadingRecords":  "Carregando...",
                            "sProcessing":      "Processando...",
                            "sZeroRecords":     "Nenhum registro encontrado",
                            "sSearch":          "Pesquisar",
                            "oPaginate": {
                                "sNext":        "Próximo",
                                "sPrevious":    "Anterior",
                                "sFirst":       "Primeiro",
                                "sLast":        "Último"
                            },
                            "oAria": {
                                "sSortAscending":   ": Ordenar colunas de forma ascendente",
                                "sSortDescending":  ": Ordenar colunas de forma descendente"
                            }
                        }
                    });
                });
            </script>
        ';
    }



    /**
     * getMensagem
     *
     * @return string
     */
    function getMensagem()
    {
        // retorna a mensagem de sucesso
        if (isset($_GET['msgSucesso'])) {
            return '<div class="row">
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>' . $_GET['msgSucesso'] . '</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>';
        }

        // retorna a mensagem de erro
        if (isset($_GET['msgError'])) {
            return '<div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>' . $_GET['msgError'] . '</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>';
        }
    }

    function total_valor($quantidade, $Valor){
        $total = $quantidade * $Valor;
        return $total;
    }