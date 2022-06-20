<?php

namespace PHPMaker2021\eclearance;

// Page object
$VKajatiKonfigurasiEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fv_kajati_konfigurasiedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fv_kajati_konfigurasiedit = currentForm = new ew.Form("fv_kajati_konfigurasiedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "v_kajati_konfigurasi")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.v_kajati_konfigurasi)
        ew.vars.tables.v_kajati_konfigurasi = currentTable;
    fv_kajati_konfigurasiedit.addFields([
        ["config_name", [fields.config_name.visible && fields.config_name.required ? ew.Validators.required(fields.config_name.caption) : null], fields.config_name.isInvalid],
        ["config_value", [fields.config_value.visible && fields.config_value.required ? ew.Validators.required(fields.config_value.caption) : null], fields.config_value.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fv_kajati_konfigurasiedit,
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
    fv_kajati_konfigurasiedit.validate = function () {
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
    fv_kajati_konfigurasiedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fv_kajati_konfigurasiedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fv_kajati_konfigurasiedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    let config=$("input[data-field=x_config_name]").val();$("input[data-field=x_config_name]").val(toTitleCase(config.replaceAll("_"," ")));
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fv_kajati_konfigurasiedit" id="fv_kajati_konfigurasiedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_kajati_konfigurasi">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->config_name->Visible) { // config_name ?>
    <div id="r_config_name" class="form-group row">
        <label id="elh_v_kajati_konfigurasi_config_name" for="x_config_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->config_name->caption() ?><?= $Page->config_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->config_name->cellAttributes() ?>>
<span id="el_v_kajati_konfigurasi_config_name">
<input type="<?= $Page->config_name->getInputTextType() ?>" data-table="v_kajati_konfigurasi" data-field="x_config_name" name="x_config_name" id="x_config_name" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->config_name->getPlaceHolder()) ?>" value="<?= $Page->config_name->EditValue ?>"<?= $Page->config_name->editAttributes() ?> aria-describedby="x_config_name_help">
<?= $Page->config_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->config_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->config_value->Visible) { // config_value ?>
    <div id="r_config_value" class="form-group row">
        <label id="elh_v_kajati_konfigurasi_config_value" for="x_config_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->config_value->caption() ?><?= $Page->config_value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->config_value->cellAttributes() ?>>
<span id="el_v_kajati_konfigurasi_config_value">
<input type="<?= $Page->config_value->getInputTextType() ?>" data-table="v_kajati_konfigurasi" data-field="x_config_value" name="x_config_value" id="x_config_value" placeholder="<?= HtmlEncode($Page->config_value->getPlaceHolder()) ?>" value="<?= $Page->config_value->EditValue ?>"<?= $Page->config_value->editAttributes() ?> aria-describedby="x_config_value_help">
<?= $Page->config_value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->config_value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="v_kajati_konfigurasi" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("v_kajati_konfigurasi");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
