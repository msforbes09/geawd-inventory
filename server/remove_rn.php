<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "DELETE FROM materialReturn
      WHERE rnId = :rnId;

      DELETE FROM materialRn
      WHERE rnId = :rnId;"

    );
    $stmt->bindValue(':rnId', $_REQUEST["rnId"], PDO::PARAM_INT);
    $stmt->execute();
  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
