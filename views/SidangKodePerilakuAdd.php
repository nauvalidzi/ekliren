<?php

namespace PHPMaker2021\eclearance;

// Page object
$SidangKodePerilakuAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsidang_kode_perilakuadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsidang_kode_perilakuadd = currentForm = new ew.Form("fsidang_kode_perilakuadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sidang_kode_perilaku")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sidang_kode_perilaku)
        ew.vars.tables.sidang_kode_perilaku = currentTable;
    fsidang_kode_perilakuadd.addFields([
        ["pid_request_skk", [fields.pid_request_skk.visible && fields.pid_request_skk.required ? ew.Validators.required(fields.pid_request_skk.caption) : null, ew.Validators.integer], fields.pid_request_skk.isInvalid],
        ["sidang_kode_perilaku_jaksa", [fields.sidang_kode_perilaku_jaksa.visible && fields.sidang_kode_perilaku_jaksa.required ? ew.Validators.required(fields.sidang_kode_perilaku_jaksa.caption) : null], fields.sidang_kode_perilaku_jaksa.isInvalid],
        ["tempat_sidang_kode_perilaku", [fields.tempat_sidang_kode_perilaku.visible && fields.tempat_sidang_kode_perilaku.required ? ew.Validators.required(fields.tempat_sidang_kode_perilaku.caption) : null], fields.tempat_sidang_kode_perilaku.isInvalid],
        ["hukuman_administratif", [fields.hukuman_administratif.visible && fields.hukuman_administratif.required ? ew.Validators.required(fields.hukuman_administratif.caption) : null], fields.hukuman_administratif.isInvalid],
        ["sk_nomor_kode_perilaku", [fields.sk_nomor_kode_perilaku.visible && fields.sk_nomor_kode_perilaku.required ? ew.Validators.required(fields.sk_nomor_kode_perilaku.caption) : null], fields.sk_nomor_kode_perilaku.isInvalid],
        ["tgl_sk_kode_perilaku", [fields.tgl_sk_kode_perilaku.visible && fields.tgl_sk_kode_perilaku.required ? ew.Validators.required(fields.tgl_sk_kode_perilaku.caption) : null, ew.Validators.datetime(0)], fields.tgl_sk_kode_perilaku.isInvalid],
        ["status_hukuman_kode_perilaku", [fields.status_hukuman_kode_perilaku.visible && fields.status_hukuman_kode_perilaku.required ? ew.Validators.required(fields.status_hukuman_kode_perilaku.caption) : null], fields.status_hukuman_kode_perilaku.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsidang_kode_perilakuadd,
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
    fsidang_kode_perilakuadd.validate = function () {
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
    fsidang_kode_perilakuadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsidang_kode_perilakuadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsidang_kode_perilakuadd.lists.sidang_kode_perilaku_jaksa = <?= $Page->sidang_kode_perilaku_jaksa->toClientList($Page) ?>;
    fsidang_kode_perilakuadd.lists.tempat_sidang_kode_perilaku = <?= $Page->tempat_sidang_kode_perilaku->toClientList($Page) ?>;
    fsidang_kode_perilakuadd.lists.status_hukuman_kode_perilaku = <?= $Page->status_hukuman_kode_perilaku->toClientList($Page) ?>;
    loadjs.done("fsidang_kode_perilakuadd");
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
<form name="fsidang_kode_perilakuadd" id="fsidang_kode_perilakuadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sidang_kode_perilaku">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "v_sekretariat") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="v_sekretariat">
<input type="hidden" name="fk_id_request" value="<?= HtmlEncode($Page->pid_request_skk->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->pid_request_skk->Visible) { // pid_request_skk ?>
    <div id="r_pid_request_skk" class="form-group row">
        <label id="elh_sidang_kode_perilaku_pid_request_skk" for="x_pid_request_skk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pid_request_skk->caption() ?><?= $Page->pid_request_skk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pid_request_skk->cellAttributes() ?>>
<?php if ($Page->pid_request_skk->getSessionValue() != "") { ?>
<span id="el_sidang_kode_perilaku_pid_request_skk">
<span<?= $Page->pid_request_skk->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid_request_skk->getDisplayValue($Page->pid_request_skk->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_pid_request_skk" name="x_pid_request_skk" value="<?= HtmlEncode($Page->pid_request_skk->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_sidang_kode_perilaku_pid_request_skk">
<input type="<?= $Page->pid_request_skk->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_pid_request_skk" name="x_pid_request_skk" id="x_pid_request_skk" size="30" placeholder="<?= HtmlEncode($Page->pid_request_skk->getPlaceHolder()) ?>" value="<?= $Page->pid_request_skk->EditValue ?>"<?= $Page->pid_request_skk->editAttributes() ?> aria-describedby="x_pid_request_skk_help">
<?= $Page->pid_request_skk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pid_request_skk->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sidang_kode_perilaku_jaksa->Visible) { // sidang_kode_perilaku_jaksa ?>
    <div id="r_sidang_kode_perilaku_jaksa" class="form-group row">
        <label id="elh_sidang_kode_perilaku_sidang_kode_perilaku_jaksa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sidang_kode_perilaku_jaksa->caption() ?><?= $Page->sidang_kode_perilaku_jaksa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sidang_kode_perilaku_jaksa->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_sidang_kode_perilaku_jaksa">
<template id="tp_x_sidang_kode_perilaku_jaksa">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="sidang_kode_perilaku" data-field="x_sidang_kode_perilaku_jaksa" name="x_sidang_kode_perilaku_jaksa" id="x_sidang_kode_perilaku_jaksa"<?= $Page->sidang_kode_perilaku_jaksa->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_sidang_kode_perilaku_jaksa" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_sidang_kode_perilaku_jaksa"
    name="x_sidang_kode_perilaku_jaksa"
    value="<?= HtmlEncode($Page->sidang_kode_perilaku_jaksa->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_sidang_kode_perilaku_jaksa"
    data-target="dsl_x_sidang_kode_perilaku_jaksa"
    data-repeatcolumn="5"
    class="form-control<?= $Page->sidang_kode_perilaku_jaksa->isInvalidClass() ?>"
    data-table="sidang_kode_perilaku"
    data-field="x_sidang_kode_perilaku_jaksa"
    data-value-separator="<?= $Page->sidang_kode_perilaku_jaksa->displayValueSeparatorAttribute() ?>"
    <?= $Page->sidang_kode_perilaku_jaksa->editAttributes() ?>>
<?= $Page->sidang_kode_perilaku_jaksa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sidang_kode_perilaku_jaksa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tempat_sidang_kode_perilaku->Visible) { // tempat_sidang_kode_perilaku ?>
    <div id="r_tempat_sidang_kode_perilaku" class="form-group row">
        <label id="elh_sidang_kode_perilaku_tempat_sidang_kode_perilaku" for="x_tempat_sidang_kode_perilaku" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tempat_sidang_kode_perilaku->caption() ?><?= $Page->tempat_sidang_kode_perilaku->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tempat_sidang_kode_perilaku->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_tempat_sidang_kode_perilaku">
    <select
        id="x_tempat_sidang_kode_perilaku"
        name="x_tempat_sidang_kode_perilaku"
        class="form-control ew-select<?= $Page->tempat_sidang_kode_perilaku->isInvalidClass() ?>"
        data-select2-id="sidang_kode_perilaku_x_tempat_sidang_kode_perilaku"
        data-table="sidang_kode_perilaku"
        data-field="x_tempat_sidang_kode_perilaku"
        data-value-separator="<?= $Page->tempat_sidang_kode_perilaku->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tempat_sidang_kode_perilaku->getPlaceHolder()) ?>"
        <?= $Page->tempat_sidang_kode_perilaku->editAttributes() ?>>
        <?= $Page->tempat_sidang_kode_perilaku->selectOptionListHtml("x_tempat_sidang_kode_perilaku") ?>
    </select>
    <?= $Page->tempat_sidang_kode_perilaku->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tempat_sidang_kode_perilaku->getErrorMessage() ?></div>
<?= $Page->tempat_sidang_kode_perilaku->Lookup->getParamTag($Page, "p_x_tempat_sidang_kode_perilaku") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sidang_kode_perilaku_x_tempat_sidang_kode_perilaku']"),
        options = { name: "x_tempat_sidang_kode_perilaku", selectId: "sidang_kode_perilaku_x_tempat_sidang_kode_perilaku", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sidang_kode_perilaku.fields.tempat_sidang_kode_perilaku.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hukuman_administratif->Visible) { // hukuman_administratif ?>
    <div id="r_hukuman_administratif" class="form-group row">
        <label id="elh_sidang_kode_perilaku_hukuman_administratif" for="x_hukuman_administratif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hukuman_administratif->caption() ?><?= $Page->hukuman_administratif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hukuman_administratif->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_hukuman_administratif">
<input type="<?= $Page->hukuman_administratif->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_hukuman_administratif" name="x_hukuman_administratif" id="x_hukuman_administratif" size="50" maxlength="255" placeholder="<?= HtmlEncode($Page->hukuman_administratif->getPlaceHolder()) ?>" value="<?= $Page->hukuman_administratif->EditValue ?>"<?= $Page->hukuman_administratif->editAttributes() ?> aria-describedby="x_hukuman_administratif_help">
<?= $Page->hukuman_administratif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hukuman_administratif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sk_nomor_kode_perilaku->Visible) { // sk_nomor_kode_perilaku ?>
    <div id="r_sk_nomor_kode_perilaku" class="form-group row">
        <label id="elh_sidang_kode_perilaku_sk_nomor_kode_perilaku" for="x_sk_nomor_kode_perilaku" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sk_nomor_kode_perilaku->caption() ?><?= $Page->sk_nomor_kode_perilaku->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sk_nomor_kode_perilaku->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_sk_nomor_kode_perilaku">
<input type="<?= $Page->sk_nomor_kode_perilaku->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_sk_nomor_kode_perilaku" name="x_sk_nomor_kode_perilaku" id="x_sk_nomor_kode_perilaku" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->sk_nomor_kode_perilaku->getPlaceHolder()) ?>" value="<?= $Page->sk_nomor_kode_perilaku->EditValue ?>"<?= $Page->sk_nomor_kode_perilaku->editAttributes() ?> aria-describedby="x_sk_nomor_kode_perilaku_help">
<?= $Page->sk_nomor_kode_perilaku->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sk_nomor_kode_perilaku->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_sk_kode_perilaku->Visible) { // tgl_sk_kode_perilaku ?>
    <div id="r_tgl_sk_kode_perilaku" class="form-group row">
        <label id="elh_sidang_kode_perilaku_tgl_sk_kode_perilaku" for="x_tgl_sk_kode_perilaku" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_sk_kode_perilaku->caption() ?><?= $Page->tgl_sk_kode_perilaku->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_sk_kode_perilaku->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_tgl_sk_kode_perilaku">
<input type="<?= $Page->tgl_sk_kode_perilaku->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_tgl_sk_kode_perilaku" name="x_tgl_sk_kode_perilaku" id="x_tgl_sk_kode_perilaku" placeholder="<?= HtmlEncode($Page->tgl_sk_kode_perilaku->getPlaceHolder()) ?>" value="<?= $Page->tgl_sk_kode_perilaku->EditValue ?>"<?= $Page->tgl_sk_kode_perilaku->editAttributes() ?> aria-describedby="x_tgl_sk_kode_perilaku_help">
<?= $Page->tgl_sk_kode_perilaku->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_sk_kode_perilaku->getErrorMessage() ?></div>
<?php if (!$Page->tgl_sk_kode_perilaku->ReadOnly && !$Page->tgl_sk_kode_perilaku->Disabled && !isset($Page->tgl_sk_kode_perilaku->EditAttrs["readonly"]) && !isset($Page->tgl_sk_kode_perilaku->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsidang_kode_perilakuadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fsidang_kode_perilakuadd", "x_tgl_sk_kode_perilaku", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_hukuman_kode_perilaku->Visible) { // status_hukuman_kode_perilaku ?>
    <div id="r_status_hukuman_kode_perilaku" class="form-group row">
        <label id="elh_sidang_kode_perilaku_status_hukuman_kode_perilaku" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_hukuman_kode_perilaku->caption() ?><?= $Page->status_hukuman_kode_perilaku->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_hukuman_kode_perilaku->cellAttributes() ?>>
<span id="el_sidang_kode_perilaku_status_hukuman_kode_perilaku">
<template id="tp_x_status_hukuman_kode_perilaku">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="sidang_kode_perilaku" data-field="x_status_hukuman_kode_perilaku" name="x_status_hukuman_kode_perilaku" id="x_status_hukuman_kode_perilaku"<?= $Page->status_hukuman_kode_perilaku->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_status_hukuman_kode_perilaku" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_status_hukuman_kode_perilaku"
    name="x_status_hukuman_kode_perilaku"
    value="<?= HtmlEncode($Page->status_hukuman_kode_perilaku->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status_hukuman_kode_perilaku"
    data-target="dsl_x_status_hukuman_kode_perilaku"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status_hukuman_kode_perilaku->isInvalidClass() ?>"
    data-table="sidang_kode_perilaku"
    data-field="x_status_hukuman_kode_perilaku"
    data-value-separator="<?= $Page->status_hukuman_kode_perilaku->displayValueSeparatorAttribute() ?>"
    <?= $Page->status_hukuman_kode_perilaku->editAttributes() ?>>
<?= $Page->status_hukuman_kode_perilaku->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_hukuman_kode_perilaku->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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
    ew.addEventHandlers("sidang_kode_perilaku");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
