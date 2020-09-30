<?php

/**
 * 
 *  @title : Information.php
 *  @brief : Information class abstract class
 *  
 */

interface Information {

    /**
     * 
     * @name : compute
     * @param Source
     * @return : array of informations
     * 
     * @get informations from api, rss...
     */
    public static function compute($source);

    /**
     * 
     * @name : save
     * 
     * @param : void
     * @return void
     * 
     * @brief : save an information into the database
     */
    // public function save();


    /**
     * 
     * @name : display
     * @param : void
     * @brief : display information on html
     * 
     */
    // public function display();

} // interface Information


?>