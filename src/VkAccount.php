<?php

class VkAccount extends VkBot{

	public $notify 		 = false; //+1
	public $friends 	 = false; //+2
	public $photos 		 = false; //+4
	public $audio 		 = false; //+8
	public $video 		 = false; //+16
	public $offers 		 = false; //+32
	public $questions 	 = false; //+64
	public $pages 		 = false; //+128
	public $menu 		 = false; //+256
	public $status 		 = false; //+1024
	public $notes 		 = false; //+2048
	public $messages	 = false; //+4096
	public $wall 		 = false; //+8192
	public $ads 		 = false; //+32768
	public $offline 	 = false; //+65536
	public $docs 		 = false; //+131072
	public $groups 		 = false; //+262144
	public $notifications= false; //+524288
	public $stats 		 = false; //+1048576
	public $email 		 = false; //+4194304
	public $market 		 = false; //+134217728
	
    public function __construct(){
        parent::__construct();
		
		$perms = $this->getAppPermissions();
		if(($perms&1)>0) $this->notify = true;
		if(($perms&2)>0) $this->friends = true;
		if(($perms&4)>0) $this->photos = true;
		if(($perms&8)>0) $this->audio = true;
		if(($perms&16)>0) $this->video = true;
		if(($perms&32)>0) $this->offers = true;
		if(($perms&64)>0) $this->questions = true;
		if(($perms&128)>0) $this->pages = true;
		if(($perms&256)>0) $this->menu = true;
		if(($perms&1024)>0) $this->status = true;
		if(($perms&2048)>0) $this->notes = true;
		if(($perms&4096)>0) $this->messages = true;
		if(($perms&8192)>0) $this->wall = true;
		if(($perms&32768)>0) $this->ads = true;
		if(($perms&65536)>0) $this->offline = true;
		if(($perms&131072)>0) $this->docs = true;
		if(($perms&262144)>0) $this->groups = true;
		if(($perms&524288)>0) $this->notifications = true;
		if(($perms&1048576)>0) $this->stats = true;
		if(($perms&4194304)>0) $this->email = true;
		if(($perms&134217728)>0) $this->market = true;
    }

	/** https://vk.com/dev/account.getCounters
     * @param $filter
     * @return array
     */
	public function getCounters($filter){
		return $this->api("account.getCounters",["filter" => $filter]);
	}
	
	/** https://vk.com/dev/account.setNameInMenu
     * @param $user_id
     * @param $name
     * @return array
     */
	public function setNameInMenu($user_id,$name){
		return $this->api("account.setNameInMenu",["user_id" => $user_id,"name" => $name]);
	}
	
	/** https://vk.com/dev/account.setOnline
	 * @param $voip
	 * @return array
	 */
	public function setOnline($voip = false){
		return $this->api("account.setOnline", [ "voip" => ($voip == true ? 1 : 0) ]);
	}
	
	/** https://vk.com/dev/account.setOffline
	 * @return array
	 */
	public function setOffline(){
		return $this->api("account.setOffline");
	}
	
	//TODO
	/**	https://vk.com/dev/account.lookupContacts
	 *
	 */
	public function lookupContacts(){}
	
	//TODO
	/** https://vk.com/dev/account.registerDevice
	 *
	 */
	public function registerDevice(){}
	
	//TODO
	/** https://vk.com/dev/account.unregisterDevice
	 *
	 */
	public function unregisterDevice(){}
	
	//TODO
	/** https://vk.com/dev/account.setSilenceMode
	 *
	 */	 
	public function setSilenceMode(){}
	
	//TODO
	/** https://vk.com/dev/account.getPushSettings
	 *
	 */
	public function getPushSettings(){}
	
	//TODO https://vk.com/dev/account.setPushSettings
	/**
	 *
	 */
	public function setPushSettings(){}
	
	/** https://vk.com/dev/account.getAppPermissions
	 *
	 */
	function getAppPermissions($user_id = null){
		return $this->api("account.getAppPermissions",(!is_null($user_id) ? ["user_id" => $user_id] : [] ));
	}
	
	//TODO
	/** https://vk.com/dev/account.getActiveOffers
	 *
	 */
	public function getActiveOffers(){}
	
	//TODO
	/** https://vk.com/dev/account.banUser
	 *
	 */
	public function banUser(){}
	
	//TODO
	/** https://vk.com/dev/account.unbanUser
	 *
	 */
	public function unbanUser(){}
	
	//TODO
	/** https://vk.com/dev/account.getBanned
	 *
	 */
	public function getBanned(){}
	
	//TODO
	/** https://vk.com/dev/account.getInfo
	 *
	 */
	public function getInfo(){}
	
	//TODO
	/** https://vk.com/dev/account.setInfo
	 *
	 */
	public function setInfo(){}
	
	//TODO
	/** https://vk.com/dev/account.changePassword
	 *
	 */
	public function changePassword(){}
	
	//TODO
	/** https://vk.com/dev/account.getProfileInfo
	 *
	 */
	public function getProfileInfo(){}
	
	//TODO
	/** https://vk.com/dev/account.saveProfileInfo
	 *
	 */
	public function saveProfileInfo(){}
}