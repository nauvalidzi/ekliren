<?php

namespace PHPMaker2021\eclearance;

// Page object
$MSatuanKerjaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fm_satuan_kerjadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fm_satuan_kerjadelete = currentForm = new ew.Form("fm_satuan_kerjadelete", "delete");
    loadjs.done("fm_satuan_kerjadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.m_satuan_kerja) ew.vars.tables.m_satuan_kerja = <?= JsonEncode(GetClientVar("tables", "m_satuan_kerja")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fm_satuan_kerjadelete" id="fm_satuan_kerjadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="m_satuan_kerja">
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
<?php if ($Page->kode_satker->Visible) { // kode_satker ?>
        <th class="<?= $Page->kode_satker->headerCellClass() ?>"><span id="elh_m_satuan_kerja_kode_satker" class="m_satuan_kerja_kode_satker"><?= $Page->kode_satker->caption() ?></span></th>
<?php } ?>
<?php if ($Page->satuan_kerja->Visible) { // satuan_kerja ?>
        <th class="<?= $Page->satuan_kerja->headerCellClass() ?>"><span id="elh_m_satuan_kerja_satuan_kerja" class="m_satuan_kerja_satuan_kerja"><?= $Page->satuan_kerja->caption() ?></span></th>
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
<?php if ($Page->kode_satker->Visible) { // kode_satker ?>
        <td <?= $Page->kode_satker->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_m_satuan_kerja_kode_satker" class="m_satuan_kerja_kode_satker">
<span<?= $Page->kode_satker->viewAttributes() ?>>
<?= $Page->kode_satker->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->satuan_kerja->Visible) { // satuan_kerja ?>
        <td <?= $Page->satuan_kerja->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_m_satuan_kerja_satuan_kerja" class="m_satuan_kerja_satuan_kerja">
<span<?= $Page->satuan_kerja->viewAttributes() ?>>
<?= $Page->satuan_kerja->getViewValue() ?></span>
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
