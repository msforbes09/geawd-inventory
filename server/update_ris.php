<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "UPDATE materialRis
      SET
      risNo = :risNo,
      risDate = :risDate,
      issuedBy = :issuedBy,
      receivedBy = :receivedBy,
      risPurpose = :purpose
      WHERE risId = :risId;"

    );
    $stmt->bindValue(':risNo', $_REQUEST["risNo"], PDO::PARAM_STR);
    $stmt->bindValue(':risDate', $_REQUEST["risDate"], PDO::PARAM_STR);
    $stmt->bindValue(':issuedBy', $_REQUEST["issuedBy"], PDO::PARAM_INT);
    $stmt->bindValue(':receivedBy', $_REQUEST["receivedBy"], PDO::PARAM_INT);
    $stmt->bindValue(':purpose', $_REQUEST["purpose"], PDO::PARAM_STR);
    $stmt->bindValue(':risId', $_REQUEST["risId"], PDO::PARAM_INT);
    $stmt->execute();
  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
