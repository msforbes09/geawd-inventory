<?php
require_once 'config.php';
  try {
    $pdo = new PDO( 'mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8;', $username, $password );    
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "SELECT r.returnId, m.stockNo, m.itemName, r.itemCount, u.unitName
      FROM materialReturn r
      JOIN materialList m
      ON m.itemId = r.itemId
      JOIN unit u
      ON u.unitId = m.unitId
      WHERE rnId = :rnId
      ORDER BY returnId;"

    );
    $stmt->bindValue(':rnId', $_REQUEST["rnId"], PDO::PARAM_INT);
    $stmt->execute();
    $content = '';
    $count = 1;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $content .= '<tr id="returnedContent_' . $row["returnId"] . '" class="rnList">';
      $content .= '<td class="mrr1"></td>';
      $content .= '<td class="rcr1">' . $row["stockNo"] . '</td>';
      $content .= '<td class="rcr2">' . $row["itemName"] . '</td>';
      $content .= '<td class="rcr3">' . $row["itemCount"] . '</td>';
      $content .= '<td class="rcr4">' . $row["unitName"] . '</td>';
      $content .= '</tr>';
      $count ++;
    }

    for($i = $count; $i < 11; $i++){
      $content .= '<tr class="tr_transaction">';
      $content .= '<td class="mrr1"></td>';
      $content .= '<td class="rcr1"></td>';
      $content .= '<td class="rcr2"></td>';
      $content .= '<td class="rcr3"></td>';
      $content .= '<td class="rcr4"></td>';
      $content .= '</tr>';
    }

    echo $content;

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
