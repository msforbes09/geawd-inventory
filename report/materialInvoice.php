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
      $content .= '<tr>';
      $content .= '<td class="">' . $row["invoiceNo"] . '</td>';
      $content .= '<td class="">' . $row["invoiceDate"] . '</td>';
      $content .= '<td class="tdLeft">' . $row["supplierName"] . '</td>';
      $content .= '<td class="tdLeft">' . $row["receiver"] . '</td>';
      $content .= '</tr>';
      $count ++;
    }

    } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>

<table class="reportTable">
  <thead>
    <tr>
      <th style="width: 15%">O.R. No.</th>
      <th style="width: 15%">Date</th>
      <th style="width: 40%">Supplier</th>
      <th style="width: 30%">Receiver</th>
    </tr>
  </thead>
  <tbody>
    <?php echo $content; ?>
  </tbody>
</table>
