<?php

class VkAudios extends VkBot{

	private $genres = [
        1 => "Rock", 2 => "Pop", 3 => "Rap & Hip-Hop", 4 => "Easy Listening", 5 => "Dance & House", 6 => "Instrumental", 7 => "Metal", 21 => "Alternative", 8 => "Dubstep", 9 => "Jazz & Blues", 10 => "Drum & Bass", 11 => "Trance", 12 => "Chanson", 13 => "Ethnic", 14 => "Acoustic & Vocal", 15 => "Reggae", 16 => "Classical", 17 => "Indie Pop", 19 => "Speech", 22 => "Electropop & Disco", 18 => "Other"
    ];

	public function __construct($token){
		parent::__construct($token);
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
		$r = array(
			"album_id" => $album_id,
			"audio_ids" => $audio_ids,
			"need_user" => $need_user ? "1" : "0",
			"offset" => $offset,
			"count" => $count
		);
		if(!is_null($owner_id)){ $r["owner_id"] = $owner_id; }
		return $this->api('audio.get',$r);
	}
	
	/**
     * @param string $request 	- Audio file IDs, in the following format: {owner_id}_{audio_id} (list comma-separated strings)
	 * @throws VkException
	 * @return array
	 */
	public function getAudiosById($request){
		return $this->api("audio.getById",array("audios" => $request));
	}
	
	/**
     * @param int $lyrics_id 	- Lyrics ID. 
	 * @throws VkException
	 * @return array
	 */
	public function getLyrics($lyrics_id){
		return $this->api("audio.getLyrics",array("lyrics_id" => $lyrics_id));
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
		return $this->api("audio.search",$r);
	}

}