<?php
require_once 'config.php';
  try {
    $pdo = new PDO( 'mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8;', $username, $password );
    
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "DELETE FROM materialReturn
      WHERE rnid = (
      	SELECT rnid
      	FROM materialRn
      	WHERE risId = :risId
      );

      DELETE FROM materialRn
      WHERE risId = :risId;

      DELETE FROM materialRelease
      WHERE risId = :risId;

      DELETE FROM materialRis
      WHERE risId = :risId;"

    );
    $stmt->bindValue(':risId', $_REQUEST["risId"], PDO::PARAM_INT);
    $stmt->execute();
  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
