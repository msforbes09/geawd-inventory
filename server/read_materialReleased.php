<?php
require_once 'config.php';
  try {
    $pdo = new PDO( 'mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8;', $username, $password );    
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "SELECT m.risId, m.risNo, m.risDate, concat(i.firstName, ' ', i.lastName) as issuedBy, concat(r.firstName, ' ', r.lastName) as receivedBy, m.risPurpose
      FROM materialRis m
      JOIN staff i
      ON i.staffId = m.issuedBy
      JOIN staff r
      ON r.staffId = m.receivedBy
      ORDER BY m.risDate DESC, m.risId DESC;"

    );
    $stmt->execute();
    $content = '';
    $count = 1;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $content .= '<tr id="ris_' . $row["risId"] . '" class="releasedList">';
      $content .= '<td class="mrr1"></td>';
      $content .= '<td class="mrr2">' . $row["risNo"] . '</td>';
      $content .= '<td class="mrr3">' . $row["risDate"] . '</td>';
      $content .= '<td class="mrr5">' . $row["issuedBy"] . '</td>';
      $content .= '<td class="mrr4" title="' . $row["risPurpose"] . '"><div class="tdPurpose">' . $row["risPurpose"] . '</div></td>';
      $content .= '</tr>';
      $count ++;
    }

    for($i = $count; $i < 11; $i++){
      $content .= '<tr class="tr_transaction">';
      $content .= '<td class="mrr1"></td>';
      $content .= '<td class="mrr2"></td>';
      $content .= '<td class="mrr3"></td>';
      $content .= '<td class="mrr5"></td>';
      $content .= '<td class="mrr4"></td>';
      $content .= '</tr>';
    }

    echo $content;

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
