<?php

/**
 * 
 *  @title : TwitterInformation.php
 *  @brief : Information from tweeter class
 * 
 */
require_once __DIR__.'/../../Core/Model.php';
require_once __DIR__.'/Information.php';
require_once __DIR__.'/../../Core/TwitterApi.php';

class TwitterInformation extends Model implements Information {

    protected $source;
    protected $name;
    protected $value;
    protected $dateC;
    protected $details;

    function __construct($source, $name, $value, $dateC, $details) {
        $this->source = $source;
        $this->name = $name;
        $this->value = $value;
        $this->dateC = $dateC;
        $this->details = $details;
    } // function __construct($source, $name, $value, $details)
    

    /**
     * 
     * @name : compute
     * @param Source object
     * @return list of TweeterInformation
     * 
     * @brief : get tweets from source with TwitterApi
     */
    public static function compute($source) {
        // Connexion to TwitterAPI
        $twitterApi = new TwitterApi();
        $APIResult = $twitterApi->getTweets($source->getValue($source));

        $listTweets = array();
        foreach ($APIResult as $key => $tweet) {
            array_push($listTweets, new TwitterInformation(
                $source,
                $tweet['user']['screen_name'],
                $tweet['full_text'],
                strtotime($tweet['created_at']),
                ''
            ));
        }

        return $listTweets;

    } // public static function compute($source)


    public function getSource(){
		return $this->source;
	}

	public function setSource($source){
		$this->source = $source;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getValue(){
		return $this->value;
	}

	public function setValue($value){
		$this->value = $value;
	}

	public function getDateC(){
		return $this->dateC;
	}

	public function setDateC($dateC){
		$this->dateC = $dateC;
	}

	public function getDetails(){
		return $this->details;
	}

	public function setDetails($details){
		$this->details = $details;
    }
    

     /**
     * 
     * @name : getDateWFormat
     * @param void
     * @return date
     */
    public function getDateWFormat() {
        return date('d/m/Y H:i:s', $this->getDateC());
    } // public function getDateWFormat()

} // class TweeterInformation extends Model implements Information


?>