<?php

/**
 *
 * @title : User.php
 *
 * @brief : User class
 *
 */
require_once __DIR__.'/../../Core/Model.php';

class User extends Model {

    protected $user_id;
    protected $username;
    protected $first_name;
    protected $last_name;
    protected $mail;
    protected $rank;
    protected $user_status;
    protected $password;
    protected $date;

    // optionnal
    protected $blog;
    protected $userFollower;
    protected $userFollowing;

    function __construct($user_id, $username, $mail, $first_name, $last_name, $rank, $user_status, $password, $date) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->rank = $rank;
        $this->mail = $mail;
        $this->user_status = $user_status;
        $this->password = $password;
        $this->date = $date;
    }


    /**
     *
     * @name : getUserRank
     * @param : $user_id : int, user id
     * @return : user rank
     */
    public static function getUserRank($user_id) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * FROM `user` WHERE `user_id` = ?');
        $stmt->execute(array(
            $user_id
        ));

        $result = $stmt->fetchAll();

        $rank = $result['rank'];

        return $rank;
    } // public static function getUserRank($user_id)

    /**
     *
     * @name : getUser
     * @param : $user_id : int, user id
     * @return : User Object if user exists, false instead
     *
     */
    public static function getUser($user_id) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT *
                                FROM `user` WHERE `user_id` = ?');
        $stmt->execute(array(
            $user_id
        ));

        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) {
            return false;
        }

        $listU = array();
        foreach ($result as $key => $value) {
            array_push($listU, $value);
        }

        $user = new User(
            $result[0]['user_id'],
            $result[0]['username'],
            $result[0]['mail'],
            $result[0]['first_name'],
            $result[0]['last_name'],
            $result[0]['rank'],
            $result[0]['user_status'],
            $result[0]['password'],
            $result[0]['date']
        );

        return $user;


    } // public static function getUser($user_id)

    /**
     *
     * @name : getUsers
     * @param : none
     * @return : array Object, to have an users list
     *
     */
    public static function getUsers() {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * FROM `user`');
        $stmt->execute();

        $result = $stmt->fetchAll();

        $listUsers = array();
        foreach ($result as $key => $value) {
            array_push($listUsers,
                new User(
                    $value['user_id'],
                    $value['username'],
                    $value['mail'],
                    $value['first_name'],
                    $value['last_name'],
                    $value['rank'],
                    $value['user_status'],
                    $value['password'],
                    $value['date']
                ));
        }

        return $listUsers;
    }

    /**
     *  @name : newUser
     *
     *  @param : int : $user_id
     *
     *  @return : void
     *
     *  @brief : delete an user from database
     *
     */
    public static function deleteUser($user_id) {
        $DB = static::DBConnect();

        $stmt = $DB->prepare('DELETE FROM `user` WHERE `user_id` = ?');

        $stmt->execute([$user_id]);

        exit();

    } // public static function newUser($username, $mail, $lastname, $firstname)

    /**
     *  @name : deleteUser
     *
     *  @param : string : $mail
     *  @param : string : $last_name
     *  @param : string : $first_name
     *  @param : string : $pwd : crypted password
     *
     *  @return : User Id
     *
     *  @brief : insert new user in database
     *
     */
    public static function newUser($username, $mail, $lastname, $firstname, $pwd) {
        $DB = static::DBConnect();

        $stmt = $DB->prepare('INSERT INTO `user` (`username`, `first_name`, `last_name`, `mail`, `password`, `rank`, `date`) 
                              VALUES (?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP(NOW()))');

        $stmt->execute([$username, $lastname, $firstname, $mail, $pwd, 'user']);

        return $DB->lastInsertId();

    } // public static function newUser($username, $mail, $lastname, $firstname)


    /**
     *  @name : isMailExist
     *
     *  @param : string : $mail  : value to check
     *
     *  @return : boolean true if mail exist, false instead
     *
     *  @brief : check if $mail already exists in the database
     */
    public static function isMailExist($mail) {

        $DB = static::DBConnect();


        $stmt = $DB->prepare('SELECT * FROM `user` WHERE `mail` = ?');
        $stmt->execute([$mail]);

        $response = $stmt->fetchAll();


        if (sizeof($response) == 0) {
            return false;
        }

        return new User (
            $response[0]['user_id'],
            $response[0]['username'],
            $response[0]['mail'],
            $response[0]['first_name'],
            $response[0]['last_name'],
            $response[0]['rank'],
            $response[0]['user_status'],
            $response[0]['password'],
            $response[0]['date']
        );

    } // public static function isMailExist($mail)


    /**
     *  @name : isUserExist
     *
     *  @param : $mail : mail
     *  @param : $pwd : password non crypted
     *
     *  @return : User object if exist, false instead
     *
     *  @brief : check in database if a user exist (with password & email)
     *
     */
    public static function isUserExist($mail, $password) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT * FROM `user` WHERE `mail` = ?');
        $stmt->execute([$mail]);

        $result = $stmt->fetchAll();

        // Check if one user exist with a mail
        if (sizeof($result) == 0) {
            return false;
        }

        var_dump($result);

        if(!password_verify($password, $result[0]['password'])) {
            return false;
        }

        return new User (
            $result[0]['user_id'],
            $result[0]['username'],
            $result[0]['mail'],
            $result[0]['first_name'],
            $result[0]['last_name'],
            $result[0]['rank'],
            $result[0]['user_status'],
            $result[0]['password'],
            $result[0]['date']

        );

    } //   public static function isUserExist($mail, $password)

    /**
     *
     * @name : updateUsername
     * @param : $user_id : int
     * @param : $mail : string
     *
     * @return : void
     *
     * @brief : change user username/login
     *
     */
    public static function updateUsername($newusername,$user_id ) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('UPDATE user SET `username` = ? WHERE `user_id` = ?');
        $stmt->execute([$newusername, $user_id]);

        return;
    }// public static function updateUsername($newUsername, $user_id)

    /**
     *
     * @name : updateMail
     * @param : $user_id : int
     * @param : $mail : string
     *
     * @return :  void
     *
     * @brief : change user mail
     *
     */
    public static function updateMail($newmail, $user_id) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('UPDATE user SET `mail` = ? WHERE `user_id` = ?');
        $stmt->execute([$newmail, $user_id]);

        return;
    }// public static function updateMail($newMail, $user_id)

    /**
     *  @name : updatePassword
     *
     *  @param : $newPassword : crypted password
     *  @param : $userId : int (11)
     *
     *  @return : void
     *
     *  @brief : change user password
     *
     */
    public static function updatePassword($newPassword, $user_id) {
        $DB = static::DBConnect();

        $stmt = $DB->prepare('UPDATE `user` 
                              SET `password` = ? 
                              WHERE `user_id` = ?');

        $stmt->execute([$newPassword, $user_id]);

        return;


    } // public static function updatePassword($newPassword, $user_id)

    /**
     *  @name : activateAccount
     *
     *  @param : user_id
     *
     *  @return : void
     *
     *  @brief : active user account
     *
     */
    public static function activateAccount($user_id) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('UPDATE `user` 
                              SET `user_status` = 1 
                              WHERE `user_id` = ?');

        $stmt->execute([$user_id]);

        return;

    } // public static function activateAccount($user_id)





    public function getUser_id(){
        return $this->user_id;
    }

    public function setUser_id($user_id){
        $this->user_id = $user_id;
    }

    public function getMail(){
        return $this->mail;
    }

    public function setMail($mail){
        $this->mail = $mail;
    }

    public function getRank(){
        return $this->rank;
    }

    public function setRank($rank){
        $this->rank = $rank;
    }


    public function getFirst_name(){
        return $this->first_name;
    }

    public function setFirst_name($first_name){
        $this->first_name = $first_name;
    }

    public function getLast_name(){
        return $this->last_name;
    }

    public function setLast_name($last_name){
        $this->last_name = $last_name;
    }


    public function getUsername(){
        return $this->username;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function getUser_status(){
        return $this->user_status;
    }

    public function setUser_status($user_status){
        $this->user_status = $user_status;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getDate(){
        return $this->date;
    }

    public function setDate($date){
        $this->date = $date;
    }



	public function getBlog(){
		return $this->blog;
	}

	public function setBlog(){
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * 
                              FROM `information`
                              JOIN `source` ON `information`.`source_id` = `source`.`source_id`
                              JOIN `category` ON `source`.`category_id` = `category`.`category_id`
                              WHERE `category`.`user_id` = ?
                              AND `information`.`blog` IS NOT NULL
                              ORDER BY `information`.`blog` DESC');   
        $stmt->execute(array(
            $this->getUser_id()
        ));
        $result = $stmt->fetchAll();


        $listResult = array();
        foreach ($result as $key => $value) {
            array_push($listResult, new Information(
                $value['information_id'],
                $value['source_id'],
                $value['information_name'],
                $value['information_value'],
                $value['information_details'],
                $value['information_date'],
                $value['img'],
                null
            ));
            $listResult[sizeof($listResult)-1]->setBlogC($value['blog']);
        }

        $this->blog = $listResult;
	} // public function setBlog()


	public function getUserFollower(){
		return $this->userFollower;
	}

	public function setUserFollower(){
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * 
                              FROM `follow`
                              JOIN `user` ON `user`.`user_id` = `follow`.`follower_id`
                              WHERE `following_id` = ?');
        $stmt->execute(array(
            $this->getUser_id()
        ));     
        $results = $stmt->fetchAll();

        $listResult = array();
        foreach ($results as $key => $value) {
            array_push($listResult, new Follow(
                new User(
                    $value['user_id'],
                    $value['username'],
                    $value['mail'],
                    $value['first_name'],
                    $value['last_name'],
                    $value['rank'],
                    $value['user_status'],
                    null,
                    $value['date']),
                $this,
                $value['dateFollow']
            ));
        }

        $this->userFollower = $listResult;
	} // public function setUserFollowers()

	public function getUserFollowing(){
		return $this->userFollowing;
	}

	public function setUserFollowing(){
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT *
                              FROM `follow`
                              JOIN `user` ON `user`.`user_id` = `follow`.`following_id`
                              WHERE `follower_id` = ?');
        $stmt->execute(array(
            $this->getUser_id()
        ));     
        $results = $stmt->fetchAll();

        $listResult = array();
        foreach ($results as $key => $value) {
            array_push($listResult, new Follow(
                new User(
                    $value['user_id'],
                    $value['username'],
                    $value['mail'],
                    $value['first_name'],
                    $value['last_name'],
                    $value['rank'],
                    $value['user_status'],
                    null,
                    $value['date']),
                $this,
                $value['dateFollow']
            ));
        }

        $this->userFollowing = $listResult;
    } // public function setUserFollowing()


        //Change user_status value 2 = desactivated 3 = ban 
    public static function ChangeUserStatus($user_id,$user_value){
        $DB = static::DBConnect();
        $stmt = $DB->prepare('UPDATE `user` 
                                SET `user_status` = ?
                                WHERE `user_id` = ?');
            $stmt->execute(array(
            $user_value,
            $user_id
        ));     
    } // public static function changeUserStatus($user_id, $user_value)


    public function isUserFollow($user_id) {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT count(*) as isExist 
                              FROM `follow`
                              WHERE `following_id` = ?
                              AND `follower_id` = ?');
        $stmt->execute(array(
            $user_id,
            $_SESSION['user']->getUser_id()
        ));
        $result = $stmt->fetch()['isExist'];

        if ($result == 0) return false;
        return true;
        
    } // public function isUserFollow($user_id)


    public function setFollow($user_id) {
        $DB = static::DBConnect();
        
        $stmt = '';
        if (!$this->isUserFollow($user_id)) {
            $stmt  = $DB->prepare('INSERT INTO `follow` (`following_id`, `follower_id`, `dateFollow`)    
                              VALUES (?, ?, UNIX_TIMESTAMP(NOW()))');

        } else {
            $stmt  = $DB->prepare('DELETE FROM `follow`
                                    WHERE `following_id` = ?
                                    AND `follower_id` = ? ');
        }
        
        $stmt->execute(array(
            $user_id,
            $_SESSION['user']->getUser_id()
        ));

        return;
    } // public function setFollow($user_id)


    /**
     * 
     * @name : getUserCategories
     * @param : $user_id : int, user id
     * @return : list of categories
     */
    public function getUserCategories() {
        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT *
                              FROM `category`
                              WHERE `category`.`user_id` = ?');
        $stmt->execute(array(
            $this->getUser_id()
        ));

        $results = $stmt->fetchAll();

        $listResults = array();
        foreach ($results as $key => $value) {
            array_push($listResults, new Category(
                $value['category_id'],
                $value['category_name'],
                $this->getUser_id(),
                null
            ));
        }

        return $listResults;
    } // public static function getUserCategories($user_id)
} // class User

?>