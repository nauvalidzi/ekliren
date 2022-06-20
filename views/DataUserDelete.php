<?php

namespace PHPMaker2021\eclearance;

// Page object
$DataUserDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fdata_userdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fdata_userdelete = currentForm = new ew.Form("fdata_userdelete", "delete");
    loadjs.done("fdata_userdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.data_user) ew.vars.tables.data_user = <?= JsonEncode(GetClientVar("tables", "data_user")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fdata_userdelete" id="fdata_userdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="data_user">
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
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_data_user__username" class="data_user__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
        <th class="<?= $Page->unit_organisasi->headerCellClass() ?>"><span id="elh_data_user_unit_organisasi" class="data_user_unit_organisasi"><?= $Page->unit_organisasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->email_satker->Visible) { // email_satker ?>
        <th class="<?= $Page->email_satker->headerCellClass() ?>"><span id="elh_data_user_email_satker" class="data_user_email_satker"><?= $Page->email_satker->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hak_akses->Visible) { // hak_akses ?>
        <th class="<?= $Page->hak_akses->headerCellClass() ?>"><span id="elh_data_user_hak_akses" class="data_user_hak_akses"><?= $Page->hak_akses->caption() ?></span></th>
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
<?php if ($Page->_username->Visible) { // username ?>
        <td <?= $Page->_username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_user__username" class="data_user__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
        <td <?= $Page->unit_organisasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_user_unit_organisasi" class="data_user_unit_organisasi">
<span<?= $Page->unit_organisasi->viewAttributes() ?>>
<?= $Page->unit_organisasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->email_satker->Visible) { // email_satker ?>
        <td <?= $Page->email_satker->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_user_email_satker" class="data_user_email_satker">
<span<?= $Page->email_satker->viewAttributes() ?>>
<?= $Page->email_satker->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hak_akses->Visible) { // hak_akses ?>
        <td <?= $Page->hak_akses->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_data_user_hak_akses" class="data_user_hak_akses">
<span<?= $Page->hak_akses->viewAttributes() ?>>
<?= $Page->hak_akses->getViewValue() ?></span>
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
