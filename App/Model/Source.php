<?php

/**
* 
* @title : Category.php
* 
* @brief : Category class
* 
*/
require_once __DIR__.'/../../Core/Model.php';
require_once __DIR__.'/SourceFrom/RSS.php';
require_once __DIR__.'/SourceFrom/Twitter.php';
require_once __DIR__.'/SourceFrom/MailInfo.php';


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
     * @name : save
     * 
     * @brief : insert in database a new source
     * 
     */
    public function save() {

        $DB = static::DBConnect();
        $stmt = $DB->prepare('INSERT INTO `source` (`source_id`, `category_id`, `source_from`, `source_value`, `source_name`) 
                              VALUES (NULL, ?, ?, ?, ?);');
        $stmt->execute(array(
            $_GET['category'],
            $this->getFrom(),
            $this->getValue(),
            $this->getName()
        ));

    } // public function save()



    public static function delete($source_id) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('DELETE FROM `information`
                                WHERE `information`.`source_id` = ?');
        $stmt->execute(array(
            $source_id
        ));
        $stmt = $DB->prepare('DELETE FROM `source`
                              WHERE `source`.`source_id` = ?');
        $stmt->execute(array(
            $source_id
        ));

        
    } // public function remove


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


    public function updateInformation() {
        // get last source entry
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT MAX(information_date) as lastEntry
                              FROM `information`
                              WHERE `information`.`source_id` = ?');
        $stmt->execute(array(
            $this->getId()
        ));

        $result = $stmt->fetch()['lastEntry'];
        if (is_null($result)) $result = 0; // if no entries in database

        if ($this->getFrom() == 'TWITTER') {
            $twitter = new Twitter($this->getValue());
            $twitter->compute($this, $result);
        } else if ($this->getFrom() == 'RSS'){
            $rss = new RSS($this->getValue());
            $rss->compute($this, $result);
        } else {
            MailInfo::compute($this, $result);
        }
    } // public function updateInformation()


    public function getInformations() {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * 
                              FROM `information`
                              WHERE `information`.`source_id` = ?
                              AND `information`.`isRead` = 0');
        $stmt->execute(array(
            $this->getId()
        ));
        $results = $stmt->fetchAll();

        $listInformations = array();
        foreach ($results as $key => $value) {
            array_push($listInformations, new Information(
                $value['information_id'],
                $this,
                $value['information_name'],
                $value['information_value'],
                $value['information_details'],
                $value['information_date'],
                $value['img'],
                $value['isRead']
            ));
        }
        return $listInformations;
    } // public function getInformations()


    public function getFavInformations() {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * 
                              FROM `information`
                              WHERE `information`.`fav` IS NOT NULL
                              AND `information`.`source_id` = ?
                              ORDER BY `information`.`fav` DESC');

        $stmt->execute(array(
            $this->getId()
        ));
        $results = $stmt->fetchAll();

        $listInformations = array();
        foreach ($results as $key => $value) {
            array_push($listInformations, new Information(
                $value['information_id'],
                $this,
                $value['information_name'],
                $value['information_value'],
                $value['information_details'],
                $value['information_date'],
                $value['img'],
                $value['isRead']
            ));
            $listInformations[sizeof($listInformations) -1]->setFavC($value['fav']);
        }
        
        return $listInformations;
    } // public function getFavInformations()

    public static function SourceBelongsUser($source_id, $user_id) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT count(*) as isExist
                        FROM `source`
                        JOIN `category` ON `category`.`category_id` = `source`.`category_id`
                        WHERE `source`.`source_id` = ?
                        AND `category`.`user_id` = ?');
        $stmt->execute(array(
            $source_id,
            $user_id
        ));

        $result = $stmt->fetch()['isExist'];
        if ($result == 0) return false;
        return true;
    } // public static function SourceBelongsUser($source_id, $user_id)


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
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}
}

?>
