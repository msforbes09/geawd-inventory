<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "SELECT r.rnId, r.rnNo, i.risNo, concat(a.firstName, ' ', a.lastName) AS returnedBy, concat(b.firstName, ' ', b.lastName) AS receivedBy, r.rnDate
      FROM materialRn r
      JOIN materialRis i
      ON i.risId = r.risId
      JOIN staff a
      ON a.staffId = r.returnedBy
      JOIN staff b
      ON b.staffId = r.receivedBy
      ORDER BY r.rnDate DESC, r.rnId DESC;"

    );
    $stmt->execute();
    $content = '';
    $count = 1;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $content .= '<tr id="rn_' . $row["rnId"] . '" class="returnedList">';
      $content .= '<td class="mrr1"></td>';
      $content .= '<td class="mrr2">' . $row["rnNo"] . '</td>';
      $content .= '<td class="mrr2">' . $row["rnDate"] . '</td>';
      $content .= '<td class="mrr2">' . $row["risNo"] . '</td>';
      $content .= '<td class="mrr7">' . $row["returnedBy"] . '</td>';
      $content .= '<td class="mrr7">' . $row["receivedBy"] . '</td>';
      $content .= '</tr>';
      $count ++;
    }

    for($i = $count; $i < 11; $i++){
      $content .= '<tr class="tr_transaction">';
      $content .= '<td class="mrr1"></td>';
      $content .= '<td class="mrr2"></td>';
      $content .= '<td class="mrr2"></td>';
      $content .= '<td class="mrr2"></td>';
      $content .= '<td class="mrr7"></td>';
      $content .= '<td class="mrr7"></td>';
      $content .= '</tr>';
    }

    echo $content;

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
