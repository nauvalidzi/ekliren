<?php

namespace PHPMaker2021\eclearance;

// Page object
$KonfigurasiEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkonfigurasiedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fkonfigurasiedit = currentForm = new ew.Form("fkonfigurasiedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "konfigurasi")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.konfigurasi)
        ew.vars.tables.konfigurasi = currentTable;
    fkonfigurasiedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["config_name", [fields.config_name.visible && fields.config_name.required ? ew.Validators.required(fields.config_name.caption) : null], fields.config_name.isInvalid],
        ["config_value", [fields.config_value.visible && fields.config_value.required ? ew.Validators.required(fields.config_value.caption) : null], fields.config_value.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fkonfigurasiedit,
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
    fkonfigurasiedit.validate = function () {
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
    fkonfigurasiedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkonfigurasiedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fkonfigurasiedit");
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
<form name="fkonfigurasiedit" id="fkonfigurasiedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="konfigurasi">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_konfigurasi_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_konfigurasi_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="konfigurasi" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->config_name->Visible) { // config_name ?>
    <div id="r_config_name" class="form-group row">
        <label id="elh_konfigurasi_config_name" for="x_config_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->config_name->caption() ?><?= $Page->config_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->config_name->cellAttributes() ?>>
<span id="el_konfigurasi_config_name">
<input type="<?= $Page->config_name->getInputTextType() ?>" data-table="konfigurasi" data-field="x_config_name" name="x_config_name" id="x_config_name" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->config_name->getPlaceHolder()) ?>" value="<?= $Page->config_name->EditValue ?>"<?= $Page->config_name->editAttributes() ?> aria-describedby="x_config_name_help">
<?= $Page->config_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->config_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->config_value->Visible) { // config_value ?>
    <div id="r_config_value" class="form-group row">
        <label id="elh_konfigurasi_config_value" for="x_config_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->config_value->caption() ?><?= $Page->config_value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->config_value->cellAttributes() ?>>
<span id="el_konfigurasi_config_value">
<textarea data-table="konfigurasi" data-field="x_config_value" name="x_config_value" id="x_config_value" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->config_value->getPlaceHolder()) ?>"<?= $Page->config_value->editAttributes() ?> aria-describedby="x_config_value_help"><?= $Page->config_value->EditValue ?></textarea>
<?= $Page->config_value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->config_value->getErrorMessage() ?></div>
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
    ew.addEventHandlers("konfigurasi");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
