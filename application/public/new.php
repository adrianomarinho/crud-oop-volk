<?php

include('partials/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (
        empty($_POST['nome'])
        || empty($_POST['pessoa_id'])
        || empty($_POST['unidade_id'])
        || empty($_POST['status_id'])
    ) {

        \App\Helpers\Functions::alertaAviso('Você precisa preencher todos os campos.');
        return \App\Helpers\Url::redirect('/new.php');

    } else {
        $data = \App\Helpers\Functions::sanitizeArray($_POST);
        $instancia = (new App\Model\DB)->connection->processos()->insert($data);

        \App\Helpers\Functions::alertaSucesso('Registro ' . $instancia->lastInsertId() . ' incluído com sucesso.');
        return \App\Helpers\Url::redirect('/edit.php?id=' . $instancia->lastInsertId());

    }
} else {

    include('partials/form-create.php');
}

include('partials/footer.php');