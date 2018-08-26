<?php
  require_once '../server/globalFunction.php';
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $stmt = $pdo->prepare(

      "SELECT risNo, risDate, issuedBy, receivedBy, risPurpose
      FROM materialRis
      WHERE risId = :risId;"

    );
    $stmt->bindValue(':risId', $_REQUEST["risId"], PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare(

      "SELECT staffId, concat(firstName, ' ', lastName) as name
      FROM staff
      WHERE removeStatus = 0;"

    );
    $stmt->execute();

    $issuedBy = '';
    $receivedBy = '';
    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
      $issuedBy .= '<option value="' . $row["staffId"] . '" ' . ifSelected($row["staffId"], $data["issuedBy"]) . '>' . $row["name"] . '</option>';
      $receivedBy .= '<option value="' . $row["staffId"] . '" ' . ifSelected($row["staffId"], $data["receivedBy"]) . '>' . $row["name"] . '</option>';
    }

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>

<div id="windowReleased" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="windowClose close_windowReleased">&times;</span>Update R.I.S.</div>
    <div class="windowBody">
      <div class="frameInvoice">
        <div class="invoiceInputGroup">
          <span class="invoiceLabel">R.I.S. No. :</span>
          <input id="inputRisNo" type="text" maxlength="11" value="<?php echo $data["risNo"] ?>" />
          <span class="invoiceLabel">Date :</span>
          <input id="inputRisDate" type="date" value="<?php echo $data["risDate"] ?>" />
        </div>
        <hr />
        <div class="invoiceInputGroup">
          <span class="invoiceLabel">Issued By :</span>
          <select id="selectIssuedBy" class="invoiceSelect">
            <?php echo $issuedBy; ?>
          </select>
        </div>
        <hr />
        <div class="invoiceInputGroup">
          <span class="invoiceLabel">Received By :</span>
          <select id="selectReceivedBy" class="invoiceSelect">
            <?php echo $receivedBy; ?>
          </select>
        </div>
      </div>
      <div class="purposeInputGroup">
        <textarea id="textPurpose" placeholder="type purpose here..." maxlength="255"><?php echo $data["risPurpose"] ?></textarea>
        <button id="updateRis" class="invoiceButton"><span class="glyphicon glyphicon-save"></span><div>Save</div></button>
      </div>
    </div>
  </div>
</div>
