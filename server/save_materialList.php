<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $stmt = $pdo->prepare(

      "INSERT INTO materialList(stockNo, itemName, unitId, reorderPoint, startBalance)
      VALUES(:stockNo, :itemDesc, :unit, :reorder, :balance);"

    );
    $stmt->bindValue(':stockNo', $_REQUEST["stockNo"], PDO::PARAM_STR);
    $stmt->bindValue(':itemDesc', $_REQUEST["itemDesc"], PDO::PARAM_STR);
    $stmt->bindValue(':unit', $_REQUEST["unit"], PDO::PARAM_INT);
    $stmt->bindValue(':reorder', $_REQUEST["reorder"], PDO::PARAM_INT);
    $stmt->bindValue(':balance', $_REQUEST["balance"], PDO::PARAM_INT);
    $stmt->execute();

    $stmt = $pdo->prepare(

      "SELECT itemId
      FROM materialList
      ORDER BY itemId DESC
      LIMIT 1;"

    );
    $stmt->execute();
    echo $stmt->fetch(PDO::FETCH_ASSOC)["itemId"];

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
