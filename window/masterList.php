<?php
  session_start();
  require_once '../server/globalFunction.php';
?>

<div id="masterListWindow" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="globalClose windowClose">&times;</span>Masterlist</div>
    <div class="windowBody">
      <div class="generateGroup">
        <button class="button_generateList emptyCode" ><span class="glyphicon glyphicon-list-alt"></span><div>Stock Card</div></button>
        <button class="button_generateList emptyCode"><span class="glyphicon glyphicon-folder-open"></span><div>Bin Card</div></button>
        <button class="button_generateList emptyCode"><span class="glyphicon glyphicon-book"></span><div>Ledger</div></button>
        <div class="displayGroup">
          <?php require_once '../server/read_materialTotal.php'; ?>
        </div>
      </div>
      <div>
        <table class="table_masterList">
          <thead>
            <tr>
              <th class="mlr1"></th>
              <th class="mlr2">Stock No.</th>
              <th class="mlr3">Item Description</th>
              <th class="mlr4">Unit</th>
              <th class="mlr5">On Hand</th>
              <th class="mlr6">Reorder Point</th>
              <th class="mlr7"></th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="container_masterList" onscroll="">
        <table class="table_masterList">
          <tbody id="body_masterList">
            <?php require_once '../server/read_masterList.php'; ?>
          </tbody>
        </table>
      </div>
      <div class="controlGroup">
        <button id="newMaterial" class="button_masterList" ><span class="glyphicon glyphicon-plus-sign"></span><div>Add</div></button>
        <button id="updateMaterial" class="button_masterList" <?php echo setDisable(); ?>><span class="glyphicon glyphicon-edit"></span><div>Edit</div></button>
        <button id="removeMaterial" class="button_masterList" <?php echo setDisable(); ?>><span class="glyphicon glyphicon-remove-sign"></span><div>Delete</div></button>
        <button id="print_masterList" class="button_masterList"><span class="glyphicon glyphicon-print"></span><div>Print</div></button>
        <div class="searchGroup">
          <span class="searchLabel">Search :</span>
          <input id="searchText" type="text" />
          <span class="glyphicon glyphicon-search searchIcon"></span>
        </div>
      </div>
    </div>
  </div>
</div>
