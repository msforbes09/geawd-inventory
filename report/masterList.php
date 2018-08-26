<?php
  try {
  	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
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
    echo '<div class="reportHeader">Total Item : <span class="content">' . $stmt->rowCount() . '</span></div>';
    $content = '';
    $count = 1;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $content .= '<tr>';
      $content .= '<td class="tdLeft">' . $row["stockNo"] . '</td>';
      $content .= '<td class="tdLeft">' . $row["itemName"] . '</td>';
      $content .= '<td>' . $row["unitName"] . '</td>';
      $content .= '<td>' . $row["onHand"] . '</td>';
      $content .= '<td>' . $row["reorderPoint"] . '</td>';
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
      <th style="width: 25%">Stock No.</th>
      <th style="width: 35%">Item Description</th>
      <th style="width: 10%">Unit</th>
      <th style="width: 15%">On Hand</th>
      <th style="width: 15%">Reorder Point</th>
    </tr>
  </thead>
  <tbody>
    <?php echo $content; ?>
  </tbody>
</table>
