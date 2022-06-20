<?php

namespace PHPMaker2021\eclearance;

// Page object
$BandingDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fbandingdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fbandingdelete = currentForm = new ew.Form("fbandingdelete", "delete");
    loadjs.done("fbandingdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.banding) ew.vars.tables.banding = <?= JsonEncode(GetClientVar("tables", "banding")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fbandingdelete" id="fbandingdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="banding">
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
<?php if ($Page->mengajukan_keberatan_banding->Visible) { // mengajukan_keberatan_banding ?>
        <th class="<?= $Page->mengajukan_keberatan_banding->headerCellClass() ?>"><span id="elh_banding_mengajukan_keberatan_banding" class="banding_mengajukan_keberatan_banding"><?= $Page->mengajukan_keberatan_banding->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sk_banding_nomor->Visible) { // sk_banding_nomor ?>
        <th class="<?= $Page->sk_banding_nomor->headerCellClass() ?>"><span id="elh_banding_sk_banding_nomor" class="banding_sk_banding_nomor"><?= $Page->sk_banding_nomor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgl_sk_banding->Visible) { // tgl_sk_banding ?>
        <th class="<?= $Page->tgl_sk_banding->headerCellClass() ?>"><span id="elh_banding_tgl_sk_banding" class="banding_tgl_sk_banding"><?= $Page->tgl_sk_banding->caption() ?></span></th>
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
<?php if ($Page->mengajukan_keberatan_banding->Visible) { // mengajukan_keberatan_banding ?>
        <td <?= $Page->mengajukan_keberatan_banding->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_banding_mengajukan_keberatan_banding" class="banding_mengajukan_keberatan_banding">
<span<?= $Page->mengajukan_keberatan_banding->viewAttributes() ?>>
<?= $Page->mengajukan_keberatan_banding->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sk_banding_nomor->Visible) { // sk_banding_nomor ?>
        <td <?= $Page->sk_banding_nomor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_banding_sk_banding_nomor" class="banding_sk_banding_nomor">
<span<?= $Page->sk_banding_nomor->viewAttributes() ?>>
<?= $Page->sk_banding_nomor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgl_sk_banding->Visible) { // tgl_sk_banding ?>
        <td <?= $Page->tgl_sk_banding->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_banding_tgl_sk_banding" class="banding_tgl_sk_banding">
<span<?= $Page->tgl_sk_banding->viewAttributes() ?>>
<?= $Page->tgl_sk_banding->getViewValue() ?></span>
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
