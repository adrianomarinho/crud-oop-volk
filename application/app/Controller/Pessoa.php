<?php
namespace App\Controller;

use App\Model\DB;
use App\Model\Pessoa as PessoaModel;

class Pessoa
{
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function create(PessoaModel $p)
    {
        $sql = 'INSERT INTO pessoas VALUES (?, ?)';

        $connect = $this->db->connection->prepare($sql);

        $connect->bindValue(1, $p->getId());
        $connect->bindValue(2, $p->getNome());

        return $connect->execute();
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM pessoas';
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
        $sql = 'SELECT * FROM pessoas WHERE id = ?';
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

    public function update(PessoaModel $p)
    {

        $sql = 'UPDATE pessoas SET nome = ?, idade = ? WHERE codigo = ?';

        $connect = $this->db->connection->prepare($sql);

        $connect->bindValue(1, $p->getNome());
        $connect->bindValue(2, $p->getIdade());
        $connect->bindValue(3, $p->getCodigo());

        return $connect->execute();
    }

    public function delete($codigo)
    {

        $sql = 'DELETE FROM pessoas WHERE codigo = ?';

        $connect = $this->db->connection->prepare($sql);
        $connect->bindValue(1, $codigo);

        return $connect->execute();
    }
}