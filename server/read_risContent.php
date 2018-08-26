<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "SELECT r.releaseId, m.stockNo, m.itemName, r.itemCount, u.unitName
      FROM materialRelease r
      JOIN materialList m
      ON m.itemId = r.itemId
      JOIN unit u
      ON u.unitId = m.unitId
      WHERE risId = :risId
      ORDER BY releaseId;"

    );
    $stmt->bindValue(':risId', $_REQUEST["risId"], PDO::PARAM_INT);
    $stmt->execute();
    $content = '';
    $count = 1;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $content .= '<tr id="releasedContent_' . $row["releaseId"] . '" class="risList">';
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
