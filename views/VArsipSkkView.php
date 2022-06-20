<?php

namespace PHPMaker2021\eclearance;

// Page object
$VArsipSkkView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_arsip_skkview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fv_arsip_skkview = currentForm = new ew.Form("fv_arsip_skkview", "view");
    loadjs.done("fv_arsip_skkview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.v_arsip_skk) ew.vars.tables.v_arsip_skk = <?= JsonEncode(GetClientVar("tables", "v_arsip_skk")) ?>;
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
<form name="fv_arsip_skkview" id="fv_arsip_skkview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_arsip_skk">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
    <tr id="r_tanggal_request">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_tanggal_request"><?= $Page->tanggal_request->caption() ?></span></td>
        <td data-name="tanggal_request" <?= $Page->tanggal_request->cellAttributes() ?>>
<span id="el_v_arsip_skk_tanggal_request">
<span<?= $Page->tanggal_request->viewAttributes() ?>>
<?= $Page->tanggal_request->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nomor_surat->Visible) { // nomor_surat ?>
    <tr id="r_nomor_surat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_nomor_surat"><?= $Page->nomor_surat->caption() ?></span></td>
        <td data-name="nomor_surat" <?= $Page->nomor_surat->cellAttributes() ?>>
<span id="el_v_arsip_skk_nomor_surat">
<span<?= $Page->nomor_surat->viewAttributes() ?>>
<?= $Page->nomor_surat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nip->Visible) { // nip ?>
    <tr id="r_nip">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_nip"><?= $Page->nip->caption() ?></span></td>
        <td data-name="nip" <?= $Page->nip->cellAttributes() ?>>
<span id="el_v_arsip_skk_nip">
<span<?= $Page->nip->viewAttributes() ?>>
<?= $Page->nip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nrp->Visible) { // nrp ?>
    <tr id="r_nrp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_nrp"><?= $Page->nrp->caption() ?></span></td>
        <td data-name="nrp" <?= $Page->nrp->cellAttributes() ?>>
<span id="el_v_arsip_skk_nrp">
<span<?= $Page->nrp->viewAttributes() ?>>
<?= $Page->nrp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_v_arsip_skk_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pangkat->Visible) { // pangkat ?>
    <tr id="r_pangkat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_pangkat"><?= $Page->pangkat->caption() ?></span></td>
        <td data-name="pangkat" <?= $Page->pangkat->cellAttributes() ?>>
<span id="el_v_arsip_skk_pangkat">
<span<?= $Page->pangkat->viewAttributes() ?>>
<?= $Page->pangkat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <tr id="r_jabatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_jabatan"><?= $Page->jabatan->caption() ?></span></td>
        <td data-name="jabatan" <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_v_arsip_skk_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<?= $Page->jabatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
    <tr id="r_unit_organisasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_unit_organisasi"><?= $Page->unit_organisasi->caption() ?></span></td>
        <td data-name="unit_organisasi" <?= $Page->unit_organisasi->cellAttributes() ?>>
<span id="el_v_arsip_skk_unit_organisasi">
<span<?= $Page->unit_organisasi->viewAttributes() ?>>
<?= $Page->unit_organisasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->scan_lhkpn->Visible) { // scan_lhkpn ?>
    <tr id="r_scan_lhkpn">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_scan_lhkpn"><?= $Page->scan_lhkpn->caption() ?></span></td>
        <td data-name="scan_lhkpn" <?= $Page->scan_lhkpn->cellAttributes() ?>>
<span id="el_v_arsip_skk_scan_lhkpn">
<span<?= $Page->scan_lhkpn->viewAttributes() ?>>
<?php if (!EmptyString($Page->scan_lhkpn->getViewValue()) && $Page->scan_lhkpn->linkAttributes() != "") { ?>
<a<?= $Page->scan_lhkpn->linkAttributes() ?>><?= $Page->scan_lhkpn->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->scan_lhkpn->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->scan_lhkasn->Visible) { // scan_lhkasn ?>
    <tr id="r_scan_lhkasn">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_scan_lhkasn"><?= $Page->scan_lhkasn->caption() ?></span></td>
        <td data-name="scan_lhkasn" <?= $Page->scan_lhkasn->cellAttributes() ?>>
<span id="el_v_arsip_skk_scan_lhkasn">
<span<?= $Page->scan_lhkasn->viewAttributes() ?>>
<?php if (!EmptyString($Page->scan_lhkasn->getViewValue()) && $Page->scan_lhkasn->linkAttributes() != "") { ?>
<a<?= $Page->scan_lhkasn->linkAttributes() ?>><?= $Page->scan_lhkasn->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->scan_lhkasn->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategori_pemohon->Visible) { // kategori_pemohon ?>
    <tr id="r_kategori_pemohon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_kategori_pemohon"><?= $Page->kategori_pemohon->caption() ?></span></td>
        <td data-name="kategori_pemohon" <?= $Page->kategori_pemohon->cellAttributes() ?>>
<span id="el_v_arsip_skk_kategori_pemohon">
<span<?= $Page->kategori_pemohon->viewAttributes() ?>>
<?= $Page->kategori_pemohon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hukuman_disiplin->Visible) { // hukuman_disiplin ?>
    <tr id="r_hukuman_disiplin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_hukuman_disiplin"><?= $Page->hukuman_disiplin->caption() ?></span></td>
        <td data-name="hukuman_disiplin" <?= $Page->hukuman_disiplin->cellAttributes() ?>>
<span id="el_v_arsip_skk_hukuman_disiplin">
<span<?= $Page->hukuman_disiplin->viewAttributes() ?>>
<?= $Page->hukuman_disiplin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keperluan->Visible) { // keperluan ?>
    <tr id="r_keperluan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_keperluan"><?= $Page->keperluan->caption() ?></span></td>
        <td data-name="keperluan" <?= $Page->keperluan->cellAttributes() ?>>
<span id="el_v_arsip_skk_keperluan">
<span<?= $Page->keperluan->viewAttributes() ?>>
<?= $Page->keperluan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_v_arsip_skk_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->email_pemohon->Visible) { // email_pemohon ?>
    <tr id="r_email_pemohon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_email_pemohon"><?= $Page->email_pemohon->caption() ?></span></td>
        <td data-name="email_pemohon" <?= $Page->email_pemohon->cellAttributes() ?>>
<span id="el_v_arsip_skk_email_pemohon">
<span<?= $Page->email_pemohon->viewAttributes() ?>>
<?= $Page->email_pemohon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_v_arsip_skk_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->acc->Visible) { // acc ?>
    <tr id="r_acc">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_acc"><?= $Page->acc->caption() ?></span></td>
        <td data-name="acc" <?= $Page->acc->cellAttributes() ?>>
<span id="el_v_arsip_skk_acc">
<span<?= $Page->acc->viewAttributes() ?>>
<?= $Page->acc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hasil_acc->Visible) { // hasil_acc ?>
    <tr id="r_hasil_acc">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_arsip_skk_hasil_acc"><?= $Page->hasil_acc->caption() ?></span></td>
        <td data-name="hasil_acc" <?= $Page->hasil_acc->cellAttributes() ?>>
<span id="el_v_arsip_skk_hasil_acc">
<span<?= $Page->hasil_acc->viewAttributes() ?>>
<?php if (!EmptyString($Page->hasil_acc->getViewValue()) && $Page->hasil_acc->linkAttributes() != "") { ?>
<a<?= $Page->hasil_acc->linkAttributes() ?>><?= $Page->hasil_acc->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->hasil_acc->getViewValue() ?>
<?php } ?>
</span>
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
    // Startup script
    $(".view-file").on("click",(function(){$(this).attr("data-status");let o=$(this).text();$("#modal-popup").modal(),$("#modal-popup .modal-title").text(o),$("#modal-popup .modal-body").empty(),$("#modal-popup .modal-body").append(`<embed src="${base_url}/files/${o}" frameborder="0" width="100%" height="400px">`),$("#modal-popup .modal-dialog").css({width:"auto","max-width":"80%"}),$("#modal-popup .modal-footer").hide()}));
});
</script>
<?php } ?>
