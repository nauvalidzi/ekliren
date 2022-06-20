<?php

namespace PHPMaker2021\eclearance;

// Page object
$HukumanDisiplinEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fhukuman_disiplinedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fhukuman_disiplinedit = currentForm = new ew.Form("fhukuman_disiplinedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "hukuman_disiplin")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.hukuman_disiplin)
        ew.vars.tables.hukuman_disiplin = currentTable;
    fhukuman_disiplinedit.addFields([
        ["pernah_dijatuhi_hukuman", [fields.pernah_dijatuhi_hukuman.visible && fields.pernah_dijatuhi_hukuman.required ? ew.Validators.required(fields.pernah_dijatuhi_hukuman.caption) : null], fields.pernah_dijatuhi_hukuman.isInvalid],
        ["jenis_hukuman", [fields.jenis_hukuman.visible && fields.jenis_hukuman.required ? ew.Validators.required(fields.jenis_hukuman.caption) : null], fields.jenis_hukuman.isInvalid],
        ["hukuman", [fields.hukuman.visible && fields.hukuman.required ? ew.Validators.required(fields.hukuman.caption) : null], fields.hukuman.isInvalid],
        ["pasal", [fields.pasal.visible && fields.pasal.required ? ew.Validators.required(fields.pasal.caption) : null], fields.pasal.isInvalid],
        ["surat_keputusan", [fields.surat_keputusan.visible && fields.surat_keputusan.required ? ew.Validators.required(fields.surat_keputusan.caption) : null], fields.surat_keputusan.isInvalid],
        ["sk_nomor", [fields.sk_nomor.visible && fields.sk_nomor.required ? ew.Validators.required(fields.sk_nomor.caption) : null], fields.sk_nomor.isInvalid],
        ["tanggal_sk", [fields.tanggal_sk.visible && fields.tanggal_sk.required ? ew.Validators.required(fields.tanggal_sk.caption) : null, ew.Validators.datetime(0)], fields.tanggal_sk.isInvalid],
        ["status_hukuman", [fields.status_hukuman.visible && fields.status_hukuman.required ? ew.Validators.required(fields.status_hukuman.caption) : null], fields.status_hukuman.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fhukuman_disiplinedit,
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
    fhukuman_disiplinedit.validate = function () {
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
    fhukuman_disiplinedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fhukuman_disiplinedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fhukuman_disiplinedit.lists.pernah_dijatuhi_hukuman = <?= $Page->pernah_dijatuhi_hukuman->toClientList($Page) ?>;
    fhukuman_disiplinedit.lists.jenis_hukuman = <?= $Page->jenis_hukuman->toClientList($Page) ?>;
    fhukuman_disiplinedit.lists.surat_keputusan = <?= $Page->surat_keputusan->toClientList($Page) ?>;
    fhukuman_disiplinedit.lists.status_hukuman = <?= $Page->status_hukuman->toClientList($Page) ?>;
    loadjs.done("fhukuman_disiplinedit");
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
<form name="fhukuman_disiplinedit" id="fhukuman_disiplinedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="hukuman_disiplin">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "v_sekretariat") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="v_sekretariat">
<input type="hidden" name="fk_id_request" value="<?= HtmlEncode($Page->pid_request_skk->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->pernah_dijatuhi_hukuman->Visible) { // pernah_dijatuhi_hukuman ?>
    <div id="r_pernah_dijatuhi_hukuman" class="form-group row">
        <label id="elh_hukuman_disiplin_pernah_dijatuhi_hukuman" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pernah_dijatuhi_hukuman->caption() ?><?= $Page->pernah_dijatuhi_hukuman->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pernah_dijatuhi_hukuman->cellAttributes() ?>>
<span id="el_hukuman_disiplin_pernah_dijatuhi_hukuman">
<template id="tp_x_pernah_dijatuhi_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_pernah_dijatuhi_hukuman" name="x_pernah_dijatuhi_hukuman" id="x_pernah_dijatuhi_hukuman"<?= $Page->pernah_dijatuhi_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_pernah_dijatuhi_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_pernah_dijatuhi_hukuman"
    name="x_pernah_dijatuhi_hukuman"
    value="<?= HtmlEncode($Page->pernah_dijatuhi_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_pernah_dijatuhi_hukuman"
    data-target="dsl_x_pernah_dijatuhi_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Page->pernah_dijatuhi_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_pernah_dijatuhi_hukuman"
    data-value-separator="<?= $Page->pernah_dijatuhi_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Page->pernah_dijatuhi_hukuman->editAttributes() ?>>
<?= $Page->pernah_dijatuhi_hukuman->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pernah_dijatuhi_hukuman->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenis_hukuman->Visible) { // jenis_hukuman ?>
    <div id="r_jenis_hukuman" class="form-group row">
        <label id="elh_hukuman_disiplin_jenis_hukuman" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jenis_hukuman->caption() ?><?= $Page->jenis_hukuman->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenis_hukuman->cellAttributes() ?>>
<span id="el_hukuman_disiplin_jenis_hukuman">
<template id="tp_x_jenis_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_jenis_hukuman" name="x_jenis_hukuman" id="x_jenis_hukuman"<?= $Page->jenis_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_jenis_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_jenis_hukuman"
    name="x_jenis_hukuman"
    value="<?= HtmlEncode($Page->jenis_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_jenis_hukuman"
    data-target="dsl_x_jenis_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Page->jenis_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_jenis_hukuman"
    data-value-separator="<?= $Page->jenis_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Page->jenis_hukuman->editAttributes() ?>>
<?= $Page->jenis_hukuman->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenis_hukuman->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hukuman->Visible) { // hukuman ?>
    <div id="r_hukuman" class="form-group row">
        <label id="elh_hukuman_disiplin_hukuman" for="x_hukuman" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hukuman->caption() ?><?= $Page->hukuman->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hukuman->cellAttributes() ?>>
<span id="el_hukuman_disiplin_hukuman">
<textarea data-table="hukuman_disiplin" data-field="x_hukuman" name="x_hukuman" id="x_hukuman" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->hukuman->getPlaceHolder()) ?>"<?= $Page->hukuman->editAttributes() ?> aria-describedby="x_hukuman_help"><?= $Page->hukuman->EditValue ?></textarea>
<?= $Page->hukuman->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hukuman->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pasal->Visible) { // pasal ?>
    <div id="r_pasal" class="form-group row">
        <label id="elh_hukuman_disiplin_pasal" for="x_pasal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pasal->caption() ?><?= $Page->pasal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pasal->cellAttributes() ?>>
<span id="el_hukuman_disiplin_pasal">
<input type="<?= $Page->pasal->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_pasal" name="x_pasal" id="x_pasal" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->pasal->getPlaceHolder()) ?>" value="<?= $Page->pasal->EditValue ?>"<?= $Page->pasal->editAttributes() ?> aria-describedby="x_pasal_help">
<?= $Page->pasal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pasal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->surat_keputusan->Visible) { // surat_keputusan ?>
    <div id="r_surat_keputusan" class="form-group row">
        <label id="elh_hukuman_disiplin_surat_keputusan" for="x_surat_keputusan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->surat_keputusan->caption() ?><?= $Page->surat_keputusan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->surat_keputusan->cellAttributes() ?>>
<span id="el_hukuman_disiplin_surat_keputusan">
    <select
        id="x_surat_keputusan"
        name="x_surat_keputusan"
        class="form-control ew-select<?= $Page->surat_keputusan->isInvalidClass() ?>"
        data-select2-id="hukuman_disiplin_x_surat_keputusan"
        data-table="hukuman_disiplin"
        data-field="x_surat_keputusan"
        data-value-separator="<?= $Page->surat_keputusan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->surat_keputusan->getPlaceHolder()) ?>"
        <?= $Page->surat_keputusan->editAttributes() ?>>
        <?= $Page->surat_keputusan->selectOptionListHtml("x_surat_keputusan") ?>
    </select>
    <?= $Page->surat_keputusan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->surat_keputusan->getErrorMessage() ?></div>
<?= $Page->surat_keputusan->Lookup->getParamTag($Page, "p_x_surat_keputusan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='hukuman_disiplin_x_surat_keputusan']"),
        options = { name: "x_surat_keputusan", selectId: "hukuman_disiplin_x_surat_keputusan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.hukuman_disiplin.fields.surat_keputusan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sk_nomor->Visible) { // sk_nomor ?>
    <div id="r_sk_nomor" class="form-group row">
        <label id="elh_hukuman_disiplin_sk_nomor" for="x_sk_nomor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sk_nomor->caption() ?><?= $Page->sk_nomor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sk_nomor->cellAttributes() ?>>
<span id="el_hukuman_disiplin_sk_nomor">
<input type="<?= $Page->sk_nomor->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_sk_nomor" name="x_sk_nomor" id="x_sk_nomor" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->sk_nomor->getPlaceHolder()) ?>" value="<?= $Page->sk_nomor->EditValue ?>"<?= $Page->sk_nomor->editAttributes() ?> aria-describedby="x_sk_nomor_help">
<?= $Page->sk_nomor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sk_nomor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_sk->Visible) { // tanggal_sk ?>
    <div id="r_tanggal_sk" class="form-group row">
        <label id="elh_hukuman_disiplin_tanggal_sk" for="x_tanggal_sk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_sk->caption() ?><?= $Page->tanggal_sk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_sk->cellAttributes() ?>>
<span id="el_hukuman_disiplin_tanggal_sk">
<input type="<?= $Page->tanggal_sk->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_tanggal_sk" name="x_tanggal_sk" id="x_tanggal_sk" placeholder="<?= HtmlEncode($Page->tanggal_sk->getPlaceHolder()) ?>" value="<?= $Page->tanggal_sk->EditValue ?>"<?= $Page->tanggal_sk->editAttributes() ?> aria-describedby="x_tanggal_sk_help">
<?= $Page->tanggal_sk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_sk->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_sk->ReadOnly && !$Page->tanggal_sk->Disabled && !isset($Page->tanggal_sk->EditAttrs["readonly"]) && !isset($Page->tanggal_sk->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fhukuman_disiplinedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fhukuman_disiplinedit", "x_tanggal_sk", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_hukuman->Visible) { // status_hukuman ?>
    <div id="r_status_hukuman" class="form-group row">
        <label id="elh_hukuman_disiplin_status_hukuman" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_hukuman->caption() ?><?= $Page->status_hukuman->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_hukuman->cellAttributes() ?>>
<span id="el_hukuman_disiplin_status_hukuman">
<template id="tp_x_status_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_status_hukuman" name="x_status_hukuman" id="x_status_hukuman"<?= $Page->status_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_status_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_status_hukuman"
    name="x_status_hukuman"
    value="<?= HtmlEncode($Page->status_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status_hukuman"
    data-target="dsl_x_status_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_status_hukuman"
    data-value-separator="<?= $Page->status_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Page->status_hukuman->editAttributes() ?>>
<?= $Page->status_hukuman->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_hukuman->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="hukuman_disiplin" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("hukuman_disiplin");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
