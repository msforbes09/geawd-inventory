<?php
  require_once '../server/globalFunction.php';
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $stmt = $pdo->prepare(

      "SELECT invoiceNo, supplierId, invoiceDate, receivedBy
      FROM materialInvoice
      WHERE invoiceId = :invoiceId;"

    );
    $stmt->bindValue(':invoiceId', $_REQUEST["invoiceId"], PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare(

      "SELECT supplierId, supplierName
      FROM supplier
      WHERE removeStatus = 0;"

    );
    $stmt->execute();

    $supplier = '';
    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
      $supplier .= '<option value="' . $row["supplierId"] . '" ' . ifSelected($row["supplierId"], $data["supplierId"]) . '>' . $row["supplierName"] . '</option>';
    }

    $stmt = $pdo->prepare(

      "SELECT staffId, concat(firstName, ' ', lastName) as receiver
      FROM staff
      WHERE removeStatus = 0;"

    );
    $stmt->execute();

    $receiver = '';
    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
      $receiver .= '<option value="' . $row["staffId"] . '" ' . ifSelected($row["staffId"], $data["receivedBy"]) . '>' . $row["receiver"] . '</option>';
    }

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>

<div id="windowReceived" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="windowClose close_windowReceived">&times;</span>Update Invoice</div>
    <div class="windowBody">
      <div class="frameInvoice">
        <div class="invoiceInputGroup">
          <span class="invoiceLabel">O.R. No. :</span>
          <input id="inputInvoiceNo" type="text" maxlength="10" value="<?php echo $data["invoiceNo"]; ?>" />
          <span class="invoiceLabel">Date :</span>
          <input id="inputInvoiceDate" type="date" value="<?php echo $data["invoiceDate"]; ?>" />
        </div>
        <hr />
        <div class="invoiceInputGroup">
          <span class="invoiceLabel">Supplier :</span>
          <select id="selectSupplier" class="invoiceSelect">
            <?php echo $supplier; ?>
          </select>
        </div>
        <hr />
        <div class="invoiceInputGroup">
          <span class="invoiceLabel">Receiver :</span>
          <select id="selectReceiver" class="invoiceSelect">
            <?php echo $receiver; ?>
          </select>
          <button id="updateInvoice" class="invoiceButton">Save <span class="glyphicon glyphicon-save"></span></button>
        </div>
      </div>
    </div>
  </div>
</div>
