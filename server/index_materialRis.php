<?php
  $row = $_REQUEST["row"];
  try {
  	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  	$stmt = $pdo->prepare(

      "SELECT risId
      FROM materialRis
      WHERE $row LIKE :keyWord
      ORDER BY risDate DESC, risId DESC;"

    );
    $stmt->bindValue(':keyWord', '%' . $_REQUEST["keyWord"] . '%', PDO::PARAM_STR);
    $stmt->execute();
    echo $row = $stmt->fetch(PDO::FETCH_ASSOC)["risId"];

  } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>
