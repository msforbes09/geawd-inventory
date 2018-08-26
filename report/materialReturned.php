<?php
  try {
  	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  	$stmt = $pdo->prepare(

      "SELECT m.stockNo, m.itemName, r.itemCount, u.unitName
      FROM materialReturn r
      JOIN materialList m
      ON m.itemId = r.itemId
      JOIN unit u
      ON u.unitId = m.unitId
      WHERE rnId = :rnId
      ORDER BY r.returnId;"

    );
    $stmt->bindValue(':rnId', $_REQUEST["rnId"], PDO::PARAM_INT);
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

      "SELECT r.rnNo, i.risNo, r.rnDate, concat(a.firstName, ' ', a.lastName) AS returnedBy, concat(b.firstName, ' ', b.lastName) AS receivedBy
      FROM materialRn r
      JOIN materialRis i
      ON i.risId = r.risId
      JOIN staff a
      ON a.staffId = r.returnedBy
      JOIN staff b
      ON b.staffId = r.receivedBy
      WHERE r.rnId = :rnId;"

    );
    $stmt->bindValue(':rnId', $_REQUEST["rnId"], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>

<table class="reportHeader">
  <tr>
    <td style="width: 10%;">R.N. No. :</td>
    <td class="content" style="width: 30%;"><?php echo $row["rnNo"]; ?></td>
    <td style="width: 15%;">Returned By :</td>
    <td class="content" style="width: 45%;"><?php echo $row["returnedBy"]; ?></td>
  </tr>
  <tr>
    <td>R.I.S. No. :</td>
    <td class="content"><?php echo $row["risNo"]; ?></td>
    <td>Received By :</td>
    <td class="content"><?php echo $row["receivedBy"]; ?></td>
  </tr>
  <tr>
    <td>Date :</td>
    <td class="content"><?php echo $row["rnDate"]; ?></td>
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
