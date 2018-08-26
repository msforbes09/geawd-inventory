<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "UPDATE materialInvoice
      SET
      invoiceNo = :invoiceNo,
      invoiceDate = :invoiceDate,
      supplierId = :supplier,
      receivedBy = :receiver
      WHERE invoiceId = :invoiceId;"

    );
    $stmt->bindValue(':invoiceNo', $_REQUEST["invoiceNo"], PDO::PARAM_STR);
    $stmt->bindValue(':invoiceDate', $_REQUEST["invoiceDate"], PDO::PARAM_STR);
    $stmt->bindValue(':supplier', $_REQUEST["supplier"], PDO::PARAM_INT);
    $stmt->bindValue(':receiver', $_REQUEST["receiver"], PDO::PARAM_INT);
    $stmt->bindValue(':invoiceId', $_REQUEST["invoiceId"], PDO::PARAM_INT);
    $stmt->execute();
  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
