<?php

namespace PHPMaker2021\eclearance;

// Page object
$DataRequestSkkDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fdata_request_skkdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fdata_request_skkdelete = currentForm = new ew.Form("fdata_request_skkdelete", "delete");
    loadjs.done("fdata_request_skkdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.data_request_skk) ew.vars.tables.data_request_skk = <?= JsonEncode(GetClientVar("tables", "data_request_skk")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fdata_request_skkdelete" id="fdata_request_skkdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="data_request_skk">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
        <th class="<?= $Page->tanggal_request->headerCellClass() ?>"><span id="elh_data_request_skk_tanggal_request" class="data_request_skk_tanggal_request"><?= $Page->tanggal_request->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nrp->Visible) { // nrp ?>
        <th class="<?= $Page->nrp->headerCellClass() ?>"><span id="elh_data_request_skk_nrp" class="data_request_skk_nrp"><?= $Page->nrp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nip->Visible) { // nip ?>
        <th class="<?= $Page->nip->headerCellClass() ?>"><span id="elh_data_request_skk_nip" class="data_request_skk_nip"><?= $Page->nip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_data_request_skk_nama" class="data_request_skk_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
        <th class="<?= $Page->unit_organisasi->headerCellClass() ?>"><span id="elh_data_request_skk_unit_organisasi" class="data_request_skk_unit_organisasi"><?= $Page->unit_organisasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keperluan->Visible) { // keperluan ?>
        <th class="<?= $Page->keperluan->headerCellClass() ?>"><span id="elh_data_request_skk_keperluan" class="data_request_skk_keperluan"><?= $Page->keperluan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_data_request_skk_status" class="data_request_skk_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
        <td <?= $Page->tanggal_request->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_request_skk_tanggal_request" class="data_request_skk_tanggal_request">
<span<?= $Page->tanggal_request->viewAttributes() ?>>
<?= $Page->tanggal_request->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nrp->Visible) { // nrp ?>
        <td <?= $Page->nrp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_request_skk_nrp" class="data_request_skk_nrp">
<span<?= $Page->nrp->viewAttributes() ?>>
<?= $Page->nrp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nip->Visible) { // nip ?>
        <td <?= $Page->nip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_request_skk_nip" class="data_request_skk_nip">
<span<?= $Page->nip->viewAttributes() ?>>
<?= $Page->nip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_request_skk_nama" class="data_request_skk_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
        <td <?= $Page->unit_organisasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_request_skk_unit_organisasi" class="data_request_skk_unit_organisasi">
<span<?= $Page->unit_organisasi->viewAttributes() ?>>
<?= $Page->unit_organisasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keperluan->Visible) { // keperluan ?>
        <td <?= $Page->keperluan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_request_skk_keperluan" class="data_request_skk_keperluan">
<span<?= $Page->keperluan->viewAttributes() ?>>
<?= $Page->keperluan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_request_skk_status" class="data_request_skk_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
