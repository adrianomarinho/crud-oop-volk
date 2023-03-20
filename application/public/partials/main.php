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

    <?php if(isset($busca) && !empty($busca)):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-primary" role="alert">
                <h4 class="alert-heading">
                    Você buscou por: <?=$busca;?>
                    <a href="/index.php" class="btn-link float-right"> <i class="fa fa-times"></i> Limpar Pesquisa</a>
                </h4>
            </div>
        </div>
    </div>
    <?php endif;?>

    <?php include ('message.php');?>

    <div class="row mt-3">
        <div class="col-sm-12">
            <form method="post" action="index.php">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Filtro:</span>
                    </div>

                    <input type="hidden" name="busca">
                    <input type="text" class="form-control" name="busca"
                           placeholder="Informe o nome ou o código do processo" required>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">OK</button>
                    </div>

                </div>
            </form>
        </div>

    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <a href="/new.php" class="btn btn-success float-right">Novo Processo</a>
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
                    <?php foreach ($processos as $processo): ?>
                        <tr>
                            <td><?= $processo->id?></td>
                            <td><?= $processo->nome ?></td>
                            <td><?= $processo->pessoa ?></td>
                            <td><?= $processo->unidade ?></td>
                            <td><?= $processo->status ?></td>
                            <td><?= $processo->created_at ?></td>
                            <td><?= $processo->updated_at ?></td>
                            <td>
                                <a href="edit.php?id=<?= $processo->id ?>" class="btn btn-primary btn-sm">
                                    <i class="fa fa-search"></i>
                                </a>
                                <a href="delete.php?id=<?= $processo->id ?>" class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>