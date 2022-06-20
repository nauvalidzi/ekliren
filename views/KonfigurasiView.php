<?php

namespace PHPMaker2021\eclearance;

// Page object
$KonfigurasiView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fkonfigurasiview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fkonfigurasiview = currentForm = new ew.Form("fkonfigurasiview", "view");
    loadjs.done("fkonfigurasiview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.konfigurasi) ew.vars.tables.konfigurasi = <?= JsonEncode(GetClientVar("tables", "konfigurasi")) ?>;
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
<form name="fkonfigurasiview" id="fkonfigurasiview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="konfigurasi">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konfigurasi_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_konfigurasi_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->config_name->Visible) { // config_name ?>
    <tr id="r_config_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konfigurasi_config_name"><?= $Page->config_name->caption() ?></span></td>
        <td data-name="config_name" <?= $Page->config_name->cellAttributes() ?>>
<span id="el_konfigurasi_config_name">
<span<?= $Page->config_name->viewAttributes() ?>>
<?= $Page->config_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->config_value->Visible) { // config_value ?>
    <tr id="r_config_value">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konfigurasi_config_value"><?= $Page->config_value->caption() ?></span></td>
        <td data-name="config_value" <?= $Page->config_value->cellAttributes() ?>>
<span id="el_konfigurasi_config_value">
<span<?= $Page->config_value->viewAttributes() ?>>
<?= $Page->config_value->getViewValue() ?></span>
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
