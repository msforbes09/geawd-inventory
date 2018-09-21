<?php
require_once 'config.php';
  try {
    $pdo = new PDO( 'mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8;', $username, $password );
    
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $stmt = $pdo->prepare(

      "INSERT INTO materialInvoice(invoiceNo, invoiceDate, supplierId, receivedBy)
      VALUES(:invoiceNo, :invoiceDate, :supplier, :receiver);"

    );
    $stmt->bindValue(':invoiceNo', $_REQUEST["invoiceNo"], PDO::PARAM_STR);
    $stmt->bindValue(':invoiceDate', $_REQUEST["invoiceDate"], PDO::PARAM_STR);
    $stmt->bindValue(':supplier', $_REQUEST["supplier"], PDO::PARAM_INT);
    $stmt->bindValue(':receiver', $_REQUEST["receiver"], PDO::PARAM_INT);
    $stmt->execute();

    $stmt = $pdo->prepare(

      "SELECT invoiceId
      FROM materialInvoice
      ORDER BY invoiceId DESC
      LIMIT 1;"

    );
    $stmt->execute();
    echo $stmt->fetch(PDO::FETCH_ASSOC)["invoiceId"];

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>
