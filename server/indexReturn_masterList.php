<?php
  try {
  	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  	$stmt = $pdo->prepare(

      "SELECT m.itemId
      FROM materialRelease i
      JOIN materialList m
      ON m.itemId = i.itemId
      WHERE i.risId =
      (
          SELECT risId
      	FROM materialRn
      	WHERE rnId = :rnId
      )
      AND (stockNo LIKE :keyWord
      OR itemName LIKE :keyWord)
      ORDER BY stockNo;"

    );
    $stmt->bindValue(':rnId', $_REQUEST["rnId"], PDO::PARAM_INT);
    $stmt->bindValue(':keyWord', '%' . $_REQUEST["keyWord"] . '%', PDO::PARAM_STR);
    $stmt->execute();
    echo $row = $stmt->fetch(PDO::FETCH_ASSOC)["itemId"];

  } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>
