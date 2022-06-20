<?php

namespace PHPMaker2021\eclearance;

// Page object
$HukumanDisiplinView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fhukuman_disiplinview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fhukuman_disiplinview = currentForm = new ew.Form("fhukuman_disiplinview", "view");
    loadjs.done("fhukuman_disiplinview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.hukuman_disiplin) ew.vars.tables.hukuman_disiplin = <?= JsonEncode(GetClientVar("tables", "hukuman_disiplin")) ?>;
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
<form name="fhukuman_disiplinview" id="fhukuman_disiplinview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="hukuman_disiplin">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_hukuman_disiplin_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_hukuman_disiplin_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pid_request_skk->Visible) { // pid_request_skk ?>
    <tr id="r_pid_request_skk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_hukuman_disiplin_pid_request_skk"><?= $Page->pid_request_skk->caption() ?></span></td>
        <td data-name="pid_request_skk" <?= $Page->pid_request_skk->cellAttributes() ?>>
<span id="el_hukuman_disiplin_pid_request_skk">
<span<?= $Page->pid_request_skk->viewAttributes() ?>>
<?= $Page->pid_request_skk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pernah_dijatuhi_hukuman->Visible) { // pernah_dijatuhi_hukuman ?>
    <tr id="r_pernah_dijatuhi_hukuman">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_hukuman_disiplin_pernah_dijatuhi_hukuman"><?= $Page->pernah_dijatuhi_hukuman->caption() ?></span></td>
        <td data-name="pernah_dijatuhi_hukuman" <?= $Page->pernah_dijatuhi_hukuman->cellAttributes() ?>>
<span id="el_hukuman_disiplin_pernah_dijatuhi_hukuman">
<span<?= $Page->pernah_dijatuhi_hukuman->viewAttributes() ?>>
<?= $Page->pernah_dijatuhi_hukuman->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenis_hukuman->Visible) { // jenis_hukuman ?>
    <tr id="r_jenis_hukuman">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_hukuman_disiplin_jenis_hukuman"><?= $Page->jenis_hukuman->caption() ?></span></td>
        <td data-name="jenis_hukuman" <?= $Page->jenis_hukuman->cellAttributes() ?>>
<span id="el_hukuman_disiplin_jenis_hukuman">
<span<?= $Page->jenis_hukuman->viewAttributes() ?>>
<?= $Page->jenis_hukuman->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hukuman->Visible) { // hukuman ?>
    <tr id="r_hukuman">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_hukuman_disiplin_hukuman"><?= $Page->hukuman->caption() ?></span></td>
        <td data-name="hukuman" <?= $Page->hukuman->cellAttributes() ?>>
<span id="el_hukuman_disiplin_hukuman">
<span<?= $Page->hukuman->viewAttributes() ?>>
<?= $Page->hukuman->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pasal->Visible) { // pasal ?>
    <tr id="r_pasal">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_hukuman_disiplin_pasal"><?= $Page->pasal->caption() ?></span></td>
        <td data-name="pasal" <?= $Page->pasal->cellAttributes() ?>>
<span id="el_hukuman_disiplin_pasal">
<span<?= $Page->pasal->viewAttributes() ?>>
<?= $Page->pasal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->surat_keputusan->Visible) { // surat_keputusan ?>
    <tr id="r_surat_keputusan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_hukuman_disiplin_surat_keputusan"><?= $Page->surat_keputusan->caption() ?></span></td>
        <td data-name="surat_keputusan" <?= $Page->surat_keputusan->cellAttributes() ?>>
<span id="el_hukuman_disiplin_surat_keputusan">
<span<?= $Page->surat_keputusan->viewAttributes() ?>>
<?= $Page->surat_keputusan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sk_nomor->Visible) { // sk_nomor ?>
    <tr id="r_sk_nomor">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_hukuman_disiplin_sk_nomor"><?= $Page->sk_nomor->caption() ?></span></td>
        <td data-name="sk_nomor" <?= $Page->sk_nomor->cellAttributes() ?>>
<span id="el_hukuman_disiplin_sk_nomor">
<span<?= $Page->sk_nomor->viewAttributes() ?>>
<?= $Page->sk_nomor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_sk->Visible) { // tanggal_sk ?>
    <tr id="r_tanggal_sk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_hukuman_disiplin_tanggal_sk"><?= $Page->tanggal_sk->caption() ?></span></td>
        <td data-name="tanggal_sk" <?= $Page->tanggal_sk->cellAttributes() ?>>
<span id="el_hukuman_disiplin_tanggal_sk">
<span<?= $Page->tanggal_sk->viewAttributes() ?>>
<?= $Page->tanggal_sk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_hukuman->Visible) { // status_hukuman ?>
    <tr id="r_status_hukuman">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_hukuman_disiplin_status_hukuman"><?= $Page->status_hukuman->caption() ?></span></td>
        <td data-name="status_hukuman" <?= $Page->status_hukuman->cellAttributes() ?>>
<span id="el_hukuman_disiplin_status_hukuman">
<span<?= $Page->status_hukuman->viewAttributes() ?>>
<?= $Page->status_hukuman->getViewValue() ?></span>
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
