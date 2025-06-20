<?php

namespace app\Controller;
require '../vendor/autoload.php';
use PDO;
use app\Models\Database;

class OrdemServico {
    public $id_os;
    public $descricao;
    public $status_os = 'Aguardando';
    public $data_abertura;
    public $data_prevista;
    public $data_entrega;
    public $valor_total;
    public $observacoes;
    public $id_cliente;

    public function cadastro(){

        if(!empty($this->id_cliente)){
            $db = new Database('ordem_servico');
            $value = [
                'descricao' => $this->descricao,
                'status_os' => $this->status_os,
                'data_prevista' => $this->data_prevista,
                'valor_total' => $this->valor_total,
                'observacoes' => $this->observacoes,
                'id_cliente' => $this->id_cliente,
            ];
            $insert = $db->insert($value);
            return $insert ? $insert : FALSE;
        }else  {
            return FALSE;
        }


    }

    public function listar($id = null){
        $db = new Database('ordem_servico');

        if($id == null){
            $select = $db->select_os()->fetchAll(PDO::FETCH_ASSOC);
            return $select ? $select : FALSE;
        }else {
            $select = $db->select_os('id_os = '. $id)->fetch(PDO::FETCH_ASSOC);
            return $select ? $select : FALSE;
        }
    }

    public function atualizar($id){
        $db = new Database('ordem_servico');

        $value = [
            'descricao' => $this->descricao,
            'data_prevista' => $this->data_prevista,
            'valor_total' => $this->valor_total,
            'observacoes' => $this->observacoes,
        ];

        $update = $db->update('id_os = '. $id, $value);
        return $update ? TRUE : FALSE;

    }

    public function mudar_status($id, $status){
        $db = new Database('ordem_servico');

        $status = $db->update_status('id_os = '. $id,$status);
        return $status ? TRUE : FALSE;
    }

    public function filtro_os($filtro){
        $db = new Database('ordem_servico');

        $buscar = $db->filtro_os($filtro)->fetch(PDO::FETCH_ASSOC);

        return $buscar;
    }
}