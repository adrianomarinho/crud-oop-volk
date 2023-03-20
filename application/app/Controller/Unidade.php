<?php
namespace App\Controller;

use App\Model\DB;
use App\Model\Unidade as UnidadeModel;

class Unidade
{
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function create(UnidadeModel $p)
    {
        $sql = 'INSERT INTO unidades VALUES (?, ?)';

        $connect = $this->db->connection->prepare($sql);

        $connect->bindValue(1, $p->getId());
        $connect->bindValue(2, $p->getNome());

        return $connect->execute();
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM unidades';
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
        $sql = 'SELECT * FROM unidades WHERE id = ?';
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

    public function update(UnidadeModel $p)
    {
        $sql = 'UPDATE unidades SET nome = ? WHERE id = ?';

        $connect = $this->db->connection->prepare($sql);

        $connect->bindValue(3, $p->getId());
        $connect->bindValue(1, $p->getNome());

        return $connect->execute();
    }

    public function delete($codigo)
    {

        $sql = 'DELETE FROM unidades WHERE id = ?';

        $connect = $this->db->connection->prepare($sql);
        $connect->bindValue(1, $codigo);

        return $connect->execute();
    }
}