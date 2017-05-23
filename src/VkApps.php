<?php

class VkApps extends VkBot{

    public function __construct(){
        parent::__construct();
    }
	
	//TODO
	/**	https://vk.com/dev/apps.getCatalog
	 *
	 */
	public function getCatalog(){}
	
	
	//TODO
	/**	https://vk.com/dev/apps.get
	 * @param $ids
	 * @param $platform
	 * @param $extended
	 * @param $return_friends
	 * @param $fields
	 * @param $name_case
     * @return array
	 */
	public function get($ids,$platform=null,$extended=null,$return_friends=null,$fields=null,$name_case=null){
		$r = array();
		if(strpos($ids,",") === false){
			$r['app_id'] = $ids;
		}else{
			$r['app_ids'] = $ids;
		}
		if(!is_null($platform)) $r['platform'] = $platform;
		if(!is_null($extended)) $r['extended'] = $extended;
		if(!is_null($return_friends)) $r['return_friends'] = $return_friends;
		if(!is_null($fields)) $r['fields'] = $fields;
		if(!is_null($name_case)) $r['name_case'] = $name_case;
		return $this->api("apps.get",$r);
	}
	
	
	//TODO
	/**	https://vk.com/dev/apps.sendRequest
	 *
	 */
	public function sendRequest(){}
	
	
	//TODO
	/**	https://vk.com/dev/apps.deleteAppRequests
	 *
	 */
	public function deleteAppRequests(){}
	
	
	//TODO
	/**	https://vk.com/dev/apps.getFriendsList
	 *
	 */
	public function getFriendsList(){}
	
	
	//TODO
	/**	https://vk.com/dev/apps.getLeaderboard
	 *
	 */
	public function getLeaderboard(){}
	
	
	//TODO
	/**	https://vk.com/dev/apps.getScore
	 *
	 */
	public function getScore(){}
	
}