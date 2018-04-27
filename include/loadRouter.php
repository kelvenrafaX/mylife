<?php
// Import da Class Router
require_once 'modules/Router.php';

// Using Router
use modules\Router;

//Instanciando o Objeto Router
$Router = new Router();
//Recebendo o Módulo da URL
$module = $Router->getModulo();
//Recebendo a Página da URL
$page = $Router->getPage();
//Recebendo os Parâmetros da URL
$params = $Router->getParams();

?>
