<?php

/**
 * 
 * @title : Follow.php
 * 
 * @brief : Follow database class
 * 
 */
require_once __DIR__.'/User.php';
require_once __DIR__.'/../../Core/Model.php';

class Follow extends Model {

    protected $userFollow;
    protected $userFollowing;
    protected $date;


    function __construct($userFollow, $userFollowing, $date) {
        $this->userFollow = $userFollow;
        $this->userFollowing = $userFollowing;
        $this->date = $date;

    } // function __construct($userFollow, $userFollowing, $date)

    public function getUserFollow(){
		return $this->userFollow;
	}

	public function setUserFollow($userFollow){
		$this->userFollow = $userFollow;
	}

	public function getUserFollowing(){
		return $this->userFollowing;
	}

	public function setUserFollowing($userFollowing){
		$this->userFollowing = $userFollowing;
	}

	public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date = $date;
	}

} // class Follow extends Model


?>