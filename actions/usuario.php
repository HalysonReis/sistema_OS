<?php

require '../vendor/autoload.php';
use app\Controller\Usuario;
$usuario = new Usuario();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['cadastro'])){
        try {
            $usuario->nome = $_POST['nome'];
            $usuario->email = $_POST['email'];
            $usuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $usuario->tipo = $_POST['tipo'];

            $cadastro = $usuario->cadastro_usuario();

            if($cadastro != FALSE){
                $response = ['status' => 201, 'msg' => 'Usuário cadastrado.'];
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
            $usuario->nome = $_POST['nome'];
            $usuario->email = $_POST['email'];
            $usuario->tipo = $_POST['tipo'];

            $atualizar = $usuario->atualizar_usuario($_POST['id_usuario']);

            if($atualizar != FALSE){
                $response = ['status' => 201, 'msg' => 'Usuário atualizar.'];
                echo json_encode($response);
            }else {
                $response = ['status' => 400, 'msg' => 'Dados mal informado, usuário não atualizado'];
                echo json_encode($response);
            }
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor'];
            echo json_encode($response);
        }
    }else{
        $response = ['status' => 400, 'msg' => 'Solicitação mal informada.'];
        echo json_encode($response);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET"){
    if (isset($_GET['buscar'])){
        try {
            if (isset($_GET['id_usuario'])){
                $response = ['usuario' => $usuario->listar($_GET['id_usuario']), "status" => 200];
                echo json_encode($response);
            }else {
                $response = ['usuarios' => $usuario->listar(), "status" => 200];
                echo json_encode($response);
            }
        } catch (\Throwable $th) {
            $response = ['status' => 500, 'msg' => 'Erro no servidor '. $th];
            echo json_encode($response);
        }
    }
}