<?php

require '../vendor/autoload.php';
use app\Controller\Cliente;
$cliente = new Cliente();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['cadastro'])){
        try {
            $cliente->nome = $_POST['nome'];
            $cliente->email = $_POST['email'];
            $cliente->tipo = 4;
            $cliente->endereco = $_POST['endereco'];
            $cliente->telefone = $_POST['telefone'];

            $cadastro = $cliente->cadastro_cliente();

            if($cadastro != FALSE){
                $response = ['status' => 201, 'msg' => 'Cliente cadastrado.', $cadastro];
                echo json_encode($response);
            }else {
                $response = ['status' => 400, 'msg' => 'Dados mal informado, cliente não cadastrado'];
                echo json_encode($response);
            }
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor '. $th];
            echo json_encode($response);
        }
    }
    else if (isset($_POST['atualizar'])){
        try {
            $cliente->nome = $_POST['nome'];
            $cliente->email = $_POST['email'];
            $cliente->tipo = 4;
            $cliente->endereco = $_POST['endereco'];
            $cliente->telefone = $_POST['telefone'];

            $atualizar = $cliente->atualizar($_POST['id_cliente']);

            if($atualizar != FALSE){
                $response = ['status' => 201, 'msg' => 'Cliente atualizar.'];
                echo json_encode($response);
            }else {
                $response = ['status' => 400, 'msg' => 'Dados mal informado, cliente não atualizado'];
                echo json_encode($response);
            }
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor'];
            echo json_encode($response);
        }
    }
    else if (isset($_POST['deletar'])){
        try {
            $id = $_POST['deletar'];

            $deletar = $cliente->deletar_cliente($id);

            if ($deletar){
                $response = ['status' => 201, 'msg' => 'Cliente deletado.'];
                echo json_encode($response);
            }else {
                $response = ['status' => 400, 'msg' => 'Cliente nao deletado.', $deletar];
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
            if (isset($_GET['id_cliente'])){
                $response = ['cliente' => $cliente->listar($_GET['id_cliente']), "status" => 200];
                echo json_encode($response);
            }else {
                $response = ['clientes' => $cliente->listar(), "status" => 200];
                echo json_encode($response);
            }
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor '. $th];
            echo json_encode($response);
        }
    }
    else if (isset($_GET['filtro'])){
        try {
            $busca = $cliente->filtrar_cliente($_GET['filtro']);
            $response = ['busca' => $busca, 'status' => 200];
            echo json_encode($response);
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor '. $th];
            echo json_encode($response);
        }
    }
}