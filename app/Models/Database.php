<?php

namespace app\Models;

require '../vendor/autoload.php';
use app\Models\Env;
use PDO;
use DateTime;
$env = new Env();
$env->load();

class Database {
    private string $DB_LOCAL;
    private string $DB_NAME;
    private string $DB_USER;
    private string $DB_PASS;
    public string $table;
    private $conn;

    function __construct($table = null){
        $this->table = $table;
        $this->set_conn();
        $this->conection();
    }

    function set_conn(){
        $this->DB_LOCAL = $_ENV['DB_HOST'];
        $this->DB_NAME = $_ENV['DB_NAME'];
        $this->DB_USER = $_ENV['DB_USER'];
        $this->DB_PASS = $_ENV['DB_PASS'];
    }

    private function conection(){
        try {

            $this->conn = new PDO("mysql:host=". $this->DB_LOCAL. ";dbname=". $this->DB_NAME, $this->DB_USER, $this->DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $err) {
            die('Conection Failed '. $err->getMessage());
        }
    }

    public function execute($query, $binds = []){
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($binds);
            return $stmt;
        } catch (\PDOException $err) {
            die('Conection Failed '. $err->getMessage());
            // return ['erro' => 500, 'msg' => $err->getMessage()];
        }
    }

    public function insert($value){
        $fields = array_keys($value);
        $binds = array_fill(0, count($value), '?');

        $query = 'INSERT INTO '. $this->table. "(".implode(',', $fields) .") VALUE (". implode(',', $binds). ")";

        $res = $this->execute($query, array_values($value));
        return $res ? TRUE : FALSE;
    }

    public function insert_last_id($value){
        $fields = array_keys($value);
        $binds = array_fill(0, count($value), '?');

        $query = 'INSERT INTO '. $this->table. "(".implode(',', $fields) .") VALUE (". implode(',', $binds). ")";

        $res = $this->execute($query, array_values($value));
        return $res ? $this->conn->lastInsertId() : FALSE;
    }

    public function select($where = null, $limit = null, $order = null, $fields = '*'){
        $where = strlen($where) ? " WHERE ". $where : '';
        $order = $order != null ? " ORDER BY ". $order : '';
        $limit = $limit != null ? " LIMIT ". $limit : '';

        $query = "SELECT ". $fields." from ". $this->table. ' '. $where. ' '. $order. ' '. $limit;
        
        return $this->execute($query);
    }

    public function update($where, $values){
        $fields = array_keys($values);
        $param = array_values($values);

        $query = "UPDATE ". $this->table. " SET ". implode("=?,", $fields). "=? WHERE ". $where;

        $res = $this->execute($query, $param);

        return $res ? TRUE : FALSE;
    }

    public function update_pai($where, $values){
        $fields = array_keys($values);
        $param = array_values($values);

        $query = "UPDATE usuario SET ". implode("=?,", $fields). "=? WHERE id_usuario = (SELECT id_usuario from ". $this->table. " WHERE ". $where. ")";

        $res = $this->execute($query, $param);

        return $res ? TRUE : FALSE;
    }

    public function delete($where){
        $query = "UPDATE ". $this->table. " SET status_usu = 0 WHERE ". $where;
        return $this->execute($query) ? TRUE : FALSE;
    }

    public function select_cliente($where = null, $limit = null, $order = null){
        $where = strlen($where) ? " WHERE ". $where : '';
        $order = $order != null ? " ORDER BY ". $order : '';
        $limit = $limit != null ? " LIMIT ". $limit : '';

        $query = "SELECT 
        cli.id_cliente, usu.id_usuario, usu.nome, usu.email, usu.status_usu, usu.data_cadastro, cli.endereco, cli.telefone 
        from usuario usu 
        inner join cliente cli 
        on usu.id_usuario = cli.id_usuario ". $where. ' '. $order. ' '. $limit;

        return $this->execute($query);
    }

    public function select_os($where = null, $limit = null, $order = null){
        $where = $where != null ? " WHERE ". $where : '';
        $order = $order != null ? " ORDER BY ". $order : '';
        $limit = $limit != null ? " LIMIT ". $limit : '';

        $query = "SELECT os.id_os, 
            os.descricao, 
            os.status_os, 
            os.data_abertura, 
            os.data_prevista,
            os.data_entrega, 
            os.valor_total, 
            os.observacoes, 
            cli.telefone,
            usu.nome
            from ordem_servico os 
            inner join cliente cli
            on os.id_cliente = cli.id_cliente 
            inner join usuario usu 
            on cli.id_usuario = usu.id_usuario ". $where. ' '. $order. ' '. $limit;

        return $this->execute($query);
    }

    public function update_status($where, $new_status){
        $date = new DateTime();
        if($new_status == "finalizado"){
            $query = "UPDATE ". $this->table. " SET data_entrega = '". $date->format('Y/m/d H:i:s'). "', status_os = '". $new_status. "' WHERE ". $where;
            return $this->execute($query) ? TRUE : FALSE;
        }else if ($new_status == "cancelado"){
            $query = "UPDATE ". $this->table. " SET status_os = '". $new_status. "' WHERE ". $where;
            return $this->execute($query) ? TRUE : FALSE;
        }else if ($new_status == "em andamento") {
            $query = "UPDATE ". $this->table. " SET status_os = '". $new_status. "' WHERE ". $where;
            return $this->execute($query) ? TRUE : FALSE;
        }
        else {
            return FALSE;
        }
    }

    public function filtro_usuario($filtro){
        $query = "SELECT 
        id_usuario, 
        nome, 
        email, 
        senha, 
        tipo, 
        status_usu, 
        data_cadastro 
        FROM usuario
        WHERE nome LIKE '%$filtro%' AND tipo != 4
        OR email LIKE '%$filtro%'
        AND tipo != 4";

        return $this->execute($query);
    }

    public function filtro_cliente($filtro){
        $query = "SELECT
            cli.id_cliente, usu.nome, usu.email, usu.status_usu, usu.data_cadastro, cli.endereco, cli.telefone
            FROM usuario usu
            INNER JOIN cliente cli
            ON usu.id_usuario = cli.id_usuario
            WHERE usu.nome LIKE '%$filtro%'
            OR usu.email LIKE '%$filtro%'
            OR cli.endereco LIKE '%$filtro%'";

        return $this->execute($query);
    }

    public function filtro_os($filtro){
        $query = "SELECT os.id_os, 
            os.descricao, 
            os.status_os, 
            os.data_abertura, 
            os.data_prevista,
            os.data_entrega, 
            os.valor_total, 
            os.observacoes, 
            cli.telefone,
            usu.nome
            FROM ordem_servico os 
            INNER JOIN cliente cli
            ON os.id_cliente = cli.id_cliente 
            INNER JOIN usuario usu 
            ON cli.id_usuario = usu.id_usuario
            WHERE usu.nome LIKE '%$filtro%'
            OR os.id_os LIKE '%$filtro%'";

        return $this->execute($query);
    }
}