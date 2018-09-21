<?php
require_once 'config.php';
  try {
  	$pdo = new PDO( 'mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8;', $username, $password );    
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  	$stmt = $pdo->prepare(

      "SELECT m.itemId, m.stockNo, m.itemName, u.unitName,
      ifnull((
      	SELECT SUM(itemCount)
      	FROM materialReceive
      	WHERE itemId = m.itemId
      ),0) - ifnull((
      	SELECT SUM(itemCount)
      	FROM materialRelease
      	WHERE itemId = m.itemId
      ),0) + m.startBalance as onHand, m.reorderPoint
      FROM materialList m
      JOIN unit u
      ON u.unitId = m.unitId
      WHERE m.removeStatus = 0
      ORDER BY m.stockNo;"

    );
    $stmt->execute();
    $content = '';
    $count = 1;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $content .= '<tr id="list_' . $row["itemId"] . '" class="materialList">';
      $content .= '<td class="mlr1"></td>';
      $content .= '<td class="mlr2">' . $row["stockNo"] . '</td>';
      $content .= '<td class="mlr3">' . $row["itemName"] . '</td>';
      $content .= '<td class="mlr4">' . $row["unitName"] . '</td>';
      $content .= '<td class="mlr5">' . $row["onHand"] . '</td>';
      $content .= '<td class="mlr6">' . $row["reorderPoint"] . '</td>';
      $content .= '</tr>';
      $count ++;
    }

    for($i = $count; $i < 16; $i++){
			$content .= '<tr class="tr_masterList">';
			$content .= '<td class="mlr1"></td>';
			$content .= '<td class="mlr2"></td>';
			$content .= '<td class="mlr3"></td>';
      $content .= '<td class="mlr4"></td>';
      $content .= '<td class="mlr5"></td>';
			$content .= '<td class="mlr6"></td>';
			$content .= '</tr>';
		}

    echo $content;

  } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>
