<?php
  try {
  	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
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
    $content = '';
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $content .= '<div class="invoiceHeader">';
    $content .= '<span class="legend">O.R. No. :</span><span class="content">' . $row["invoiceNo"] . '</span>';
    $content .= '<span class="legend">Supplier :</span><span class="content">' . $row["supplierName"] . '</span>';
    $content .= '</div>';
    $content .= '<div class="invoiceHeader">';
    $content .= '<span class="legend">Date :</span><span class="content">' . $row["invoiceDate"] . '</span>';
    $content .= '<span class="legend">Receiver :</span><span class="content">' . $row["receiver"] . '</span>';
    $content .= '</div>';

    echo $content;

  } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>
