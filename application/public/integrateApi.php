<?php

require '../vendor/autoload.php';
include('partials/header.php');

$processos = (new App\Model\DB)->connection->processos();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {


    if (
        isset($_GET['id']) &&
        !empty($_GET['id'])
    ) {

        /**
         * Integate API - Token
         */
        $api = new \App\Controller\Api();
        $apiToken = $api->getToken();
        if (!$apiToken) {
            \App\Helpers\Functions::alertaErro('Erro ao obter token da Integração via API.');
            return \App\Helpers\Url::redirect('/');
        }

        $id = (int)$_GET['id'];

        /**
         * Verifica se o processo existe e se não está deletado
         */
        $instancia = (new App\Model\DB)->connection->processos()->findOne($id);
        if (!$instancia) {
            \App\Helpers\Functions::alertaAviso('Registro ' . $id . ' não encontrado ou removido.');
            return \App\Helpers\Url::redirect('/');
        }

        if (!is_null($instancia->id_queue)) {
            /**
             * Verifica se o registro foi gerado na api com o metodo getQueue
             */
            $getQueue = $api->getQueue($instancia->id_queue);
            if (!$getQueue) {
                \App\Helpers\Functions::alertaErro('Erro ao confirmar fila ' . $instancia->id_queue . ' na Integração via API.');
                return \App\Helpers\Url::redirect('/edit.php?id=' . $id);
            }

            $updateQueue = $api->updateQueue($instancia);
            if (!$updateQueue) {
                \App\Helpers\Functions::alertaErro('Erro ao atualizar fila ' . $instancia->id_queue . ' na Integração via API.');
                return \App\Helpers\Url::redirect('/edit.php?id=' . $id);
            }

            \App\Helpers\Functions::alertaSucesso('Fila ' . $instancia->id_queue . ' atualizada na Integração via API.');
            return \App\Helpers\Url::redirect('/edit.php?id=' . $id);


        } else {

            $newQueue = $api->newQueue($instancia);
            if (!$newQueue) {
                \App\Helpers\Functions::alertaErro('Erro ao gerar nova fila na Integração via API.');
                return \App\Helpers\Url::redirect('/edit.php?id=' . $id);
            }

            /**
             * Verifica se o registro foi gerado na api com o metodo getQueue
             */
            $getQueue = $api->getQueue($newQueue);
            if (!$getQueue) {
                \App\Helpers\Functions::alertaErro('Erro ao confirmar fila ' . $newQueue . ' na Integração via API.');
                return \App\Helpers\Url::redirect('/edit.php?id=' . $id);
            }

            /**
             * Atualiza o Processo
             */

            $instancia->set('id_queue', $newQueue)
                ->update();

            \App\Helpers\Functions::alertaSucesso('Registrado com sucesso na Integração via API.');
            return \App\Helpers\Url::redirect('/edit.php?id=' . $id);
        }

    } else {

        \App\Helpers\Functions::alertaErro('Método inválido');
        return \App\Helpers\Url::redirect('/');
    }

}

include('partials/footer.php');