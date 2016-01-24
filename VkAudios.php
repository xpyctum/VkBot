<?php

class VkAudios extends VkBot{

    public function __construct($token){
        parent::__construct($token);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getNameGenreById($id){
        $genres = [
            1 => "Rock", 2 => "Pop", 3 => "Rap & Hip-Hop", 4 => "Easy Listening", 5 => "Dance & House", 6 => "Instrumental", 7 => "Metal", 21 => "Alternative", 8 => "Dubstep", 9 => "Jazz & Blues", 10 => "Drum & Bass", 11 => "Trance", 12 => "Chanson", 13 => "Ethnic", 14 => "Acoustic & Vocal", 15 => "Reggae", 16 => "Classical", 17 => "Indie Pop", 19 => "Speech", 22 => "Electropop & Disco", 18 => "Other"
        ];
        if(isset($genres[$id])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return array
     */
    public function getGenres(){
        return $genres = [
            1 => "Rock", 2 => "Pop", 3 => "Rap & Hip-Hop", 4 => "Easy Listening", 5 => "Dance & House", 6 => "Instrumental", 7 => "Metal", 21 => "Alternative", 8 => "Dubstep", 9 => "Jazz & Blues", 10 => "Drum & Bass", 11 => "Trance", 12 => "Chanson", 13 => "Ethnic", 14 => "Acoustic & Vocal", 15 => "Reggae", 16 => "Classical", 17 => "Indie Pop", 19 => "Speech", 22 => "Electropop & Disco", 18 => "Other"
        ];
    }

}