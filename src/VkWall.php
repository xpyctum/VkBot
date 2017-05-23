<?php

class VkWall extends VkBot{

    public function __construct(){
        parent::__construct();
    }

    /**
     * @param $owner_id
     * @param $query
     * @param int $count
     * @return array
     */
    public function search($owner_id,$query,$count = 20) : array {
        $wall = $this->api("wall.search",["owner_id" => $owner_id,"count" => $count,"query" => $query]);
        return $wall["items"];
    }


}