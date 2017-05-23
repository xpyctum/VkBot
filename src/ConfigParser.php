<?php

class ConfigParser{

    private $config = [];

    public function __construct($path = "config.json"){
        $this->loadConfig($path);
        $this->checkConfig();
    }

    private function loadConfig($path){
        $this->config = json_decode(file_get_contents($path),true);
    }

    private function checkConfig(){
        if(!isset($this->config['token_key'])){
            throw new VkException('Токен не найден', 10001);
        }

        if(!isset($this->config['app_id'])){
            throw new VkException('APP ID не найден', 10002);
        }

        if(!isset($this->config['security_key'])){
            throw new VkException('Защищённый ключ не найден', 10003);
        }

        if(!isset($this->config['scopes'])){
            throw new VkException('Разрешения не найдены', 10004);
        }

        if(!isset($this->config['api_version'])){
            throw new VkException('Версия API не найдена', 10005);
        }

        if(!isset($this->config['timeout'])){
            throw new VkException('Timeout не найден', 10006);
        }
    }

    public function getToken() : string {
        return $this->config['token_key'];
    }

    public function getAppId() : int {
        return $this->config['app_id'];
    }

    public function getSecurityKey() : string {
        return $this->config['security_key'];
    }

    public function getScopes() : array {
        return $this->config['scopes'];
    }

    public function getApiVerion() : double {
        return $this->config['api_version'];
    }
}