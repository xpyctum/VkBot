<?php

class VkAudios{ //extends VkBot
	private $client = null;
	private $token = "";
	
	private $genres = [
        1 => "Rock", 2 => "Pop", 3 => "Rap & Hip-Hop", 4 => "Easy Listening", 5 => "Dance & House", 6 => "Instrumental", 7 => "Metal", 21 => "Alternative", 8 => "Dubstep", 9 => "Jazz & Blues", 10 => "Drum & Bass", 11 => "Trance", 12 => "Chanson", 13 => "Ethnic", 14 => "Acoustic & Vocal", 15 => "Reggae", 16 => "Classical", 17 => "Indie Pop", 19 => "Speech", 22 => "Electropop & Disco", 18 => "Other"
    ];

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
     * @param $id
     * @return bool
     */
    public function getNameGenreById($id){
		if(isset($this->genres[$id])){
			return $this->genres[$id];//true;
		}else{
			return false;
		}
	}

	public function getIdGenreByName($name){
		foreach($this->getGenres() as $id => $genre_name){
			if(strtolower($genre_name) == strtolower($name)){
				return $id;
			}
		}
		return false;
	}

    /**
     * @return array
     */
    public function getGenres(){
        return $this->genres;
    }

	/**
     * @param int $owner_id 	- ID of the user or community that owns the audio file. Use a negative value to designate a community ID. (current user id is used by default)
	 * @param int $album_id 	- Audio album ID.
	 * @param string $audio_ids - IDs of the audio files to return. (list of comma-separated positive numbers)
	 * @param bool $need_user 	- true — to return information about users who uploaded audio files (default: true)
	 * @param int $offset 		- Offset needed to return a specific subset of audio files. (default: 0)
	 * @param int $count 		- Number of audio files to return. (default: 6000, max: 6000)
	 * @throws VkException
	 * @return array
	 */
	public function getAudios($owner_id = null, $album_id, $audio_ids = '', $need_user = true, $offset = 0, $count = 6000){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		$r = array(
			"album_id" => $album_id,
			"audio_ids" => $audio_ids,
			"need_user" => ($need_user ? "1" : "0"),
			"offset" => $offset,
			"count" => $count
		);
		if(!is_null($owner_id)) $r["owner_id"] = $owner_id;
		return $this->client->api('audio.get',$r);
	}
	
	/**
     * @param string $request 	- Audio file IDs, in the following format: {owner_id}_{audio_id} (list comma-separated strings)
	 * @throws VkException
	 * @return array
	 */
	public function getAudiosById($request){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		return $this->client->api("audio.getById",array("audios" => $request));
	}
	
	/**
     * @param int $lyrics_id 	- Lyrics ID. 
	 * @throws VkException
	 * @return array
	 */
	public function getLyrics($lyrics_id){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		return $this->client->api("audio.getLyrics",array("lyrics_id" => $lyrics_id));
	}
	
	/**
     * @param string $q 			- Search query string (e.g., The Beatles).
     * @param bool $auto_complete 	- true — to correct for mistakes in the search query (e.g., if you enter Beetles, the system will search for Beatles) 
     * @param bool $lyrics 			- true — to return only audio files that have associated lyrics
     * @param bool $performer_only 	- true — to search only by artist name
     * @param int $sort 			- Sort order:
	 * 									1 — by duration
	 * 									2 — by popularity
	 * 									0 — by date added
	 * @param bool $search_own 		- 
	 * @param int $offset 			- Offset needed to return a specific subset of audio files. (default: 0)
	 * @param int $count			- Number of audio files to return. (default: 30, max: 300)
	 * @throws VkException
	 * @return array
	 */
	public function search($q, $auto_complete, $lyrics, $performer_only, $sort, $search_own, $offset = 0, $count = 30){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		$r = array(
			"q" => $q,
			"auto_complete" => $auto_complete,
			"lyrics" => $lyrics,
			"performer_only" => $performer_only,
			"sort" => $sort,
			"search_own" => $search_own,
			"offset" => $offset,
			"count" => $count
		);
		return $this->client->api("audio.search",$r);
	}
	
	/**
	 * @throws VkException
	 * @return string
	 */
	public function getUploadServer(){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		$r = $this->client->api("audio.search");
		return $r['upload_url'];
	}
	
	//TODO
	/** https://vk.com/dev/audio.save
	 *
	 */
	public function save(){}
	
	/**
	 * @param int $audio_id 	- Audio file ID.
	 * @param int $owner_id 	- ID of the user or community that owns the audio file.
	 * @param int $group_id 	- Community ID, needed when adding the audio file to a community.
	 * @param int $album_id
	 * @throws VkException
	 * @return int
	 */
	public function addAudio($audio_id, $owner_id, $group_id = null, $album_id = null){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		$r = array("audio_id" => $audio_id, "owner_id" => $owner_id);
		if(!is_null($group_id)) $r['group_id'] = $group_id;
		if(!is_null($album_id)) $r['album_id'] = $album_id;
		return $this->client->api("audio.add",$r);
	}
	
