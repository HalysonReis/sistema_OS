<?php

require '../vendor/autoload.php';
use app\Controller\Usuario;

$usu = new Usuario();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['cadastro'])){
        try {
            $usu->nome = $_POST['nome'];
            $usu->email = $_POST['email'];
            $usu->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $usu->tipo = $_POST['tipo'];

            $cadastro = $usu->cadastro_usuario();
            if($cadastro != FALSE){
                $response = ['status' => 201, 'msg' => 'Usuário cadastrado.', $cadastro];
                echo json_encode($response);
            }else {
                $response = ['status' => 400, 'msg' => 'Dados mal informado, usuário não cadastrado'];
                echo json_encode($response);
            }
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor '. $th];
            echo json_encode($response);
        }
    }
    else if (isset($_POST['atualizar'])){
        try {
            
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor'];
            echo json_encode($response);
        }
    }else{
        $response = ['status' => 400, 'msg' => 'Solicitação mal informada.'];
        echo json_encode($response);
    }
}