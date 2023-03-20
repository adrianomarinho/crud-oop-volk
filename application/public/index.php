<?php

include('partials/header.php');

$processos = (new App\Model\DB)->connection->processos();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['busca']) && !empty($_POST['busca'])){

    $data = \App\Helpers\Functions::sanitizeArray($_POST);

    $busca = $data['busca'];
    $processos->whereLike('nome', '%' . $busca . '%')->_or_()->whereLike('id',  '%' . $busca . '%');

} else {

    $processos = (new App\Model\DB)->connection->processos();
}

include('partials/main.php');

include('partials/footer.php');