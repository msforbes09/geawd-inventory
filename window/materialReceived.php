<?php
  session_start();
  require_once '../server/globalFunction.php';
?>

<div id="materialReceivedWindow" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="globalClose windowClose">&times;</span>Receipts</div>
    <div class="windowBody">
      <div class="transactionSearchGroup">
        <span class="transactionLabel">O.R. No. :</span>
        <input id="text_invoiceNo" class="transactionText" type="text" />
        <span class="glyphicon glyphicon-search transactionIcon"></span>
        <span class="transactionLabel">Date :</span>
        <input id="text_invoiceDate" class="transactionText" type="date" value="<?php echo date("Y-m-d") ?>" />
        <span class="glyphicon glyphicon-calendar transactionIcon"></span>
      </div>
      <div>
        <table class="tableTransaction">
          <thead>
            <tr>
              <th class="mrr1"></th>
              <th class="mrr2">O.R. No.</th>
              <th class="mrr3">Date</th>
              <th class="mrr4">Supplier</th>
              <th class="mrr5">Receiver</th>
              <th class="mrr6"></th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="containerTransaction">
        <table class="tableTransaction">
          <tbody id="bodyMaterialReceived">
            <?php require_once '../server/read_materialReceived.php'; ?>
          </tbody>
        </table>
      </div>
      <div class="transactionButtonGroup">
        <button id="newInvoice" class="transactionButton">Add New <span class="glyphicon glyphicon-plus-sign"></span></button>
        <button id="viewInvoice" class="transactionButton">View <span class="glyphicon glyphicon-new-window"></span></button>
        <button id="editInvoice" class="transactionButton" <?php echo setDisable(); ?>>Edit <span class="glyphicon glyphicon-edit"></span></button>
        <button id="removeInvoice" class="transactionButton" <?php echo setDisable(); ?>>Delete <span class="glyphicon glyphicon-remove-sign"></span></button>
        <button id="print_materialInvoice" class="transactionButton">Print <span class="glyphicon glyphicon-print"></span></button>
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
          <tbody id="bodyReceivedContent">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
