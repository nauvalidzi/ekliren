<?php

namespace PHPMaker2021\eclearance;

// Page object
$BandingEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fbandingedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fbandingedit = currentForm = new ew.Form("fbandingedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "banding")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.banding)
        ew.vars.tables.banding = currentTable;
    fbandingedit.addFields([
        ["mengajukan_keberatan_banding", [fields.mengajukan_keberatan_banding.visible && fields.mengajukan_keberatan_banding.required ? ew.Validators.required(fields.mengajukan_keberatan_banding.caption) : null], fields.mengajukan_keberatan_banding.isInvalid],
        ["sk_banding_nomor", [fields.sk_banding_nomor.visible && fields.sk_banding_nomor.required ? ew.Validators.required(fields.sk_banding_nomor.caption) : null], fields.sk_banding_nomor.isInvalid],
        ["tgl_sk_banding", [fields.tgl_sk_banding.visible && fields.tgl_sk_banding.required ? ew.Validators.required(fields.tgl_sk_banding.caption) : null, ew.Validators.datetime(0)], fields.tgl_sk_banding.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fbandingedit,
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
    fbandingedit.validate = function () {
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
    fbandingedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbandingedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fbandingedit.lists.mengajukan_keberatan_banding = <?= $Page->mengajukan_keberatan_banding->toClientList($Page) ?>;
    loadjs.done("fbandingedit");
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
<form name="fbandingedit" id="fbandingedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="banding">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "v_sekretariat") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="v_sekretariat">
<input type="hidden" name="fk_id_request" value="<?= HtmlEncode($Page->pid_request_skk->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->mengajukan_keberatan_banding->Visible) { // mengajukan_keberatan_banding ?>
    <div id="r_mengajukan_keberatan_banding" class="form-group row">
        <label id="elh_banding_mengajukan_keberatan_banding" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mengajukan_keberatan_banding->caption() ?><?= $Page->mengajukan_keberatan_banding->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mengajukan_keberatan_banding->cellAttributes() ?>>
<span id="el_banding_mengajukan_keberatan_banding">
<template id="tp_x_mengajukan_keberatan_banding">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="banding" data-field="x_mengajukan_keberatan_banding" name="x_mengajukan_keberatan_banding" id="x_mengajukan_keberatan_banding"<?= $Page->mengajukan_keberatan_banding->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_mengajukan_keberatan_banding" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_mengajukan_keberatan_banding"
    name="x_mengajukan_keberatan_banding"
    value="<?= HtmlEncode($Page->mengajukan_keberatan_banding->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_mengajukan_keberatan_banding"
    data-target="dsl_x_mengajukan_keberatan_banding"
    data-repeatcolumn="5"
    class="form-control<?= $Page->mengajukan_keberatan_banding->isInvalidClass() ?>"
    data-table="banding"
    data-field="x_mengajukan_keberatan_banding"
    data-value-separator="<?= $Page->mengajukan_keberatan_banding->displayValueSeparatorAttribute() ?>"
    <?= $Page->mengajukan_keberatan_banding->editAttributes() ?>>
<?= $Page->mengajukan_keberatan_banding->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mengajukan_keberatan_banding->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sk_banding_nomor->Visible) { // sk_banding_nomor ?>
    <div id="r_sk_banding_nomor" class="form-group row">
        <label id="elh_banding_sk_banding_nomor" for="x_sk_banding_nomor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sk_banding_nomor->caption() ?><?= $Page->sk_banding_nomor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sk_banding_nomor->cellAttributes() ?>>
<span id="el_banding_sk_banding_nomor">
<input type="<?= $Page->sk_banding_nomor->getInputTextType() ?>" data-table="banding" data-field="x_sk_banding_nomor" name="x_sk_banding_nomor" id="x_sk_banding_nomor" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->sk_banding_nomor->getPlaceHolder()) ?>" value="<?= $Page->sk_banding_nomor->EditValue ?>"<?= $Page->sk_banding_nomor->editAttributes() ?> aria-describedby="x_sk_banding_nomor_help">
<?= $Page->sk_banding_nomor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sk_banding_nomor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_sk_banding->Visible) { // tgl_sk_banding ?>
    <div id="r_tgl_sk_banding" class="form-group row">
        <label id="elh_banding_tgl_sk_banding" for="x_tgl_sk_banding" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_sk_banding->caption() ?><?= $Page->tgl_sk_banding->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_sk_banding->cellAttributes() ?>>
<span id="el_banding_tgl_sk_banding">
<input type="<?= $Page->tgl_sk_banding->getInputTextType() ?>" data-table="banding" data-field="x_tgl_sk_banding" name="x_tgl_sk_banding" id="x_tgl_sk_banding" maxlength="255" placeholder="<?= HtmlEncode($Page->tgl_sk_banding->getPlaceHolder()) ?>" value="<?= $Page->tgl_sk_banding->EditValue ?>"<?= $Page->tgl_sk_banding->editAttributes() ?> aria-describedby="x_tgl_sk_banding_help">
<?= $Page->tgl_sk_banding->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_sk_banding->getErrorMessage() ?></div>
<?php if (!$Page->tgl_sk_banding->ReadOnly && !$Page->tgl_sk_banding->Disabled && !isset($Page->tgl_sk_banding->EditAttrs["readonly"]) && !isset($Page->tgl_sk_banding->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbandingedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fbandingedit", "x_tgl_sk_banding", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="banding" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("banding");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
