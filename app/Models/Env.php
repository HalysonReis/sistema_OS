<?php

namespace app\Models;
require '../vendor/autoload.php';

class Env{
    public function load(string $dotenv = '../.env'){
        if (file_exists($dotenv)){
            $env = parse_ini_file($dotenv);

            foreach ($env as $key => $value) {
                putenv($key. "=". $value);
                $_ENV[$key] = $value;
            }
        }else {
            throw new \RuntimeException('arquivo env nao encontrado em '. $dotenv);
        }
    }
}