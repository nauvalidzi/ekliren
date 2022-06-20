<?php

namespace PHPMaker2021\eclearance;

// Page object
$BandingView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fbandingview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fbandingview = currentForm = new ew.Form("fbandingview", "view");
    loadjs.done("fbandingview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.banding) ew.vars.tables.banding = <?= JsonEncode(GetClientVar("tables", "banding")) ?>;
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
<form name="fbandingview" id="fbandingview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="banding">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_banding_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_banding_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pid_request_skk->Visible) { // pid_request_skk ?>
    <tr id="r_pid_request_skk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_banding_pid_request_skk"><?= $Page->pid_request_skk->caption() ?></span></td>
        <td data-name="pid_request_skk" <?= $Page->pid_request_skk->cellAttributes() ?>>
<span id="el_banding_pid_request_skk">
<span<?= $Page->pid_request_skk->viewAttributes() ?>>
<?= $Page->pid_request_skk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mengajukan_keberatan_banding->Visible) { // mengajukan_keberatan_banding ?>
    <tr id="r_mengajukan_keberatan_banding">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_banding_mengajukan_keberatan_banding"><?= $Page->mengajukan_keberatan_banding->caption() ?></span></td>
        <td data-name="mengajukan_keberatan_banding" <?= $Page->mengajukan_keberatan_banding->cellAttributes() ?>>
<span id="el_banding_mengajukan_keberatan_banding">
<span<?= $Page->mengajukan_keberatan_banding->viewAttributes() ?>>
<?= $Page->mengajukan_keberatan_banding->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sk_banding_nomor->Visible) { // sk_banding_nomor ?>
    <tr id="r_sk_banding_nomor">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_banding_sk_banding_nomor"><?= $Page->sk_banding_nomor->caption() ?></span></td>
        <td data-name="sk_banding_nomor" <?= $Page->sk_banding_nomor->cellAttributes() ?>>
<span id="el_banding_sk_banding_nomor">
<span<?= $Page->sk_banding_nomor->viewAttributes() ?>>
<?= $Page->sk_banding_nomor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_sk_banding->Visible) { // tgl_sk_banding ?>
    <tr id="r_tgl_sk_banding">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_banding_tgl_sk_banding"><?= $Page->tgl_sk_banding->caption() ?></span></td>
        <td data-name="tgl_sk_banding" <?= $Page->tgl_sk_banding->cellAttributes() ?>>
<span id="el_banding_tgl_sk_banding">
<span<?= $Page->tgl_sk_banding->viewAttributes() ?>>
<?= $Page->tgl_sk_banding->getViewValue() ?></span>
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
