<?php

$pessoas = (new App\Model\DB)->connection->pessoas();
$unidades = (new App\Model\DB)->connection->unidades();
$status = (new App\Model\DB)->connection->status();

?>
<main role="main" class="container">
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Administração</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Novo Processo</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php include('message.php'); ?>

    <div class="row">
        <div class="col-sm-12">
            <form method="post" action="new.php">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" class="form-control" required placeholder="Digite seu nome...">
                </div>
                <div class="form-group">
                    <label for="pessoas">Pessoas</label>
                    <select name="pessoa_id" class="form-control" >
                        <option value="" selected>Selecione uma pessoa</option>
                        <?php foreach ($pessoas as $pessoa): ?>
                            <option value="<?= $pessoa->id; ?>"><?= $pessoa->nome; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="unidades">Unidades</label>
                    <select name="unidade_id" class="form-control" >
                        <option value="" selected>Selecione uma unidade</option>
                        <?php foreach ($unidades as $unidade):?>
                            <option value="<?=$unidade->id;?>"><?=$unidade->nome;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status_id" class="form-control" >
                        <option value="" selected>Selecione o status</option>
                        <?php foreach ($status as $stat):?>
                            <option value="<?=$stat->id;?>"><?=$stat->nome;?></option>
                        <?php endforeach;?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Gravar</button>
            </form>
        </div>
    </div>

</main>