<?php

/**
 * 
 * @title : Information.php
 * 
 * @brief : Information database table class
 * 
 */
require_once __DIR__.'/../../Core/Model.php';

class Information extends Model {

    protected $id;
    protected $source;
    protected $name;
    protected $value;
    protected $details;
    protected $date;
    protected $img;
	protected $isRead;
	// optionnal
	protected $fav;
	protected $blog;

    function __construct($id, $source, $name, $value, $details, $date, $img, $isRead) {
        $this->id = $id;
        $this->source = $source;
        $this->name = $name; 
        $this->value = $value;
        $this->details = $details;
        $this->date = $date;
        $this->img = $img;
        $this->isRead = $isRead;

    } // function __construct($id, $source, $name, $value, $details, $date, $img, $isRead)


    public function save() {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('INSERT INTO `information` (`information_id`, `source_id`, `information_name`, `information_value`, `information_details`, `information_date`, `img`, `isRead`) 
                              VALUES (NULL, ?, ?, ?, ?, ?, ?, 0)');
        $stmt->execute(array(
            $this->getSource()->getId(),
            $this->getName(),
            $this->getValue(),
            $this->getDetails(),
            $this->getDate(),
            $this->getImg(),
		));
    } // public function save()





	public static function InformationBelongsToCategory($information_id, $category_id) {
		$DB = static::DBConnect();
		$stmt = $DB->prepare('SELECT COUNT(`information_id`) as isExist
							  FROM `information`
							  JOIN `source` ON `information`.`source_id` = `source`.`source_id`
							  JOIN `category` ON `source`.`category_id` = `category`.`category_id`
							  WHERE `information`.`information_id` = ?
							  AND `category`.`category_id` = ? ');
		$stmt->execute(array(
			$information_id,
			$category_id
		));
		$result = $stmt->fetch();

		if ($result['isExist'] == 0) return false;
		return true;
	}

	public static function setIsRead($information_id, $value) {
		$DB = static::DBConnect();
		$stmt = $DB->prepare('UPDATE `information` 
							  SET `isRead`  = ?
							  WHERE `information`.`information_id` = ?');
		$stmt->execute(array(
			$value,
			$information_id
		));
	} // public static function setRead($information_id, $value)


	public static function setFav($information_id, $value) {
		$DB = static::DBConnect();

		if ($value == 1) {
			$stmt = $DB->prepare('UPDATE `information` 
								SET `fav` = UNIX_TIMESTAMP(NOW())
								WHERE `information`.`information_id` = ?');
		} else {
			$stmt = $DB->prepare('UPDATE `information` 
								SET `fav` = NULL
								WHERE `information`.`information_id` = ?');
		}
		$stmt->execute(array(
			$information_id
		));
	} // public static function setFav($information_id, $value)


	public static function setBlog($information_id, $value) {
		$DB = static::DBConnect();

		if ($value == 1) {
			$stmt = $DB->prepare('UPDATE `information` 
								SET `blog` = UNIX_TIMESTAMP(NOW())
								WHERE `information`.`information_id` = ?');
		} else {
			$stmt = $DB->prepare('UPDATE `information` 
								SET `blog` = NULL
								WHERE `information`.`information_id` = ?');
		}

		$stmt->execute(array(
			$information_id
		));
	} // public static function setBlog($information_id, $value) {

	
	public static function getInformationById($article_id) {
		$DB = static::DBConnect();
		$stmt = $DB->prepare('SELECT * 
							  FROM `information`
							  JOIN `source` ON `information`.`source_id` = `source`.`source_id`
							  WHERE `information`.`information_id` = ?');
		$stmt->execute(
			array(
				$article_id
			));
		$result = $stmt->fetchAll();

		if (sizeof($result) == 0) {
			return false;
		}

		return new Information(
			$result[0]['information_id'],
			$result[0]['source_from'],
			$result[0]['information_name'],
			$result[0]['information_value'],
			$result[0]['information_details'],
			$result[0]['information_date'],
			$result[0]['img'],
			$result[0]['isRead']
		);

	}


    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

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

	public function getDetails(){
		return $this->details;
	}

	public function setDetails($details){
		$this->details = $details;
	}

	public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date = $date;
	}

	public function getImg(){
		return $this->img;
	}

	public function setImg($img){
		$this->img = $img;
	}

	public function getIsRead(){
		return $this->isRead;
	}
	

	public function getFav(){
		return $this->fav;
	}

	public function setFavC($fav){
		$this->fav = $fav;
	}

	public function getBlog(){
		return $this->blog;
	}

	public function setBlogC($blog){
		$this->blog = $blog;
	}


	
    /**
     * 
     * @name : getDateWFormat
     * @param void
     * @return date
     */
    public function getDateWFormat() {
        return date('d/m/Y H:i:s', $this->getDate());
	} // public function getDateWFormat()
	
	
} // class Information


?>