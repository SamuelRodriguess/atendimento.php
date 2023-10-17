<?php
class Atendimento
{
    private $id;
    private $senha;
    private $tipo;

    public function __construct()
    {
    }

    public function __construct($id, $senha, $tipo)
    {
        $this->id = $id;
        $this->senha = $senha;
        $this->tipo = $tipo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
}
