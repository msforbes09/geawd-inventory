<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "SELECT i.invoiceId, i.invoiceNo, i.invoiceDate, c.supplierName, concat(s.firstName, ' ', s.lastName) AS receiver
      FROM materialInvoice i
      JOIN supplier c
      ON c.supplierId = i.supplierID
      JOIN staff s
      ON s.staffId = i.receivedBy
      ORDER BY i.invoiceDate DESC, i.invoiceId DESC;"

    );
    $stmt->execute();
    $content = '';
    $count = 1;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $content .= '<tr id="list_' . $row["invoiceId"] . '" class="receivedList">';
      $content .= '<td class="mrr1"></td>';
      $content .= '<td class="mrr2">' . $row["invoiceNo"] . '</td>';
      $content .= '<td class="mrr3">' . $row["invoiceDate"] . '</td>';
      $content .= '<td class="mrr4">' . $row["supplierName"] . '</td>';
      $content .= '<td class="mrr5">' . $row["receiver"] . '</td>';
      $content .= '</tr>';
      $count ++;
    }

    for($i = $count; $i < 11; $i++){
      $content .= '<tr class="tr_transaction">';
      $content .= '<td class="mrr1"></td>';
      $content .= '<td class="mrr2"></td>';
      $content .= '<td class="mrr3"></td>';
      $content .= '<td class="mrr4"></td>';
      $content .= '<td class="mrr5"></td>';
      $content .= '</tr>';
    }

    echo $content;

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
