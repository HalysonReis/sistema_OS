<?php

namespace app\Controller;
require '../../vendor/autoload.php';
use app\Models\Database;
use app\Controller\cliente;

class OrdemServico {
    public int $id_os;
    public string $descricao;
    public string $status = 'Aguardando';
    public string $data_abertura;
    public string $data_prevista;
    public string $data_entrega;
    public string $valor_total;
    public string $observacoes;

    public function cadastro($id_cliente = null){

        if($id_cliente != null){
            $db = new Database('ordem_servico');
            $value = [
                'descricao' => $this->descricao,
                'status' => $this->status,
                'data_prevista' => $this->data_prevista,
                'valor_total' => $this->valor_total,
                'observacoes' => $this->observacoes,
            ];
            $insert = $db->insert($value);
            return $insert ? TRUE : FALSE;
        }else  {
            return FALSE;
        }


    }

    public function listar($id = null){
        $db = new Database('ordem_servico');

        if($id == null){
            $select = $db->select_os()->fetchAll(PDO::FECTH_ASSOC);
            return $select ? $select : FALSE;
        }else {
            $select = $db->select_cliente('id_os = '. $id)->fetchObject(PDO::FECTH_ASSOC);
            return $select ? $select : FALSE;
        }
    }

    public function atualizar($id){
        $db = new Database('ordem_servico');

        $value = [
            'descricao' => $this->descricao,
            'status' => $this->status,
            'data_prevista' => $this->data_prevista,
            'valor_total' => $this->valor_total,
            'observacoes' => $this->observacoes,
        ];

        $update = $db->update('id_os = '. $id, $value);
        return $update ? TRUE : FALSE;

    }

    public function mudar_status($status){
        $db = new Database('ordem_servico');

        $status = $db->update_status($status);
        return $status ? TRUE : FALSE;
    }
}