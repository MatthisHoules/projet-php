<?php

/**
 * 
 * @title : Category.php
 * 
 * @brief : Category class
 * 
 */
require_once __DIR__.'/../../Core/Model.php';
require_once __DIR__.'/Source.php';

class Category extends Model {

    protected $category_id;
    protected $category_name;
    protected $user_id;
    protected $listSources;

    function __construct($category_id, $category_name, $user_id, $listSources) {
        $this->category_id = $category_id;
        $this->category_name = $category_name;
        $this->user_id = $user_id;
        $this->listSources = $listSources;
    }


    /**
     * 
     * @name : getUserCategories
     * @param : $user_id : int, user id
     * @return : list of categories
     */
    public static function getUserCategories($user_id) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * FROM `category` WHERE `user_id` = ?');
        $stmt->execute(array(
            $user_id
        ));

        $result = $stmt->fetchAll();

        $categories = array();
        foreach ($result as $key => $value) {
            array_push($categories, new Category(
                $value['category_id'],
                $value['category_name'],
                $value['user_id'],
                Source::getCategorySources($value['category_id'])
            ));
        }

        return $categories;
    } // public static function getUserCategories($user_id)


    /**
     *  
     * @name : getCategory
     * @param : $category_id : int, category id
     * @return Category Object if category exist, false instead
     * 
     */
    public static function getCategory($category_id) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * 
                                FROM `category` 
                                JOIN `source` ON `source`.`category_id` = `category`.`category_id`
                                WHERE `category`.`category_id` = ?');
        $stmt->execute(array(
            $category_id
        ));

        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) {
            return false;
        }

        $listS = array();
        foreach ($result as $key => $value) {
            array_push($listS, $value['source_value']);
        }

        $category = new Category(
            $result[0]['category_id'],
            $result[0]['category_name'],
            $result[0]['user_id'],
            Source::getCategorySources($result[0]['category_id'])
        );

        return $category;
        

    } // public static function getCategory($category_id)


    public function getCategory_id(){
		return $this->category_id;
	}

	public function setCategory_id($category_id){
		$this->category_id = $category_id;
	}

	public function getCategory_name(){
		return $this->category_name;
	}

	public function setCategory_name($category_name){
		$this->category_name = $category_name;
	}

	public function getUser_id(){
		return $this->user_id;
	}

	public function setUser_id($user_id){
		$this->user_id = $user_id;
	}

	public function getListSources(){
		return $this->listSources;
	}

	public function setListSources($listSources){
		$this->listSources = $listSources;
    }
    
} // class Category

?>