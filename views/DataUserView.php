<?php

namespace PHPMaker2021\eclearance;

// Page object
$DataUserView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fdata_userview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fdata_userview = currentForm = new ew.Form("fdata_userview", "view");
    loadjs.done("fdata_userview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.data_user) ew.vars.tables.data_user = <?= JsonEncode(GetClientVar("tables", "data_user")) ?>;
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
<form name="fdata_userview" id="fdata_userview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="data_user">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_user->Visible) { // id_user ?>
    <tr id="r_id_user">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_user_id_user"><?= $Page->id_user->caption() ?></span></td>
        <td data-name="id_user" <?= $Page->id_user->cellAttributes() ?>>
<span id="el_data_user_id_user">
<span<?= $Page->id_user->viewAttributes() ?>>
<?= $Page->id_user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_user__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username" <?= $Page->_username->cellAttributes() ?>>
<span id="el_data_user__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
    <tr id="r_unit_organisasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_user_unit_organisasi"><?= $Page->unit_organisasi->caption() ?></span></td>
        <td data-name="unit_organisasi" <?= $Page->unit_organisasi->cellAttributes() ?>>
<span id="el_data_user_unit_organisasi">
<span<?= $Page->unit_organisasi->viewAttributes() ?>>
<?= $Page->unit_organisasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->email_satker->Visible) { // email_satker ?>
    <tr id="r_email_satker">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_user_email_satker"><?= $Page->email_satker->caption() ?></span></td>
        <td data-name="email_satker" <?= $Page->email_satker->cellAttributes() ?>>
<span id="el_data_user_email_satker">
<span<?= $Page->email_satker->viewAttributes() ?>>
<?= $Page->email_satker->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hak_akses->Visible) { // hak_akses ?>
    <tr id="r_hak_akses">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_user_hak_akses"><?= $Page->hak_akses->caption() ?></span></td>
        <td data-name="hak_akses" <?= $Page->hak_akses->cellAttributes() ?>>
<span id="el_data_user_hak_akses">
<span<?= $Page->hak_akses->viewAttributes() ?>>
<?= $Page->hak_akses->getViewValue() ?></span>
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
