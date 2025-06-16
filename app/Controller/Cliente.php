<?php

namespace app\Controller;
require '../vendor/autoload.php';
use PDO;
use app\Models\Database;
use app\Controller\Usuario;

class Cliente extends Usuario{
    public $id_cliente;
    public $endereco;
    public $telefone;

    public function cadastro_cliente(){
        $idUsuario = $this->cadastro_usuario();

        if($idUsuario != FALSE){
            $db = new Database('cliente');
            $value = [
                'endereco' => $this->endereco,
                'telefone' => $this->telefone,
                'id_usuario' => $idUsuario
            ];
            $insert_cliente = $db->insert($value);
            return $insert_cliente ? $idUsuario : FALSE;
        }else  {
            return FALSE;
        }

    }

    public function listar($id = null){
        $db = new Database('cliente');

        if($id == null){
            $select = $db->select_cliente()->fetchAll(PDO::FETCH_ASSOC);
            return $select ? $select : FALSE;
        }else {
            $select = $db->select_cliente('id_cliente = '. $id)->fetch(PDO::FETCH_ASSOC);
            return $select ? $select : FALSE;
        }
    }

    public function atualizar($id){
        $db = new Database('cliente');
        $value1 = [
            'nome' => $this->nome,
            'email' => $this->email,
        ];

        $update_pai = $db->update_pai('id_cliente = '. $id, $value1);
        if($update_pai){
            $value2 = [
                'endereco' => $this->endereco,
                'telefone' => $this->telefone,
            ];
    
            $update = $db->update('id_cliente = '. $id, $value2);
            return $update ? TRUE : FALSE;
        }else {
            return FALSE;
        }

    }
}