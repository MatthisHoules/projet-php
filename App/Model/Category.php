<?php


/**
 * @title : Category.php
 * 
 * @brief : category database class
 */
require_once __DIR__.'/../../Core/Model.php';
require_once __DIR__.'/User.php';

class Category extends Model {
    
    protected $id;
    protected $name;
    protected $user_id;
    protected $listSources;

    // optionnal for fav and display pages
    protected $listInformations;

    function __construct($id, $name, $user_id, $listSources) {
        $this->id = $id;
        $this->name = $name;
        $this->user_id = $user_id;
        $this->listSources = $listSources;
    } // function __construct($id, $name, $user_id)


    /**
     * @name : save
     * @param : void
     * @return void
     * @brief insert in database a new category
     */
    public function save() {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('INSERT INTO `category` (`category_id`, `category_name`, `user_id`) 
                              VALUES (NULL, ?, ?);');
        $stmt->execute(array(
            $this->getName(),
            $this->getUser_id()
        ));

        return $DB->lastInsertId();

    } // public function save()



    /**
     * 
     * @name : getUserCategories
     * @param : $user_id : int, user id
     * @return : list of categories
     */
    public static function getUserCategories($user_id) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT *
                              FROM `category`
                              WHERE `category`.`user_id` = ?');
        $stmt->execute(array(
            $user_id
        ));

        $results = $stmt->fetchAll();

        $listResults = array();
        foreach ($results as $key => $value) {
            array_push($listResults, new Category(
                $value['category_id'],
                $value['category_name'],
                $user_id,
                Source::getCategorySources($value['category_id'])
            ));
        }
    } // public static function getUserCategories($user_id)


    public static function delete($category_id) {
        $listSources = Source::getCategorySources($category_id);
        foreach ($listSources as $key => $value) {
            Source::delete($value->getId());
        }
        
        $DB = static::DBConnect();
        $stmt = $DB->prepare('DELETE FROM `category`
                              WHERE `category`.`category_id` = ?');
        $stmt->execute(array(
            $category_id
        ));

    } // public static function delete($category_id)


    /**
     * @name : categoryBelongsToUser
     * @param int user id
     * @param int category_id
     * 
     * @return bool true if category belongs to user, false instead
     */
    public static function categoryBelongsToUser($user_id, $category_id) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT `category_id`
                              FROM `category`
                              WHERE `category_id` = ?
                              AND `user_id` = ?');
        $stmt->execute(array(
            $category_id,
            $user_id
        ));

        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) return false;
        return true;
    
    } // public static function categoryBelongsToUser($user_id, $category_id)



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
                                WHERE `category`.`category_id` = ?');
        $stmt->execute(array(
            $category_id
        ));

        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) {
            return false;
        }

        $category = new Category(
            $result[0]['category_id'],
            $result[0]['category_name'],
            $result[0]['user_id'],
            Source::getCategorySources($result[0]['category_id'])
        );

        return $category;
        
    } // public static function getCategory($category_id)




    public function getId(){
		return $this->id;
	} // public function getId()

	public function setId($id){
		$this->id = $id;
	} // public function setId($id)

	public function getName(){
		return $this->name;
	} // public function getName()

	public function setName($name){
		$this->name = $name;
	} // public function setName($name)

	public function getUser_id(){
		return $this->user_id;
	} // public function getUser_id()

	public function setUser_id($user_id){
		$this->user_id = $user_id;
	} // public function setUser_id($user_id)

    public function getListSources() {
        return $this->listSources;
    }

    public function setListInformationsDisplay() {
        $listInformations = array();
        foreach ($this->getListSources() as $key => $source) {
            // update source
            $source->updateInformation();
            $listSourceInfo = $source->getInformations();

            foreach ($listSourceInfo as $key => $value) {
                array_push($listInformations, $value);
            }
        }

        // order informations date DESC
        function cmp($a, $b) {
            return strcmp($b->getDate(), $a->getDate());
        }
        usort($listInformations, "cmp");


        $this->listInformations = $listInformations;
    } // public function retreiveInformations()


    public function setListInformationsFav() {
        $listInformations = array();
        foreach ($this->getListSources() as $key => $source) {
            $listSourceInfo = $source->getFavInformations();

            foreach ($listSourceInfo as $key => $value) {
                array_push($listInformations, $value);
            }
        }

        // order informations date DESC
        function cmp($a, $b) {
            return strcmp($b->getDate(), $a->getDate());
        }
        usort($listInformations, "cmp");


        $this->listInformations = $listInformations;

    } // public function setListInformationsFav()

    public function getListInformations() {
        return $this->listInformations;
    }

}
 


?>