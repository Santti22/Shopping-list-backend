<?php
// Haetaan yhteys ja luvat tiedon näyttämiseen
require_once 'inc/headers.php';
require_once 'inc/functions.php';

// Tietojen haku json muodossa ja muuttujiin asettaminen
$input = json_decode(file_get_contents('php://input'));
$description = filter_var($input->description, FILTER_SANITIZE_STRING);
$amount = filter_var($input->amount, FILTER_SANITIZE_STRING);

// Laitetaan tiedot kantaan
try {
   $db = slDB();

   $query = $db->prepare('insert into item(description, amount) values (:description, :amount)');
   $query->bindValue(':description', $description, PDO::PARAM_STR);
   $query->bindValue(':amount', $amount, PDO::PARAM_INT);
   $query->execute();
   echo header ('http1.1 200 OK');
   $data = array('id' => $db->lastInsertId(), 'description' => $description, 'amount' => $amount);
   echo json_encode($data);
}
// Virheilmoitus
catch (PDOException $pdoex) {
   returnError($pdoex);
}