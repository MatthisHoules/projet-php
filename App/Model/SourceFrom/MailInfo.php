<?php

/**
 * @title : Mail.php
 * 
 * @brief : information Mail
 * 
 */
require_once __DIR__.'/../Information.php';
require_once __DIR__.'/../../../Core/Model.php';

class MailInfo extends Model {

    const IMAP = array(
        'gmail' => 'imap.gmail.com:993',
        'icloud' => 'imap.mail.me.com:993',
        'outlook' => 'outlook.office365.com:993',
        'yahoo' => 'imap.mail.yahoo.com:993' 
    );

    protected $source;
    protected $typeMail;
    protected $mail;
    protected $password;
    protected $request;

    function __construct($imap, $typeMail, $mail, $password, $request) {
        $this->source = $imap;
        $this->request = $request;

        $this->typeMail = $typeMail;
        $this->mail = $mail;
        $this->password = $password;
        $this->request = $request;
    } // function __construct


    public static function connectIMAP($typeMail, $mail, $password, $request) {
        $imap = @imap_open('{'.MailInfo::IMAP[$typeMail].'/imap/ssl}INBOX', $mail, $password, OP_READONLY);
        // ignores errors, imap is false if cannot connect.
        imap_errors();
        imap_alerts();

        if (!$imap) {
            return false;
        }
        
        return new MailInfo($imap, $typeMail, $mail, $password, $request);
        
    } // public static function connectIMAP($typeMail, $mail, $password, $order)


    public function save() {        
        $DB = static::DBConnect();
        $stmt = $DB->prepare('INSERT INTO `source` (`source_id`, `category_id`, `source_from`, `source_value`, `source_name`) 
                              VALUES (NULL, ?, ?, ?, ?);');
        $stmt->execute(array(
            $_GET['category'],
            $this->getTypeMail(),
            $this->getRequest(),
            $this->getMail()
        ));

        $sourceId = $DB->lastInsertId();

        setcookie('source'.$sourceId, $this->getPassword(), time() + (10 * 365 * 24 * 60 * 60), '/');
        
    } // public function save()


    public static function compute($source, $lastInsertDate) {
        if (!isset($_COOKIE['source'.$source->getId()])) {
            return false;
        }


        $password = $_COOKIE['source'.$source->getId()];
        $request = $source->getValue();
        $mail = $source->getName();
        $typeMail = $source->getFrom();

        $imap = MailInfo::connectIMAP($typeMail, $mail, $password, $request);

        if (!$imap) {
            return;
        }

        $test = imap_search($imap->getSource(), $request);
        
        foreach ($test as $key => $emailIdent) {
            $overview = imap_fetch_overview($imap->getSource(), $emailIdent, 0);
            if (strtotime($overview[0]->date) > $lastInsertDate) {
                $message = imap_fetchbody($imap->getSource(), $emailIdent, 1);
                $date = strtotime($overview[0]->date);

                $newInformation = new Information(
                    null,
                    $source,
                    iconv_mime_decode($overview[0]->subject),
                    imap_qprint($message),
                    null,
                    $date,
                    null,
                    0
                );

                $newInformation->save();
            }
            

        }

    }


    public function search() {
        
        return imap_search($this->getSource(), $this->getRequest());
    } // public function search



    // getters setters
    public function getSource(){
		return $this->source;
	}

	public function setSource($source){
		$this->source = $source;
	}

	public function getTypeMail(){
		return $this->typeMail;
	}

	public function setTypeMail($typeMail){
		$this->typeMail = $typeMail;
	}

	public function getMail(){
		return $this->mail;
	}

	public function setMail($mail){
		$this->mail = $mail;
	}

	public function getPassword(){
		return $this->password;
	}

	public function setPassword($password){
		$this->password = $password;
	}

	public function getRequest(){
		return $this->request;
	}

	public function setRequest($request){
		$this->request = $request;
	}
}




?>