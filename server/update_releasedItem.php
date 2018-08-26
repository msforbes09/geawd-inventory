<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "UPDATE materialRelease
      SET
      itemId = :itemId,
      itemCount = :quantity
      WHERE releaseId = :releaseId;"

    );
    $stmt->bindValue(':itemId', $_REQUEST["itemId"], PDO::PARAM_INT);
    $stmt->bindValue(':quantity', $_REQUEST["quantity"], PDO::PARAM_INT);
    $stmt->bindValue(':releaseId', $_REQUEST["releaseId"], PDO::PARAM_INT);
    $stmt->execute();
  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
  /*
  */
?>
