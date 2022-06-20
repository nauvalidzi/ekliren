<?php

namespace PHPMaker2021\eclearance;

// Page object
$MSatuanKerjaAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fm_satuan_kerjaadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fm_satuan_kerjaadd = currentForm = new ew.Form("fm_satuan_kerjaadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "m_satuan_kerja")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.m_satuan_kerja)
        ew.vars.tables.m_satuan_kerja = currentTable;
    fm_satuan_kerjaadd.addFields([
        ["kode_satker", [fields.kode_satker.visible && fields.kode_satker.required ? ew.Validators.required(fields.kode_satker.caption) : null], fields.kode_satker.isInvalid],
        ["satuan_kerja", [fields.satuan_kerja.visible && fields.satuan_kerja.required ? ew.Validators.required(fields.satuan_kerja.caption) : null], fields.satuan_kerja.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fm_satuan_kerjaadd,
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
    fm_satuan_kerjaadd.validate = function () {
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
    fm_satuan_kerjaadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fm_satuan_kerjaadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fm_satuan_kerjaadd");
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
<form name="fm_satuan_kerjaadd" id="fm_satuan_kerjaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="m_satuan_kerja">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->kode_satker->Visible) { // kode_satker ?>
    <div id="r_kode_satker" class="form-group row">
        <label id="elh_m_satuan_kerja_kode_satker" for="x_kode_satker" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode_satker->caption() ?><?= $Page->kode_satker->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode_satker->cellAttributes() ?>>
<span id="el_m_satuan_kerja_kode_satker">
<input type="<?= $Page->kode_satker->getInputTextType() ?>" data-table="m_satuan_kerja" data-field="x_kode_satker" name="x_kode_satker" id="x_kode_satker" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->kode_satker->getPlaceHolder()) ?>" value="<?= $Page->kode_satker->EditValue ?>"<?= $Page->kode_satker->editAttributes() ?> aria-describedby="x_kode_satker_help">
<?= $Page->kode_satker->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode_satker->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->satuan_kerja->Visible) { // satuan_kerja ?>
    <div id="r_satuan_kerja" class="form-group row">
        <label id="elh_m_satuan_kerja_satuan_kerja" for="x_satuan_kerja" class="<?= $Page->LeftColumnClass ?>"><?= $Page->satuan_kerja->caption() ?><?= $Page->satuan_kerja->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->satuan_kerja->cellAttributes() ?>>
<span id="el_m_satuan_kerja_satuan_kerja">
<input type="<?= $Page->satuan_kerja->getInputTextType() ?>" data-table="m_satuan_kerja" data-field="x_satuan_kerja" name="x_satuan_kerja" id="x_satuan_kerja" size="50" maxlength="255" placeholder="<?= HtmlEncode($Page->satuan_kerja->getPlaceHolder()) ?>" value="<?= $Page->satuan_kerja->EditValue ?>"<?= $Page->satuan_kerja->editAttributes() ?> aria-describedby="x_satuan_kerja_help">
<?= $Page->satuan_kerja->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->satuan_kerja->getErrorMessage() ?></div>
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
    ew.addEventHandlers("m_satuan_kerja");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
