<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "UPDATE materialList
      SET stockNo = :stockNo,
      itemName = :itemDesc,
      unitId = :unit,
      reorderPoint = :reorder,
      startBalance = :balance
      WHERE itemId = :itemIndex;"

    );
    $stmt->bindValue(':stockNo', $_REQUEST["stockNo"], PDO::PARAM_STR);
    $stmt->bindValue(':itemDesc', $_REQUEST["itemDesc"], PDO::PARAM_STR);
    $stmt->bindValue(':unit', $_REQUEST["unit"], PDO::PARAM_INT);
    $stmt->bindValue(':reorder', $_REQUEST["reorder"], PDO::PARAM_INT);
    $stmt->bindValue(':balance', $_REQUEST["balance"], PDO::PARAM_INT);
    $stmt->bindValue(':itemIndex', $_REQUEST["itemIndex"], PDO::PARAM_INT);
    $stmt->execute();
  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
