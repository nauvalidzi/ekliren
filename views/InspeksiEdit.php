<?php

namespace PHPMaker2021\eclearance;

// Page object
$InspeksiEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var finspeksiedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    finspeksiedit = currentForm = new ew.Form("finspeksiedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "inspeksi")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.inspeksi)
        ew.vars.tables.inspeksi = currentTable;
    finspeksiedit.addFields([
        ["inspeksi_kasus", [fields.inspeksi_kasus.visible && fields.inspeksi_kasus.required ? ew.Validators.required(fields.inspeksi_kasus.caption) : null], fields.inspeksi_kasus.isInvalid],
        ["pelanggaran_disiplin", [fields.pelanggaran_disiplin.visible && fields.pelanggaran_disiplin.required ? ew.Validators.required(fields.pelanggaran_disiplin.caption) : null], fields.pelanggaran_disiplin.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = finspeksiedit,
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
    finspeksiedit.validate = function () {
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
    finspeksiedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finspeksiedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    finspeksiedit.lists.inspeksi_kasus = <?= $Page->inspeksi_kasus->toClientList($Page) ?>;
    loadjs.done("finspeksiedit");
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
<form name="finspeksiedit" id="finspeksiedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="inspeksi">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "v_sekretariat") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="v_sekretariat">
<input type="hidden" name="fk_id_request" value="<?= HtmlEncode($Page->pid_request_skk->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->inspeksi_kasus->Visible) { // inspeksi_kasus ?>
    <div id="r_inspeksi_kasus" class="form-group row">
        <label id="elh_inspeksi_inspeksi_kasus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->inspeksi_kasus->caption() ?><?= $Page->inspeksi_kasus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->inspeksi_kasus->cellAttributes() ?>>
<span id="el_inspeksi_inspeksi_kasus">
<template id="tp_x_inspeksi_kasus">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="inspeksi" data-field="x_inspeksi_kasus" name="x_inspeksi_kasus" id="x_inspeksi_kasus"<?= $Page->inspeksi_kasus->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_inspeksi_kasus" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_inspeksi_kasus"
    name="x_inspeksi_kasus"
    value="<?= HtmlEncode($Page->inspeksi_kasus->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_inspeksi_kasus"
    data-target="dsl_x_inspeksi_kasus"
    data-repeatcolumn="5"
    class="form-control<?= $Page->inspeksi_kasus->isInvalidClass() ?>"
    data-table="inspeksi"
    data-field="x_inspeksi_kasus"
    data-value-separator="<?= $Page->inspeksi_kasus->displayValueSeparatorAttribute() ?>"
    <?= $Page->inspeksi_kasus->editAttributes() ?>>
<?= $Page->inspeksi_kasus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->inspeksi_kasus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pelanggaran_disiplin->Visible) { // pelanggaran_disiplin ?>
    <div id="r_pelanggaran_disiplin" class="form-group row">
        <label id="elh_inspeksi_pelanggaran_disiplin" for="x_pelanggaran_disiplin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pelanggaran_disiplin->caption() ?><?= $Page->pelanggaran_disiplin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pelanggaran_disiplin->cellAttributes() ?>>
<span id="el_inspeksi_pelanggaran_disiplin">
<input type="<?= $Page->pelanggaran_disiplin->getInputTextType() ?>" data-table="inspeksi" data-field="x_pelanggaran_disiplin" name="x_pelanggaran_disiplin" id="x_pelanggaran_disiplin" size="50" maxlength="255" placeholder="<?= HtmlEncode($Page->pelanggaran_disiplin->getPlaceHolder()) ?>" value="<?= $Page->pelanggaran_disiplin->EditValue ?>"<?= $Page->pelanggaran_disiplin->editAttributes() ?> aria-describedby="x_pelanggaran_disiplin_help">
<?= $Page->pelanggaran_disiplin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pelanggaran_disiplin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="inspeksi" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("inspeksi");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
