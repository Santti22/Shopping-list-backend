<?php 
// Yhteys tietokantaan funktiona
function slDB() {
   $db = new PDO('mysql:host=localhost;dbname=shoppingList;charset=utf8', 'root', 'mysql');
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   return $db;
}
// Virheilmoitus tiedon haussa
function returnError(PDOException $pdoex) {
   echo header('http/1.1 500 Internal Server Error');
   $error = array('error' => $pdoex->getMessage());
   echo json_encode($error);
   exit;
}