<?php
include_once 'EntityClassLib.php';

// basic PDO and user management
function getPDO()
{
    $dbConnection = parse_ini_file("Database.ini");
    extract($dbConnection);
    return new PDO($dsn, $scriptUser, $scriptPassword);  
}

function getUserByIdAndPassword($userId, $password)
{
    $pdo = getPDO();
    
    $sql = "SELECT UserId, Name, Phone FROM User WHERE UserId = :userId AND Password = :password";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId, 'password' => $password]);    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row)
    {
       return new User($row['UserId'], $row['Name'], $row['Phone'] );            
    }
    else
    {
        return null;
    }
}

function addNewUser($userId, $name, $phone, $password)
{
   $pdo = getPDO();
   
    $sql = "INSERT INTO User (UserId, Name, Phone, Password) VALUES( :userId, :name, :phone, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId, 'name' => $name, 'phone' => $phone, 'password' => $password]);
}

// validation for NewUser.php
function ValidateUserId($userId) {
  $trimmeduserId = trim($userId);
  
  $pdo = getPDO();
  $sql = "SELECT UserId FROM User WHERE UserId = '$trimmeduserId'";
  $resultSet = $pdo->query($sql);
    
  if (empty($trimmeduserId)) {
      $userIdErr = "User ID cannot be blank.";             
  } elseif ($resultSet->rowCount() > 0){
      $userIdErr = "An user with this ID has already signed up."; 
  } else {
      $userIdErr = "";
  }
  return $userIdErr;
}   

function ValidateName($name) {
  $trimmedName = trim($name);
  if (empty($trimmedName)) {
      $nameErr = "Name cannot be blank.";             
  } else {
      $nameErr = "";
  }
  return $nameErr;
}   

function ValidatePhone($phoneNumber) {
  $trimmedPhone = trim($phoneNumber);
  if (empty($trimmedPhone)) {
      $phoneNumberErr = "Phone number cannot be blank.";
  } elseif(!preg_match("/^(\d{3})-?(\d{3})-?(\d{4})$/", $trimmedPhone)){
      $phoneNumberErr = "Incorrect phone number format.";
  } else {
      $phoneNumberErr = "";
  }
  return $phoneNumberErr;
}   

function ValidatePassword($password) {
  $trimmedpassword = trim($password);
  if (empty($trimmedpassword)) {
      $passwordErr = "Password cannot be blank.";
  } elseif(!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$/", $trimmedpassword)){
      $passwordErr = "Incorrect password format.";
  } else {
      $passwordErr = "";
  }
  return $passwordErr;
}

function ValidateRePassword($password, $rePassword) {
  if ($rePassword == $password && $rePassword == ""){
      $rePasswordErr = "Password cannot be blank.";
  } elseif($rePassword != $password){
      $rePasswordErr = "Password must be matched.";
  } else {
      $rePasswordErr = "";
  }      
  return $rePasswordErr;
}

// validation for Login.php
function ValidateLoginUserId($userId) {
  $trimmeduserId = trim($userId);    
  if (empty($trimmeduserId)) {
      $userIdErr = "User ID cannot be blank.";             
  } else {
      $userIdErr = "";
  }
  return $userIdErr;
}  

function ValidateLoginPassword($password) {
  $trimmedpassword = trim($password);
  if (empty($trimmedpassword)) {
      $passwordErr = "Password cannot be blank.";
  } else {
      $passwordErr = "";
  }
  return $passwordErr;
}

function ValidateLoginCredential($userId, $password) {
  $pdo = getPDO();
  $sql = "SELECT * FROM User WHERE UserId = :userId AND Password = :password";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['userId' => $userId, 'password' => $password]);  
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
  if ($row){
      $credentialErr = "";
  } else {
      $credentialErr = "Incorrect user ID and/or Password!";
  }
  return $credentialErr;
}   

// data control and validation for AddAlbum.php
function getAccessibilities()
{
    $accessibilities = array();
    
    $pdo = getPDO();
    
    $sql = "SELECT * FROM Accessibility";
    
    $resultSet = $pdo->query($sql);
    
    foreach ($resultSet as $row) {
        $accessibility = new Accessibility($row['Accessibility_Code'], $row['Description']);
        $accessibilities[] = $accessibility;
    }
    
    return $accessibilities;
}

function ValidateTitle($title) {
  $trimmedTitle = trim($title);
  if (empty($trimmedTitle)) {
      $titleErr = "Title cannot be blank.";             
  } else {
      $titleErr = "";
  }
  return $titleErr;
}   

function addAlbum($title, $userId, $description, $aCode)
{
    $pdo = getPDO();
   
    $sql = "INSERT INTO Album (Title, Description, Owner_Id, Accessibility_Code) VALUES( :title, :description, :userId, :accessibilityCode)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['title' => $title, 'description' => $description, 'userId' => $userId, 'accessibilityCode' => $aCode]);
}

// for MyAlbum.php
function getAlbums($userId)
{
    $albums = array();
    
    $pdo = getPDO();

    $sql = "SELECT * FROM Album WHERE Owner_Id = :userId";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId]);
    
    foreach ($stmt as $row) {
        $album = new Album($row['Album_Id'], $row['Title'], $row['Description'], $row['Owner_Id'], $row['Accessibility_Code']);
        $albums[] = $album;
    }
    
    return $albums;    
}

function updateAlbum($aCode, $albumId)
{
    $pdo = getPDO();
   
    $sql = "UPDATE Album SET Accessibility_Code = :accessibilityCode WHERE Album_Id = :albumId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['accessibilityCode' => $aCode, 'albumId' => $albumId]);
}

function deleteAlbum($albumId)
{
    $pdo = getPDO();
   
    $sql = "DELETE FROM Album WHERE Album_Id = :albumId;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['albumId' => $albumId]);
}