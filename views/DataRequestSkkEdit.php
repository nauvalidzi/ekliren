<?php

namespace PHPMaker2021\eclearance;

// Page object
$DataRequestSkkEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fdata_request_skkedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fdata_request_skkedit = currentForm = new ew.Form("fdata_request_skkedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "data_request_skk")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.data_request_skk)
        ew.vars.tables.data_request_skk = currentTable;
    fdata_request_skkedit.addFields([
        ["id_request", [fields.id_request.visible && fields.id_request.required ? ew.Validators.required(fields.id_request.caption) : null], fields.id_request.isInvalid],
        ["tanggal_request", [fields.tanggal_request.visible && fields.tanggal_request.required ? ew.Validators.required(fields.tanggal_request.caption) : null], fields.tanggal_request.isInvalid],
        ["nrp", [fields.nrp.visible && fields.nrp.required ? ew.Validators.required(fields.nrp.caption) : null], fields.nrp.isInvalid],
        ["nip", [fields.nip.visible && fields.nip.required ? ew.Validators.required(fields.nip.caption) : null], fields.nip.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["unit_organisasi", [fields.unit_organisasi.visible && fields.unit_organisasi.required ? ew.Validators.required(fields.unit_organisasi.caption) : null], fields.unit_organisasi.isInvalid],
        ["pangkat", [fields.pangkat.visible && fields.pangkat.required ? ew.Validators.required(fields.pangkat.caption) : null], fields.pangkat.isInvalid],
        ["jabatan", [fields.jabatan.visible && fields.jabatan.required ? ew.Validators.required(fields.jabatan.caption) : null], fields.jabatan.isInvalid],
        ["keperluan", [fields.keperluan.visible && fields.keperluan.required ? ew.Validators.required(fields.keperluan.caption) : null], fields.keperluan.isInvalid],
        ["kategori_pemohon", [fields.kategori_pemohon.visible && fields.kategori_pemohon.required ? ew.Validators.required(fields.kategori_pemohon.caption) : null], fields.kategori_pemohon.isInvalid],
        ["scan_lhkpn", [fields.scan_lhkpn.visible && fields.scan_lhkpn.required ? ew.Validators.fileRequired(fields.scan_lhkpn.caption) : null], fields.scan_lhkpn.isInvalid],
        ["scan_lhkasn", [fields.scan_lhkasn.visible && fields.scan_lhkasn.required ? ew.Validators.fileRequired(fields.scan_lhkasn.caption) : null], fields.scan_lhkasn.isInvalid],
        ["email_pemohon", [fields.email_pemohon.visible && fields.email_pemohon.required ? ew.Validators.required(fields.email_pemohon.caption) : null, ew.Validators.email], fields.email_pemohon.isInvalid],
        ["hukuman_disiplin", [fields.hukuman_disiplin.visible && fields.hukuman_disiplin.required ? ew.Validators.required(fields.hukuman_disiplin.caption) : null], fields.hukuman_disiplin.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fdata_request_skkedit,
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
    fdata_request_skkedit.validate = function () {
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
    fdata_request_skkedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdata_request_skkedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fdata_request_skkedit.lists.unit_organisasi = <?= $Page->unit_organisasi->toClientList($Page) ?>;
    fdata_request_skkedit.lists.pangkat = <?= $Page->pangkat->toClientList($Page) ?>;
    fdata_request_skkedit.lists.jabatan = <?= $Page->jabatan->toClientList($Page) ?>;
    fdata_request_skkedit.lists.keperluan = <?= $Page->keperluan->toClientList($Page) ?>;
    fdata_request_skkedit.lists.kategori_pemohon = <?= $Page->kategori_pemohon->toClientList($Page) ?>;
    fdata_request_skkedit.lists.hukuman_disiplin = <?= $Page->hukuman_disiplin->toClientList($Page) ?>;
    loadjs.done("fdata_request_skkedit");
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
<form name="fdata_request_skkedit" id="fdata_request_skkedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="data_request_skk">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_request->Visible) { // id_request ?>
    <div id="r_id_request" class="form-group row">
        <label id="elh_data_request_skk_id_request" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_request->caption() ?><?= $Page->id_request->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_request->cellAttributes() ?>>
<span id="el_data_request_skk_id_request">
<span<?= $Page->id_request->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_request->getDisplayValue($Page->id_request->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="data_request_skk" data-field="x_id_request" data-hidden="1" name="x_id_request" id="x_id_request" value="<?= HtmlEncode($Page->id_request->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nrp->Visible) { // nrp ?>
    <div id="r_nrp" class="form-group row">
        <label id="elh_data_request_skk_nrp" for="x_nrp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nrp->caption() ?><?= $Page->nrp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nrp->cellAttributes() ?>>
<span id="el_data_request_skk_nrp">
<input type="<?= $Page->nrp->getInputTextType() ?>" data-table="data_request_skk" data-field="x_nrp" name="x_nrp" id="x_nrp" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nrp->getPlaceHolder()) ?>" value="<?= $Page->nrp->EditValue ?>"<?= $Page->nrp->editAttributes() ?> aria-describedby="x_nrp_help">
<?= $Page->nrp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nrp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nip->Visible) { // nip ?>
    <div id="r_nip" class="form-group row">
        <label id="elh_data_request_skk_nip" for="x_nip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nip->caption() ?><?= $Page->nip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nip->cellAttributes() ?>>
<span id="el_data_request_skk_nip">
<input type="<?= $Page->nip->getInputTextType() ?>" data-table="data_request_skk" data-field="x_nip" name="x_nip" id="x_nip" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nip->getPlaceHolder()) ?>" value="<?= $Page->nip->EditValue ?>"<?= $Page->nip->editAttributes() ?> aria-describedby="x_nip_help">
<?= $Page->nip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_data_request_skk_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_data_request_skk_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="data_request_skk" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
    <div id="r_unit_organisasi" class="form-group row">
        <label id="elh_data_request_skk_unit_organisasi" for="x_unit_organisasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unit_organisasi->caption() ?><?= $Page->unit_organisasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->unit_organisasi->cellAttributes() ?>>
<span id="el_data_request_skk_unit_organisasi">
    <select
        id="x_unit_organisasi"
        name="x_unit_organisasi"
        class="form-control ew-select<?= $Page->unit_organisasi->isInvalidClass() ?>"
        data-select2-id="data_request_skk_x_unit_organisasi"
        data-table="data_request_skk"
        data-field="x_unit_organisasi"
        data-value-separator="<?= $Page->unit_organisasi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->unit_organisasi->getPlaceHolder()) ?>"
        <?= $Page->unit_organisasi->editAttributes() ?>>
        <?= $Page->unit_organisasi->selectOptionListHtml("x_unit_organisasi") ?>
    </select>
    <?= $Page->unit_organisasi->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->unit_organisasi->getErrorMessage() ?></div>
<?= $Page->unit_organisasi->Lookup->getParamTag($Page, "p_x_unit_organisasi") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='data_request_skk_x_unit_organisasi']"),
        options = { name: "x_unit_organisasi", selectId: "data_request_skk_x_unit_organisasi", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.data_request_skk.fields.unit_organisasi.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pangkat->Visible) { // pangkat ?>
    <div id="r_pangkat" class="form-group row">
        <label id="elh_data_request_skk_pangkat" for="x_pangkat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pangkat->caption() ?><?= $Page->pangkat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pangkat->cellAttributes() ?>>
<span id="el_data_request_skk_pangkat">
<div class="input-group flex-nowrap">
    <select
        id="x_pangkat"
        name="x_pangkat"
        class="form-control ew-select<?= $Page->pangkat->isInvalidClass() ?>"
        data-select2-id="data_request_skk_x_pangkat"
        data-table="data_request_skk"
        data-field="x_pangkat"
        data-value-separator="<?= $Page->pangkat->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pangkat->getPlaceHolder()) ?>"
        <?= $Page->pangkat->editAttributes() ?>>
        <?= $Page->pangkat->selectOptionListHtml("x_pangkat") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "m_pangkat") && !$Page->pangkat->ReadOnly) { ?>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_pangkat" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->pangkat->caption() ?>" data-title="<?= $Page->pangkat->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_pangkat',url:'<?= GetUrl("MPangkatAddopt") ?>'});"><i class="fas fa-plus ew-icon"></i></button></div>
    <?php } ?>
</div>
<?= $Page->pangkat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pangkat->getErrorMessage() ?></div>
<?= $Page->pangkat->Lookup->getParamTag($Page, "p_x_pangkat") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='data_request_skk_x_pangkat']"),
        options = { name: "x_pangkat", selectId: "data_request_skk_x_pangkat", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.data_request_skk.fields.pangkat.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <div id="r_jabatan" class="form-group row">
        <label id="elh_data_request_skk_jabatan" for="x_jabatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatan->caption() ?><?= $Page->jabatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_data_request_skk_jabatan">
<div class="input-group flex-nowrap">
    <select
        id="x_jabatan"
        name="x_jabatan"
        class="form-control ew-select<?= $Page->jabatan->isInvalidClass() ?>"
        data-select2-id="data_request_skk_x_jabatan"
        data-table="data_request_skk"
        data-field="x_jabatan"
        data-value-separator="<?= $Page->jabatan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->jabatan->getPlaceHolder()) ?>"
        <?= $Page->jabatan->editAttributes() ?>>
        <?= $Page->jabatan->selectOptionListHtml("x_jabatan") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "m_jabatan") && !$Page->jabatan->ReadOnly) { ?>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_jabatan" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->jabatan->caption() ?>" data-title="<?= $Page->jabatan->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_jabatan',url:'<?= GetUrl("MJabatanAddopt") ?>'});"><i class="fas fa-plus ew-icon"></i></button></div>
    <?php } ?>
</div>
<?= $Page->jabatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jabatan->getErrorMessage() ?></div>
<?= $Page->jabatan->Lookup->getParamTag($Page, "p_x_jabatan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='data_request_skk_x_jabatan']"),
        options = { name: "x_jabatan", selectId: "data_request_skk_x_jabatan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.data_request_skk.fields.jabatan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keperluan->Visible) { // keperluan ?>
    <div id="r_keperluan" class="form-group row">
        <label id="elh_data_request_skk_keperluan" for="x_keperluan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keperluan->caption() ?><?= $Page->keperluan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keperluan->cellAttributes() ?>>
<span id="el_data_request_skk_keperluan">
<div class="input-group flex-nowrap">
    <select
        id="x_keperluan"
        name="x_keperluan"
        class="form-control ew-select<?= $Page->keperluan->isInvalidClass() ?>"
        data-select2-id="data_request_skk_x_keperluan"
        data-table="data_request_skk"
        data-field="x_keperluan"
        data-value-separator="<?= $Page->keperluan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->keperluan->getPlaceHolder()) ?>"
        <?= $Page->keperluan->editAttributes() ?>>
        <?= $Page->keperluan->selectOptionListHtml("x_keperluan") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "m_keperluan") && !$Page->keperluan->ReadOnly) { ?>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_keperluan" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->keperluan->caption() ?>" data-title="<?= $Page->keperluan->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_keperluan',url:'<?= GetUrl("MKeperluanAddopt") ?>'});"><i class="fas fa-plus ew-icon"></i></button></div>
    <?php } ?>
