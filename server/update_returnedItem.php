<?php
require_once 'config.php';
  try {
    $pdo = new PDO( 'mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8;', $username, $password );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "UPDATE materialReturn
      SET
      itemId = :itemId,
      itemCount = :quantity
      WHERE returnId = :returnId;"

    );
    $stmt->bindValue(':itemId', $_REQUEST["itemId"], PDO::PARAM_INT);
    $stmt->bindValue(':quantity', $_REQUEST["quantity"], PDO::PARAM_INT);
    $stmt->bindValue(':returnId', $_REQUEST["returnId"], PDO::PARAM_INT);
    $stmt->execute();
  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
  /*
  */
?>
