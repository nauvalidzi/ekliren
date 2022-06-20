<?php

namespace PHPMaker2021\eclearance;

// Page object
$SidangKodePerilakuView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsidang_kode_perilakuview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fsidang_kode_perilakuview = currentForm = new ew.Form("fsidang_kode_perilakuview", "view");
    loadjs.done("fsidang_kode_perilakuview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.sidang_kode_perilaku) ew.vars.tables.sidang_kode_perilaku = <?= JsonEncode(GetClientVar("tables", "sidang_kode_perilaku")) ?>;
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
<form name="fsidang_kode_perilakuview" id="fsidang_kode_perilakuview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sidang_kode_perilaku">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sidang_kode_perilaku_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pid_request_skk->Visible) { // pid_request_skk ?>
    <tr id="r_pid_request_skk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sidang_kode_perilaku_pid_request_skk"><?= $Page->pid_request_skk->caption() ?></span></td>
        <td data-name="pid_request_skk" <?= $Page->pid_request_skk->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_pid_request_skk">
<span<?= $Page->pid_request_skk->viewAttributes() ?>>
<?= $Page->pid_request_skk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sidang_kode_perilaku_jaksa->Visible) { // sidang_kode_perilaku_jaksa ?>
    <tr id="r_sidang_kode_perilaku_jaksa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sidang_kode_perilaku_sidang_kode_perilaku_jaksa"><?= $Page->sidang_kode_perilaku_jaksa->caption() ?></span></td>
        <td data-name="sidang_kode_perilaku_jaksa" <?= $Page->sidang_kode_perilaku_jaksa->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_sidang_kode_perilaku_jaksa">
<span<?= $Page->sidang_kode_perilaku_jaksa->viewAttributes() ?>>
<?= $Page->sidang_kode_perilaku_jaksa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tempat_sidang_kode_perilaku->Visible) { // tempat_sidang_kode_perilaku ?>
    <tr id="r_tempat_sidang_kode_perilaku">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sidang_kode_perilaku_tempat_sidang_kode_perilaku"><?= $Page->tempat_sidang_kode_perilaku->caption() ?></span></td>
        <td data-name="tempat_sidang_kode_perilaku" <?= $Page->tempat_sidang_kode_perilaku->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_tempat_sidang_kode_perilaku">
<span<?= $Page->tempat_sidang_kode_perilaku->viewAttributes() ?>>
<?= $Page->tempat_sidang_kode_perilaku->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hukuman_administratif->Visible) { // hukuman_administratif ?>
    <tr id="r_hukuman_administratif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sidang_kode_perilaku_hukuman_administratif"><?= $Page->hukuman_administratif->caption() ?></span></td>
        <td data-name="hukuman_administratif" <?= $Page->hukuman_administratif->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_hukuman_administratif">
<span<?= $Page->hukuman_administratif->viewAttributes() ?>>
<?= $Page->hukuman_administratif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sk_nomor_kode_perilaku->Visible) { // sk_nomor_kode_perilaku ?>
    <tr id="r_sk_nomor_kode_perilaku">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sidang_kode_perilaku_sk_nomor_kode_perilaku"><?= $Page->sk_nomor_kode_perilaku->caption() ?></span></td>
        <td data-name="sk_nomor_kode_perilaku" <?= $Page->sk_nomor_kode_perilaku->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_sk_nomor_kode_perilaku">
<span<?= $Page->sk_nomor_kode_perilaku->viewAttributes() ?>>
<?= $Page->sk_nomor_kode_perilaku->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_sk_kode_perilaku->Visible) { // tgl_sk_kode_perilaku ?>
    <tr id="r_tgl_sk_kode_perilaku">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sidang_kode_perilaku_tgl_sk_kode_perilaku"><?= $Page->tgl_sk_kode_perilaku->caption() ?></span></td>
        <td data-name="tgl_sk_kode_perilaku" <?= $Page->tgl_sk_kode_perilaku->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_tgl_sk_kode_perilaku">
<span<?= $Page->tgl_sk_kode_perilaku->viewAttributes() ?>>
<?= $Page->tgl_sk_kode_perilaku->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_hukuman_kode_perilaku->Visible) { // status_hukuman_kode_perilaku ?>
    <tr id="r_status_hukuman_kode_perilaku">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sidang_kode_perilaku_status_hukuman_kode_perilaku"><?= $Page->status_hukuman_kode_perilaku->caption() ?></span></td>
        <td data-name="status_hukuman_kode_perilaku" <?= $Page->status_hukuman_kode_perilaku->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_status_hukuman_kode_perilaku">
<span<?= $Page->status_hukuman_kode_perilaku->viewAttributes() ?>>
<?= $Page->status_hukuman_kode_perilaku->getViewValue() ?></span>
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
