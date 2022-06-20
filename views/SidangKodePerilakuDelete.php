<?php

namespace PHPMaker2021\eclearance;

// Page object
$SidangKodePerilakuDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsidang_kode_perilakudelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fsidang_kode_perilakudelete = currentForm = new ew.Form("fsidang_kode_perilakudelete", "delete");
    loadjs.done("fsidang_kode_perilakudelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.sidang_kode_perilaku) ew.vars.tables.sidang_kode_perilaku = <?= JsonEncode(GetClientVar("tables", "sidang_kode_perilaku")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsidang_kode_perilakudelete" id="fsidang_kode_perilakudelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sidang_kode_perilaku">
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
<?php if ($Page->sidang_kode_perilaku_jaksa->Visible) { // sidang_kode_perilaku_jaksa ?>
        <th class="<?= $Page->sidang_kode_perilaku_jaksa->headerCellClass() ?>"><span id="elh_sidang_kode_perilaku_sidang_kode_perilaku_jaksa" class="sidang_kode_perilaku_sidang_kode_perilaku_jaksa"><?= $Page->sidang_kode_perilaku_jaksa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tempat_sidang_kode_perilaku->Visible) { // tempat_sidang_kode_perilaku ?>
        <th class="<?= $Page->tempat_sidang_kode_perilaku->headerCellClass() ?>"><span id="elh_sidang_kode_perilaku_tempat_sidang_kode_perilaku" class="sidang_kode_perilaku_tempat_sidang_kode_perilaku"><?= $Page->tempat_sidang_kode_perilaku->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hukuman_administratif->Visible) { // hukuman_administratif ?>
        <th class="<?= $Page->hukuman_administratif->headerCellClass() ?>"><span id="elh_sidang_kode_perilaku_hukuman_administratif" class="sidang_kode_perilaku_hukuman_administratif"><?= $Page->hukuman_administratif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sk_nomor_kode_perilaku->Visible) { // sk_nomor_kode_perilaku ?>
        <th class="<?= $Page->sk_nomor_kode_perilaku->headerCellClass() ?>"><span id="elh_sidang_kode_perilaku_sk_nomor_kode_perilaku" class="sidang_kode_perilaku_sk_nomor_kode_perilaku"><?= $Page->sk_nomor_kode_perilaku->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgl_sk_kode_perilaku->Visible) { // tgl_sk_kode_perilaku ?>
        <th class="<?= $Page->tgl_sk_kode_perilaku->headerCellClass() ?>"><span id="elh_sidang_kode_perilaku_tgl_sk_kode_perilaku" class="sidang_kode_perilaku_tgl_sk_kode_perilaku"><?= $Page->tgl_sk_kode_perilaku->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_hukuman_kode_perilaku->Visible) { // status_hukuman_kode_perilaku ?>
        <th class="<?= $Page->status_hukuman_kode_perilaku->headerCellClass() ?>"><span id="elh_sidang_kode_perilaku_status_hukuman_kode_perilaku" class="sidang_kode_perilaku_status_hukuman_kode_perilaku"><?= $Page->status_hukuman_kode_perilaku->caption() ?></span></th>
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
<?php if ($Page->sidang_kode_perilaku_jaksa->Visible) { // sidang_kode_perilaku_jaksa ?>
        <td <?= $Page->sidang_kode_perilaku_jaksa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_sidang_kode_perilaku_jaksa" class="sidang_kode_perilaku_sidang_kode_perilaku_jaksa">
<span<?= $Page->sidang_kode_perilaku_jaksa->viewAttributes() ?>>
<?= $Page->sidang_kode_perilaku_jaksa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tempat_sidang_kode_perilaku->Visible) { // tempat_sidang_kode_perilaku ?>
        <td <?= $Page->tempat_sidang_kode_perilaku->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_tempat_sidang_kode_perilaku" class="sidang_kode_perilaku_tempat_sidang_kode_perilaku">
<span<?= $Page->tempat_sidang_kode_perilaku->viewAttributes() ?>>
<?= $Page->tempat_sidang_kode_perilaku->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hukuman_administratif->Visible) { // hukuman_administratif ?>
        <td <?= $Page->hukuman_administratif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_hukuman_administratif" class="sidang_kode_perilaku_hukuman_administratif">
<span<?= $Page->hukuman_administratif->viewAttributes() ?>>
<?= $Page->hukuman_administratif->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sk_nomor_kode_perilaku->Visible) { // sk_nomor_kode_perilaku ?>
        <td <?= $Page->sk_nomor_kode_perilaku->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_sk_nomor_kode_perilaku" class="sidang_kode_perilaku_sk_nomor_kode_perilaku">
<span<?= $Page->sk_nomor_kode_perilaku->viewAttributes() ?>>
<?= $Page->sk_nomor_kode_perilaku->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgl_sk_kode_perilaku->Visible) { // tgl_sk_kode_perilaku ?>
        <td <?= $Page->tgl_sk_kode_perilaku->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_tgl_sk_kode_perilaku" class="sidang_kode_perilaku_tgl_sk_kode_perilaku">
<span<?= $Page->tgl_sk_kode_perilaku->viewAttributes() ?>>
<?= $Page->tgl_sk_kode_perilaku->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_hukuman_kode_perilaku->Visible) { // status_hukuman_kode_perilaku ?>
        <td <?= $Page->status_hukuman_kode_perilaku->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_status_hukuman_kode_perilaku" class="sidang_kode_perilaku_status_hukuman_kode_perilaku">
<span<?= $Page->status_hukuman_kode_perilaku->viewAttributes() ?>>
<?= $Page->status_hukuman_kode_perilaku->getViewValue() ?></span>
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
