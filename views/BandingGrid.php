<?php

namespace PHPMaker2021\eclearance;

// Set up and run Grid object
$Grid = Container("BandingGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fbandinggrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fbandinggrid = new ew.Form("fbandinggrid", "grid");
    fbandinggrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "banding")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.banding)
        ew.vars.tables.banding = currentTable;
    fbandinggrid.addFields([
        ["mengajukan_keberatan_banding", [fields.mengajukan_keberatan_banding.visible && fields.mengajukan_keberatan_banding.required ? ew.Validators.required(fields.mengajukan_keberatan_banding.caption) : null], fields.mengajukan_keberatan_banding.isInvalid],
        ["sk_banding_nomor", [fields.sk_banding_nomor.visible && fields.sk_banding_nomor.required ? ew.Validators.required(fields.sk_banding_nomor.caption) : null], fields.sk_banding_nomor.isInvalid],
        ["tgl_sk_banding", [fields.tgl_sk_banding.visible && fields.tgl_sk_banding.required ? ew.Validators.required(fields.tgl_sk_banding.caption) : null, ew.Validators.datetime(0)], fields.tgl_sk_banding.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fbandinggrid,
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
    fbandinggrid.validate = function () {
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
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    fbandinggrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "mengajukan_keberatan_banding", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sk_banding_nomor", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tgl_sk_banding", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fbandinggrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbandinggrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fbandinggrid.lists.mengajukan_keberatan_banding = <?= $Grid->mengajukan_keberatan_banding->toClientList($Grid) ?>;
    loadjs.done("fbandinggrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> banding">
<div id="fbandinggrid" class="ew-form ew-list-form form-inline">
<div id="gmp_banding" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_bandinggrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->mengajukan_keberatan_banding->Visible) { // mengajukan_keberatan_banding ?>
        <th data-name="mengajukan_keberatan_banding" class="<?= $Grid->mengajukan_keberatan_banding->headerCellClass() ?>"><div id="elh_banding_mengajukan_keberatan_banding" class="banding_mengajukan_keberatan_banding"><?= $Grid->renderSort($Grid->mengajukan_keberatan_banding) ?></div></th>
<?php } ?>
<?php if ($Grid->sk_banding_nomor->Visible) { // sk_banding_nomor ?>
        <th data-name="sk_banding_nomor" class="<?= $Grid->sk_banding_nomor->headerCellClass() ?>"><div id="elh_banding_sk_banding_nomor" class="banding_sk_banding_nomor"><?= $Grid->renderSort($Grid->sk_banding_nomor) ?></div></th>
<?php } ?>
<?php if ($Grid->tgl_sk_banding->Visible) { // tgl_sk_banding ?>
        <th data-name="tgl_sk_banding" class="<?= $Grid->tgl_sk_banding->headerCellClass() ?>"><div id="elh_banding_tgl_sk_banding" class="banding_tgl_sk_banding"><?= $Grid->renderSort($Grid->tgl_sk_banding) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_banding", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->mengajukan_keberatan_banding->Visible) { // mengajukan_keberatan_banding ?>
        <td data-name="mengajukan_keberatan_banding" <?= $Grid->mengajukan_keberatan_banding->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_banding_mengajukan_keberatan_banding" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="banding" data-field="x_mengajukan_keberatan_banding" name="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" id="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"<?= $Grid->mengajukan_keberatan_banding->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    name="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    value="<?= HtmlEncode($Grid->mengajukan_keberatan_banding->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    data-target="dsl_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->mengajukan_keberatan_banding->isInvalidClass() ?>"
    data-table="banding"
    data-field="x_mengajukan_keberatan_banding"
    data-value-separator="<?= $Grid->mengajukan_keberatan_banding->displayValueSeparatorAttribute() ?>"
    <?= $Grid->mengajukan_keberatan_banding->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->mengajukan_keberatan_banding->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="banding" data-field="x_mengajukan_keberatan_banding" data-hidden="1" name="o<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" id="o<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" value="<?= HtmlEncode($Grid->mengajukan_keberatan_banding->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_banding_mengajukan_keberatan_banding" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="banding" data-field="x_mengajukan_keberatan_banding" name="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" id="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"<?= $Grid->mengajukan_keberatan_banding->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    name="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    value="<?= HtmlEncode($Grid->mengajukan_keberatan_banding->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    data-target="dsl_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->mengajukan_keberatan_banding->isInvalidClass() ?>"
    data-table="banding"
    data-field="x_mengajukan_keberatan_banding"
    data-value-separator="<?= $Grid->mengajukan_keberatan_banding->displayValueSeparatorAttribute() ?>"
    <?= $Grid->mengajukan_keberatan_banding->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->mengajukan_keberatan_banding->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_banding_mengajukan_keberatan_banding">
<span<?= $Grid->mengajukan_keberatan_banding->viewAttributes() ?>>
<?= $Grid->mengajukan_keberatan_banding->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="banding" data-field="x_mengajukan_keberatan_banding" data-hidden="1" name="fbandinggrid$x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" id="fbandinggrid$x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" value="<?= HtmlEncode($Grid->mengajukan_keberatan_banding->FormValue) ?>">
<input type="hidden" data-table="banding" data-field="x_mengajukan_keberatan_banding" data-hidden="1" name="fbandinggrid$o<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" id="fbandinggrid$o<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" value="<?= HtmlEncode($Grid->mengajukan_keberatan_banding->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sk_banding_nomor->Visible) { // sk_banding_nomor ?>
        <td data-name="sk_banding_nomor" <?= $Grid->sk_banding_nomor->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_banding_sk_banding_nomor" class="form-group">
<input type="<?= $Grid->sk_banding_nomor->getInputTextType() ?>" data-table="banding" data-field="x_sk_banding_nomor" name="x<?= $Grid->RowIndex ?>_sk_banding_nomor" id="x<?= $Grid->RowIndex ?>_sk_banding_nomor" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->sk_banding_nomor->getPlaceHolder()) ?>" value="<?= $Grid->sk_banding_nomor->EditValue ?>"<?= $Grid->sk_banding_nomor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sk_banding_nomor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="banding" data-field="x_sk_banding_nomor" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sk_banding_nomor" id="o<?= $Grid->RowIndex ?>_sk_banding_nomor" value="<?= HtmlEncode($Grid->sk_banding_nomor->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_banding_sk_banding_nomor" class="form-group">
<input type="<?= $Grid->sk_banding_nomor->getInputTextType() ?>" data-table="banding" data-field="x_sk_banding_nomor" name="x<?= $Grid->RowIndex ?>_sk_banding_nomor" id="x<?= $Grid->RowIndex ?>_sk_banding_nomor" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->sk_banding_nomor->getPlaceHolder()) ?>" value="<?= $Grid->sk_banding_nomor->EditValue ?>"<?= $Grid->sk_banding_nomor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sk_banding_nomor->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_banding_sk_banding_nomor">
<span<?= $Grid->sk_banding_nomor->viewAttributes() ?>>
<?= $Grid->sk_banding_nomor->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="banding" data-field="x_sk_banding_nomor" data-hidden="1" name="fbandinggrid$x<?= $Grid->RowIndex ?>_sk_banding_nomor" id="fbandinggrid$x<?= $Grid->RowIndex ?>_sk_banding_nomor" value="<?= HtmlEncode($Grid->sk_banding_nomor->FormValue) ?>">
<input type="hidden" data-table="banding" data-field="x_sk_banding_nomor" data-hidden="1" name="fbandinggrid$o<?= $Grid->RowIndex ?>_sk_banding_nomor" id="fbandinggrid$o<?= $Grid->RowIndex ?>_sk_banding_nomor" value="<?= HtmlEncode($Grid->sk_banding_nomor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tgl_sk_banding->Visible) { // tgl_sk_banding ?>
        <td data-name="tgl_sk_banding" <?= $Grid->tgl_sk_banding->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_banding_tgl_sk_banding" class="form-group">
<input type="<?= $Grid->tgl_sk_banding->getInputTextType() ?>" data-table="banding" data-field="x_tgl_sk_banding" name="x<?= $Grid->RowIndex ?>_tgl_sk_banding" id="x<?= $Grid->RowIndex ?>_tgl_sk_banding" maxlength="255" placeholder="<?= HtmlEncode($Grid->tgl_sk_banding->getPlaceHolder()) ?>" value="<?= $Grid->tgl_sk_banding->EditValue ?>"<?= $Grid->tgl_sk_banding->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tgl_sk_banding->getErrorMessage() ?></div>
<?php if (!$Grid->tgl_sk_banding->ReadOnly && !$Grid->tgl_sk_banding->Disabled && !isset($Grid->tgl_sk_banding->EditAttrs["readonly"]) && !isset($Grid->tgl_sk_banding->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbandinggrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fbandinggrid", "x<?= $Grid->RowIndex ?>_tgl_sk_banding", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="banding" data-field="x_tgl_sk_banding" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tgl_sk_banding" id="o<?= $Grid->RowIndex ?>_tgl_sk_banding" value="<?= HtmlEncode($Grid->tgl_sk_banding->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_banding_tgl_sk_banding" class="form-group">
<input type="<?= $Grid->tgl_sk_banding->getInputTextType() ?>" data-table="banding" data-field="x_tgl_sk_banding" name="x<?= $Grid->RowIndex ?>_tgl_sk_banding" id="x<?= $Grid->RowIndex ?>_tgl_sk_banding" maxlength="255" placeholder="<?= HtmlEncode($Grid->tgl_sk_banding->getPlaceHolder()) ?>" value="<?= $Grid->tgl_sk_banding->EditValue ?>"<?= $Grid->tgl_sk_banding->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tgl_sk_banding->getErrorMessage() ?></div>
<?php if (!$Grid->tgl_sk_banding->ReadOnly && !$Grid->tgl_sk_banding->Disabled && !isset($Grid->tgl_sk_banding->EditAttrs["readonly"]) && !isset($Grid->tgl_sk_banding->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbandinggrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fbandinggrid", "x<?= $Grid->RowIndex ?>_tgl_sk_banding", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_banding_tgl_sk_banding">
<span<?= $Grid->tgl_sk_banding->viewAttributes() ?>>
<?= $Grid->tgl_sk_banding->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="banding" data-field="x_tgl_sk_banding" data-hidden="1" name="fbandinggrid$x<?= $Grid->RowIndex ?>_tgl_sk_banding" id="fbandinggrid$x<?= $Grid->RowIndex ?>_tgl_sk_banding" value="<?= HtmlEncode($Grid->tgl_sk_banding->FormValue) ?>">
<input type="hidden" data-table="banding" data-field="x_tgl_sk_banding" data-hidden="1" name="fbandinggrid$o<?= $Grid->RowIndex ?>_tgl_sk_banding" id="fbandinggrid$o<?= $Grid->RowIndex ?>_tgl_sk_banding" value="<?= HtmlEncode($Grid->tgl_sk_banding->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fbandinggrid","load"], function () {
    fbandinggrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_banding", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->mengajukan_keberatan_banding->Visible) { // mengajukan_keberatan_banding ?>
        <td data-name="mengajukan_keberatan_banding">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_banding_mengajukan_keberatan_banding" class="form-group banding_mengajukan_keberatan_banding">
<template id="tp_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="banding" data-field="x_mengajukan_keberatan_banding" name="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" id="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"<?= $Grid->mengajukan_keberatan_banding->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    name="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    value="<?= HtmlEncode($Grid->mengajukan_keberatan_banding->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    data-target="dsl_x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->mengajukan_keberatan_banding->isInvalidClass() ?>"
    data-table="banding"
    data-field="x_mengajukan_keberatan_banding"
    data-value-separator="<?= $Grid->mengajukan_keberatan_banding->displayValueSeparatorAttribute() ?>"
    <?= $Grid->mengajukan_keberatan_banding->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->mengajukan_keberatan_banding->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_banding_mengajukan_keberatan_banding" class="form-group banding_mengajukan_keberatan_banding">
<span<?= $Grid->mengajukan_keberatan_banding->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->mengajukan_keberatan_banding->getDisplayValue($Grid->mengajukan_keberatan_banding->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="banding" data-field="x_mengajukan_keberatan_banding" data-hidden="1" name="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" id="x<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" value="<?= HtmlEncode($Grid->mengajukan_keberatan_banding->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="banding" data-field="x_mengajukan_keberatan_banding" data-hidden="1" name="o<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" id="o<?= $Grid->RowIndex ?>_mengajukan_keberatan_banding" value="<?= HtmlEncode($Grid->mengajukan_keberatan_banding->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sk_banding_nomor->Visible) { // sk_banding_nomor ?>
        <td data-name="sk_banding_nomor">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_banding_sk_banding_nomor" class="form-group banding_sk_banding_nomor">
<input type="<?= $Grid->sk_banding_nomor->getInputTextType() ?>" data-table="banding" data-field="x_sk_banding_nomor" name="x<?= $Grid->RowIndex ?>_sk_banding_nomor" id="x<?= $Grid->RowIndex ?>_sk_banding_nomor" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->sk_banding_nomor->getPlaceHolder()) ?>" value="<?= $Grid->sk_banding_nomor->EditValue ?>"<?= $Grid->sk_banding_nomor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sk_banding_nomor->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_banding_sk_banding_nomor" class="form-group banding_sk_banding_nomor">
<span<?= $Grid->sk_banding_nomor->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sk_banding_nomor->getDisplayValue($Grid->sk_banding_nomor->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="banding" data-field="x_sk_banding_nomor" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sk_banding_nomor" id="x<?= $Grid->RowIndex ?>_sk_banding_nomor" value="<?= HtmlEncode($Grid->sk_banding_nomor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="banding" data-field="x_sk_banding_nomor" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sk_banding_nomor" id="o<?= $Grid->RowIndex ?>_sk_banding_nomor" value="<?= HtmlEncode($Grid->sk_banding_nomor->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tgl_sk_banding->Visible) { // tgl_sk_banding ?>
        <td data-name="tgl_sk_banding">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_banding_tgl_sk_banding" class="form-group banding_tgl_sk_banding">
<input type="<?= $Grid->tgl_sk_banding->getInputTextType() ?>" data-table="banding" data-field="x_tgl_sk_banding" name="x<?= $Grid->RowIndex ?>_tgl_sk_banding" id="x<?= $Grid->RowIndex ?>_tgl_sk_banding" maxlength="255" placeholder="<?= HtmlEncode($Grid->tgl_sk_banding->getPlaceHolder()) ?>" value="<?= $Grid->tgl_sk_banding->EditValue ?>"<?= $Grid->tgl_sk_banding->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tgl_sk_banding->getErrorMessage() ?></div>
<?php if (!$Grid->tgl_sk_banding->ReadOnly && !$Grid->tgl_sk_banding->Disabled && !isset($Grid->tgl_sk_banding->EditAttrs["readonly"]) && !isset($Grid->tgl_sk_banding->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbandinggrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fbandinggrid", "x<?= $Grid->RowIndex ?>_tgl_sk_banding", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_banding_tgl_sk_banding" class="form-group banding_tgl_sk_banding">
<span<?= $Grid->tgl_sk_banding->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tgl_sk_banding->getDisplayValue($Grid->tgl_sk_banding->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="banding" data-field="x_tgl_sk_banding" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tgl_sk_banding" id="x<?= $Grid->RowIndex ?>_tgl_sk_banding" value="<?= HtmlEncode($Grid->tgl_sk_banding->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="banding" data-field="x_tgl_sk_banding" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tgl_sk_banding" id="o<?= $Grid->RowIndex ?>_tgl_sk_banding" value="<?= HtmlEncode($Grid->tgl_sk_banding->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fbandinggrid","load"], function() {
    fbandinggrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fbandinggrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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
<?php } ?>
