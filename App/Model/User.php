<?php

/**
 *  @title : template.php
 * 
 *  @brief : Example model
 * 
 */
class User extends Model{

    // class vars
    // protected $var;


    /**
     *  @name : __construct
     * 
     *  @brief : constructor
     * 
     */
    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public static function getUsers() {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * FROM `user`');
        $stmt->execute();

        $result = $stmt->fetchAll();

        $listUsers = array();
        foreach ($result as $key => $value) {
            array_push($listUsers, 
                new User(
                    $value['id'],
                    $value['name']
            ));
        }

        return $listUsers;
    }

}



?>