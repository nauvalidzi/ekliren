<?php

namespace PHPMaker2021\eclearance;

// Page object
$VAswasEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fv_aswasedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fv_aswasedit = currentForm = new ew.Form("fv_aswasedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "v_aswas")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.v_aswas)
        ew.vars.tables.v_aswas = currentTable;
    fv_aswasedit.addFields([
        ["tanggal_request", [fields.tanggal_request.visible && fields.tanggal_request.required ? ew.Validators.required(fields.tanggal_request.caption) : null], fields.tanggal_request.isInvalid],
        ["nip", [fields.nip.visible && fields.nip.required ? ew.Validators.required(fields.nip.caption) : null], fields.nip.isInvalid],
        ["nrp", [fields.nrp.visible && fields.nrp.required ? ew.Validators.required(fields.nrp.caption) : null], fields.nrp.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["pangkat", [fields.pangkat.visible && fields.pangkat.required ? ew.Validators.required(fields.pangkat.caption) : null], fields.pangkat.isInvalid],
        ["jabatan", [fields.jabatan.visible && fields.jabatan.required ? ew.Validators.required(fields.jabatan.caption) : null], fields.jabatan.isInvalid],
        ["unit_organisasi", [fields.unit_organisasi.visible && fields.unit_organisasi.required ? ew.Validators.required(fields.unit_organisasi.caption) : null], fields.unit_organisasi.isInvalid],
        ["scan_lhkpn", [fields.scan_lhkpn.visible && fields.scan_lhkpn.required ? ew.Validators.required(fields.scan_lhkpn.caption) : null], fields.scan_lhkpn.isInvalid],
        ["scan_lhkasn", [fields.scan_lhkasn.visible && fields.scan_lhkasn.required ? ew.Validators.required(fields.scan_lhkasn.caption) : null], fields.scan_lhkasn.isInvalid],
        ["kategori_pemohon", [fields.kategori_pemohon.visible && fields.kategori_pemohon.required ? ew.Validators.required(fields.kategori_pemohon.caption) : null], fields.kategori_pemohon.isInvalid],
        ["keperluan", [fields.keperluan.visible && fields.keperluan.required ? ew.Validators.required(fields.keperluan.caption) : null], fields.keperluan.isInvalid],
        ["email_pemohon", [fields.email_pemohon.visible && fields.email_pemohon.required ? ew.Validators.required(fields.email_pemohon.caption) : null], fields.email_pemohon.isInvalid],
        ["hukuman_disiplin", [fields.hukuman_disiplin.visible && fields.hukuman_disiplin.required ? ew.Validators.required(fields.hukuman_disiplin.caption) : null], fields.hukuman_disiplin.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["pernah_dijatuhi_hukuman", [fields.pernah_dijatuhi_hukuman.visible && fields.pernah_dijatuhi_hukuman.required ? ew.Validators.required(fields.pernah_dijatuhi_hukuman.caption) : null], fields.pernah_dijatuhi_hukuman.isInvalid],
        ["jenis_hukuman", [fields.jenis_hukuman.visible && fields.jenis_hukuman.required ? ew.Validators.required(fields.jenis_hukuman.caption) : null], fields.jenis_hukuman.isInvalid],
        ["hukuman", [fields.hukuman.visible && fields.hukuman.required ? ew.Validators.required(fields.hukuman.caption) : null], fields.hukuman.isInvalid],
        ["pasal", [fields.pasal.visible && fields.pasal.required ? ew.Validators.required(fields.pasal.caption) : null], fields.pasal.isInvalid],
        ["surat_keputusan", [fields.surat_keputusan.visible && fields.surat_keputusan.required ? ew.Validators.required(fields.surat_keputusan.caption) : null], fields.surat_keputusan.isInvalid],
        ["sk_nomor", [fields.sk_nomor.visible && fields.sk_nomor.required ? ew.Validators.required(fields.sk_nomor.caption) : null], fields.sk_nomor.isInvalid],
        ["tanggal_sk", [fields.tanggal_sk.visible && fields.tanggal_sk.required ? ew.Validators.required(fields.tanggal_sk.caption) : null], fields.tanggal_sk.isInvalid],
        ["status_hukuman", [fields.status_hukuman.visible && fields.status_hukuman.required ? ew.Validators.required(fields.status_hukuman.caption) : null], fields.status_hukuman.isInvalid],
        ["mengajukan_keberatan_banding", [fields.mengajukan_keberatan_banding.visible && fields.mengajukan_keberatan_banding.required ? ew.Validators.required(fields.mengajukan_keberatan_banding.caption) : null], fields.mengajukan_keberatan_banding.isInvalid],
        ["tgl_sk_banding", [fields.tgl_sk_banding.visible && fields.tgl_sk_banding.required ? ew.Validators.required(fields.tgl_sk_banding.caption) : null], fields.tgl_sk_banding.isInvalid],
        ["inspeksi_kasus", [fields.inspeksi_kasus.visible && fields.inspeksi_kasus.required ? ew.Validators.required(fields.inspeksi_kasus.caption) : null], fields.inspeksi_kasus.isInvalid],
        ["pelanggaran_disiplin", [fields.pelanggaran_disiplin.visible && fields.pelanggaran_disiplin.required ? ew.Validators.required(fields.pelanggaran_disiplin.caption) : null], fields.pelanggaran_disiplin.isInvalid],
        ["sidang_kode_perilaku_jaksa", [fields.sidang_kode_perilaku_jaksa.visible && fields.sidang_kode_perilaku_jaksa.required ? ew.Validators.required(fields.sidang_kode_perilaku_jaksa.caption) : null], fields.sidang_kode_perilaku_jaksa.isInvalid],
        ["tempat_sidang_kode_perilaku", [fields.tempat_sidang_kode_perilaku.visible && fields.tempat_sidang_kode_perilaku.required ? ew.Validators.required(fields.tempat_sidang_kode_perilaku.caption) : null], fields.tempat_sidang_kode_perilaku.isInvalid],
        ["hukuman_administratif", [fields.hukuman_administratif.visible && fields.hukuman_administratif.required ? ew.Validators.required(fields.hukuman_administratif.caption) : null], fields.hukuman_administratif.isInvalid],
        ["sk_nomor_kode_perilaku", [fields.sk_nomor_kode_perilaku.visible && fields.sk_nomor_kode_perilaku.required ? ew.Validators.required(fields.sk_nomor_kode_perilaku.caption) : null], fields.sk_nomor_kode_perilaku.isInvalid],
        ["tgl_sk_kode_perilaku", [fields.tgl_sk_kode_perilaku.visible && fields.tgl_sk_kode_perilaku.required ? ew.Validators.required(fields.tgl_sk_kode_perilaku.caption) : null], fields.tgl_sk_kode_perilaku.isInvalid],
        ["status_hukuman_kode_perilaku", [fields.status_hukuman_kode_perilaku.visible && fields.status_hukuman_kode_perilaku.required ? ew.Validators.required(fields.status_hukuman_kode_perilaku.caption) : null], fields.status_hukuman_kode_perilaku.isInvalid],
        ["sk_banding_nomor", [fields.sk_banding_nomor.visible && fields.sk_banding_nomor.required ? ew.Validators.required(fields.sk_banding_nomor.caption) : null], fields.sk_banding_nomor.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fv_aswasedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fv_aswasedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fv_aswasedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fv_aswasedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fv_aswasedit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fv_aswasedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fv_aswasedit" id="fv_aswasedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_aswas">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div d-none"><!-- page* -->
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
    <div id="r_tanggal_request" class="form-group row">
        <label id="elh_v_aswas_tanggal_request" for="x_tanggal_request" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_tanggal_request"><?= $Page->tanggal_request->caption() ?><?= $Page->tanggal_request->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_request->cellAttributes() ?>>
<template id="tpx_v_aswas_tanggal_request"><span id="el_v_aswas_tanggal_request">
<span<?= $Page->tanggal_request->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tanggal_request->getDisplayValue($Page->tanggal_request->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_tanggal_request" data-hidden="1" name="x_tanggal_request" id="x_tanggal_request" value="<?= HtmlEncode($Page->tanggal_request->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nip->Visible) { // nip ?>
    <div id="r_nip" class="form-group row">
        <label id="elh_v_aswas_nip" for="x_nip" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_nip"><?= $Page->nip->caption() ?><?= $Page->nip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nip->cellAttributes() ?>>
<template id="tpx_v_aswas_nip"><span id="el_v_aswas_nip">
<span<?= $Page->nip->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nip->getDisplayValue($Page->nip->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_nip" data-hidden="1" name="x_nip" id="x_nip" value="<?= HtmlEncode($Page->nip->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nrp->Visible) { // nrp ?>
    <div id="r_nrp" class="form-group row">
        <label id="elh_v_aswas_nrp" for="x_nrp" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_nrp"><?= $Page->nrp->caption() ?><?= $Page->nrp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nrp->cellAttributes() ?>>
<template id="tpx_v_aswas_nrp"><span id="el_v_aswas_nrp">
<span<?= $Page->nrp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nrp->getDisplayValue($Page->nrp->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_nrp" data-hidden="1" name="x_nrp" id="x_nrp" value="<?= HtmlEncode($Page->nrp->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_v_aswas_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_nama"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<template id="tpx_v_aswas_nama"><span id="el_v_aswas_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nama->getDisplayValue($Page->nama->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_nama" data-hidden="1" name="x_nama" id="x_nama" value="<?= HtmlEncode($Page->nama->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pangkat->Visible) { // pangkat ?>
    <div id="r_pangkat" class="form-group row">
        <label id="elh_v_aswas_pangkat" for="x_pangkat" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_pangkat"><?= $Page->pangkat->caption() ?><?= $Page->pangkat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pangkat->cellAttributes() ?>>
<template id="tpx_v_aswas_pangkat"><span id="el_v_aswas_pangkat">
<span<?= $Page->pangkat->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pangkat->getDisplayValue($Page->pangkat->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_pangkat" data-hidden="1" name="x_pangkat" id="x_pangkat" value="<?= HtmlEncode($Page->pangkat->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <div id="r_jabatan" class="form-group row">
        <label id="elh_v_aswas_jabatan" for="x_jabatan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_jabatan"><?= $Page->jabatan->caption() ?><?= $Page->jabatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
<template id="tpx_v_aswas_jabatan"><span id="el_v_aswas_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->jabatan->getDisplayValue($Page->jabatan->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_jabatan" data-hidden="1" name="x_jabatan" id="x_jabatan" value="<?= HtmlEncode($Page->jabatan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
    <div id="r_unit_organisasi" class="form-group row">
        <label id="elh_v_aswas_unit_organisasi" for="x_unit_organisasi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_unit_organisasi"><?= $Page->unit_organisasi->caption() ?><?= $Page->unit_organisasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->unit_organisasi->cellAttributes() ?>>
<template id="tpx_v_aswas_unit_organisasi"><span id="el_v_aswas_unit_organisasi">
<span<?= $Page->unit_organisasi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->unit_organisasi->getDisplayValue($Page->unit_organisasi->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_unit_organisasi" data-hidden="1" name="x_unit_organisasi" id="x_unit_organisasi" value="<?= HtmlEncode($Page->unit_organisasi->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->scan_lhkpn->Visible) { // scan_lhkpn ?>
    <div id="r_scan_lhkpn" class="form-group row">
        <label id="elh_v_aswas_scan_lhkpn" for="x_scan_lhkpn" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_scan_lhkpn"><?= $Page->scan_lhkpn->caption() ?><?= $Page->scan_lhkpn->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->scan_lhkpn->cellAttributes() ?>>
<template id="tpx_v_aswas_scan_lhkpn"><span id="el_v_aswas_scan_lhkpn">
<span<?= $Page->scan_lhkpn->viewAttributes() ?>>
<?php if (!EmptyString($Page->scan_lhkpn->EditValue) && $Page->scan_lhkpn->linkAttributes() != "") { ?>
<a<?= $Page->scan_lhkpn->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkpn->getDisplayValue($Page->scan_lhkpn->EditValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkpn->getDisplayValue($Page->scan_lhkpn->EditValue))) ?>">
<?php } ?>
</span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_scan_lhkpn" data-hidden="1" name="x_scan_lhkpn" id="x_scan_lhkpn" value="<?= HtmlEncode($Page->scan_lhkpn->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->scan_lhkasn->Visible) { // scan_lhkasn ?>
    <div id="r_scan_lhkasn" class="form-group row">
        <label id="elh_v_aswas_scan_lhkasn" for="x_scan_lhkasn" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_scan_lhkasn"><?= $Page->scan_lhkasn->caption() ?><?= $Page->scan_lhkasn->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->scan_lhkasn->cellAttributes() ?>>
<template id="tpx_v_aswas_scan_lhkasn"><span id="el_v_aswas_scan_lhkasn">
<span<?= $Page->scan_lhkasn->viewAttributes() ?>>
<?php if (!EmptyString($Page->scan_lhkasn->EditValue) && $Page->scan_lhkasn->linkAttributes() != "") { ?>
<a<?= $Page->scan_lhkasn->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkasn->getDisplayValue($Page->scan_lhkasn->EditValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkasn->getDisplayValue($Page->scan_lhkasn->EditValue))) ?>">
<?php } ?>
</span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_scan_lhkasn" data-hidden="1" name="x_scan_lhkasn" id="x_scan_lhkasn" value="<?= HtmlEncode($Page->scan_lhkasn->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategori_pemohon->Visible) { // kategori_pemohon ?>
    <div id="r_kategori_pemohon" class="form-group row">
        <label id="elh_v_aswas_kategori_pemohon" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_kategori_pemohon"><?= $Page->kategori_pemohon->caption() ?><?= $Page->kategori_pemohon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategori_pemohon->cellAttributes() ?>>
<template id="tpx_v_aswas_kategori_pemohon"><span id="el_v_aswas_kategori_pemohon">
<span<?= $Page->kategori_pemohon->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->kategori_pemohon->getDisplayValue($Page->kategori_pemohon->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_kategori_pemohon" data-hidden="1" name="x_kategori_pemohon" id="x_kategori_pemohon" value="<?= HtmlEncode($Page->kategori_pemohon->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keperluan->Visible) { // keperluan ?>
    <div id="r_keperluan" class="form-group row">
        <label id="elh_v_aswas_keperluan" for="x_keperluan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_keperluan"><?= $Page->keperluan->caption() ?><?= $Page->keperluan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keperluan->cellAttributes() ?>>
<template id="tpx_v_aswas_keperluan"><span id="el_v_aswas_keperluan">
<span<?= $Page->keperluan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->keperluan->getDisplayValue($Page->keperluan->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_keperluan" data-hidden="1" name="x_keperluan" id="x_keperluan" value="<?= HtmlEncode($Page->keperluan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email_pemohon->Visible) { // email_pemohon ?>
    <div id="r_email_pemohon" class="form-group row">
        <label id="elh_v_aswas_email_pemohon" for="x_email_pemohon" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_email_pemohon"><?= $Page->email_pemohon->caption() ?><?= $Page->email_pemohon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->email_pemohon->cellAttributes() ?>>
<template id="tpx_v_aswas_email_pemohon"><span id="el_v_aswas_email_pemohon">
<span<?= $Page->email_pemohon->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->email_pemohon->getDisplayValue($Page->email_pemohon->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_email_pemohon" data-hidden="1" name="x_email_pemohon" id="x_email_pemohon" value="<?= HtmlEncode($Page->email_pemohon->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hukuman_disiplin->Visible) { // hukuman_disiplin ?>
    <div id="r_hukuman_disiplin" class="form-group row">
        <label id="elh_v_aswas_hukuman_disiplin" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_hukuman_disiplin"><?= $Page->hukuman_disiplin->caption() ?><?= $Page->hukuman_disiplin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hukuman_disiplin->cellAttributes() ?>>
<template id="tpx_v_aswas_hukuman_disiplin"><span id="el_v_aswas_hukuman_disiplin">
<span<?= $Page->hukuman_disiplin->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->hukuman_disiplin->getDisplayValue($Page->hukuman_disiplin->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_hukuman_disiplin" data-hidden="1" name="x_hukuman_disiplin" id="x_hukuman_disiplin" value="<?= HtmlEncode($Page->hukuman_disiplin->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_v_aswas_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_keterangan"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<template id="tpx_v_aswas_keterangan"><span id="el_v_aswas_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->EditValue ?></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_keterangan" data-hidden="1" name="x_keterangan" id="x_keterangan" value="<?= HtmlEncode($Page->keterangan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_v_aswas_status" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_status"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<template id="tpx_v_aswas_status"><span id="el_v_aswas_status">
<template id="tp_x_status">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="v_aswas" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_status" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_status"
    name="x_status"
    value="<?= HtmlEncode($Page->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status"
    data-target="dsl_x_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status->isInvalidClass() ?>"
    data-table="v_aswas"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pernah_dijatuhi_hukuman->Visible) { // pernah_dijatuhi_hukuman ?>
    <div id="r_pernah_dijatuhi_hukuman" class="form-group row">
        <label id="elh_v_aswas_pernah_dijatuhi_hukuman" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_pernah_dijatuhi_hukuman"><?= $Page->pernah_dijatuhi_hukuman->caption() ?><?= $Page->pernah_dijatuhi_hukuman->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pernah_dijatuhi_hukuman->cellAttributes() ?>>
<template id="tpx_v_aswas_pernah_dijatuhi_hukuman"><span id="el_v_aswas_pernah_dijatuhi_hukuman">
<span<?= $Page->pernah_dijatuhi_hukuman->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pernah_dijatuhi_hukuman->getDisplayValue($Page->pernah_dijatuhi_hukuman->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_pernah_dijatuhi_hukuman" data-hidden="1" name="x_pernah_dijatuhi_hukuman" id="x_pernah_dijatuhi_hukuman" value="<?= HtmlEncode($Page->pernah_dijatuhi_hukuman->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenis_hukuman->Visible) { // jenis_hukuman ?>
    <div id="r_jenis_hukuman" class="form-group row">
        <label id="elh_v_aswas_jenis_hukuman" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_jenis_hukuman"><?= $Page->jenis_hukuman->caption() ?><?= $Page->jenis_hukuman->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenis_hukuman->cellAttributes() ?>>
<template id="tpx_v_aswas_jenis_hukuman"><span id="el_v_aswas_jenis_hukuman">
<span<?= $Page->jenis_hukuman->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->jenis_hukuman->getDisplayValue($Page->jenis_hukuman->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_jenis_hukuman" data-hidden="1" name="x_jenis_hukuman" id="x_jenis_hukuman" value="<?= HtmlEncode($Page->jenis_hukuman->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hukuman->Visible) { // hukuman ?>
    <div id="r_hukuman" class="form-group row">
        <label id="elh_v_aswas_hukuman" for="x_hukuman" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_hukuman"><?= $Page->hukuman->caption() ?><?= $Page->hukuman->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hukuman->cellAttributes() ?>>
<template id="tpx_v_aswas_hukuman"><span id="el_v_aswas_hukuman">
<span<?= $Page->hukuman->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->hukuman->getDisplayValue($Page->hukuman->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_hukuman" data-hidden="1" name="x_hukuman" id="x_hukuman" value="<?= HtmlEncode($Page->hukuman->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pasal->Visible) { // pasal ?>
    <div id="r_pasal" class="form-group row">
        <label id="elh_v_aswas_pasal" for="x_pasal" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_pasal"><?= $Page->pasal->caption() ?><?= $Page->pasal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pasal->cellAttributes() ?>>
<template id="tpx_v_aswas_pasal"><span id="el_v_aswas_pasal">
<span<?= $Page->pasal->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pasal->getDisplayValue($Page->pasal->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_pasal" data-hidden="1" name="x_pasal" id="x_pasal" value="<?= HtmlEncode($Page->pasal->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->surat_keputusan->Visible) { // surat_keputusan ?>
    <div id="r_surat_keputusan" class="form-group row">
        <label id="elh_v_aswas_surat_keputusan" for="x_surat_keputusan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_surat_keputusan"><?= $Page->surat_keputusan->caption() ?><?= $Page->surat_keputusan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->surat_keputusan->cellAttributes() ?>>
<template id="tpx_v_aswas_surat_keputusan"><span id="el_v_aswas_surat_keputusan">
<span<?= $Page->surat_keputusan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->surat_keputusan->getDisplayValue($Page->surat_keputusan->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_surat_keputusan" data-hidden="1" name="x_surat_keputusan" id="x_surat_keputusan" value="<?= HtmlEncode($Page->surat_keputusan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sk_nomor->Visible) { // sk_nomor ?>
    <div id="r_sk_nomor" class="form-group row">
        <label id="elh_v_aswas_sk_nomor" for="x_sk_nomor" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_sk_nomor"><?= $Page->sk_nomor->caption() ?><?= $Page->sk_nomor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sk_nomor->cellAttributes() ?>>
<template id="tpx_v_aswas_sk_nomor"><span id="el_v_aswas_sk_nomor">
<span<?= $Page->sk_nomor->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->sk_nomor->getDisplayValue($Page->sk_nomor->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_sk_nomor" data-hidden="1" name="x_sk_nomor" id="x_sk_nomor" value="<?= HtmlEncode($Page->sk_nomor->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_sk->Visible) { // tanggal_sk ?>
    <div id="r_tanggal_sk" class="form-group row">
        <label id="elh_v_aswas_tanggal_sk" for="x_tanggal_sk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_tanggal_sk"><?= $Page->tanggal_sk->caption() ?><?= $Page->tanggal_sk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_sk->cellAttributes() ?>>
<template id="tpx_v_aswas_tanggal_sk"><span id="el_v_aswas_tanggal_sk">
<span<?= $Page->tanggal_sk->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tanggal_sk->getDisplayValue($Page->tanggal_sk->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_tanggal_sk" data-hidden="1" name="x_tanggal_sk" id="x_tanggal_sk" value="<?= HtmlEncode($Page->tanggal_sk->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_hukuman->Visible) { // status_hukuman ?>
    <div id="r_status_hukuman" class="form-group row">
        <label id="elh_v_aswas_status_hukuman" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_status_hukuman"><?= $Page->status_hukuman->caption() ?><?= $Page->status_hukuman->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_hukuman->cellAttributes() ?>>
<template id="tpx_v_aswas_status_hukuman"><span id="el_v_aswas_status_hukuman">
<span<?= $Page->status_hukuman->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->status_hukuman->getDisplayValue($Page->status_hukuman->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_status_hukuman" data-hidden="1" name="x_status_hukuman" id="x_status_hukuman" value="<?= HtmlEncode($Page->status_hukuman->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mengajukan_keberatan_banding->Visible) { // mengajukan_keberatan_banding ?>
    <div id="r_mengajukan_keberatan_banding" class="form-group row">
        <label id="elh_v_aswas_mengajukan_keberatan_banding" for="x_mengajukan_keberatan_banding" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_mengajukan_keberatan_banding"><?= $Page->mengajukan_keberatan_banding->caption() ?><?= $Page->mengajukan_keberatan_banding->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mengajukan_keberatan_banding->cellAttributes() ?>>
<template id="tpx_v_aswas_mengajukan_keberatan_banding"><span id="el_v_aswas_mengajukan_keberatan_banding">
<span<?= $Page->mengajukan_keberatan_banding->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->mengajukan_keberatan_banding->getDisplayValue($Page->mengajukan_keberatan_banding->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_mengajukan_keberatan_banding" data-hidden="1" name="x_mengajukan_keberatan_banding" id="x_mengajukan_keberatan_banding" value="<?= HtmlEncode($Page->mengajukan_keberatan_banding->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_sk_banding->Visible) { // tgl_sk_banding ?>
    <div id="r_tgl_sk_banding" class="form-group row">
        <label id="elh_v_aswas_tgl_sk_banding" for="x_tgl_sk_banding" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_tgl_sk_banding"><?= $Page->tgl_sk_banding->caption() ?><?= $Page->tgl_sk_banding->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_sk_banding->cellAttributes() ?>>
<template id="tpx_v_aswas_tgl_sk_banding"><span id="el_v_aswas_tgl_sk_banding">
<span<?= $Page->tgl_sk_banding->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tgl_sk_banding->getDisplayValue($Page->tgl_sk_banding->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_tgl_sk_banding" data-hidden="1" name="x_tgl_sk_banding" id="x_tgl_sk_banding" value="<?= HtmlEncode($Page->tgl_sk_banding->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->inspeksi_kasus->Visible) { // inspeksi_kasus ?>
    <div id="r_inspeksi_kasus" class="form-group row">
        <label id="elh_v_aswas_inspeksi_kasus" for="x_inspeksi_kasus" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_inspeksi_kasus"><?= $Page->inspeksi_kasus->caption() ?><?= $Page->inspeksi_kasus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->inspeksi_kasus->cellAttributes() ?>>
<template id="tpx_v_aswas_inspeksi_kasus"><span id="el_v_aswas_inspeksi_kasus">
<span<?= $Page->inspeksi_kasus->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->inspeksi_kasus->getDisplayValue($Page->inspeksi_kasus->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_inspeksi_kasus" data-hidden="1" name="x_inspeksi_kasus" id="x_inspeksi_kasus" value="<?= HtmlEncode($Page->inspeksi_kasus->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pelanggaran_disiplin->Visible) { // pelanggaran_disiplin ?>
    <div id="r_pelanggaran_disiplin" class="form-group row">
        <label id="elh_v_aswas_pelanggaran_disiplin" for="x_pelanggaran_disiplin" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_pelanggaran_disiplin"><?= $Page->pelanggaran_disiplin->caption() ?><?= $Page->pelanggaran_disiplin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pelanggaran_disiplin->cellAttributes() ?>>
<template id="tpx_v_aswas_pelanggaran_disiplin"><span id="el_v_aswas_pelanggaran_disiplin">
<span<?= $Page->pelanggaran_disiplin->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pelanggaran_disiplin->getDisplayValue($Page->pelanggaran_disiplin->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_pelanggaran_disiplin" data-hidden="1" name="x_pelanggaran_disiplin" id="x_pelanggaran_disiplin" value="<?= HtmlEncode($Page->pelanggaran_disiplin->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sidang_kode_perilaku_jaksa->Visible) { // sidang_kode_perilaku_jaksa ?>
    <div id="r_sidang_kode_perilaku_jaksa" class="form-group row">
        <label id="elh_v_aswas_sidang_kode_perilaku_jaksa" for="x_sidang_kode_perilaku_jaksa" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_sidang_kode_perilaku_jaksa"><?= $Page->sidang_kode_perilaku_jaksa->caption() ?><?= $Page->sidang_kode_perilaku_jaksa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sidang_kode_perilaku_jaksa->cellAttributes() ?>>
<template id="tpx_v_aswas_sidang_kode_perilaku_jaksa"><span id="el_v_aswas_sidang_kode_perilaku_jaksa">
<span<?= $Page->sidang_kode_perilaku_jaksa->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->sidang_kode_perilaku_jaksa->getDisplayValue($Page->sidang_kode_perilaku_jaksa->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_sidang_kode_perilaku_jaksa" data-hidden="1" name="x_sidang_kode_perilaku_jaksa" id="x_sidang_kode_perilaku_jaksa" value="<?= HtmlEncode($Page->sidang_kode_perilaku_jaksa->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tempat_sidang_kode_perilaku->Visible) { // tempat_sidang_kode_perilaku ?>
    <div id="r_tempat_sidang_kode_perilaku" class="form-group row">
        <label id="elh_v_aswas_tempat_sidang_kode_perilaku" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_tempat_sidang_kode_perilaku"><?= $Page->tempat_sidang_kode_perilaku->caption() ?><?= $Page->tempat_sidang_kode_perilaku->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tempat_sidang_kode_perilaku->cellAttributes() ?>>
<template id="tpx_v_aswas_tempat_sidang_kode_perilaku"><span id="el_v_aswas_tempat_sidang_kode_perilaku">
<span<?= $Page->tempat_sidang_kode_perilaku->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tempat_sidang_kode_perilaku->getDisplayValue($Page->tempat_sidang_kode_perilaku->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_tempat_sidang_kode_perilaku" data-hidden="1" name="x_tempat_sidang_kode_perilaku" id="x_tempat_sidang_kode_perilaku" value="<?= HtmlEncode($Page->tempat_sidang_kode_perilaku->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hukuman_administratif->Visible) { // hukuman_administratif ?>
    <div id="r_hukuman_administratif" class="form-group row">
        <label id="elh_v_aswas_hukuman_administratif" for="x_hukuman_administratif" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_hukuman_administratif"><?= $Page->hukuman_administratif->caption() ?><?= $Page->hukuman_administratif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hukuman_administratif->cellAttributes() ?>>
<template id="tpx_v_aswas_hukuman_administratif"><span id="el_v_aswas_hukuman_administratif">
<span<?= $Page->hukuman_administratif->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->hukuman_administratif->getDisplayValue($Page->hukuman_administratif->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_hukuman_administratif" data-hidden="1" name="x_hukuman_administratif" id="x_hukuman_administratif" value="<?= HtmlEncode($Page->hukuman_administratif->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sk_nomor_kode_perilaku->Visible) { // sk_nomor_kode_perilaku ?>
    <div id="r_sk_nomor_kode_perilaku" class="form-group row">
        <label id="elh_v_aswas_sk_nomor_kode_perilaku" for="x_sk_nomor_kode_perilaku" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_sk_nomor_kode_perilaku"><?= $Page->sk_nomor_kode_perilaku->caption() ?><?= $Page->sk_nomor_kode_perilaku->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sk_nomor_kode_perilaku->cellAttributes() ?>>
<template id="tpx_v_aswas_sk_nomor_kode_perilaku"><span id="el_v_aswas_sk_nomor_kode_perilaku">
<span<?= $Page->sk_nomor_kode_perilaku->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->sk_nomor_kode_perilaku->getDisplayValue($Page->sk_nomor_kode_perilaku->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_sk_nomor_kode_perilaku" data-hidden="1" name="x_sk_nomor_kode_perilaku" id="x_sk_nomor_kode_perilaku" value="<?= HtmlEncode($Page->sk_nomor_kode_perilaku->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_sk_kode_perilaku->Visible) { // tgl_sk_kode_perilaku ?>
    <div id="r_tgl_sk_kode_perilaku" class="form-group row">
        <label id="elh_v_aswas_tgl_sk_kode_perilaku" for="x_tgl_sk_kode_perilaku" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_tgl_sk_kode_perilaku"><?= $Page->tgl_sk_kode_perilaku->caption() ?><?= $Page->tgl_sk_kode_perilaku->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_sk_kode_perilaku->cellAttributes() ?>>
<template id="tpx_v_aswas_tgl_sk_kode_perilaku"><span id="el_v_aswas_tgl_sk_kode_perilaku">
<span<?= $Page->tgl_sk_kode_perilaku->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tgl_sk_kode_perilaku->getDisplayValue($Page->tgl_sk_kode_perilaku->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_tgl_sk_kode_perilaku" data-hidden="1" name="x_tgl_sk_kode_perilaku" id="x_tgl_sk_kode_perilaku" value="<?= HtmlEncode($Page->tgl_sk_kode_perilaku->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_hukuman_kode_perilaku->Visible) { // status_hukuman_kode_perilaku ?>
    <div id="r_status_hukuman_kode_perilaku" class="form-group row">
        <label id="elh_v_aswas_status_hukuman_kode_perilaku" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_status_hukuman_kode_perilaku"><?= $Page->status_hukuman_kode_perilaku->caption() ?><?= $Page->status_hukuman_kode_perilaku->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_hukuman_kode_perilaku->cellAttributes() ?>>
<template id="tpx_v_aswas_status_hukuman_kode_perilaku"><span id="el_v_aswas_status_hukuman_kode_perilaku">
<span<?= $Page->status_hukuman_kode_perilaku->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->status_hukuman_kode_perilaku->getDisplayValue($Page->status_hukuman_kode_perilaku->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_status_hukuman_kode_perilaku" data-hidden="1" name="x_status_hukuman_kode_perilaku" id="x_status_hukuman_kode_perilaku" value="<?= HtmlEncode($Page->status_hukuman_kode_perilaku->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sk_banding_nomor->Visible) { // sk_banding_nomor ?>
    <div id="r_sk_banding_nomor" class="form-group row">
        <label id="elh_v_aswas_sk_banding_nomor" for="x_sk_banding_nomor" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_v_aswas_sk_banding_nomor"><?= $Page->sk_banding_nomor->caption() ?><?= $Page->sk_banding_nomor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sk_banding_nomor->cellAttributes() ?>>
<template id="tpx_v_aswas_sk_banding_nomor"><span id="el_v_aswas_sk_banding_nomor">
<span<?= $Page->sk_banding_nomor->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->sk_banding_nomor->getDisplayValue($Page->sk_banding_nomor->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="v_aswas" data-field="x_sk_banding_nomor" data-hidden="1" name="x_sk_banding_nomor" id="x_sk_banding_nomor" value="<?= HtmlEncode($Page->sk_banding_nomor->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="v_aswas" data-field="x_id_request" data-hidden="1" name="x_id_request" id="x_id_request" value="<?= HtmlEncode($Page->id_request->CurrentValue) ?>">
<div id="tpd_v_aswasedit" class="ew-custom-template"></div>
<template id="tpm_v_aswasedit">
<div id="ct_VAswasEdit"><div class="container">
    <div id="r_tanggal_request" class="form-group row">
        <label id="elh_tanggal_request" for="x_tanggal_request" class="col-sm-2 control-label ewLabel"><?= $Page->tanggal_request->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_tanggal_request"></slot></div>
    </div>
    <div id="r_unit_organisasi" class="form-group row">
        <label id="elh_unit_organisasi" for="x_unit_organisasi" class="col-sm-2 control-label ewLabel"><?= $Page->unit_organisasi->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_unit_organisasi"></slot></div>
    </div>
    <div id="r_nama" class="form-group row">
        <label id="elh_nama" for="x_nama" class="col-sm-2 control-label ewLabel"><?= $Page->nama->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_nama"></slot></div>
    </div>
    <div id="r_nip" class="form-group row">
        <label id="elh_nip" for="x_nip" class="col-sm-2 control-label ewLabel"><?= $Page->nip->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_nip"></slot></div>
    </div>
    <div id="r_nrp" class="form-group row">
        <label id="elh_nrp" for="x_nrp" class="col-sm-2 control-label ewLabel"><?= $Page->nrp->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_nrp"></slot></div>
    </div>
    <div id="r_pangkat" class="form-group row">
        <label id="elh_pangkat" for="x_pangkat" class="col-sm-2 control-label ewLabel"><?= $Page->pangkat->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_pangkat"></slot></div>
    </div>
    <div id="r_jabatan" class="form-group row">
        <label id="elh_jabatan" for="x_jabatan" class="col-sm-2 control-label ewLabel"><?= $Page->jabatan->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_jabatan"></slot></div>
    </div>    
    {{if kategori_pemohon == "Wajib LHKPN" }}
    <div id="r_scan_lhkpn" class="form-group row">
        <label id="elh_scan_lhkpn" for="x_scan_lhkpn" class="col-sm-2 control-label ewLabel"><?= $Page->scan_lhkpn->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_scan_lhkpn"></slot></div>
    </div>
    {{else}}
    <div id="r_scan_lhkasn" class="form-group row">
        <label id="elh_scan_lhkasn" for="x_scan_lhkasn" class="col-sm-2 control-label ewLabel"><?= $Page->scan_lhkasn->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_scan_lhkasn"></slot></div>
    </div>
    {{/if}}
    <div id="r_keperluan" class="form-group row">
        <label id="elh_keperluan" for="x_keperluan" class="col-sm-2 control-label ewLabel"><?= $Page->keperluan->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_keperluan"></slot></div>
    </div>
    <div id="r_email_pemohon" class="form-group row">
        <label id="elh_email_pemohon" for="x_email_pemohon" class="col-sm-2 control-label ewLabel"><?= $Page->email_pemohon->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_email_pemohon"></slot></div>
    </div>
    <div id="r_hukuman_disiplin" class="form-group row">
        <label id="elh_hukuman_disiplin" for="x_hukuman_disiplin" class="col-sm-2 control-label ewLabel"><?= $Page->hukuman_disiplin->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_hukuman_disiplin"></slot></div>
    </div>
    {{if hukuman_disiplin != "Tidak" }}
    <div id="r_keterangan" class="form-group row">
        <label id="elh_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?= $Page->keterangan->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_v_aswas_keterangan"></slot></div>
    </div>
    {{/if}}
    <div class="card shadow">
        <div class="card-header">
            <div class="card-title">Hukuman Disiplin</div>
        </div>
        <div class="card-body">
            <div id="r_pernah_dijatuhi_hukuman" class="form-group row">
                <label id="elh_pernah_dijatuhi_hukuman" for="x_pernah_dijatuhi_hukuman" class="col-sm-3 control-label ewLabel"><?= $Page->pernah_dijatuhi_hukuman->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_pernah_dijatuhi_hukuman"></slot></div>
            </div>
            {{if pernah_dijatuhi_hukuman != "Tidak" }}
            <div id="r_jenis_hukuman" class="form-group row">
                <label id="elh_jenis_hukuman" for="x_jenis_hukuman" class="col-sm-3 control-label ewLabel"><?= $Page->jenis_hukuman->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_jenis_hukuman"></slot></div>
            </div>
            <div id="r_hukuman" class="form-group row">
                <label id="elh_hukuman" for="x_hukuman" class="col-sm-3 control-label ewLabel"><?= $Page->hukuman->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_hukuman"></slot></div>
            </div>
            <div id="r_pasal" class="form-group row">
                <label id="elh_pasal" for="x_pasal" class="col-sm-3 control-label ewLabel"><?= $Page->pasal->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_pasal"></slot></div>
            </div>
            <div id="r_surat_keputusan" class="form-group row">
                <label id="elh_surat_keputusan" for="x_surat_keputusan" class="col-sm-3 control-label ewLabel"><?= $Page->surat_keputusan->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_surat_keputusan"></slot></div>
            </div>
            <div id="r_sk_nomor" class="form-group row">
                <label id="elh_sk_nomor" for="x_sk_nomor" class="col-sm-3 control-label ewLabel"><?= $Page->sk_nomor->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_sk_nomor"></slot></div>
            </div>
            <div id="r_tanggal_sk" class="form-group row">
                <label id="elh_tanggal_sk" for="x_tanggal_sk" class="col-sm-3 control-label ewLabel"><?= $Page->tanggal_sk->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_tanggal_sk"></slot></div>
            </div>
            <div id="r_status_hukuman" class="form-group row">
                <label id="elh_status_hukuman" for="x_status_hukuman" class="col-sm-3 control-label ewLabel"><?= $Page->status_hukuman->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_status_hukuman"></slot></div>
            </div>
            <div id="r_mengajukan_keberatan_banding" class="form-group row">
                <label id="elh_mengajukan_keberatan_banding" for="x_mengajukan_keberatan_banding" class="col-sm-3 control-label ewLabel"><?= $Page->mengajukan_keberatan_banding->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_mengajukan_keberatan_banding"></slot></div>
            </div>
            {{/if}}
        </div>
    </div>
    <div class="card shadow">
        <div class="card-header">
            <div class="card-title">Banding Administrasi</div>
        </div>
        <div class="card-body">
            <div id="r_mengajukan_keberatan_banding" class="form-group row">
                <label id="elh_mengajukan_keberatan_banding" for="x_mengajukan_keberatan_banding" class="col-sm-3 control-label ewLabel"><?= $Page->mengajukan_keberatan_banding->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_mengajukan_keberatan_banding"></slot></div>
            </div>
            {{if mengajukan_keberatan_banding != "Tidak" }}
            <div id="r_sk_banding_nomor" class="form-group row">
                <label id="elh_sk_banding_nomor" for="x_sk_banding_nomor" class="col-sm-3 control-label ewLabel">
                    <slot class="ew-slot" name="tpcaption_sk_bandng_nomor"></slot></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_sk_bandng_nomor"></slot></div>
            </div>      
            <div id="r_tgl_sk_banding" class="form-group row">
                <label id="elh_tgl_sk_banding" for="x_tgl_sk_banding" class="col-sm-3 control-label ewLabel">
                    <?= $Page->tgl_sk_banding->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_tgl_sk_banding"></slot></div>
            </div>
            {{/if}}
        </div>
    </div>
    <div class="card shadow">
        <div class="card-header">
            <div class="card-title">Inspeksi Kasus</div>
        </div>
        <div class="card-body">
            <div id="r_inspeksi_kasus" class="form-group row">
                <label id="elh_inspeksi_kasus" for="x_inspeksi_kasus" class="col-sm-3 control-label ewLabel"><?= $Page->inspeksi_kasus->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_inspeksi_kasus"></slot></div>
            </div>
            {{if inspeksi_kasus != "Tidak" }}
            <div id="r_pelanggaran_disiplin" class="form-group row">
                <label id="elh_pelanggaran_disiplin" for="x_pelanggaran_disiplin" class="col-sm-3 control-label ewLabel"><?= $Page->pelanggaran_disiplin->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_pelanggaran_disiplin"></slot></div>
            </div>
            {{/if}}
        </div>
    </div>
    <div class="card shadow">
        <div class="card-header">
            <div class="card-title">Sidang Kode Perilaku</div>
        </div>
        <div class="card-body">
            <div id="r_sidang_kode_perilaku_jaksa" class="form-group row">
                <label id="elh_sidang_kode_perilaku_jaksa" for="x_sidang_kode_perilaku_jaksa" class="col-sm-3 control-label ewLabel">
                    <?= $Page->sidang_kode_perilaku_jaksa->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_sidang_kode_perilaku_jaksa"></slot></div>
            </div>
            {{if sidang_kode_perilaku_jaksa != "Tidak" }}
            <div id="r_tempat_sidang_kode_perilaku" class="form-group row">
                <label id="elh_tempat_sidang_kode_perilaku" for="x_tempat_sidang_kode_perilaku" class="col-sm-3 control-label ewLabel"><?= $Page->tempat_sidang_kode_perilaku->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_tempat_sidang_kode_perilaku"></slot></div>
            </div>
            <div id="r_hukuman_administratif" class="form-group row">
                <label id="elh_hukuman_administratif" for="x_hukuman_administratif" class="col-sm-3 control-label ewLabel"><?= $Page->hukuman_administratif->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_hukuman_administratif"></slot></div>
            </div>
            <div id="r_sk_nomor_kode_perilaku" class="form-group row">
                <label id="elh_sk_nomor_kode_perilaku" for="x_sk_nomor_kode_perilaku" class="col-sm-3 control-label ewLabel"><?= $Page->sk_nomor_kode_perilaku->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_sk_nomor_kode_perilaku"></slot></div>
            </div>
            <div id="r_tgl_sk_kode_perilaku" class="form-group row">
                <label id="elh_tgl_sk_kode_perilaku" for="x_tgl_sk_kode_perilaku" class="col-sm-3 control-label ewLabel"><?= $Page->tgl_sk_kode_perilaku->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_tgl_sk_kode_perilaku"></slot></div>
            </div>
            <div id="r_status_hukuman_kode_perilaku" class="form-group row">
                <label id="elh_status_hukuman_kode_perilaku" for="x_status_hukuman_kode_perilaku" class="col-sm-3 control-label ewLabel"><?= $Page->status_hukuman_kode_perilaku->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_status_hukuman_kode_perilaku"></slot></div>
            </div>
            {{/if}}
        </div>
    </div>
    <div class="card shadow">
        <div class="card-header">
            <div class="card-title">ACC Request</div>
        </div>
        <div class="card-body">
            <div id="r_status" class="form-group row">
                <label id="elh_status" for="x_status" class="col-sm-3 control-label ewLabel"><?= $Page->status->caption() ?></label>
                <div class="col-sm-9"><slot class="ew-slot" name="tpx_v_aswas_status"></slot></div>
            </div>             
        </div>
    </div>
</div>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_v_aswasedit", "tpm_v_aswasedit", "v_aswasedit", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("v_aswas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    if($(document).ready((function(){var a=$("input[data-field='x_pernah_dijatuhi_hukuman']").val();"Tidak"==a||""==a?$("div[class=input_hukuman]").css({display:"none"}):$("div[class=input_hukuman]").removeAttr("style");var s=$("input[data-field='x_mengajukan_keberatan_banding']").val();"Tidak"==s||""==s?$("div[class=banding]").css({display:"none"}):$("div[class=banding]").removeAttr("style");var l=$("input[data-field='x_inspeksi_kasus']").val();"Tidak"==l||""==l?$("div[class=inspeksi_kasus]").css({display:"none"}):$("div[class=inspeksi_kasus]").removeAttr("style");var e=$("input[data-field='x_sidang_kode_perilaku_jaksa']").val();"Tidak"==e||""==e?$("div[class=sidang_kode_perilaku]").css({display:"none"}):$("div[class=sidang_kode_perilaku]").removeAttr("style")})),$("#el_v_aswas_scan_lhkpn").length){var lhkpn=$("#el_v_aswas_scan_lhkpn input").val();$("#el_v_aswas_scan_lhkpn span input").replaceWith(`<a href="#modal-popup" data-toggle="modal">${lhkpn}</a>`),$("#modal-popup .modal-title").text(lhkpn),$("#modal-popup .modal-body").append(`<embed src="${base_url}/files/${lhkpn}" frameborder="0" width="100%" height="400px">`),$("#modal-popup .modal-footer").hide()}if($("#el_v_aswas_scan_lhkasn").length){var lhkasn=$("#el_v_aswas_scan_lhkasn input").val();$("#el_v_aswas_scan_lhkpn span input").replaceWith(`<a href="#modal-popup" data-toggle="modal">${lhkasn}</a>`),$("#modal-popup .modal-title").text(lhkasn),$("#modal-popup .modal-body").append(`<embed src="${base_url}/files/${lhkasn}" frameborder="0" width="100%" height="400px">`),$("#modal-popup .modal-footer").hide()}
});
</script>
