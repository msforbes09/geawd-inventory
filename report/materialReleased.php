<?php
  try {
  	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  	$stmt = $pdo->prepare(

      "SELECT m.stockNo, m.itemName, r.itemCount, u.unitName
      FROM materialRelease r
      JOIN materialList m
      ON m.itemId = r.itemId
      JOIN unit u
      ON u.unitId = m.unitId
      WHERE risId = :risId
      ORDER BY r.releaseId;"

    );
    $stmt->bindValue(':risId', $_REQUEST["risId"], PDO::PARAM_INT);
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

      "SELECT m.risNo, m.risDate, concat(i.firstName, ' ', i.lastName) as issuedBy, concat(r.firstName, ' ', r.lastName) as receivedBy, m.risPurpose
      FROM materialRis m
      JOIN staff i
      ON i.staffId = m.issuedBy
      JOIN staff r
      ON r.staffId = m.receivedBy
      WHERE m.risId = :risId;"

    );
    $stmt->bindValue(':risId', $_REQUEST["risId"], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>

<table class="reportHeader">
  <tr>
    <td style="width: 10%;">R.I.S. No. :</td>
    <td class="content" style="width: 30%;"><?php echo $row["risNo"]; ?></td>
    <td style="width: 15%;">Issued By :</td>
    <td class="content" style="width: 45%;"><?php echo $row["issuedBy"]; ?></td>
  </tr>
  <tr>
    <td>Date :</td>
    <td class="content"><?php echo $row["risDate"]; ?></td>
    <td>Received By :</td>
    <td class="content"><?php echo $row["receivedBy"]; ?></td>
  </tr>
  <tr>
    <td>Purpose :</td>
    <td colspan="3" class="content"><?php echo $row["risPurpose"]; ?></td>
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
