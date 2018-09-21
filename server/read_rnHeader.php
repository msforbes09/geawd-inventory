<?php
require_once 'config.php';
  try {
  	$pdo = new PDO( 'mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8;', $username, $password );    
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
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
    $content = '';
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $content .= '<div class="rnHeader">';
    $content .= '<span class="legend">R.N. No. :</span><span class="content">' . $row["rnNo"] . '</span>';
    $content .= '<span class="legend">Returned By :</span><span class="content">' . $row["returnedBy"] . '</span>';
    $content .= '</div>';
    $content .= '<div class="rnHeader">';
    $content .= '<span class="legend">R.I.S. No. :</span><span class="content">' . $row["risNo"] . '</span>';
    $content .= '<span class="legend">Received By :</span><span class="content">' . $row["receivedBy"] . '</span>';
    $content .= '</div>';
    $content .= '<div class="rnHeader">';
    $content .= '<span class="legend">Date :</span><span class="content">' . $row["rnDate"] . '</span>';
    $content .= '</div>';

    echo $content;

  } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>
