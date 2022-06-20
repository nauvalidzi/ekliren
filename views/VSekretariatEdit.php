<?php

namespace PHPMaker2021\eclearance;

// Page object
$VSekretariatEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fv_sekretariatedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fv_sekretariatedit = currentForm = new ew.Form("fv_sekretariatedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "v_sekretariat")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.v_sekretariat)
        ew.vars.tables.v_sekretariat = currentTable;
    fv_sekretariatedit.addFields([
        ["tanggal_request", [fields.tanggal_request.visible && fields.tanggal_request.required ? ew.Validators.required(fields.tanggal_request.caption) : null], fields.tanggal_request.isInvalid],
        ["nip", [fields.nip.visible && fields.nip.required ? ew.Validators.required(fields.nip.caption) : null], fields.nip.isInvalid],
        ["nrp", [fields.nrp.visible && fields.nrp.required ? ew.Validators.required(fields.nrp.caption) : null], fields.nrp.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["unit_organisasi", [fields.unit_organisasi.visible && fields.unit_organisasi.required ? ew.Validators.required(fields.unit_organisasi.caption) : null], fields.unit_organisasi.isInvalid],
        ["pangkat", [fields.pangkat.visible && fields.pangkat.required ? ew.Validators.required(fields.pangkat.caption) : null], fields.pangkat.isInvalid],
        ["jabatan", [fields.jabatan.visible && fields.jabatan.required ? ew.Validators.required(fields.jabatan.caption) : null], fields.jabatan.isInvalid],
        ["keperluan", [fields.keperluan.visible && fields.keperluan.required ? ew.Validators.required(fields.keperluan.caption) : null], fields.keperluan.isInvalid],
        ["scan_lhkpn", [fields.scan_lhkpn.visible && fields.scan_lhkpn.required ? ew.Validators.required(fields.scan_lhkpn.caption) : null], fields.scan_lhkpn.isInvalid],
        ["scan_lhkasn", [fields.scan_lhkasn.visible && fields.scan_lhkasn.required ? ew.Validators.required(fields.scan_lhkasn.caption) : null], fields.scan_lhkasn.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["nomor_surat", [fields.nomor_surat.visible && fields.nomor_surat.required ? ew.Validators.required(fields.nomor_surat.caption) : null], fields.nomor_surat.isInvalid],
        ["acc", [fields.acc.visible && fields.acc.required ? ew.Validators.required(fields.acc.caption) : null, ew.Validators.datetime(0)], fields.acc.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fv_sekretariatedit,
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
    fv_sekretariatedit.validate = function () {
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
    fv_sekretariatedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fv_sekretariatedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fv_sekretariatedit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fv_sekretariatedit");
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
<form name="fv_sekretariatedit" id="fv_sekretariatedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_sekretariat">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
    <div id="r_tanggal_request" class="form-group row">
        <label id="elh_v_sekretariat_tanggal_request" for="x_tanggal_request" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_request->caption() ?><?= $Page->tanggal_request->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_request->cellAttributes() ?>>
<span id="el_v_sekretariat_tanggal_request">
<span<?= $Page->tanggal_request->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tanggal_request->getDisplayValue($Page->tanggal_request->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_tanggal_request" data-hidden="1" name="x_tanggal_request" id="x_tanggal_request" value="<?= HtmlEncode($Page->tanggal_request->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nip->Visible) { // nip ?>
    <div id="r_nip" class="form-group row">
        <label id="elh_v_sekretariat_nip" for="x_nip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nip->caption() ?><?= $Page->nip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nip->cellAttributes() ?>>
<span id="el_v_sekretariat_nip">
<span<?= $Page->nip->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nip->getDisplayValue($Page->nip->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_nip" data-hidden="1" name="x_nip" id="x_nip" value="<?= HtmlEncode($Page->nip->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nrp->Visible) { // nrp ?>
    <div id="r_nrp" class="form-group row">
        <label id="elh_v_sekretariat_nrp" for="x_nrp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nrp->caption() ?><?= $Page->nrp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nrp->cellAttributes() ?>>
<span id="el_v_sekretariat_nrp">
<span<?= $Page->nrp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nrp->getDisplayValue($Page->nrp->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_nrp" data-hidden="1" name="x_nrp" id="x_nrp" value="<?= HtmlEncode($Page->nrp->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_v_sekretariat_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_v_sekretariat_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nama->getDisplayValue($Page->nama->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_nama" data-hidden="1" name="x_nama" id="x_nama" value="<?= HtmlEncode($Page->nama->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
    <div id="r_unit_organisasi" class="form-group row">
        <label id="elh_v_sekretariat_unit_organisasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unit_organisasi->caption() ?><?= $Page->unit_organisasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->unit_organisasi->cellAttributes() ?>>
<span id="el_v_sekretariat_unit_organisasi">
<span<?= $Page->unit_organisasi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->unit_organisasi->getDisplayValue($Page->unit_organisasi->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_unit_organisasi" data-hidden="1" name="x_unit_organisasi" id="x_unit_organisasi" value="<?= HtmlEncode($Page->unit_organisasi->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pangkat->Visible) { // pangkat ?>
    <div id="r_pangkat" class="form-group row">
        <label id="elh_v_sekretariat_pangkat" for="x_pangkat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pangkat->caption() ?><?= $Page->pangkat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pangkat->cellAttributes() ?>>
<span id="el_v_sekretariat_pangkat">
<span<?= $Page->pangkat->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pangkat->getDisplayValue($Page->pangkat->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_pangkat" data-hidden="1" name="x_pangkat" id="x_pangkat" value="<?= HtmlEncode($Page->pangkat->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <div id="r_jabatan" class="form-group row">
        <label id="elh_v_sekretariat_jabatan" for="x_jabatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatan->caption() ?><?= $Page->jabatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_v_sekretariat_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->jabatan->getDisplayValue($Page->jabatan->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_jabatan" data-hidden="1" name="x_jabatan" id="x_jabatan" value="<?= HtmlEncode($Page->jabatan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keperluan->Visible) { // keperluan ?>
    <div id="r_keperluan" class="form-group row">
        <label id="elh_v_sekretariat_keperluan" for="x_keperluan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keperluan->caption() ?><?= $Page->keperluan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keperluan->cellAttributes() ?>>
<span id="el_v_sekretariat_keperluan">
<span<?= $Page->keperluan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->keperluan->getDisplayValue($Page->keperluan->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_keperluan" data-hidden="1" name="x_keperluan" id="x_keperluan" value="<?= HtmlEncode($Page->keperluan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->scan_lhkpn->Visible) { // scan_lhkpn ?>
    <div id="r_scan_lhkpn" class="form-group row">
        <label id="elh_v_sekretariat_scan_lhkpn" for="x_scan_lhkpn" class="<?= $Page->LeftColumnClass ?>"><?= $Page->scan_lhkpn->caption() ?><?= $Page->scan_lhkpn->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->scan_lhkpn->cellAttributes() ?>>
<span id="el_v_sekretariat_scan_lhkpn">
<span<?= $Page->scan_lhkpn->viewAttributes() ?>>
<?php if (!EmptyString($Page->scan_lhkpn->EditValue) && $Page->scan_lhkpn->linkAttributes() != "") { ?>
<a<?= $Page->scan_lhkpn->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkpn->getDisplayValue($Page->scan_lhkpn->EditValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkpn->getDisplayValue($Page->scan_lhkpn->EditValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_scan_lhkpn" data-hidden="1" name="x_scan_lhkpn" id="x_scan_lhkpn" value="<?= HtmlEncode($Page->scan_lhkpn->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->scan_lhkasn->Visible) { // scan_lhkasn ?>
    <div id="r_scan_lhkasn" class="form-group row">
        <label id="elh_v_sekretariat_scan_lhkasn" for="x_scan_lhkasn" class="<?= $Page->LeftColumnClass ?>"><?= $Page->scan_lhkasn->caption() ?><?= $Page->scan_lhkasn->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->scan_lhkasn->cellAttributes() ?>>
<span id="el_v_sekretariat_scan_lhkasn">
<span<?= $Page->scan_lhkasn->viewAttributes() ?>>
<?php if (!EmptyString($Page->scan_lhkasn->EditValue) && $Page->scan_lhkasn->linkAttributes() != "") { ?>
<a<?= $Page->scan_lhkasn->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkasn->getDisplayValue($Page->scan_lhkasn->EditValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkasn->getDisplayValue($Page->scan_lhkasn->EditValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_scan_lhkasn" data-hidden="1" name="x_scan_lhkasn" id="x_scan_lhkasn" value="<?= HtmlEncode($Page->scan_lhkasn->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_v_sekretariat_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_v_sekretariat_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->keterangan->getDisplayValue($Page->keterangan->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_sekretariat" data-field="x_keterangan" data-hidden="1" name="x_keterangan" id="x_keterangan" value="<?= HtmlEncode($Page->keterangan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nomor_surat->Visible) { // nomor_surat ?>
    <div id="r_nomor_surat" class="form-group row">
        <label id="elh_v_sekretariat_nomor_surat" for="x_nomor_surat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nomor_surat->caption() ?><?= $Page->nomor_surat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nomor_surat->cellAttributes() ?>>
<span id="el_v_sekretariat_nomor_surat">
<input type="<?= $Page->nomor_surat->getInputTextType() ?>" data-table="v_sekretariat" data-field="x_nomor_surat" name="x_nomor_surat" id="x_nomor_surat" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->nomor_surat->getPlaceHolder()) ?>" value="<?= $Page->nomor_surat->EditValue ?>"<?= $Page->nomor_surat->editAttributes() ?> aria-describedby="x_nomor_surat_help">
<?= $Page->nomor_surat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nomor_surat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acc->Visible) { // acc ?>
    <div id="r_acc" class="form-group row">
        <label id="elh_v_sekretariat_acc" for="x_acc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acc->caption() ?><?= $Page->acc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->acc->cellAttributes() ?>>
<span id="el_v_sekretariat_acc">
<input type="<?= $Page->acc->getInputTextType() ?>" data-table="v_sekretariat" data-field="x_acc" name="x_acc" id="x_acc" placeholder="<?= HtmlEncode($Page->acc->getPlaceHolder()) ?>" value="<?= $Page->acc->EditValue ?>"<?= $Page->acc->editAttributes() ?> aria-describedby="x_acc_help">
<?= $Page->acc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->acc->getErrorMessage() ?></div>
<?php if (!$Page->acc->ReadOnly && !$Page->acc->Disabled && !isset($Page->acc->EditAttrs["readonly"]) && !isset($Page->acc->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fv_sekretariatedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fv_sekretariatedit", "x_acc", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_v_sekretariat_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_v_sekretariat_status">
<template id="tp_x_status">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="v_sekretariat" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
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
    data-table="v_sekretariat"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="v_sekretariat" data-field="x_id_request" data-hidden="1" name="x_id_request" id="x_id_request" value="<?= HtmlEncode($Page->id_request->CurrentValue) ?>">
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("hukuman_disiplin", explode(",", $Page->getCurrentDetailTable())) && $hukuman_disiplin->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "hukuman_disiplin") {
            $firstActiveDetailTable = "hukuman_disiplin";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("hukuman_disiplin") ?>" href="#tab_hukuman_disiplin" data-toggle="tab"><?= $Language->tablePhrase("hukuman_disiplin", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("banding", explode(",", $Page->getCurrentDetailTable())) && $banding->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "banding") {
            $firstActiveDetailTable = "banding";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("banding") ?>" href="#tab_banding" data-toggle="tab"><?= $Language->tablePhrase("banding", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("inspeksi", explode(",", $Page->getCurrentDetailTable())) && $inspeksi->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "inspeksi") {
            $firstActiveDetailTable = "inspeksi";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("inspeksi") ?>" href="#tab_inspeksi" data-toggle="tab"><?= $Language->tablePhrase("inspeksi", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("sidang_kode_perilaku", explode(",", $Page->getCurrentDetailTable())) && $sidang_kode_perilaku->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "sidang_kode_perilaku") {
            $firstActiveDetailTable = "sidang_kode_perilaku";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("sidang_kode_perilaku") ?>" href="#tab_sidang_kode_perilaku" data-toggle="tab"><?= $Language->tablePhrase("sidang_kode_perilaku", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("hukuman_disiplin", explode(",", $Page->getCurrentDetailTable())) && $hukuman_disiplin->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "hukuman_disiplin") {
            $firstActiveDetailTable = "hukuman_disiplin";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("hukuman_disiplin") ?>" id="tab_hukuman_disiplin"><!-- page* -->
<?php include_once "HukumanDisiplinGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("banding", explode(",", $Page->getCurrentDetailTable())) && $banding->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "banding") {
            $firstActiveDetailTable = "banding";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("banding") ?>" id="tab_banding"><!-- page* -->
<?php include_once "BandingGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("inspeksi", explode(",", $Page->getCurrentDetailTable())) && $inspeksi->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "inspeksi") {
            $firstActiveDetailTable = "inspeksi";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("inspeksi") ?>" id="tab_inspeksi"><!-- page* -->
<?php include_once "InspeksiGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("sidang_kode_perilaku", explode(",", $Page->getCurrentDetailTable())) && $sidang_kode_perilaku->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "sidang_kode_perilaku") {
            $firstActiveDetailTable = "sidang_kode_perilaku";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("sidang_kode_perilaku") ?>" id="tab_sidang_kode_perilaku"><!-- page* -->
<?php include_once "SidangKodePerilakuGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("v_sekretariat");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    if($("#el_v_sekretariat_scan_lhkpn").length){var lhkpn=$("#el_v_sekretariat_scan_lhkpn input").val();$("#el_v_sekretariat_scan_lhkpn a input").replaceWith(lhkpn),$("#el_v_sekretariat_scan_lhkpn a").attr("href","#modal-popup"),$("#modal-popup .modal-title").text(lhkpn),$("#modal-popup .modal-body").append(`<embed src="${base_url}/files/${lhkpn}" frameborder="0" width="100%" height="400px">`),$("#modal-popup .modal-footer").hide()}if($("#el_v_sekretariat_scan_lhkasn").length){var lhkasn=$("#el_v_sekretariat_scan_lhkasn input").val();$("#el_v_sekretariat_scan_lhkasn a input").replaceWith(lhkasn),$("#el_v_sekretariat_scan_lhkasn a").attr("href","#modal-popup"),$("#modal-popup .modal-title").text(lhkasn),$("#modal-popup .modal-body").append(`<embed src="${base_url}/files/${lhkasn}" frameborder="0" width="100%" height="400px">`),$("#modal-popup .modal-footer").hide()}
});
</script>
