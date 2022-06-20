<?php

namespace PHPMaker2021\eclearance;

// Page object
$InspeksiView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var finspeksiview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    finspeksiview = currentForm = new ew.Form("finspeksiview", "view");
    loadjs.done("finspeksiview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.inspeksi) ew.vars.tables.inspeksi = <?= JsonEncode(GetClientVar("tables", "inspeksi")) ?>;
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
<form name="finspeksiview" id="finspeksiview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="inspeksi">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_inspeksi_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_inspeksi_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pid_request_skk->Visible) { // pid_request_skk ?>
    <tr id="r_pid_request_skk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_inspeksi_pid_request_skk"><?= $Page->pid_request_skk->caption() ?></span></td>
        <td data-name="pid_request_skk" <?= $Page->pid_request_skk->cellAttributes() ?>>
<span id="el_inspeksi_pid_request_skk">
<span<?= $Page->pid_request_skk->viewAttributes() ?>>
<?= $Page->pid_request_skk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->inspeksi_kasus->Visible) { // inspeksi_kasus ?>
    <tr id="r_inspeksi_kasus">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_inspeksi_inspeksi_kasus"><?= $Page->inspeksi_kasus->caption() ?></span></td>
        <td data-name="inspeksi_kasus" <?= $Page->inspeksi_kasus->cellAttributes() ?>>
<span id="el_inspeksi_inspeksi_kasus">
<span<?= $Page->inspeksi_kasus->viewAttributes() ?>>
<?= $Page->inspeksi_kasus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pelanggaran_disiplin->Visible) { // pelanggaran_disiplin ?>
    <tr id="r_pelanggaran_disiplin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_inspeksi_pelanggaran_disiplin"><?= $Page->pelanggaran_disiplin->caption() ?></span></td>
        <td data-name="pelanggaran_disiplin" <?= $Page->pelanggaran_disiplin->cellAttributes() ?>>
<span id="el_inspeksi_pelanggaran_disiplin">
<span<?= $Page->pelanggaran_disiplin->viewAttributes() ?>>
<?= $Page->pelanggaran_disiplin->getViewValue() ?></span>
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
