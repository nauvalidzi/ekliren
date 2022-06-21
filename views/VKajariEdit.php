<?php

namespace PHPMaker2021\eclearance;

// Page object
$VKajariEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fv_kajariedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fv_kajariedit = currentForm = new ew.Form("fv_kajariedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "v_kajari")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.v_kajari)
        ew.vars.tables.v_kajari = currentTable;
    fv_kajariedit.addFields([
        ["tanggal_request", [fields.tanggal_request.visible && fields.tanggal_request.required ? ew.Validators.required(fields.tanggal_request.caption) : null], fields.tanggal_request.isInvalid],
        ["nip", [fields.nip.visible && fields.nip.required ? ew.Validators.required(fields.nip.caption) : null], fields.nip.isInvalid],
        ["nrp", [fields.nrp.visible && fields.nrp.required ? ew.Validators.required(fields.nrp.caption) : null], fields.nrp.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["unit_organisasi", [fields.unit_organisasi.visible && fields.unit_organisasi.required ? ew.Validators.required(fields.unit_organisasi.caption) : null], fields.unit_organisasi.isInvalid],
        ["pangkat", [fields.pangkat.visible && fields.pangkat.required ? ew.Validators.required(fields.pangkat.caption) : null], fields.pangkat.isInvalid],
        ["jabatan", [fields.jabatan.visible && fields.jabatan.required ? ew.Validators.required(fields.jabatan.caption) : null], fields.jabatan.isInvalid],
        ["keperluan", [fields.keperluan.visible && fields.keperluan.required ? ew.Validators.required(fields.keperluan.caption) : null], fields.keperluan.isInvalid],
        ["kategori_pemohon", [fields.kategori_pemohon.visible && fields.kategori_pemohon.required ? ew.Validators.required(fields.kategori_pemohon.caption) : null], fields.kategori_pemohon.isInvalid],
        ["scan_lhkpn", [fields.scan_lhkpn.visible && fields.scan_lhkpn.required ? ew.Validators.required(fields.scan_lhkpn.caption) : null], fields.scan_lhkpn.isInvalid],
        ["scan_lhkasn", [fields.scan_lhkasn.visible && fields.scan_lhkasn.required ? ew.Validators.required(fields.scan_lhkasn.caption) : null], fields.scan_lhkasn.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fv_kajariedit,
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
    fv_kajariedit.validate = function () {
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
    fv_kajariedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fv_kajariedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fv_kajariedit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fv_kajariedit");
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
<form name="fv_kajariedit" id="fv_kajariedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_kajari">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
    <div id="r_tanggal_request" class="form-group row">
        <label id="elh_v_kajari_tanggal_request" for="x_tanggal_request" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_request->caption() ?><?= $Page->tanggal_request->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_request->cellAttributes() ?>>
<span id="el_v_kajari_tanggal_request">
<span<?= $Page->tanggal_request->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tanggal_request->getDisplayValue($Page->tanggal_request->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_tanggal_request" data-hidden="1" name="x_tanggal_request" id="x_tanggal_request" value="<?= HtmlEncode($Page->tanggal_request->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nip->Visible) { // nip ?>
    <div id="r_nip" class="form-group row">
        <label id="elh_v_kajari_nip" for="x_nip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nip->caption() ?><?= $Page->nip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nip->cellAttributes() ?>>
<span id="el_v_kajari_nip">
<span<?= $Page->nip->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nip->getDisplayValue($Page->nip->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_nip" data-hidden="1" name="x_nip" id="x_nip" value="<?= HtmlEncode($Page->nip->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nrp->Visible) { // nrp ?>
    <div id="r_nrp" class="form-group row">
        <label id="elh_v_kajari_nrp" for="x_nrp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nrp->caption() ?><?= $Page->nrp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nrp->cellAttributes() ?>>
<span id="el_v_kajari_nrp">
<span<?= $Page->nrp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nrp->getDisplayValue($Page->nrp->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_nrp" data-hidden="1" name="x_nrp" id="x_nrp" value="<?= HtmlEncode($Page->nrp->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_v_kajari_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_v_kajari_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nama->getDisplayValue($Page->nama->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_nama" data-hidden="1" name="x_nama" id="x_nama" value="<?= HtmlEncode($Page->nama->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
    <div id="r_unit_organisasi" class="form-group row">
        <label id="elh_v_kajari_unit_organisasi" for="x_unit_organisasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unit_organisasi->caption() ?><?= $Page->unit_organisasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->unit_organisasi->cellAttributes() ?>>
<span id="el_v_kajari_unit_organisasi">
<span<?= $Page->unit_organisasi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->unit_organisasi->getDisplayValue($Page->unit_organisasi->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_unit_organisasi" data-hidden="1" name="x_unit_organisasi" id="x_unit_organisasi" value="<?= HtmlEncode($Page->unit_organisasi->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pangkat->Visible) { // pangkat ?>
    <div id="r_pangkat" class="form-group row">
        <label id="elh_v_kajari_pangkat" for="x_pangkat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pangkat->caption() ?><?= $Page->pangkat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pangkat->cellAttributes() ?>>
<span id="el_v_kajari_pangkat">
<span<?= $Page->pangkat->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pangkat->getDisplayValue($Page->pangkat->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_pangkat" data-hidden="1" name="x_pangkat" id="x_pangkat" value="<?= HtmlEncode($Page->pangkat->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <div id="r_jabatan" class="form-group row">
        <label id="elh_v_kajari_jabatan" for="x_jabatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatan->caption() ?><?= $Page->jabatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_v_kajari_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->jabatan->getDisplayValue($Page->jabatan->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_jabatan" data-hidden="1" name="x_jabatan" id="x_jabatan" value="<?= HtmlEncode($Page->jabatan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keperluan->Visible) { // keperluan ?>
    <div id="r_keperluan" class="form-group row">
        <label id="elh_v_kajari_keperluan" for="x_keperluan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keperluan->caption() ?><?= $Page->keperluan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keperluan->cellAttributes() ?>>
<span id="el_v_kajari_keperluan">
<span<?= $Page->keperluan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->keperluan->getDisplayValue($Page->keperluan->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_keperluan" data-hidden="1" name="x_keperluan" id="x_keperluan" value="<?= HtmlEncode($Page->keperluan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategori_pemohon->Visible) { // kategori_pemohon ?>
    <div id="r_kategori_pemohon" class="form-group row">
        <label id="elh_v_kajari_kategori_pemohon" for="x_kategori_pemohon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kategori_pemohon->caption() ?><?= $Page->kategori_pemohon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategori_pemohon->cellAttributes() ?>>
<span id="el_v_kajari_kategori_pemohon">
<span<?= $Page->kategori_pemohon->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->kategori_pemohon->getDisplayValue($Page->kategori_pemohon->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_kategori_pemohon" data-hidden="1" name="x_kategori_pemohon" id="x_kategori_pemohon" value="<?= HtmlEncode($Page->kategori_pemohon->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->scan_lhkpn->Visible) { // scan_lhkpn ?>
    <div id="r_scan_lhkpn" class="form-group row">
        <label id="elh_v_kajari_scan_lhkpn" for="x_scan_lhkpn" class="<?= $Page->LeftColumnClass ?>"><?= $Page->scan_lhkpn->caption() ?><?= $Page->scan_lhkpn->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->scan_lhkpn->cellAttributes() ?>>
<span id="el_v_kajari_scan_lhkpn">
<span<?= $Page->scan_lhkpn->viewAttributes() ?>>
<?php if (!EmptyString($Page->scan_lhkpn->EditValue) && $Page->scan_lhkpn->linkAttributes() != "") { ?>
<a<?= $Page->scan_lhkpn->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkpn->getDisplayValue($Page->scan_lhkpn->EditValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkpn->getDisplayValue($Page->scan_lhkpn->EditValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_scan_lhkpn" data-hidden="1" name="x_scan_lhkpn" id="x_scan_lhkpn" value="<?= HtmlEncode($Page->scan_lhkpn->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->scan_lhkasn->Visible) { // scan_lhkasn ?>
    <div id="r_scan_lhkasn" class="form-group row">
        <label id="elh_v_kajari_scan_lhkasn" for="x_scan_lhkasn" class="<?= $Page->LeftColumnClass ?>"><?= $Page->scan_lhkasn->caption() ?><?= $Page->scan_lhkasn->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->scan_lhkasn->cellAttributes() ?>>
<span id="el_v_kajari_scan_lhkasn">
<span<?= $Page->scan_lhkasn->viewAttributes() ?>>
<?php if (!EmptyString($Page->scan_lhkasn->EditValue) && $Page->scan_lhkasn->linkAttributes() != "") { ?>
<a<?= $Page->scan_lhkasn->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkasn->getDisplayValue($Page->scan_lhkasn->EditValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->scan_lhkasn->getDisplayValue($Page->scan_lhkasn->EditValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_scan_lhkasn" data-hidden="1" name="x_scan_lhkasn" id="x_scan_lhkasn" value="<?= HtmlEncode($Page->scan_lhkasn->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_v_kajari_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_v_kajari_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->keterangan->getDisplayValue($Page->keterangan->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_kajari" data-field="x_keterangan" data-hidden="1" name="x_keterangan" id="x_keterangan" value="<?= HtmlEncode($Page->keterangan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_v_kajari_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_v_kajari_status">
<template id="tp_x_status">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="v_kajari" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
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
    data-table="v_kajari"
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
    <input type="hidden" data-table="v_kajari" data-field="x_id_request" data-hidden="1" name="x_id_request" id="x_id_request" value="<?= HtmlEncode($Page->id_request->CurrentValue) ?>">
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
    ew.addEventHandlers("v_kajari");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    if($("#el_v_kajari_scan_lhkpn").length){var lhkpn=$("#el_v_kajari_scan_lhkpn input").val();$("#el_v_kajari_scan_lhkpn a input").replaceWith(lhkpn),$("#el_v_kajari_scan_lhkpn a").attr("href","#modal-popup"),$("#modal-popup .modal-title").text(lhkpn),$("#modal-popup .modal-body").append(`<embed src="${base_url}/files/${lhkpn}" frameborder="0" width="100%" height="400px">`),$("#modal-popup .modal-footer").hide()}if($("#el_v_kajari_scan_lhkasn").length){var lhkasn=$("#el_v_kajari_scan_lhkasn input").val();$("#el_v_kajari_scan_lhkasn a input").replaceWith(lhkasn),$("#el_v_kajari_scan_lhkasn a").attr("href","#modal-popup"),$("#modal-popup .modal-title").text(lhkasn),$("#modal-popup .modal-body").append(`<embed src="${base_url}/files/${lhkasn}" frameborder="0" width="100%" height="400px">`),$("#modal-popup .modal-footer").hide()}
});
</script>
