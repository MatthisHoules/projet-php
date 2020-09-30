<?php


/**
 * 
 * @title : TwitterApiConnect.php
 * 
 * @brief : Twitter api class 
 * 
 */

//  require api exchange
require_once __DIR__.'/TwitterApi/TwitterAPIExchange.php';
require_once __DIR__.'/Config.php';

final class TwitterApi {

    const SETTINGS = array(
        'oauth_access_token' => Config::OAUTH_ACCESS_TOKEN,
        'oauth_access_token_secret' => Config::OAUTH_ACCESS_TOKEN_SECRET,
        'consumer_key' => Config::CONSUMER_KEY,
        'consumer_secret' => Config::CONSUMER_SECRET
    );


    const SEARCH_TWEET_URL = 'https://api.twitter.com/1.1/search/tweets.json';

    protected $twitterApiExchange;

    /**
     *  @name : __construct
     *  
     *  @param : void
     * 
     *  @return TwitterApi object
     */ 
    function __construct() {
        $this->twitterApiExchange = new TwitterAPIExchange(TwitterApi::SETTINGS);
    } // __construct


    /**
     * @name : getTwitterApiExchange
     * @param void
     * @return TwitterAPIExchange 
     */
    public function getTwitterApiExchange() {
        return $this->twitterApiExchange;
    } // public function getTwitterApiExchange()


    /**
     *  @name : getTweets
     *  @param : STRING value
     *  @brief : redirect to methods getUserTweet or getTwitterTrend
     * 
     */
    public function getTweets($value) {
        if ($value[0] == '#') {
            return $this->getTweetsTrend($value);
        }
        return $this->getTweetsUser($value);
    } // public function getTweets($value)

    /**
     *  
     * @name : getUserTweet
     * @param : usertag : @userName
     * @return array of tweets
     */
    private function getTweetsUser($usertag) {
        $requestMethod = 'GET';
        $getField = '?q=from:'.$usertag.' AND -filter:retweets AND -filter:replies&tweet_mode=extended&result_type=recent';

        $result = json_decode($this->twitterApiExchange->setGetfield($getField)
                    ->buildOauth(TwitterApi::SEARCH_TWEET_URL, $requestMethod)
                    ->performRequest(),$assoc = TRUE);

        return $result['statuses']; 
    } // public function getUserTweet($usertag)


    /**
     * @name : getTweetTrend
     * @param : string : #hashtag
     * @return array of tweets
     */
    private function getTweetsTrend($hashtag) {
        $requestMethod = 'GET';
        $getfield = '?q='.$hashtag.' AND -filter:retweets AND -filter:replies&tweet_mode=extended&result_type=recent';
    
        $result = json_decode($this->twitterApiExchange->setGetfield($getfield)
                    ->buildOauth(TwitterApi::SEARCH_TWEET_URL, $requestMethod)
                    ->performRequest(),$assoc = TRUE);

        return $result['statuses']; 
    } // public function getTwitterTrend($hashtag)

}