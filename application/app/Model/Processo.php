<?php

namespace App\Model;

class Processo
{
    private $id;
    private $nome;
    private $status_id;
    private $pessoa_id;
    private $unidade_id;
    private $created_at;
    private $updated_at;
    private $deleted_at;
    private $id_queue;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    public function getPessoa()
    {
        return $this->pessoa_id;
    }

    public function setPessoa($pessoa_id)
    {
        $this->pessoa_id = $pessoa_id;

        return $this;
    }

    public function getUnidade()
    {
        return $this->unidade_id;
    }

    public function setUnidade($unidade_id)
    {
        $this->unidade_id = $unidade_id;

        return $this;
    }

    public function getStatus()
    {
        return $this->status_id;
    }

    public function setStatus($status_id)
    {
        $this->status_id = $status_id;

        return $this;
    }

    public function getCreated()
    {
        return $this->created_at;
    }

    public function setCreated($created_at)
    {
        $this->created_at = date('Y-m-d H:i:s');

        return $this;
    }

    public function getUpdated()
    {
        return $this->updated_at;
    }

    public function setUpdated($updated_at)
    {
        $this->updated_at = date('Y-m-d H:i:s');

        return $this;
    }

    public function getDeleted()
    {
        return $this->deleted_at;
    }

    public function setDeleted($deleted_at)
    {
        $this->deleted_at = date('Y-m-d H:i:s');

        return $this;
    }

    public function getIdQueue()
    {
        return $this->id_queue;
    }

    public function setIdQueue($id_queue)
    {
        $this->id_queue = $id_queue;

        return $this;
    }
}