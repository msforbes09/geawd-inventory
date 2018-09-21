<?php
require_once 'config.php';
  try {
  	$pdo = new PDO( 'mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8;', $username, $password );    
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
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
    $content = '';
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $content .= '<div class="risHeader">';
    $content .= '<span class="legend">R.I.S. No. :</span><span class="content">' . $row["risNo"] . '</span>';
    $content .= '<span class="legend">Issued By :</span><span class="content">' . $row["issuedBy"] . '</span>';
    $content .= '</div>';
    $content .= '<div class="risHeader">';
    $content .= '<span class="legend">Date :</span><span class="content">' . $row["risDate"] . '</span>';
    $content .= '<span class="legend">Received By :</span><span class="content">' . $row["receivedBy"] . '</span>';
    $content .= '</div>';
    $content .= '<div class="risHeader">';
    $content .= '<span class="legend">Purpose :</span><span class="purpose">' . $row["risPurpose"] . '</span>';
    $content .= '</div>';

    echo $content;

  } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>
