<?php
namespace App\Controller;

use App\Model\DB;
use App\Model\Status as StatusModel;

class Status
{
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function create(StatusModel $p)
    {
        $sql = 'INSERT INTO status VALUES (?, ?)';

        $connect = $this->db->connection->prepare($sql);

        $connect->bindValue(1, $p->getId());
        $connect->bindValue(2, $p->getNome());

        return $connect->execute();
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM status';
        $result = [];

        $connect = $this->db->connection->prepare($sql);

        $connect->execute();

        if ($connect->rowCount() > 0) {
            $result = $connect->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }

        return $result;
    }

    public function getOne($id)
    {
        $sql = 'SELECT * FROM status WHERE id = ?';
        $result = [];

        $connect = $this->db->connection->prepare($sql);
        $connect->bindValue(1, $id);

        $connect->execute();

        if ($connect->rowCount() > 0) {
            $result = $connect->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }

        return $result;
    }

    public function update(StatusModel $p)
    {
        $sql = 'UPDATE status SET nome = ? WHERE id = ?';

        $connect = $this->db->connection->prepare($sql);

        $connect->bindValue(3, $p->getId());
        $connect->bindValue(1, $p->getNome());

        return $connect->execute();
    }

    public function delete($codigo)
    {

        $sql = 'DELETE FROM status WHERE id = ?';

        $connect = $this->db->connection->prepare($sql);
        $connect->bindValue(1, $codigo);

        return $connect->execute();
    }
}