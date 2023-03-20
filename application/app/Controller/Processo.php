<?php

namespace App\Controller;

use App\Model\DB;
use App\Model\Processo as ProcessoModel;


class Processo
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function create(ProcessoModel $p)
    {
        $sql = 'INSERT INTO processos (nome, pessoa_id, unidade_id, status_id, created_at, updated_at) VALUES (?,?,?,?,?,?)';

//        $stmt = $this->db->connection->prepare($sql);
//        $stmt->bindParam(":field1", $data['field1']);
//        $stmt->bindParam(":field2", $data['field2']);
//        $stmt->bindParam(":field3", $data['field3']);
//        return $stmt->execute();

        $connect = $this->db->connection->prepare($sql);

        $connect->bindValue(1, $p->getNome());
        $connect->bindValue(2, $p->getPessoa());
        $connect->bindValue(3, $p->getStatus());
        $connect->bindValue(4, $p->getUnidade());
        $connect->bindValue(5, date('Y-m-d H:i:s'));
        $connect->bindValue(6, date('Y-m-d H:i:s'));

        return $connect->execute();
    }

    public function getAll($where = null)
    {
        $sql = 'SELECT * FROM processos where deleted_at is null';
        $result = [];

        if ($where) {
            foreach ($where as $param => $value) {

                $sql .= ' AND id LIKE "%' . $value . '%"';
                $sql .= ' OR nome LIKE "%' . $value . '%"';
            }
        }

        $connect = $this->db->connection->prepare($sql);

        $connect->execute();

        if ($connect->rowCount() > 0) {
            $result = $connect->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($result as $key => $value) {
                $result[$key]['pessoa'] = $this->getPessoa($result[$key]['pessoa_id']);
                $result[$key]['unidade'] = $this->getUnidade($result[$key]['pessoa_id']);
                $result[$key]['status'] = $this->getStatus($result[$key]['pessoa_id']);
            }
            return $result;
        }

        return $result;
    }

    public function getOne($id, $where = null)
    {
        $sql = 'SELECT * FROM processos WHERE id = (?)';
        $result = [];

        if ($where) {
            foreach ($where as $param => $value) {
                if (is_null($value)) {
                    $sql .= ' AND ' . $param . ' is null';
                } else {
                    $sql .= ' AND ' . $param . ' = ' . $value;
                }
            }
        }

        $connect = $this->db->connection->prepare($sql);
        $connect->bindValue(1, $id);

        $connect->execute();

        if ($connect->rowCount() > 0) {
            $result = $connect->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }

        return $result;
    }

    public function getPessoa($id)
    {
        return (new \App\Controller\Pessoa($id))->getOne($id);
    }

    public function getUnidade($id)
    {
        return (new \App\Controller\Unidade($id))->getOne($id);
    }

    public function getStatus($id)
    {
        return (new \App\Controller\Status($id))->getOne($id);
    }

    public function update(ProcessoModel $p)
    {
        $sql = 'UPDATE processos SET nome = ?, pessoa_id = ?, unidade_id = ?, status_id = ?, updated_at = ?, id_queue = ? WHERE id = ?';

        $connect = $this->db->connection->prepare($sql);

        $connect->bindValue(1, $p->getNome());
        $connect->bindValue(2, $p->getPessoa());
        $connect->bindValue(3, $p->getUnidade());
        $connect->bindValue(4, $p->getStatus());
        $connect->bindValue(5, date('Y-m-d H:i:s'));
        $connect->bindValue(6, $p->getIdQueue());
        $connect->bindValue(7, $p->getId());

        return $connect->execute();
    }

    public function delete($codigo)
    {

        $sql = 'UPDATE processos SET deleted_at = ? WHERE id = ?';

        $connect = $this->db->connection->prepare($sql);

        $connect->bindValue(1, date('Y-m-d H:i:s'));
        $connect->bindValue(2, $codigo);

        return $connect->execute();
    }
}