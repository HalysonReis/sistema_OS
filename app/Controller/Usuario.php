<?php

namespace app\Controller;
require '../vendor/autoload.php';
use PDO;
use app\Models\Database;

class Usuario{
    public $id_usuario;
    public $nome;
    public $email;
    public $senha;
    public $tipo;
    public $status_usu;
    public $data_cadastro;

    public function cadastro_usuario(){
        $db = new Database('usuario');

        if ($this->tipo == 4){
            $value = [
                'nome' => $this->nome,
                'email' => $this->email,
                'tipo' => $this->tipo,
            ];
        }else {
            $value = [
                'nome' => $this->nome,
                'email' => $this->email,
                'senha' => $this->senha,
                'tipo' => $this->tipo,
            ];
        }

        $insert = $db->insert_last_id($value);
        return $insert ? $insert : FALSE;
    }

    public function listar($id = null){
        $db = new Database('usuario');

        if($id == null){
            $select = $db->select('tipo != 4')->fetchAll(PDO::FETCH_ASSOC);
            return $select ? $select : FALSE;
        }else {
            $select = $db->select('id_usuario = '. $id)->fetch(PDO::FETCH_ASSOC);
            return $select ? $select : FALSE;
        }
    }

    public function atualizar_usuario($id){
        $db = new Database('usuario');

        $value = [
            'nome' => $this->nome,
            'email' => $this->email,
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

    public function filtrar_usuario($filtro){
        $db = new Database('usuario');

        $filtro = $db->filtro_usuario($filtro)->fetchAll(PDO::FETCH_ASSOC);

        return $filtro ? $filtro : FALSE;
    }
}