</div>
<?= $Page->keperluan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keperluan->getErrorMessage() ?></div>
<?= $Page->keperluan->Lookup->getParamTag($Page, "p_x_keperluan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='data_request_skk_x_keperluan']"),
        options = { name: "x_keperluan", selectId: "data_request_skk_x_keperluan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.data_request_skk.fields.keperluan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategori_pemohon->Visible) { // kategori_pemohon ?>
    <div id="r_kategori_pemohon" class="form-group row">
        <label id="elh_data_request_skk_kategori_pemohon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kategori_pemohon->caption() ?><?= $Page->kategori_pemohon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategori_pemohon->cellAttributes() ?>>
<span id="el_data_request_skk_kategori_pemohon">
<template id="tp_x_kategori_pemohon">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="data_request_skk" data-field="x_kategori_pemohon" name="x_kategori_pemohon" id="x_kategori_pemohon"<?= $Page->kategori_pemohon->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_kategori_pemohon" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_kategori_pemohon"
    name="x_kategori_pemohon"
    value="<?= HtmlEncode($Page->kategori_pemohon->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_kategori_pemohon"
    data-target="dsl_x_kategori_pemohon"
    data-repeatcolumn="5"
    class="form-control<?= $Page->kategori_pemohon->isInvalidClass() ?>"
    data-table="data_request_skk"
    data-field="x_kategori_pemohon"
    data-value-separator="<?= $Page->kategori_pemohon->displayValueSeparatorAttribute() ?>"
    <?= $Page->kategori_pemohon->editAttributes() ?>>
<?= $Page->kategori_pemohon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kategori_pemohon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->scan_lhkpn->Visible) { // scan_lhkpn ?>
    <div id="r_scan_lhkpn" class="form-group row">
        <label id="elh_data_request_skk_scan_lhkpn" class="<?= $Page->LeftColumnClass ?>"><?= $Page->scan_lhkpn->caption() ?><?= $Page->scan_lhkpn->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->scan_lhkpn->cellAttributes() ?>>
<span id="el_data_request_skk_scan_lhkpn">
<div id="fd_x_scan_lhkpn">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->scan_lhkpn->title() ?>" data-table="data_request_skk" data-field="x_scan_lhkpn" name="x_scan_lhkpn" id="x_scan_lhkpn" lang="<?= CurrentLanguageID() ?>"<?= $Page->scan_lhkpn->editAttributes() ?><?= ($Page->scan_lhkpn->ReadOnly || $Page->scan_lhkpn->Disabled) ? " disabled" : "" ?> aria-describedby="x_scan_lhkpn_help">
        <label class="custom-file-label ew-file-label" for="x_scan_lhkpn"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->scan_lhkpn->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->scan_lhkpn->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_scan_lhkpn" id= "fn_x_scan_lhkpn" value="<?= $Page->scan_lhkpn->Upload->FileName ?>">
<input type="hidden" name="fa_x_scan_lhkpn" id= "fa_x_scan_lhkpn" value="<?= (Post("fa_x_scan_lhkpn") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_scan_lhkpn" id= "fs_x_scan_lhkpn" value="255">
<input type="hidden" name="fx_x_scan_lhkpn" id= "fx_x_scan_lhkpn" value="<?= $Page->scan_lhkpn->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_scan_lhkpn" id= "fm_x_scan_lhkpn" value="<?= $Page->scan_lhkpn->UploadMaxFileSize ?>">
</div>
<table id="ft_x_scan_lhkpn" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->scan_lhkasn->Visible) { // scan_lhkasn ?>
    <div id="r_scan_lhkasn" class="form-group row">
        <label id="elh_data_request_skk_scan_lhkasn" class="<?= $Page->LeftColumnClass ?>"><?= $Page->scan_lhkasn->caption() ?><?= $Page->scan_lhkasn->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->scan_lhkasn->cellAttributes() ?>>
<span id="el_data_request_skk_scan_lhkasn">
<div id="fd_x_scan_lhkasn">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->scan_lhkasn->title() ?>" data-table="data_request_skk" data-field="x_scan_lhkasn" name="x_scan_lhkasn" id="x_scan_lhkasn" lang="<?= CurrentLanguageID() ?>"<?= $Page->scan_lhkasn->editAttributes() ?><?= ($Page->scan_lhkasn->ReadOnly || $Page->scan_lhkasn->Disabled) ? " disabled" : "" ?> aria-describedby="x_scan_lhkasn_help">
        <label class="custom-file-label ew-file-label" for="x_scan_lhkasn"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->scan_lhkasn->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->scan_lhkasn->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_scan_lhkasn" id= "fn_x_scan_lhkasn" value="<?= $Page->scan_lhkasn->Upload->FileName ?>">
<input type="hidden" name="fa_x_scan_lhkasn" id= "fa_x_scan_lhkasn" value="<?= (Post("fa_x_scan_lhkasn") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_scan_lhkasn" id= "fs_x_scan_lhkasn" value="255">
<input type="hidden" name="fx_x_scan_lhkasn" id= "fx_x_scan_lhkasn" value="<?= $Page->scan_lhkasn->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_scan_lhkasn" id= "fm_x_scan_lhkasn" value="<?= $Page->scan_lhkasn->UploadMaxFileSize ?>">
</div>
<table id="ft_x_scan_lhkasn" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email_pemohon->Visible) { // email_pemohon ?>
    <div id="r_email_pemohon" class="form-group row">
        <label id="elh_data_request_skk_email_pemohon" for="x_email_pemohon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email_pemohon->caption() ?><?= $Page->email_pemohon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->email_pemohon->cellAttributes() ?>>
<span id="el_data_request_skk_email_pemohon">
<input type="<?= $Page->email_pemohon->getInputTextType() ?>" data-table="data_request_skk" data-field="x_email_pemohon" name="x_email_pemohon" id="x_email_pemohon" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->email_pemohon->getPlaceHolder()) ?>" value="<?= $Page->email_pemohon->EditValue ?>"<?= $Page->email_pemohon->editAttributes() ?> aria-describedby="x_email_pemohon_help">
<?= $Page->email_pemohon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email_pemohon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hukuman_disiplin->Visible) { // hukuman_disiplin ?>
    <div id="r_hukuman_disiplin" class="form-group row">
        <label id="elh_data_request_skk_hukuman_disiplin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hukuman_disiplin->caption() ?><?= $Page->hukuman_disiplin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hukuman_disiplin->cellAttributes() ?>>
<span id="el_data_request_skk_hukuman_disiplin">
<template id="tp_x_hukuman_disiplin">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="data_request_skk" data-field="x_hukuman_disiplin" name="x_hukuman_disiplin" id="x_hukuman_disiplin"<?= $Page->hukuman_disiplin->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_hukuman_disiplin" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_hukuman_disiplin"
    name="x_hukuman_disiplin"
    value="<?= HtmlEncode($Page->hukuman_disiplin->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_hukuman_disiplin"
    data-target="dsl_x_hukuman_disiplin"
    data-repeatcolumn="5"
    class="form-control<?= $Page->hukuman_disiplin->isInvalidClass() ?>"
    data-table="data_request_skk"
    data-field="x_hukuman_disiplin"
    data-value-separator="<?= $Page->hukuman_disiplin->displayValueSeparatorAttribute() ?>"
    <?= $Page->hukuman_disiplin->editAttributes() ?>>
<?= $Page->hukuman_disiplin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hukuman_disiplin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_data_request_skk_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_data_request_skk_keterangan">
<textarea data-table="data_request_skk" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("data_request_skk");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
