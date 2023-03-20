<?php

include('partials/header.php');

if($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['id']) && !empty($_GET['id'])) {

        $id = (int)$_GET['id'];

        /**
         * Verifica se o processo existe e se não está deletado
         */
        $instancia = (new App\Model\DB)->connection->processos()->findOne($id);
        if (!$instancia) {
            $processos = (new App\Model\DB)->connection->processos();
            \App\Helpers\Functions::alertaAviso('Registro ' . $id . ' não encontrado ou removido.');
            return \App\Helpers\Url::redirect('/');
        }

        include('partials/form-edit.php');
    }

} else {

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $data = \App\Helpers\Functions::sanitizeArray($_POST);
        $id = (int)$data['id'];

        $instancia = (new App\Model\DB)->connection->processos()->findOne($id);
        if (!$instancia) {
            \App\Helpers\Functions::alertaAviso('Registro ' . $id . ' não encontrado ou removido.');
            return \App\Helpers\Url::redirect('/');
        }

        $instancia->set($data)
            ->update();

        \App\Helpers\Functions::alertaSucesso('Registro ' . $id . ' atualizado com sucesso!');
        return \App\Helpers\Url::redirect('/edit.php?id=' . $id);
    }

    include('partials/form-edit.php');
}

include('partials/footer.php');