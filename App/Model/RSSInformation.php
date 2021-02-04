<?php

/**
 * 
 *  @title : RSSInformation.php
 *  @brief : Information from RSS
 * 
 */
require_once __DIR__.'/../../Core/Model.php';
require_once __DIR__.'/Information.php';

class RSSInformation extends Model  {

    protected $source;
    protected $name;
    protected $value;
    protected $dateC;
    protected $details;
    protected $img;

    function __construct($source, $name, $value, $dateC, $details, $img) {
        $this->source = $source;
        $this->name = $name;
        $this->value = $value;
        $this->dateC = $dateC;
        $this->details = $details;
        $this->img = $img;
    } // function __construct($source, $name, $value, $details)
    

    /**
     * 
     * @name : compute
     * @param Source object
     * @return list of RSSInformation
     * 
     * @brief : get tweets from source with TwitterApi
     */
    public static function compute($source) {
        $xml = simplexml_load_file($source->getValue());
        if($xml->getName() != 'rss') {
            return array();
        }

        $listRSSInfos = array();
        foreach ($xml->channel->item as $key => $value) {
            array_push($listRSSInfos, new RSSInformation(
                $source,
                strval($value->title),
                strval($value->description),
                strval(strtotime($value->pubDate)),
                strval($value->link),
                strval($value->enclosure->attributes()[2])
            ));
        }

        // print_r($xml->channel);

        return $listRSSInfos;

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
    
    public function getImg(){
		return $this->img;
	}

	public function setImg($img){
		$this->img = $img;
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

} // class RSSInformation extends Model implements Information


?>
