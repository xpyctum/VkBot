<?php

class VkMessages extends VkBot{

    public function __construct($token){
        parent::__construct($token);
    }
    //TODO this
    public function getUnreadMessages(){}

    public function getMessagesByDialogID($id){}

    public function getMsgsByDID($id){$this->getMessagesByDialogID($id);}
}