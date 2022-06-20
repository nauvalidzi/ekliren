<?php

namespace PHPMaker2021\eclearance;

// Page object
$MSatuanKerjaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fm_satuan_kerjaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fm_satuan_kerjaview = currentForm = new ew.Form("fm_satuan_kerjaview", "view");
    loadjs.done("fm_satuan_kerjaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.m_satuan_kerja) ew.vars.tables.m_satuan_kerja = <?= JsonEncode(GetClientVar("tables", "m_satuan_kerja")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fm_satuan_kerjaview" id="fm_satuan_kerjaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="m_satuan_kerja">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_m_satuan_kerja_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_m_satuan_kerja_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kode_satker->Visible) { // kode_satker ?>
    <tr id="r_kode_satker">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_m_satuan_kerja_kode_satker"><?= $Page->kode_satker->caption() ?></span></td>
        <td data-name="kode_satker" <?= $Page->kode_satker->cellAttributes() ?>>
<span id="el_m_satuan_kerja_kode_satker">
<span<?= $Page->kode_satker->viewAttributes() ?>>
<?= $Page->kode_satker->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->satuan_kerja->Visible) { // satuan_kerja ?>
    <tr id="r_satuan_kerja">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_m_satuan_kerja_satuan_kerja"><?= $Page->satuan_kerja->caption() ?></span></td>
        <td data-name="satuan_kerja" <?= $Page->satuan_kerja->cellAttributes() ?>>
<span id="el_m_satuan_kerja_satuan_kerja">
<span<?= $Page->satuan_kerja->viewAttributes() ?>>
<?= $Page->satuan_kerja->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
