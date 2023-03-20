<?php include('header.php') ?>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>
                        Lista de Tarefas
                        <a href="create.php" class="btn btn-primary pull-right"></a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
<?php include('footer.php') ?>


<!doctype html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Teste - Volks</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/datatable.css" rel="stylesheet">
        <link href="assets/css/template.css" rel="stylesheet">
    </head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-danger fixed-top">
        <a class="navbar-brand" href="#">SistemaEscudo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
                aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                            </li>
                        <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                        <li class="nav-item">
                                <a class="nav-link disabled" href="#">Disabled</a>
                            </li>
                        <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http:example.com" id="dropdown01" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                <div class="dropdown-menu" aria-labelledby="dropdown01">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                            </li>
                    </ul>
            </div>
    </nav>

<main role="main" class="container">
        <div class="row">
                <div class="col-sm-12">
                        <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/">Administração</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Fila de Processos</li>
                                    </ol>
                            </nav>
                    </div>
            </div>

        <div class="row" id="rows_filter">
                <div class="col-sm-12">
                        <div class="input-group">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">Filtro:</span>
                                    </div>
                                <input type="text" class="form-control" id="username"
                                       placeholder="Informe o nome ou o código do processo" required>
                                <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
                            </div>
                    </div>
            </div>

        <div class="row mt-5">
                <div class="col-sm-12">
                        <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="rows">
                                        <thead class="text-center">
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Pessoa</th>
                                        <th>Unidade</th>
                                        <th>Status</th>
                                        <th>Data Criação</th>
                                        <th>Data Modificação</th>
                                        <th>Opções</th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                                <td>101</td>
                                                <td>Certificados em Lote</td>
                                                <td>Mauricio</td>
                                                <td>Unidade São Luis</td>
                                                <td>Processado</td>
                                                <td><?= date('Y/m/d H:i:s') ?><!--</td>-->
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default">VER</a>
                                                        <a href="#" class="btn btn-default">APAGAR</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>102</td>
                                                    <td>Certificados em Lote</td>
                                                    <td>Artemísio</td>
                                                    <td>Unidade São Luis</td>
                                                    <td>Processado</td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default">VER</a>
                                                        <a href="#" class="btn btn-default">APAGAR</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>103</td>
                                                    <td>Certificados em Lote</td>
                                                    <td>Amaro Filho</td>
                                                    <td>Unidade São Luis</td>
                                                    <td>Processado</td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default">VER</a>
                                                        <a href="#" class="btn btn-default">APAGAR</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>104</td>
                                                    <td>Certificados em Lote</td>
                                                    <td>Teresinha</td>
                                                    <td>Unidade São Luis</td>
                                                    <td>Processado</td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default">VER</a>
                                                        <a href="#" class="btn btn-default">APAGAR</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>105</td>
                                                    <td>Certificados em Lote</td>
                                                    <td>Amaro</td>
                                                    <td>Unidade São Luis</td>
                                                    <td>Processado</td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default">VER</a>
                                                        <a href="#" class="btn btn-default">APAGAR</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>106</td>
                                                    <td>Certificados em Lote</td>
                                                    <td>Adriano</td>
                                                    <td>Unidade São Luis</td>
                                                    <td>Processado</td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default">VER</a>
                                                        <a href="#" class="btn btn-default">APAGAR</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>107</td>
                                                    <td>Certificados em Lote</td>
                                                    <td>Nelma</td>
                                                    <td>Unidade São Luis</td>
                                                    <td>Processado</td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default">VER</a>
                                                        <a href="#" class="btn btn-default">APAGAR</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>108</td>
                                                    <td>Certificados em Lote</td>
                                                    <td>Raquel</td>
                                                    <td>Unidade São Luis</td>
                                                    <td>Processado</td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default">VER</a>
                                                        <a href="#" class="btn btn-default">APAGAR</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>109</td>
                                                    <td>Certificados em Lote</td>
                                                    <td>Fábio</td>
                                                    <td>Unidade São Luis</td>
                                                    <td>Processado</td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default">VER</a>
                                                        <a href="#" class="btn btn-default">APAGAR</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>110</td>
                                                    <td>Certificados em Lote</td>
                                                    <td>Wesley</td>
                                                    <td>Unidade São Luis</td>
                                                    <td>Processado</td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td><?= date('Y/m/d H:i:s') ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default">VER</a>
                                                        <a href="#" class="btn btn-default">APAGAR</a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <!--    <div class="starter-template">-->
                                <!--        <h1>Bootstrap starter template</h1>-->
                                <!--        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a-->
                                <!--            mostly barebones HTML document.</p>-->
                                <!--    </div>-->

                            </main>

                            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                                    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                                    crossorigin="anonymous"></script>
                            <script type="text/javascript"
                                    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
                            <script type="text/javascript"
                                    src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $('#rows').DataTable(
                                        {
                                            language: {
                                                // url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',

                                                emptyTable: "Nenhum registro encontrado",
                                                info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                                                infoFiltered: "(Filtrados de _MAX_ registros)",
                                                infoThousands: ".",
                                                loadingRecords: "Carregando...",
                                                zeroRecords: "Nenhum registro encontrado",
                                                search: "Pesquisar",
                                                paginate: {
                                                    next: "Próximo",
                                                    previous: "Anterior",
                                                    first: "Primeiro",
                                                    last: "Último"
                                                },
                                                aria: {
                                                    sortAscending: ": Ordenar colunas de forma ascendente",
                                                    sortDescending: ": Ordenar colunas de forma descendente"
                                                },
                                                select: {
                                                    rows: {
                                                        1: "Selecionado 1 linha",
                                                        _: "Selecionado %d linhas"
                                                    },
                                                    cells: {
                                                        1: "1 célula selecionada",
                                                        _: "%d células selecionadas"
                                                    },
                                                    columns: {
                                                        1: "1 coluna selecionada",
                                                        _: "%d colunas selecionadas"
                                                    }
                                                },
                                                buttons: {
                                                    copySuccess: {
                                                        1: "Uma linha copiada com sucesso",
                                                        _: "%d linhas copiadas com sucesso"
                                                    },
                                                    collection: "ColeçãopageLength",
                                                    colvis: "Visibilidade da Coluna",
                                                    colvisRestore: "Restaurar Visibilidade",
                                                    copy: "Copiar",
                                                    copyKeys: "Pressione ctrl ou u2318 + C para copiar os dados da tabela para a área de transferência do sistema. Para cancelar, clique nesta mensagem ou pressione Esc..",
                                                    copyTitle: "Copiar para a Área de Transferência",
                                                    csv: "CSV",
                                                    excel: "Excel",
                                                }
                                            }
                                        })
                                });
                            </script>
                            </body>
                            </html>
