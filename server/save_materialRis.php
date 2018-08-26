<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $stmt = $pdo->prepare(

      "INSERT INTO materialRis(risNo, risDate, issuedBy, receivedBy, risPurpose)
      VALUES(:risNo, :risDate, :issuedBy, :receivedBy, :purpose);"

    );
    $stmt->bindValue(':risNo', $_REQUEST["risNo"], PDO::PARAM_STR);
    $stmt->bindValue(':risDate', $_REQUEST["risDate"], PDO::PARAM_STR);
    $stmt->bindValue(':issuedBy', $_REQUEST["issuedBy"], PDO::PARAM_INT);
    $stmt->bindValue(':receivedBy', $_REQUEST["receivedBy"], PDO::PARAM_INT);
    $stmt->bindValue(':purpose', $_REQUEST["purpose"], PDO::PARAM_STR);
    $stmt->execute();

    $stmt = $pdo->prepare(

      "SELECT risId
      FROM materialRis
      ORDER BY risId DESC
      LIMIT 1;"

    );
    $stmt->execute();
    echo $stmt->fetch(PDO::FETCH_ASSOC)["risId"];

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
