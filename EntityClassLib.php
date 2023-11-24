<?php
class User {
    private $userId;
    private $name;
    private $phone;
    
    private $messages;
    
    public function __construct($userId, $name, $phone)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->phone = $phone;
        
        $this->messages = array();
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function getName() {
        return $this->name;
    }

    public function getPhone() {
        return $this->phone;
    }
}

class Accessibility {
    private $code;
    private $description;
    public function __construct($code, $description)
    {
        $this->code = $code;
        $this->description = $description;
    }
    
    public function getCode(){
        return $this->code;
    }
    public function getDescription(){
        return $this->description;
    }
}

class Album {
    private $albumId;
    private $title;
    private $description;
    private $userId;
    private $accessibilityCode;
    public function __construct($albumId, $title, $description, $userId, $accessibilityCode)
    {
        $this->albumId = $albumId;
        $this->title = $title;
        $this->description = $description;
        $this->userId = $userId;
        $this->accessibilityCode = $accessibilityCode;
    }
    
    public function getAlbumId(){
        return $this->albumId;
    }
    public function getTitle(){
        return $this->title;
    }    
    public function getDescription(){
        return $this->description;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getAccessibilityCode(){
        return $this->accessibilityCode;
    }    
}