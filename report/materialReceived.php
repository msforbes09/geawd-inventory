<?php
  try {
  	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  	$stmt = $pdo->prepare(

      "SELECT r.receiveId, m.stockNo, m.itemName, r.itemCount, u.unitName
      FROM materialReceive r
      JOIN materialList m
      ON m.itemId = r.itemId
      JOIN unit u
      ON u.unitId = m.unitId
      WHERE invoiceId = :invoiceId
      ORDER BY receiveId;"

    );
    $stmt->bindValue(':invoiceId', $_REQUEST["invoiceId"], PDO::PARAM_INT);
    $stmt->execute();
    $content = '';
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $content .= '<tr>';
      $content .= '<td class="tdLeft">' . $row["stockNo"] . '</td>';
      $content .= '<td class="tdLeft">' . $row["itemName"] . '</td>';
      $content .= '<td>' . $row["itemCount"] . '</td>';
      $content .= '<td>' . $row["unitName"] . '</td>';
      $content .= '</tr>';
    }

    $stmt = $pdo->prepare(

      "SELECT i.invoiceNo, i.invoiceDate, c.supplierName, concat(s.firstName, ' ', s.lastName) AS receiver
      FROM materialInvoice i
      JOIN supplier c
      ON c.supplierId = i.supplierID
      JOIN staff s
      ON s.staffId = i.receivedBy
      WHERE i.invoiceId = :invoiceId;"

    );
    $stmt->bindValue(':invoiceId', $_REQUEST["invoiceId"], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>

<table class="reportHeader">
  <tr>
    <td style="width: 10%;">O.R. No. :</td>
    <td class="content" style="width: 20%;"><?php echo $row["invoiceNo"]; ?></td>
    <td style="width: 10%;">Supplier :</td>
    <td class="content" style="width: 60%;"><?php echo $row["supplierName"]; ?></td>
  </tr>
  <tr>
    <td>Date :</td>
    <td class="content"><?php echo $row["invoiceDate"]; ?></td>
    <td>Receiver :</td>
    <td class="content"><?php echo $row["receiver"]; ?></td>
  </tr>
</table>
<table class="reportTable">
  <thead>
    <tr>
      <th style="width: 30%">Stock No.</th>
      <th style="width: 40%">Item Description</th>
      <th style="width: 15%">Quantity</th>
      <th style="width: 15%">Unit</th>
    </tr>
  </thead>
  <tbody>
    <?php echo $content; ?>
  </tbody>
</table>
