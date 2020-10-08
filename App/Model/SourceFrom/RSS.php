<?php

/**
 *  
 * @title : RSS.php
 * 
 * @brief : RSS classs
 * 
 */
require_once __DIR__.'/../Information.php';

class RSS {
    protected $sourceValue;

    function __construct($sourceValue) {
        $this->sourceValue = $sourceValue;
    }


    /**
     * 
     * @name : compute
     * @param Source object
     * @param : int last date of insertion of last source information
     * @return void
     * 
     * @brief : insert in db new rss informations
     */
    public function compute($source, $lastDate) {
        $rss = new DOMDocument();
        $rss->load($source->getValue());

        foreach ($rss->getElementsByTagName('item') as $node) {
            if (strval(strtotime($node->getElementsByTagName('pubDate')->item(0)->nodeValue)) > $lastDate) {
                $titleT = $this->sky_cleanup_attributes(strval($node->getElementsByTagName('title')->item(0)->nodeValue));
                $valueT = $this->sky_cleanup_attributes(strval(strtotime($node->getElementsByTagName('pubDate')->item(0)->nodeValue)));
                $descriptionT = $this->sky_cleanup_attributes(strval($node->getElementsByTagName('description')->item(0)->nodeValue));
                $linkT = $this->sky_cleanup_attributes(strval($node->getElementsByTagName('link')->item(0)->nodeValue));
                
                $details = $node;
                $link = $details->getElementsByTagName('link')->item(0);
                $link->parentNode->removeChild($link);

                $details = $this->sky_cleanup_attributes(strval($details->nodeValue));

                $information = new Information(
                                null,
                                $source,
                                $titleT,
                                $descriptionT,
                                $linkT,
                                $valueT,
                                $details,
                                null
                            );
                $information->save();
            }
        }


        return;
    } // public function compute ($source, $lastDate)


    public function getSourceValue() {
        return $this->sourceValue;
    } // public function getSourceValue()
    


    /*
    |-----------------------------------------------------------------------
    | Sky Cleanup Attributes by Matt - www.skyminds.net
    | https://www.skyminds.net/?p=2523
    |-----------------------------------------------------------------------
    |
    | Clean up unwanted HTML attributes defined in a list in given HTML code and return cleaned output.
    |
    */
    public function sky_cleanup_attributes($source) {
        // Define a list of attributes to remove in an array.
        $remove = array('style', 'srcset', 'script', 'class', 'id', 'alt', 'width', 'height');
        $cleanstring = $source;
        foreach($remove as $attribute) {
            $cleanstring = preg_replace('!\\s+'.$attribute.'=("|\')?[-_():;a-z0-9 ]+("|\')?!i','',$cleanstring);
        }

        return $cleanstring;
    } // private function sky_cleanup_attributes($source)

}

?>