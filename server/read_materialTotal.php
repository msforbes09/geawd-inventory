<?php
require_once 'config.php';
  try {
  	$pdo = new PDO( 'mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8;', $username, $password );    
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  	$stmt = $pdo->prepare(

      "SELECT COUNT(*) as totalItem, SUM(ifnull((
      	SELECT SUM(itemCount)
      	FROM materialReceive
      	WHERE itemId = m.itemId
      ),0) - ifnull((
      	SELECT SUM(itemCount)
      	FROM materialRelease
      	WHERE itemId = m.itemId
      ),0) + m.startBalance) as onHand
      FROM materialList m
      WHERE m.removeStatus = 0;"

    );
    $stmt->execute();
    $content = '';
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $content .= '<span class="displayLabel">Total Item :</span>';
    $content .= '<input class="displayText" type="text" value="' . $row["totalItem"] . '" readonly/>';
    $content .= '<span class="displayLabel">Total Balance :</span>';
    $content .= '<input class="displayText" type="text" value="' . $row["onHand"] . '" readonly/>';

    echo $content;

  } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>
