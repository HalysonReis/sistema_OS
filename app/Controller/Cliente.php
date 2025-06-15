<?php

namespace app\Controller;
require '../../vendor/autoload.php';
use app\Models\Database;
use app\Controller\cliente;

class cliente extends cliente{
    public int $id_cliente;
    public string $endereco;
    public string $telefone;

    public function cadastro_cliente(){
        $idUsuario = $this->cadastro_usuario();

        if($idUsuario != FALSE){
            $db = new Database('cliente');
            $value = [
                'endereco' => $this->endereco,
                'telefone' => $this->telefone,
            ];
            $insert_cliente = $db->insert($value);
            return $insert_cliente ? TRUE : FALSE;
        }else  {
            return FALSE;
        }


    }

    public function listar($id = null){
        $db = new Database('cliente');

        if($id == null){
            $select = $db->select_cliente()->fetchAll(PDO::FECTH_ASSOC);
            return $select ? $select : FALSE;
        }else {
            $select = $db->select_cliente('id_cliente = '. $id)->fetchObject(PDO::FECTH_ASSOC);
            return $select ? $select : FALSE;
        }
    }

    public function atualizar($id, $id_usuario){
        if($this->atualizar_usuario($id_usuario)){

            $db = new Database('cliente');
    
            $value = [
                'endereco' => $this->endereco,
                'telefone' => $this->telefone,
            ];
    
            $update = $db->update('id_cliente = '. $id, $value);
            return $update ? TRUE : FALSE;
        }else {
            return FALSE;
        }

    }
}