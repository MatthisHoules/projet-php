<?php

/**
 *  
 * @title : Twitter.php
 * 
 * @brief : Twitter static classs
 * 
 */

require_once __DIR__.'/../../../Core/TwitterApi.php';
require_once __DIR__.'/../Information.php';

class Twitter {
    protected $sourceValue;

    function __construct($sourceValue) {
        $this->sourceValue = $sourceValue;
    }


    /**
     * 
     * @name : compute
     * @param Source object
     * @return list of TweeterInformation
     * 
     * @brief : insert in db new tweets
     */
    public function compute($source, $lastDate) {
        // Connexion to TwitterAPI
        $twitterApi = new TwitterApi();
        $APIResult = $twitterApi->getTweets($this->getSourceValue());

        foreach ($APIResult as $key => $tweet) {
            if (strval(strtotime($tweet['created_at'])) > $lastDate) {
                $information = new Information(
                    null,
                    $source,
                    $tweet['user']['screen_name'],
                    strval($tweet['full_text']),
                    '',
                    strtotime($tweet['created_at']),
                    '',
                    null
                );
                $information->save();
            }
        }
    } // public function compute ($source, $lastDate)


    public function getSourceValue() {
        return $this->sourceValue;
    } // public function getSourceValue()
    

}

?>