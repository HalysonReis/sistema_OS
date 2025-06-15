<?php

namespace app\Controller;
require '../vendor/autoload.php';
use app\Models\Database;

class Usuario{
    public int $id_usuario;
    public string $nome;
    public string $email;
    public string $senha;
    public int $tipo = 0;
    public int $status;
    public string $data_cadastro;

    public function cadastro_usuario(){
        $db = new Database('usuario');

        $value = [
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha,
            'tipo' => $this->tipo,
        ];

        $insert = $db->insert_last_id($value);
        return $insert ? $insert : FALSE;
    }

    public function listar($id = null){
        $db = new Database('usuario');

        if($id == null){
            $select = $db->select()->fetchAll(PDO::FECTH_ASSOC);
            return $select ? $select : FALSE;
        }else {
            $select = $db->select('id_usuario = '. $id)->fetchObject(PDO::FECTH_ASSOC);
            return $select ? $select : FALSE;
        }
    }

    public function atualizar_usuario($id){
        $db = new Database('usuario');

        $value = [
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha,
            'tipo' => $this->tipo,
        ];

        $update = $db->update('id_usuario = '. $id, $value);
        return $update ? TRUE : FALSE;
    }

    public function excluir($id){
        $db = new Database('usuario');
        
        $delete = $db->delete('id_usuario = '. $id);

        return $delete ? TRUE : FALSE;
    }
}