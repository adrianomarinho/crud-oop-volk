<?php

include('partials/header.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    $data = \App\Helpers\Functions::sanitizeArray($_GET);

    if (isset($data['id']) && !empty($data['id'])) {

        $id = (int)$data['id'];
        $instancia = (new App\Model\DB)->connection->processos()->findOne($data['id']);
        if (!$instancia) {
            \App\Helpers\Functions::alertaAviso('Registro ' . $id . ' não encontrado ou removido.');
            return \App\Helpers\Url::redirect('/');
        }

        $instancia->delete($id);

        $processos = (new App\Model\DB)->connection->processos();

        \App\Helpers\Functions::alertaSucesso('Registro ' . $id . ' removido com sucesso!');
        return \App\Helpers\Url::redirect('/');

        include('partials/main.php');

    }
}

include('partials/footer.php');