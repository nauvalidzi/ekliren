<?php

namespace PHPMaker2021\eclearance;

// Page object
$DataUserEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fdata_useredit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fdata_useredit = currentForm = new ew.Form("fdata_useredit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "data_user")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.data_user)
        ew.vars.tables.data_user = currentTable;
    fdata_useredit.addFields([
        ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
        ["unit_organisasi", [fields.unit_organisasi.visible && fields.unit_organisasi.required ? ew.Validators.required(fields.unit_organisasi.caption) : null], fields.unit_organisasi.isInvalid],
        ["email_satker", [fields.email_satker.visible && fields.email_satker.required ? ew.Validators.required(fields.email_satker.caption) : null], fields.email_satker.isInvalid],
        ["hak_akses", [fields.hak_akses.visible && fields.hak_akses.required ? ew.Validators.required(fields.hak_akses.caption) : null], fields.hak_akses.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fdata_useredit,
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
    fdata_useredit.validate = function () {
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
    fdata_useredit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdata_useredit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fdata_useredit.lists.unit_organisasi = <?= $Page->unit_organisasi->toClientList($Page) ?>;
    fdata_useredit.lists.hak_akses = <?= $Page->hak_akses->toClientList($Page) ?>;
    loadjs.done("fdata_useredit");
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
<form name="fdata_useredit" id="fdata_useredit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="data_user">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->_username->Visible) { // username ?>
    <div id="r__username" class="form-group row">
        <label id="elh_data_user__username" for="x__username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_username->caption() ?><?= $Page->_username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_username->cellAttributes() ?>>
<span id="el_data_user__username">
<span<?= $Page->_username->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_username->getDisplayValue($Page->_username->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="data_user" data-field="x__username" data-hidden="1" name="x__username" id="x__username" value="<?= HtmlEncode($Page->_username->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
    <div id="r_unit_organisasi" class="form-group row">
        <label id="elh_data_user_unit_organisasi" for="x_unit_organisasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unit_organisasi->caption() ?><?= $Page->unit_organisasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->unit_organisasi->cellAttributes() ?>>
<span id="el_data_user_unit_organisasi">
    <select
        id="x_unit_organisasi"
        name="x_unit_organisasi"
        class="form-control ew-select<?= $Page->unit_organisasi->isInvalidClass() ?>"
        data-select2-id="data_user_x_unit_organisasi"
        data-table="data_user"
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
    var el = document.querySelector("select[data-select2-id='data_user_x_unit_organisasi']"),
        options = { name: "x_unit_organisasi", selectId: "data_user_x_unit_organisasi", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.data_user.fields.unit_organisasi.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email_satker->Visible) { // email_satker ?>
    <div id="r_email_satker" class="form-group row">
        <label id="elh_data_user_email_satker" for="x_email_satker" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email_satker->caption() ?><?= $Page->email_satker->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->email_satker->cellAttributes() ?>>
<span id="el_data_user_email_satker">
<input type="<?= $Page->email_satker->getInputTextType() ?>" data-table="data_user" data-field="x_email_satker" name="x_email_satker" id="x_email_satker" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->email_satker->getPlaceHolder()) ?>" value="<?= $Page->email_satker->EditValue ?>"<?= $Page->email_satker->editAttributes() ?> aria-describedby="x_email_satker_help">
<?= $Page->email_satker->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email_satker->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hak_akses->Visible) { // hak_akses ?>
    <div id="r_hak_akses" class="form-group row">
        <label id="elh_data_user_hak_akses" for="x_hak_akses" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hak_akses->caption() ?><?= $Page->hak_akses->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hak_akses->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_data_user_hak_akses">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->hak_akses->getDisplayValue($Page->hak_akses->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el_data_user_hak_akses">
    <select
        id="x_hak_akses"
        name="x_hak_akses"
        class="form-control ew-select<?= $Page->hak_akses->isInvalidClass() ?>"
        data-select2-id="data_user_x_hak_akses"
        data-table="data_user"
        data-field="x_hak_akses"
        data-value-separator="<?= $Page->hak_akses->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->hak_akses->getPlaceHolder()) ?>"
        <?= $Page->hak_akses->editAttributes() ?>>
        <?= $Page->hak_akses->selectOptionListHtml("x_hak_akses") ?>
    </select>
    <?= $Page->hak_akses->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->hak_akses->getErrorMessage() ?></div>
<?= $Page->hak_akses->Lookup->getParamTag($Page, "p_x_hak_akses") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='data_user_x_hak_akses']"),
        options = { name: "x_hak_akses", selectId: "data_user_x_hak_akses", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.data_user.fields.hak_akses.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="data_user" data-field="x_id_user" data-hidden="1" name="x_id_user" id="x_id_user" value="<?= HtmlEncode($Page->id_user->CurrentValue) ?>">
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
    ew.addEventHandlers("data_user");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
