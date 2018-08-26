<?php
  try {
  	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
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
      $content .= '<tr>';
      $content .= '<td class="">' . $row["risNo"] . '</td>';
      $content .= '<td class="">' . $row["risDate"] . '</td>';
      $content .= '<td class="tdLeft">' . $row["issuedBy"] . '</td>';
      $content .= '<td class="tdLeft">' . $row["risPurpose"] . '</td>';
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
      <th style="width: 15%">R.I.S. No.</th>
      <th style="width: 15%">Date</th>
      <th style="width: 25%">Issued By</th>
      <th style="width: 45%">Purpose</th>
    </tr>
  </thead>
  <tbody>
    <?php echo $content; ?>
  </tbody>
</table>
