<?php

namespace PHPMaker2021\eclearance;

// Page object
$DataRequestSkkView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fdata_request_skkview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fdata_request_skkview = currentForm = new ew.Form("fdata_request_skkview", "view");
    loadjs.done("fdata_request_skkview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.data_request_skk) ew.vars.tables.data_request_skk = <?= JsonEncode(GetClientVar("tables", "data_request_skk")) ?>;
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
<form name="fdata_request_skkview" id="fdata_request_skkview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="data_request_skk">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_request->Visible) { // id_request ?>
    <tr id="r_id_request">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_id_request"><?= $Page->id_request->caption() ?></span></td>
        <td data-name="id_request" <?= $Page->id_request->cellAttributes() ?>>
<span id="el_data_request_skk_id_request">
<span<?= $Page->id_request->viewAttributes() ?>>
<?= $Page->id_request->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nomor_surat->Visible) { // nomor_surat ?>
    <tr id="r_nomor_surat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_nomor_surat"><?= $Page->nomor_surat->caption() ?></span></td>
        <td data-name="nomor_surat" <?= $Page->nomor_surat->cellAttributes() ?>>
<span id="el_data_request_skk_nomor_surat">
<span<?= $Page->nomor_surat->viewAttributes() ?>>
<?= $Page->nomor_surat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
    <tr id="r_tanggal_request">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_tanggal_request"><?= $Page->tanggal_request->caption() ?></span></td>
        <td data-name="tanggal_request" <?= $Page->tanggal_request->cellAttributes() ?>>
<span id="el_data_request_skk_tanggal_request">
<span<?= $Page->tanggal_request->viewAttributes() ?>>
<?= $Page->tanggal_request->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nrp->Visible) { // nrp ?>
    <tr id="r_nrp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_nrp"><?= $Page->nrp->caption() ?></span></td>
        <td data-name="nrp" <?= $Page->nrp->cellAttributes() ?>>
<span id="el_data_request_skk_nrp">
<span<?= $Page->nrp->viewAttributes() ?>>
<?= $Page->nrp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nip->Visible) { // nip ?>
    <tr id="r_nip">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_nip"><?= $Page->nip->caption() ?></span></td>
        <td data-name="nip" <?= $Page->nip->cellAttributes() ?>>
<span id="el_data_request_skk_nip">
<span<?= $Page->nip->viewAttributes() ?>>
<?= $Page->nip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_data_request_skk_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
    <tr id="r_unit_organisasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_unit_organisasi"><?= $Page->unit_organisasi->caption() ?></span></td>
        <td data-name="unit_organisasi" <?= $Page->unit_organisasi->cellAttributes() ?>>
<span id="el_data_request_skk_unit_organisasi">
<span<?= $Page->unit_organisasi->viewAttributes() ?>>
<?= $Page->unit_organisasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pangkat->Visible) { // pangkat ?>
    <tr id="r_pangkat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_pangkat"><?= $Page->pangkat->caption() ?></span></td>
        <td data-name="pangkat" <?= $Page->pangkat->cellAttributes() ?>>
<span id="el_data_request_skk_pangkat">
<span<?= $Page->pangkat->viewAttributes() ?>>
<?= $Page->pangkat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <tr id="r_jabatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_jabatan"><?= $Page->jabatan->caption() ?></span></td>
        <td data-name="jabatan" <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_data_request_skk_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<?= $Page->jabatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keperluan->Visible) { // keperluan ?>
    <tr id="r_keperluan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_keperluan"><?= $Page->keperluan->caption() ?></span></td>
        <td data-name="keperluan" <?= $Page->keperluan->cellAttributes() ?>>
<span id="el_data_request_skk_keperluan">
<span<?= $Page->keperluan->viewAttributes() ?>>
<?= $Page->keperluan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategori_pemohon->Visible) { // kategori_pemohon ?>
    <tr id="r_kategori_pemohon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_kategori_pemohon"><?= $Page->kategori_pemohon->caption() ?></span></td>
        <td data-name="kategori_pemohon" <?= $Page->kategori_pemohon->cellAttributes() ?>>
<span id="el_data_request_skk_kategori_pemohon">
<span<?= $Page->kategori_pemohon->viewAttributes() ?>>
<?= $Page->kategori_pemohon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->scan_lhkpn->Visible) { // scan_lhkpn ?>
    <tr id="r_scan_lhkpn">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_scan_lhkpn"><?= $Page->scan_lhkpn->caption() ?></span></td>
        <td data-name="scan_lhkpn" <?= $Page->scan_lhkpn->cellAttributes() ?>>
<span id="el_data_request_skk_scan_lhkpn">
<span<?= $Page->scan_lhkpn->viewAttributes() ?>>
<?= GetFileViewTag($Page->scan_lhkpn, $Page->scan_lhkpn->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->scan_lhkasn->Visible) { // scan_lhkasn ?>
    <tr id="r_scan_lhkasn">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_scan_lhkasn"><?= $Page->scan_lhkasn->caption() ?></span></td>
        <td data-name="scan_lhkasn" <?= $Page->scan_lhkasn->cellAttributes() ?>>
<span id="el_data_request_skk_scan_lhkasn">
<span<?= $Page->scan_lhkasn->viewAttributes() ?>>
<?= GetFileViewTag($Page->scan_lhkasn, $Page->scan_lhkasn->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->email_pemohon->Visible) { // email_pemohon ?>
    <tr id="r_email_pemohon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_email_pemohon"><?= $Page->email_pemohon->caption() ?></span></td>
        <td data-name="email_pemohon" <?= $Page->email_pemohon->cellAttributes() ?>>
<span id="el_data_request_skk_email_pemohon">
<span<?= $Page->email_pemohon->viewAttributes() ?>>
<?= $Page->email_pemohon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hukuman_disiplin->Visible) { // hukuman_disiplin ?>
    <tr id="r_hukuman_disiplin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_hukuman_disiplin"><?= $Page->hukuman_disiplin->caption() ?></span></td>
        <td data-name="hukuman_disiplin" <?= $Page->hukuman_disiplin->cellAttributes() ?>>
<span id="el_data_request_skk_hukuman_disiplin">
<span<?= $Page->hukuman_disiplin->viewAttributes() ?>>
<?= $Page->hukuman_disiplin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_data_request_skk_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_data_request_skk_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->acc->Visible) { // acc ?>
    <tr id="r_acc">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_data_request_skk_acc"><?= $Page->acc->caption() ?></span></td>
        <td data-name="acc" <?= $Page->acc->cellAttributes() ?>>
<span id="el_data_request_skk_acc">
<span<?= $Page->acc->viewAttributes() ?>>
<?= $Page->acc->getViewValue() ?></span>
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
