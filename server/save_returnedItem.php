<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $stmt = $pdo->prepare(

      "INSERT INTO materialReturn(rnId, itemId, itemCount)
      VALUES(:rnId, :itemId, :quantity);"

    );
    $stmt->bindValue(':rnId', $_REQUEST["rnId"], PDO::PARAM_INT);
    $stmt->bindValue(':itemId', $_REQUEST["itemId"], PDO::PARAM_INT);
    $stmt->bindValue(':quantity', $_REQUEST["quantity"], PDO::PARAM_INT);
    $stmt->execute();

    $stmt = $pdo->prepare(

      "SELECT returnId
      FROM materialReturn
      WHERE rnId = :rnId
      ORDER BY returnId DESC
      LIMIT 1;"

    );
    $stmt->bindValue(':rnId', $_REQUEST["rnId"], PDO::PARAM_INT);
    $stmt->execute();
    echo $stmt->fetch(PDO::FETCH_ASSOC)["returnId"];

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
