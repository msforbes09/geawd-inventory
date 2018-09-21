<?php
require_once 'config.php';
  try {
    $pdo = new PDO( 'mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8;', $username, $password );
    
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $stmt = $pdo->prepare(

      "INSERT INTO materialRn(rnNo, rnDate, returnedBy, receivedBy, risId)
      VALUES(:rnNo, :rnDate, :returnedBy, :receivedBy, :risId);"

    );
    $stmt->bindValue(':rnNo', $_REQUEST["rnNo"], PDO::PARAM_STR);
    $stmt->bindValue(':rnDate', $_REQUEST["rnDate"], PDO::PARAM_STR);
    $stmt->bindValue(':returnedBy', $_REQUEST["returnedBy"], PDO::PARAM_INT);
    $stmt->bindValue(':receivedBy', $_REQUEST["receivedBy"], PDO::PARAM_INT);
    $stmt->bindValue(':risId', $_REQUEST["risId"], PDO::PARAM_INT);
    $stmt->execute();

    $stmt = $pdo->prepare(

      "SELECT rnId
      FROM materialRn
      ORDER BY rnId DESC
      LIMIT 1;"

    );
    $stmt->execute();
    echo $stmt->fetch(PDO::FETCH_ASSOC)["rnId"];

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
