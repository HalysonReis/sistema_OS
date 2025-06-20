<?php

require '../vendor/autoload.php';
use app\Controller\OrdemServico;
$os = new OrdemServico();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['cadastro'])){
        try {
            $os->descricao = $_POST['descricao'];
            $os->data_prevista = $_POST['data_prevista'];
            $os->valor_total = $_POST['valor_total'];
            $os->observacoes = $_POST['observacoes'];
            $os->id_cliente = $_POST['id_cliente'];

            $cadastro = $os->cadastro();

            if($cadastro != FALSE){
                $response = ['status' => 201, 'msg' => 'Ordem de Serviço cadastrado.', $cadastro];
                echo json_encode($response);
            }else {
                $response = ['status' => 400, 'msg' => 'Dados mal informado, Ordem de Serviço não cadastrada'];
                echo json_encode($response);
            }
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor '. $th];
            echo json_encode($response);
        }
    }
    else if (isset($_POST['atualizar'])){
        try {
            $os->descricao = $_POST['descricao'];
            $os->data_prevista = $_POST['data_prevista'];
            $os->valor_total = $_POST['valor_total'];
            $os->observacoes = $_POST['observacoes'];

            $atualizar = $os->atualizar($_POST['id_os']);

            if($atualizar != FALSE){
                $response = ['status' => 201, 'msg' => 'Ordem de Serviço  atualizar.'];
                echo json_encode($response);
            }else {
                $response = ['status' => 400, 'msg' => 'Dados mal informado, Ordem de Serviço não atualizada'];
                echo json_encode($response);
            }
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor'];
            echo json_encode($response);
        }
    }
    else if (isset($_POST['status'])){
        try {
            $id = $_POST['id_os'];
            $status = $_POST['status'];

            $mudar_status = $os->mudar_status($id, $status);

            if ($mudar_status){
                $response = ['status' => 201, 'msg' => 'status da Ordem de Serviço atualizada.'];
                echo json_encode($response);
            }
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor'. $th];
            echo json_encode($response);
        }
    }
    else{
        $response = ['status' => 400, 'msg' => 'Solicitação mal informada.'];
        echo json_encode($response);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['buscar'])){
        try {
            if (isset($_GET['id_os'])){
                $response = ['os' => $os->listar($_GET['id_os']), "status" => 200];
                echo json_encode($response);
            }else {
                $response = ['oss' => $os->listar(), "status" => 200];
                echo json_encode($response);
            }
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor '. $th];
            echo json_encode($response);
        }
    }
    else if (isset($_GET['filtro'])){
        try {
            $response = ['os' => $os->filtro_os($_GET['filtro']), "status" => 200];
            echo json_encode($response);
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor '. $th];
            echo json_encode($response);
        }
    }
}