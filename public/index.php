<?php
//abrir sessao

use core\classes\Database;
use core\classes\Functions;

session_start();
//carrega todas as classes do projeto
require_once('../vendor/autoload.php');
//rotas
require_once('../core/rotas.php');





