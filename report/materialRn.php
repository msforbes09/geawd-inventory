<?php
  try {
  	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  	$stmt = $pdo->prepare(

      "SELECT r.rnNo, i.risNo, concat(a.firstName, ' ', a.lastName) AS returnedBy, concat(b.firstName, ' ', b.lastName) AS receivedBy, r.rnDate
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
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $content .= '<tr>';
      $content .= '<td>' . $row["rnNo"] . '</td>';
      $content .= '<td>' . $row["rnDate"] . '</td>';
      $content .= '<td>' . $row["risNo"] . '</td>';
      $content .= '<td class="tdLeft">' . $row["returnedBy"] . '</td>';
      $content .= '<td class="tdLeft">' . $row["receivedBy"] . '</td>';
      $content .= '</tr>';
    }

    } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>

<table class="reportTable">
  <thead>
    <tr>
      <th style="width: 15%;">R.N. No.</th>
      <th style="width: 15%;">Date</th>
      <th style="width: 15%;">R.I.S. No.</th>
      <th style="width: 27.5%;">Returned By</th>
      <th style="width: 27.5%;">Received By</th>
    </tr>
  </thead>
  <tbody>
    <?php echo $content; ?>
  </tbody>
</table>
