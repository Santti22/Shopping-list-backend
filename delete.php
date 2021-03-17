<?php
// Haetaan yhteys ja luvat tiedon näyttämiseen
require_once 'inc/headers.php';
require_once 'inc/functions.php';

// Tietojen haku json muodossa ja muuttujiin asettaminen
$input = json_decode(file_get_contents('php://input'));
$id = filter_var($input->id, FILTER_SANITIZE_STRING);

// Poistetaan tieto taulusta ID:n perusteella
try {
   $db = slDB();

   $query = $db->prepare('delete from item where id=(:id)');
   $query->bindValue(':id', $id, PDO::PARAM_INT);
   $query->execute();

   echo header ('http1.1 200 OK');
   $data = array('id' => $id);
   echo json_encode($data);
}
// Virheilmoitus
catch (PDOException $pdoex) {
   returnError($pdoex);
}