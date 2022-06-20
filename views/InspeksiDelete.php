<?php

namespace PHPMaker2021\eclearance;

// Page object
$InspeksiDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var finspeksidelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    finspeksidelete = currentForm = new ew.Form("finspeksidelete", "delete");
    loadjs.done("finspeksidelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.inspeksi) ew.vars.tables.inspeksi = <?= JsonEncode(GetClientVar("tables", "inspeksi")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="finspeksidelete" id="finspeksidelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="inspeksi">
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
<?php if ($Page->inspeksi_kasus->Visible) { // inspeksi_kasus ?>
        <th class="<?= $Page->inspeksi_kasus->headerCellClass() ?>"><span id="elh_inspeksi_inspeksi_kasus" class="inspeksi_inspeksi_kasus"><?= $Page->inspeksi_kasus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pelanggaran_disiplin->Visible) { // pelanggaran_disiplin ?>
        <th class="<?= $Page->pelanggaran_disiplin->headerCellClass() ?>"><span id="elh_inspeksi_pelanggaran_disiplin" class="inspeksi_pelanggaran_disiplin"><?= $Page->pelanggaran_disiplin->caption() ?></span></th>
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
<?php if ($Page->inspeksi_kasus->Visible) { // inspeksi_kasus ?>
        <td <?= $Page->inspeksi_kasus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_inspeksi_inspeksi_kasus" class="inspeksi_inspeksi_kasus">
<span<?= $Page->inspeksi_kasus->viewAttributes() ?>>
<?= $Page->inspeksi_kasus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pelanggaran_disiplin->Visible) { // pelanggaran_disiplin ?>
        <td <?= $Page->pelanggaran_disiplin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_inspeksi_pelanggaran_disiplin" class="inspeksi_pelanggaran_disiplin">
<span<?= $Page->pelanggaran_disiplin->viewAttributes() ?>>
<?= $Page->pelanggaran_disiplin->getViewValue() ?></span>
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
