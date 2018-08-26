<?php
  session_start();
  require_once '../server/globalFunction.php';
?>

<div id="windowReleased" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="windowClose close_windowReleased">&times;</span>R.I.S. Slip</div>
    <div class="windowBody">
      <div class="container_invoiceHeader">
        <?php require_once '../server/read_risHeader.php'; ?>
      </div>
      <div>
        <table class="tableTransactionContent">
          <thead>
            <tr>
              <th class="mrr1"></th>
              <th class="rcr1">Stock No.</th>
              <th class="rcr2">Item Description</th>
              <th class="rcr3">Quantity</th>
              <th class="rcr4">Unit</th>
              <th class="mrr6"></th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="containerRisContent">
        <table class="tableTransactionContent">
          <tbody id="bodyRisContent">
            <?php require_once '../server/read_risContent.php'; ?>
          </tbody>
        </table>
      </div>
      <div class="invoice_buttonGroup">
        <button id="add_releasedItem" class="button_materialInvoice" ><span class="glyphicon glyphicon-plus-sign"></span><div>Add</div></button>
        <button id="edit_releasedItem" class="button_materialInvoice" <?php echo setDisable(); ?>><span class="glyphicon glyphicon-edit"></span><div>Edit</div></button>
        <button id="remove_releasedItem" class="button_materialInvoice" <?php echo setDisable(); ?>><span class="glyphicon glyphicon-remove-sign"></span><div>Delete</div></button>
        <button id="print_releasedItem" class="button_materialInvoice"><span class="glyphicon glyphicon-print"></span><div>Print</div></button>
      </div>
    </div>
  </div>
</div>
