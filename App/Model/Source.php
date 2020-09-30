<?php

/**
* 
* @title : Category.php
* 
* @brief : Category class
* 
*/
require_once __DIR__.'/../../Core/Model.php';
require_once __DIR__.'/TwitterInformation.php';
require_once __DIR__.'/RSSInformation.php';

class Source extends Model {
    protected $id;
    protected $from;
    protected $value;
    protected $name;

    function __construct($id, $from, $value, $name) {
        $this->id = $id;
        $this->from = $from;
        $this->value = $value;
        $this->name = $name;
    } // function __construct($id, $from, $value)


    /**
     *  
     * @name : getCategorySources
     * @param : category_id, int
     * @return Source array
     * 
     */
    public static function getCategorySources($category_id) {

        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * 
                              FROM `source`
                              WHERE `source`.`category_id` = ?');
        $stmt->execute(array(
            $category_id
        ));

        $result = $stmt->fetchAll();


        $sourceList = array();
        foreach ($result as $key => $value) {
            array_push($sourceList, new Source(
                $value['source_id'],
                $value['source_from'],
                $value['source_value'],
                $value['source_name']
            ));
        }

        return $sourceList;

    } // public static function getCategorySources($category_id)


    /**
     * @name : retreiveInformations
     * @param : void
     * @return : array of Informations sobjects
     * @brief : get Informations
     */
    public function retreiveInformations() {
        if ($this->getFrom() == 'TWITTER') {
            $var = TwitterInformation::compute($this);
            return $var;
        
        } else if ($this->getFrom() == 'RSS') {
            return RSSInformation::compute($this);
        }
    } // public function retreiveInformations()



    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getFrom(){
		return $this->from;
	}

	public function setFrom($from){
		$this->from = $from;
	}

	public function getValue(){
		return $this->value;
	}

	public function setValue($value){
		$this->value = $value;
    }
    
    public function getName(){
		return $this->value;
	}

	public function setName($name){
		$this->name = $name;
	}
}

?>