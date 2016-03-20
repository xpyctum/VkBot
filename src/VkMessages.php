<?php

class VkMessages{ //extends VkBot
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

    //TODO this
    public function getUnreadMessages(){}

    public function getMessagesByDialogID($id){}

    public function getMsgsByDID($id){$this->getMessagesByDialogID($id);}

    //TODO documentation
    /**
     * @param $text
     * @param null $user_id
     * @param null $domain_name
     */
    public function sendMessageToUser($text,$user_id = null, $domain_name = null){
        $r = [];
        if (!is_null($domain_name)) $r["domain"] = $domain_name;
        if (!is_null($user_id)) $r["user_id"] = $user_id;
        $r["message"] = $text;
        $this->client->api('messages.send',$r);
    }

    /**
     * @param $chat_id
     * @param int $count
     * @return array|null
     */
    public function getHistoryMessagesFromChat($chat_id,$count = 20){
        $result = $this->client->api('messages.getHistory', array('chat_id' => $chat_id,"count" => $count,"start_message_id" => -$count));
        if(isset($result["items"])) {
            return $result["items"];
        }else{
            return null;
        }
    }

    /**
     * @param int $out
     * @param null $offset
     * @param int $count
     * @param int $time_offset
     * @param int $filters
     * @param int $preview_length
     * @return array|null
     */
    public function get($out = 0,$offset = null,$count = 20,$time_offset = 0,$filters = 0,$preview_length = 0){
        $r = [
            "out" => $out,
            "count" => $count,
            "time_offset" => $time_offset,
            "filters" => $filters,
            "preview_length" => $preview_length
        ];
        if(!is_null($offset)) $r["offset"] = $offset;
        $result = $this->client->api('messages.get',$r);
        if(isset($result["items"])){
            return $result["items"];
        }else{
            return null;
        }
    }
    
}