<?php

require_once(__DIR__ . "/VkException.php");
require_once(__DIR__ . "/ConfigParser.php");

class VkBot{

    const VKBOT_APP_VERSION = '1.0.2';
    const API_VERSION = '5.24';
    const METHOD_URL = 'https://api.vk.com/method/';

    private $access_token = "";
    private $scopes = [];
    private $app_id,$timeout,$connect_timeout;
	private $is_standalone = false;

    /** @var VkAccount */
    protected $account;

    /** @var VkApps */
    protected $apps;

    /** @var VkAudios */
    protected $audios;

    /** @var VkMessages */
    protected $messages;

    /** @var VkWall */
    protected $wall;

    public function __construct($config_path = "../config.json"){
        $c = new ConfigParser($config_path);
        $this->setAccessToken($c->getToken());
        $this->setAppId($c->getAppId());
        $this->setScopes($c->getScopes());
        $this->init_classes();
    }

    private function init_classes(){
		require_once(__DIR__ . "/VkAccount.php");
		$this->account = new VkAccount($this->getAccessToken(),$this);
		require_once(__DIR__ . "/VkApps.php");
		$this->apps = new VkApps($this->getAccessToken(),$this);
		
		if(!is_null($this->app_id)){
			$data = $this->apps->get($this->app_id);
			$this->is_standalone = ($data["items"][0]["type"]=="standalone");
		}
		
		if($this->account->audio){
			require_once(__DIR__ . "/VkAudios.php");
			$this->audios = new VkAudios();
		}
		if($this->account->messages){
			require_once(__DIR__ . "/VkMessages.php");
			$this->messages = new VkMessages();
		}
		if($this->account->wall){
			require_once(__DIR__ . "/VkWall.php");
			$this->wall = new VkWall();
        }
		//TODO: More Classes
    }
	
	public function start(){} //TODO

    /**
     * @return null|string
     */
    public function getAccessToken() : ?string {
        return $this->access_token;
    }

    /**
     * @param null|string $access_token
     */
    public function setAccessToken($access_token){
        $this->access_token = $access_token;
    }

    /**
     * @return array
     */
    public function getScopes() : array{
        return $this->scopes;
    }

    /**
     * @param array $scopes
     */
    public function setScopes($scopes){
        $this->scopes = $scopes;
    }

    /**
     * @param string $method - Do api, http://vk.com/dev/methods
     * @param array $vars
     * @return array
     */
    public function api($method = '', array $vars = []) : array {

        $vars['v'] = self::API_VERSION;
        $vars['access_token'] = $this->access_token;

        $params = http_build_query($vars);

        $url = $this->http_build_query($method, $params);

        return (array)$this->call($url);
    }

    /**
     * @param $method
     * @param string $params
     * @return string
     */
    private function http_build_query($method, $params = '') : string{
        return self::METHOD_URL . $method . '?' . $params;
    }

    /**
     * @param string $url
     * @return bool|mixed|string
     * @throws VkException
     */
    private function call($url = ''){
        if(function_exists('curl_init')) $json = $this->curl_post($url); else $json = file_get_contents($url);

        $json = json_decode($json, true);

        // Ошибки, которые могут возникнуть описаны тут: https://vk.com/dev/errors
        if(isset($json['error'])) {
            if ($json['error']['error_msg'] != "Captcha needed") {
                if (isset($json['error'], $json['error']['error_msg'], $json['error']['error_code'])) {
                    throw new VkException($json['error']['error_msg'], $json['error']['error_code']);
                }
            } else {
                echo "Error detected! Need captcha! Captcha img: " . $json['error']['captcha_img'];
            }
        }

        if(isset($json['response'])) return $json['response'];

        return $json;
    }

    private function curl_post($url){

        if(!function_exists('curl_init')) return false;

        $param = parse_url($url);

        if( $curl = curl_init() ) {

            curl_setopt($curl, CURLOPT_URL, $param['scheme'].'://'.$param['host'].$param['path']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $param['query']);
            curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
            $out = curl_exec($curl);

            curl_close($curl);

            return $out;
        }

        return false;
    }

    /**
     * @return VkAudios
     */
    public function getAudiosApi(){
        return $this->audios;
    }

    /**
     * @return VkMessages
     */
    public function getMessagesApi(){
        return $this->messages;
    }

    /**
     * @return VkWall
     */
    public function getWallApi(){
        return $this->wall;
    }

    /**
     * @return mixed
     */
    public function getAppId() : ?int{
        return $this->app_id;
    }

    /**
     * @param mixed $app_id
     */
    public function setAppId($app_id){
        $this->app_id = $app_id;
		if(!is_null($this->app_id)){
			$data = $this->apps->get($this->app_id);
			$this->is_standalone = ($data["items"][0]["type"]=="standalone");
		}
    }

    /**
     * @return mixed
     */
    public function getTimeout(){
        return $this->timeout;
    }

    /**
     * @param mixed $timeout
     */
    public function setTimeout($timeout){
        $this->timeout = $timeout;
    }

    /**
     * @return mixed
     */
    public function getConnectTimeout(){
        return $this->connect_timeout;
    }

    /**
     * @param mixed $connect_timeout
     */
    public function setConnectTimeout($connect_timeout){
        $this->connect_timeout = $connect_timeout;
    }


}