	/**
	 * @param int $audio_id - Audio file ID.
	 * @param int $owner_id - ID of the user or community that owns the audio file.
	 * @throws VkException
	 * @return int
	 */
	public function deleteAudio($audio_id, $owner_id){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		return $this->client->api("audio.delete",array("audio_id" => $audio_id,"owner_id" => $owner_id));
	}
	 
	/**
	 * @param int $owner_id			 - ID of the user or community that owns the audio file.
	 * @param int $audio_id			 - Audio file ID.
	 * @param string $artist		 - Name of the artist.
	 * @param string $title			 - Title of the audio file.
	 * @param string $text			 - Text of the lyrics of the audio file.
	 * @param int/string $genre_name - Genre of the audio file. See the list of audio genres.
	 * @param bool $no_search		 - true  — audio file will not be available for search
	 *								   false — audio file will be available for search (default)
	 * @throws VkException
	 * @return int
	 */
	public function editAudio($owner_id, $audio_id, $artist = null, $title = null, $text = null, $genre_id = null, $no_search = false){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		$r = array("owner_id" => $owner_id,"audio_id" => $audio_id);
		if(!is_null($artist)) $r['artist'] = $artist;
		if(!is_null($title)) $r['title'] = $title;
		if(!is_null($text)) $r['text'] = $text;
		if($no_search){ $r['no_search'] = 1; }else{ $r['no_search'] = 0; }
		if(!is_null($genre_id)){
			if(!is_numeric($genre_id)) $genre_id = $this->getIdGenreByName($genre_id);
			if($genre_id != false) $r['genre_id'] = $genre_id;
		}
		return $this->client->api("audio.edit",$r);
	}
	
	/**
	 * @param int $audio_id	- Audio file ID.
	 * @param int $owner_id	- ID of the user or community that owns the audio file. (current user id is used by default)
	 * @param int $before	- ID of the audio file before which to place the audio file.
	 * @param int $after	- ID of the audio file after which to place the audio file.
	 * @throws VkException
	 * @return int
	 */
	public function reorderAudio($audio_id, $owner_id = null, $before = null, $after = null){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		$r = array("audio_id" => $audio_id);
		if(!is_null($owner_id)) $r['owner_id'] = $owner_id;
		if(!is_null($before)) $r['before'] = $before;
		if(!is_null($after)) $r['after'] = $after;
		return $this->client->api("audio.reorder",$r);
	}
	
	/**
	 * @param int $audio_id - Audio file ID.
	 * @param int $owner_id - ID of the user or community that owns the audio file. (current user id is used by default)
	 * @throws VkException
	 * @return array
	 */
	public function restoreAudio($audio_id, $owner_id = null){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		$r = array("audio_id" => $audio_id);
		if(!is_null($owner_id)) $r['owner_id'] = $owner_id;
		return $this->client->api("audio.restore",$r);
	}
	 
	//TODO
	/** https://vk.com/dev/audio.getAlbums
	 *
	 */
	public function getAlbums(){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
	}
	 
	 
	//TODO
	/** https://vk.com/dev/audio.addAlbum
	 *
	 */
	public function addAlbum(){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
	}
	 
	 
	//TODO
	/** https://vk.com/dev/audio.editAlbum
	 *
	 */
	public function editAlbum(){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
	}
	 
	//TODO
	/** https://vk.com/dev/audio.deleteAlbum
	 *
	 */
	public function deleteAlbum(){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
	}
	 
	//TODO
	/** https://vk.com/dev/audio.moveToAlbum
	 *
	 */
	public function moveToAlbum(){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
	}
	 
	 
	//TODO
	/** https://vk.com/dev/audio.setBroadcast
	 *
	 */
	public function setBroadcast(){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
	}
	 
	 
	//TODO
	/** https://vk.com/dev/audio.getBroadcastList
	 *
	 */
	public function getBroadcastList(){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
	}
	 
	 
	//TODO
	/** https://vk.com/dev/audio.getRecommendations
	 *
	 */
	public function getRecommendations(){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
	}
	 
	 
	//TODO
	/** https://vk.com/dev/audio.getPopular
	 *
	 */
	public function getPopular(){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
	}
	 
	 
	/** https://vk.com/dev/audio.getCount
	 * @param int $owner_id
	 * @return int
	 */
	public function getCount($owner_id){
		if(!$this->client->account->audio) throw new VkException("",7); //TODO
		return $this->client->api("audio.getCount",array("owner_id" => $owner_id));
	}
	 
}