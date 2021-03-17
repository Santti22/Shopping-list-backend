<?php
// Haetaan yhteys ja luvat tiedon näyttämiseen
require_once 'inc/headers.php';
require_once 'inc/functions.php';

// Tietojen haku json muodossa ja muuttujiin asettaminen
$input = json_decode(file_get_contents('php://input'));

$id = filter_var($input->id, FILTER_SANITIZE_STRING);
$description = filter_var($input->description, FILTER_SANITIZE_STRING);
$amount = filter_var($input->amount, FILTER_SANITIZE_STRING);

// Päivitetään olemassaoleva tieto
try {
   $db = slDB();

   $query = $db->prepare('update item set description=:description, amount=:amount WHERE id=:id');
   $query->bindValue(':description', $description, PDO::PARAM_STR);
   $query->bindValue(':amount', $amount, PDO::PARAM_INT);
   $query->bindValue(':id', $id, PDO::PARAM_INT);
   $query->execute();

   echo header ('http1.1 200 OK');
   $data = array('id' => $id, 'description' => $description, 'amount' => $amount);
   echo json_encode($data);
}
// Virheilmoitus
catch (PDOException $pdoex) {
   returnError($pdoex);
}