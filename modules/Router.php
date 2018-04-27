<?php

namespace modules;

    class Router {
        private $url;
        private $modulo = ' ';
        private $page = ' ';
        private $exploder;
        private $params;

        public function __construct(){
            $this->setUrl();
            $this->setExploder();
            $this->setModulo();
            $this->setPage();
            $this->setParams();
        }

        private function setUrl()
        {
            //$this->url = $_SERVER['PHP_SELF'];
            $REQUEST_URI = filter_input(INPUT_SERVER, 'REQUEST_URI');
            $INITE = strpos($REQUEST_URI,'?');
            if($INITE){
                $INITE --;
                $REQUEST_URI_PASTA = substr($REQUEST_URI, 1, $INITE);
                $this->url = $REQUEST_URI_PASTA;
            } else {
                $this->url = substr($REQUEST_URI, 1);
            }
        }

        private function setParams()
        {
            $REQUEST_URI = filter_input(INPUT_SERVER, 'REQUEST_URI');
            $INITE = strpos($REQUEST_URI,'?');
            if($INITE){
                $INITE++;
                $REQUEST_P = substr($REQUEST_URI, $INITE);
                $this->params = explode('&', $REQUEST_P);
            }

        }

        public function getParams()
        {
            return $this->params;
        }

        private function setExploder()
        {
            $this->exploder = explode('/', $this->url);
        }

        private function setModulo()
        {
            if(isset($this->exploder[1])){
                $this->modulo = $this->exploder[1];
            }
        }

        public function getModulo()
        {
            return $this->modulo;
        }

        private function setPage()
        {
            if(isset($this->exploder[2])){
                $this->page = $this->exploder[2];
            }
        }

        public function getPage()
        {
            return $this->page;
        }
    }
?>
