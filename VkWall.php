<?php

class VkWall extends VkBot{

    public function __construct($token){
        parent::__construct($token);
    }

    /**
     * @param $owner_id
     * @param $query
     * @param int $count
     * @return array
     */
    public function search($owner_id,$query,$count = 30){
        $wall = $this->api("wall.search",array("owner_id" => $owner_id,"count" => $count,"query" => $query));
        return $wall["items"];
    }

}