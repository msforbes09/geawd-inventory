<?php
  session_start();
  require_once '../server/globalFunction.php';
?>

<div id="materialReleasedWindow" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="globalClose windowClose">&times;</span>Issues</div>
    <div class="windowBody">
      <div class="transactionSearchGroup">
        <span class="transactionLabel">R.I.S. No. :</span>
        <input id="text_risNo" class="transactionText" type="text" />
        <span class="glyphicon glyphicon-search transactionIcon"></span>
        <span class="transactionLabel">Date :</span>
        <input id="text_risDate" class="transactionText" type="date" value="<?php echo date("Y-m-d") ?>" />
        <span class="glyphicon glyphicon-calendar transactionIcon"></span>
      </div>
      <div>
        <table class="tableTransaction">
          <thead>
            <tr>
              <th class="mrr1"></th>
              <th class="mrr2">R.I.S. No.</th>
              <th class="mrr3">Date</th>
              <th class="mrr5">Issued By</th>
              <th class="mrr4">Purpose</th>
              <th class="mrr6"></th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="containerTransaction">
        <table class="tableTransaction">
          <tbody id="bodyMaterialReleased">
            <?php require_once '../server/read_materialReleased.php'; ?>
          </tbody>
        </table>
      </div>
      <div class="transactionButtonGroup">
        <button id="newRis" class="transactionButton">Add New <span class="glyphicon glyphicon-plus-sign"></span></button>
        <button id="viewRis" class="transactionButton">View <span class="glyphicon glyphicon-new-window"></span></button>
        <button id="editRis" class="transactionButton" <?php echo setDisable(); ?>>Edit <span class="glyphicon glyphicon-edit"></span></button>
        <button id="removeRis" class="transactionButton" <?php echo setDisable(); ?>>Delete <span class="glyphicon glyphicon-remove-sign"></span></button>
        <button id="print_materialRis" class="transactionButton">Print <span class="glyphicon glyphicon-print"></span></button>
      </div>
      <div>
        <table class="tableTransactionContent">
          <thead>
            <tr>
              <th class="rcr1">Stock No.</th>
              <th class="rcr2">Item Description</th>
              <th class="rcr3">Quantity</th>
              <th class="rcr4">Unit</th>
              <th class="mrr6"></th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="containerTransactionContent">
        <table class="tableTransactionContent">
          <tbody id="bodyReleasedContent">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
