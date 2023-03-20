<?php

namespace App\Controller;

class Api
{
    private $url = "https://dev.evolke.com.br/admin/gabriel/admin/api/v2/router.php";
    private $email = "volklms@evolke.com.br";
    private $senha = "volklmsdesafio";

    private $acoes = [
        1 => "Importação de unidades",
        2 => "Importação de cargos",
        3 => "Importação de setores",
        4 => "Importação de pessoas",
        5 => "Importação de cursos",
        6 => "Importação de matriculas",
        7 => "Certificados em lote",
    ];

    public function connect()
    {
        try {

            $params = array(
                'action' => 'authToken',
                'email' => $this->email,
                'senha' => $this->senha
            );

            $ApiConnection = curl_init();

            $this->url .= '?' . http_build_query($params);

            curl_setopt($ApiConnection, CURLOPT_URL, $this->url);
            curl_setopt($ApiConnection, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ApiConnection);
            curl_close($ApiConnection);

            return $response;

        } catch (\PDOException $e) {

            echo "Connection API failed: " . $e->getMessage();

        }
    }

    public function getToken()
    {
        $apiConnect = $this->connect();
        $authToken = json_decode($apiConnect, true);
        if (!isset($authToken['result']['access_token'])) {
            return false;
        }

        return $authToken['result']['access_token'];
    }

    public function newQueue($data)
    {
        $apiToken = $this->getToken();

        try {

            $ApiConnection = curl_init();
            $url = 'https://dev.evolke.com.br/admin/gabriel/admin/api/v2/router.php?' . http_build_query(
                    [
                        'action' => 'newQueue',
                        'id_pessoa' => $data->pessoa_id,
                        'id_unidade' => $data->unidade_id,
                        'status' => $data->status_id,
                        'acao_fila' => 1
                    ]

                );

            curl_setopt_array($ApiConnection, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$apiToken}",
                ),
            ));

            $response = curl_exec($ApiConnection);
            curl_close($ApiConnection);

            $response = json_decode($response, true);

            if (
                isset($response['error']) &&
                !empty($response['error'])
            ) {
                return false;
            }

            return $response['result']['id_fila'];


        } catch (\PDOException $e) {

            echo "Connection API failed: " . $e->getMessage();

        }

    }

    public function getQueue($idQueue)
    {
        $apiToken = $this->getToken();

        try {

            $ApiConnection = curl_init();
            $url = 'https://dev.evolke.com.br/admin/gabriel/admin/api/v2/router.php?' . http_build_query(
                    [
                        'action' => 'getQueue',
                        'id_fila' => $idQueue,
                    ]

                );

            curl_setopt_array($ApiConnection, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$apiToken}",
                ),
            ));

            $response = curl_exec($ApiConnection);
            curl_close($ApiConnection);

            $response = json_decode($response, true);

            if (
                isset($response['error']) &&
                !empty($response['error'])
            ) {
                return false;
            }

            return $response;


        } catch (\PDOException $e) {

            echo "Connection API failed: " . $e->getMessage();

        }

    }

    public function updateQueue($data)
    {
        $apiToken = $this->getToken();

        try {

            $ApiConnection = curl_init();
            $url = 'https://dev.evolke.com.br/admin/gabriel/admin/api/v2/router.php?' . http_build_query(
                    [
                        'action' => 'updateQueue',
                        'id_fila' => $data->id_queue,
                        'status' => $data->status_id,
                    ]

                );

            curl_setopt_array($ApiConnection, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$apiToken}",
                ),
            ));

            $response = curl_exec($ApiConnection);
            curl_close($ApiConnection);

            $response = json_decode($response, true);

            if (
                isset($response['error']) &&
                !empty($response['error'])
            ) {
                return false;
            }

            return $response['result']['info'];


        } catch (\PDOException $e) {

            echo "Connection API failed: " . $e->getMessage();

        }

    }
}
