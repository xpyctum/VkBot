<?php

class VkWall{ //extends VkBot
	private $client = null;
	private $token = "";

    public function __construct($token,$parent=null){
        //parent::__construct($token);
		$this->token = $token;
		if(!is_null($parent)){
			$this->client = $parent;
		}else{
			$this->client = new VkBot($token,null,true);
		}
    }

    /**
     * @param $owner_id
     * @param $query
     * @param int $count
     * @return array
     */
    public function search($owner_id,$query,$count = 20){
        $wall = $this->client->api("wall.search",array("owner_id" => $owner_id,"count" => $count,"query" => $query));
        return $wall["items"];
    }


}