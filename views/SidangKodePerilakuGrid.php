<?php

namespace PHPMaker2021\eclearance;

// Set up and run Grid object
$Grid = Container("SidangKodePerilakuGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsidang_kode_perilakugrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fsidang_kode_perilakugrid = new ew.Form("fsidang_kode_perilakugrid", "grid");
    fsidang_kode_perilakugrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "sidang_kode_perilaku")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.sidang_kode_perilaku)
        ew.vars.tables.sidang_kode_perilaku = currentTable;
    fsidang_kode_perilakugrid.addFields([
        ["sidang_kode_perilaku_jaksa", [fields.sidang_kode_perilaku_jaksa.visible && fields.sidang_kode_perilaku_jaksa.required ? ew.Validators.required(fields.sidang_kode_perilaku_jaksa.caption) : null], fields.sidang_kode_perilaku_jaksa.isInvalid],
        ["tempat_sidang_kode_perilaku", [fields.tempat_sidang_kode_perilaku.visible && fields.tempat_sidang_kode_perilaku.required ? ew.Validators.required(fields.tempat_sidang_kode_perilaku.caption) : null], fields.tempat_sidang_kode_perilaku.isInvalid],
        ["hukuman_administratif", [fields.hukuman_administratif.visible && fields.hukuman_administratif.required ? ew.Validators.required(fields.hukuman_administratif.caption) : null], fields.hukuman_administratif.isInvalid],
        ["sk_nomor_kode_perilaku", [fields.sk_nomor_kode_perilaku.visible && fields.sk_nomor_kode_perilaku.required ? ew.Validators.required(fields.sk_nomor_kode_perilaku.caption) : null], fields.sk_nomor_kode_perilaku.isInvalid],
        ["tgl_sk_kode_perilaku", [fields.tgl_sk_kode_perilaku.visible && fields.tgl_sk_kode_perilaku.required ? ew.Validators.required(fields.tgl_sk_kode_perilaku.caption) : null, ew.Validators.datetime(0)], fields.tgl_sk_kode_perilaku.isInvalid],
        ["status_hukuman_kode_perilaku", [fields.status_hukuman_kode_perilaku.visible && fields.status_hukuman_kode_perilaku.required ? ew.Validators.required(fields.status_hukuman_kode_perilaku.caption) : null], fields.status_hukuman_kode_perilaku.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsidang_kode_perilakugrid,
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
    fsidang_kode_perilakugrid.validate = function () {
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
    fsidang_kode_perilakugrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "sidang_kode_perilaku_jaksa", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tempat_sidang_kode_perilaku", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "hukuman_administratif", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sk_nomor_kode_perilaku", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tgl_sk_kode_perilaku", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "status_hukuman_kode_perilaku", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsidang_kode_perilakugrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsidang_kode_perilakugrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsidang_kode_perilakugrid.lists.sidang_kode_perilaku_jaksa = <?= $Grid->sidang_kode_perilaku_jaksa->toClientList($Grid) ?>;
    fsidang_kode_perilakugrid.lists.tempat_sidang_kode_perilaku = <?= $Grid->tempat_sidang_kode_perilaku->toClientList($Grid) ?>;
    fsidang_kode_perilakugrid.lists.status_hukuman_kode_perilaku = <?= $Grid->status_hukuman_kode_perilaku->toClientList($Grid) ?>;
    loadjs.done("fsidang_kode_perilakugrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> sidang_kode_perilaku">
<div id="fsidang_kode_perilakugrid" class="ew-form ew-list-form form-inline">
<div id="gmp_sidang_kode_perilaku" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_sidang_kode_perilakugrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->sidang_kode_perilaku_jaksa->Visible) { // sidang_kode_perilaku_jaksa ?>
        <th data-name="sidang_kode_perilaku_jaksa" class="<?= $Grid->sidang_kode_perilaku_jaksa->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_sidang_kode_perilaku_jaksa" class="sidang_kode_perilaku_sidang_kode_perilaku_jaksa"><?= $Grid->renderSort($Grid->sidang_kode_perilaku_jaksa) ?></div></th>
<?php } ?>
<?php if ($Grid->tempat_sidang_kode_perilaku->Visible) { // tempat_sidang_kode_perilaku ?>
        <th data-name="tempat_sidang_kode_perilaku" class="<?= $Grid->tempat_sidang_kode_perilaku->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_tempat_sidang_kode_perilaku" class="sidang_kode_perilaku_tempat_sidang_kode_perilaku"><?= $Grid->renderSort($Grid->tempat_sidang_kode_perilaku) ?></div></th>
<?php } ?>
<?php if ($Grid->hukuman_administratif->Visible) { // hukuman_administratif ?>
        <th data-name="hukuman_administratif" class="<?= $Grid->hukuman_administratif->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_hukuman_administratif" class="sidang_kode_perilaku_hukuman_administratif"><?= $Grid->renderSort($Grid->hukuman_administratif) ?></div></th>
<?php } ?>
<?php if ($Grid->sk_nomor_kode_perilaku->Visible) { // sk_nomor_kode_perilaku ?>
        <th data-name="sk_nomor_kode_perilaku" class="<?= $Grid->sk_nomor_kode_perilaku->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_sk_nomor_kode_perilaku" class="sidang_kode_perilaku_sk_nomor_kode_perilaku"><?= $Grid->renderSort($Grid->sk_nomor_kode_perilaku) ?></div></th>
<?php } ?>
<?php if ($Grid->tgl_sk_kode_perilaku->Visible) { // tgl_sk_kode_perilaku ?>
        <th data-name="tgl_sk_kode_perilaku" class="<?= $Grid->tgl_sk_kode_perilaku->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_tgl_sk_kode_perilaku" class="sidang_kode_perilaku_tgl_sk_kode_perilaku"><?= $Grid->renderSort($Grid->tgl_sk_kode_perilaku) ?></div></th>
<?php } ?>
<?php if ($Grid->status_hukuman_kode_perilaku->Visible) { // status_hukuman_kode_perilaku ?>
        <th data-name="status_hukuman_kode_perilaku" class="<?= $Grid->status_hukuman_kode_perilaku->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_status_hukuman_kode_perilaku" class="sidang_kode_perilaku_status_hukuman_kode_perilaku"><?= $Grid->renderSort($Grid->status_hukuman_kode_perilaku) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_sidang_kode_perilaku", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->sidang_kode_perilaku_jaksa->Visible) { // sidang_kode_perilaku_jaksa ?>
        <td data-name="sidang_kode_perilaku_jaksa" <?= $Grid->sidang_kode_perilaku_jaksa->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_sidang_kode_perilaku_jaksa" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="sidang_kode_perilaku" data-field="x_sidang_kode_perilaku_jaksa" name="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" id="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"<?= $Grid->sidang_kode_perilaku_jaksa->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    name="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    value="<?= HtmlEncode($Grid->sidang_kode_perilaku_jaksa->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    data-target="dsl_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->sidang_kode_perilaku_jaksa->isInvalidClass() ?>"
    data-table="sidang_kode_perilaku"
    data-field="x_sidang_kode_perilaku_jaksa"
    data-value-separator="<?= $Grid->sidang_kode_perilaku_jaksa->displayValueSeparatorAttribute() ?>"
    <?= $Grid->sidang_kode_perilaku_jaksa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sidang_kode_perilaku_jaksa->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_sidang_kode_perilaku_jaksa" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" id="o<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" value="<?= HtmlEncode($Grid->sidang_kode_perilaku_jaksa->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_sidang_kode_perilaku_jaksa" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="sidang_kode_perilaku" data-field="x_sidang_kode_perilaku_jaksa" name="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" id="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"<?= $Grid->sidang_kode_perilaku_jaksa->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    name="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    value="<?= HtmlEncode($Grid->sidang_kode_perilaku_jaksa->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    data-target="dsl_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->sidang_kode_perilaku_jaksa->isInvalidClass() ?>"
    data-table="sidang_kode_perilaku"
    data-field="x_sidang_kode_perilaku_jaksa"
    data-value-separator="<?= $Grid->sidang_kode_perilaku_jaksa->displayValueSeparatorAttribute() ?>"
    <?= $Grid->sidang_kode_perilaku_jaksa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sidang_kode_perilaku_jaksa->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_sidang_kode_perilaku_jaksa">
<span<?= $Grid->sidang_kode_perilaku_jaksa->viewAttributes() ?>>
<?= $Grid->sidang_kode_perilaku_jaksa->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_sidang_kode_perilaku_jaksa" data-hidden="1" name="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" id="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" value="<?= HtmlEncode($Grid->sidang_kode_perilaku_jaksa->FormValue) ?>">
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_sidang_kode_perilaku_jaksa" data-hidden="1" name="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" id="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" value="<?= HtmlEncode($Grid->sidang_kode_perilaku_jaksa->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tempat_sidang_kode_perilaku->Visible) { // tempat_sidang_kode_perilaku ?>
        <td data-name="tempat_sidang_kode_perilaku" <?= $Grid->tempat_sidang_kode_perilaku->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_tempat_sidang_kode_perilaku" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku"
        name="x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku"
        class="form-control ew-select<?= $Grid->tempat_sidang_kode_perilaku->isInvalidClass() ?>"
        data-select2-id="sidang_kode_perilaku_x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku"
        data-table="sidang_kode_perilaku"
        data-field="x_tempat_sidang_kode_perilaku"
        data-value-separator="<?= $Grid->tempat_sidang_kode_perilaku->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tempat_sidang_kode_perilaku->getPlaceHolder()) ?>"
        <?= $Grid->tempat_sidang_kode_perilaku->editAttributes() ?>>
        <?= $Grid->tempat_sidang_kode_perilaku->selectOptionListHtml("x{$Grid->RowIndex}_tempat_sidang_kode_perilaku") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tempat_sidang_kode_perilaku->getErrorMessage() ?></div>
<?= $Grid->tempat_sidang_kode_perilaku->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tempat_sidang_kode_perilaku") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sidang_kode_perilaku_x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku']"),
        options = { name: "x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku", selectId: "sidang_kode_perilaku_x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sidang_kode_perilaku.fields.tempat_sidang_kode_perilaku.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_tempat_sidang_kode_perilaku" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku" id="o<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku" value="<?= HtmlEncode($Grid->tempat_sidang_kode_perilaku->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_tempat_sidang_kode_perilaku" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku"
        name="x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku"
        class="form-control ew-select<?= $Grid->tempat_sidang_kode_perilaku->isInvalidClass() ?>"
        data-select2-id="sidang_kode_perilaku_x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku"
        data-table="sidang_kode_perilaku"
        data-field="x_tempat_sidang_kode_perilaku"
        data-value-separator="<?= $Grid->tempat_sidang_kode_perilaku->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tempat_sidang_kode_perilaku->getPlaceHolder()) ?>"
        <?= $Grid->tempat_sidang_kode_perilaku->editAttributes() ?>>
        <?= $Grid->tempat_sidang_kode_perilaku->selectOptionListHtml("x{$Grid->RowIndex}_tempat_sidang_kode_perilaku") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tempat_sidang_kode_perilaku->getErrorMessage() ?></div>
<?= $Grid->tempat_sidang_kode_perilaku->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tempat_sidang_kode_perilaku") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sidang_kode_perilaku_x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku']"),
        options = { name: "x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku", selectId: "sidang_kode_perilaku_x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sidang_kode_perilaku.fields.tempat_sidang_kode_perilaku.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_tempat_sidang_kode_perilaku">
<span<?= $Grid->tempat_sidang_kode_perilaku->viewAttributes() ?>>
<?= $Grid->tempat_sidang_kode_perilaku->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_tempat_sidang_kode_perilaku" data-hidden="1" name="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku" id="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku" value="<?= HtmlEncode($Grid->tempat_sidang_kode_perilaku->FormValue) ?>">
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_tempat_sidang_kode_perilaku" data-hidden="1" name="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku" id="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku" value="<?= HtmlEncode($Grid->tempat_sidang_kode_perilaku->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->hukuman_administratif->Visible) { // hukuman_administratif ?>
        <td data-name="hukuman_administratif" <?= $Grid->hukuman_administratif->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_hukuman_administratif" class="form-group">
<input type="<?= $Grid->hukuman_administratif->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_hukuman_administratif" name="x<?= $Grid->RowIndex ?>_hukuman_administratif" id="x<?= $Grid->RowIndex ?>_hukuman_administratif" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->hukuman_administratif->getPlaceHolder()) ?>" value="<?= $Grid->hukuman_administratif->EditValue ?>"<?= $Grid->hukuman_administratif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hukuman_administratif->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_hukuman_administratif" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hukuman_administratif" id="o<?= $Grid->RowIndex ?>_hukuman_administratif" value="<?= HtmlEncode($Grid->hukuman_administratif->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_hukuman_administratif" class="form-group">
<input type="<?= $Grid->hukuman_administratif->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_hukuman_administratif" name="x<?= $Grid->RowIndex ?>_hukuman_administratif" id="x<?= $Grid->RowIndex ?>_hukuman_administratif" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->hukuman_administratif->getPlaceHolder()) ?>" value="<?= $Grid->hukuman_administratif->EditValue ?>"<?= $Grid->hukuman_administratif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hukuman_administratif->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_hukuman_administratif">
<span<?= $Grid->hukuman_administratif->viewAttributes() ?>>
<?= $Grid->hukuman_administratif->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_hukuman_administratif" data-hidden="1" name="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_hukuman_administratif" id="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_hukuman_administratif" value="<?= HtmlEncode($Grid->hukuman_administratif->FormValue) ?>">
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_hukuman_administratif" data-hidden="1" name="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_hukuman_administratif" id="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_hukuman_administratif" value="<?= HtmlEncode($Grid->hukuman_administratif->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sk_nomor_kode_perilaku->Visible) { // sk_nomor_kode_perilaku ?>
        <td data-name="sk_nomor_kode_perilaku" <?= $Grid->sk_nomor_kode_perilaku->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_sk_nomor_kode_perilaku" class="form-group">
<input type="<?= $Grid->sk_nomor_kode_perilaku->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_sk_nomor_kode_perilaku" name="x<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" id="x<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->sk_nomor_kode_perilaku->getPlaceHolder()) ?>" value="<?= $Grid->sk_nomor_kode_perilaku->EditValue ?>"<?= $Grid->sk_nomor_kode_perilaku->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sk_nomor_kode_perilaku->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_sk_nomor_kode_perilaku" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" id="o<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" value="<?= HtmlEncode($Grid->sk_nomor_kode_perilaku->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_sk_nomor_kode_perilaku" class="form-group">
<input type="<?= $Grid->sk_nomor_kode_perilaku->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_sk_nomor_kode_perilaku" name="x<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" id="x<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->sk_nomor_kode_perilaku->getPlaceHolder()) ?>" value="<?= $Grid->sk_nomor_kode_perilaku->EditValue ?>"<?= $Grid->sk_nomor_kode_perilaku->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sk_nomor_kode_perilaku->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_sk_nomor_kode_perilaku">
<span<?= $Grid->sk_nomor_kode_perilaku->viewAttributes() ?>>
<?= $Grid->sk_nomor_kode_perilaku->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_sk_nomor_kode_perilaku" data-hidden="1" name="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" id="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" value="<?= HtmlEncode($Grid->sk_nomor_kode_perilaku->FormValue) ?>">
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_sk_nomor_kode_perilaku" data-hidden="1" name="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" id="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" value="<?= HtmlEncode($Grid->sk_nomor_kode_perilaku->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tgl_sk_kode_perilaku->Visible) { // tgl_sk_kode_perilaku ?>
        <td data-name="tgl_sk_kode_perilaku" <?= $Grid->tgl_sk_kode_perilaku->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_tgl_sk_kode_perilaku" class="form-group">
<input type="<?= $Grid->tgl_sk_kode_perilaku->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_tgl_sk_kode_perilaku" name="x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" id="x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" placeholder="<?= HtmlEncode($Grid->tgl_sk_kode_perilaku->getPlaceHolder()) ?>" value="<?= $Grid->tgl_sk_kode_perilaku->EditValue ?>"<?= $Grid->tgl_sk_kode_perilaku->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tgl_sk_kode_perilaku->getErrorMessage() ?></div>
<?php if (!$Grid->tgl_sk_kode_perilaku->ReadOnly && !$Grid->tgl_sk_kode_perilaku->Disabled && !isset($Grid->tgl_sk_kode_perilaku->EditAttrs["readonly"]) && !isset($Grid->tgl_sk_kode_perilaku->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsidang_kode_perilakugrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fsidang_kode_perilakugrid", "x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_tgl_sk_kode_perilaku" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" id="o<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" value="<?= HtmlEncode($Grid->tgl_sk_kode_perilaku->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_tgl_sk_kode_perilaku" class="form-group">
<input type="<?= $Grid->tgl_sk_kode_perilaku->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_tgl_sk_kode_perilaku" name="x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" id="x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" placeholder="<?= HtmlEncode($Grid->tgl_sk_kode_perilaku->getPlaceHolder()) ?>" value="<?= $Grid->tgl_sk_kode_perilaku->EditValue ?>"<?= $Grid->tgl_sk_kode_perilaku->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tgl_sk_kode_perilaku->getErrorMessage() ?></div>
<?php if (!$Grid->tgl_sk_kode_perilaku->ReadOnly && !$Grid->tgl_sk_kode_perilaku->Disabled && !isset($Grid->tgl_sk_kode_perilaku->EditAttrs["readonly"]) && !isset($Grid->tgl_sk_kode_perilaku->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsidang_kode_perilakugrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fsidang_kode_perilakugrid", "x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_tgl_sk_kode_perilaku">
<span<?= $Grid->tgl_sk_kode_perilaku->viewAttributes() ?>>
<?= $Grid->tgl_sk_kode_perilaku->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_tgl_sk_kode_perilaku" data-hidden="1" name="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" id="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" value="<?= HtmlEncode($Grid->tgl_sk_kode_perilaku->FormValue) ?>">
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_tgl_sk_kode_perilaku" data-hidden="1" name="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" id="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" value="<?= HtmlEncode($Grid->tgl_sk_kode_perilaku->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_hukuman_kode_perilaku->Visible) { // status_hukuman_kode_perilaku ?>
        <td data-name="status_hukuman_kode_perilaku" <?= $Grid->status_hukuman_kode_perilaku->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_status_hukuman_kode_perilaku" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="sidang_kode_perilaku" data-field="x_status_hukuman_kode_perilaku" name="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" id="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"<?= $Grid->status_hukuman_kode_perilaku->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    name="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    value="<?= HtmlEncode($Grid->status_hukuman_kode_perilaku->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_hukuman_kode_perilaku->isInvalidClass() ?>"
    data-table="sidang_kode_perilaku"
    data-field="x_status_hukuman_kode_perilaku"
    data-value-separator="<?= $Grid->status_hukuman_kode_perilaku->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_hukuman_kode_perilaku->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_hukuman_kode_perilaku->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_status_hukuman_kode_perilaku" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" id="o<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" value="<?= HtmlEncode($Grid->status_hukuman_kode_perilaku->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_status_hukuman_kode_perilaku" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="sidang_kode_perilaku" data-field="x_status_hukuman_kode_perilaku" name="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" id="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"<?= $Grid->status_hukuman_kode_perilaku->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    name="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    value="<?= HtmlEncode($Grid->status_hukuman_kode_perilaku->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_hukuman_kode_perilaku->isInvalidClass() ?>"
    data-table="sidang_kode_perilaku"
    data-field="x_status_hukuman_kode_perilaku"
    data-value-separator="<?= $Grid->status_hukuman_kode_perilaku->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_hukuman_kode_perilaku->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_hukuman_kode_perilaku->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_sidang_kode_perilaku_status_hukuman_kode_perilaku">
<span<?= $Grid->status_hukuman_kode_perilaku->viewAttributes() ?>>
<?= $Grid->status_hukuman_kode_perilaku->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_status_hukuman_kode_perilaku" data-hidden="1" name="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" id="fsidang_kode_perilakugrid$x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" value="<?= HtmlEncode($Grid->status_hukuman_kode_perilaku->FormValue) ?>">
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_status_hukuman_kode_perilaku" data-hidden="1" name="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" id="fsidang_kode_perilakugrid$o<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" value="<?= HtmlEncode($Grid->status_hukuman_kode_perilaku->OldValue) ?>">
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
loadjs.ready(["fsidang_kode_perilakugrid","load"], function () {
    fsidang_kode_perilakugrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_sidang_kode_perilaku", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->sidang_kode_perilaku_jaksa->Visible) { // sidang_kode_perilaku_jaksa ?>
        <td data-name="sidang_kode_perilaku_jaksa">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sidang_kode_perilaku_sidang_kode_perilaku_jaksa" class="form-group sidang_kode_perilaku_sidang_kode_perilaku_jaksa">
<template id="tp_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="sidang_kode_perilaku" data-field="x_sidang_kode_perilaku_jaksa" name="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" id="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"<?= $Grid->sidang_kode_perilaku_jaksa->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    name="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    value="<?= HtmlEncode($Grid->sidang_kode_perilaku_jaksa->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    data-target="dsl_x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->sidang_kode_perilaku_jaksa->isInvalidClass() ?>"
    data-table="sidang_kode_perilaku"
    data-field="x_sidang_kode_perilaku_jaksa"
    data-value-separator="<?= $Grid->sidang_kode_perilaku_jaksa->displayValueSeparatorAttribute() ?>"
    <?= $Grid->sidang_kode_perilaku_jaksa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sidang_kode_perilaku_jaksa->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_sidang_kode_perilaku_sidang_kode_perilaku_jaksa" class="form-group sidang_kode_perilaku_sidang_kode_perilaku_jaksa">
<span<?= $Grid->sidang_kode_perilaku_jaksa->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sidang_kode_perilaku_jaksa->getDisplayValue($Grid->sidang_kode_perilaku_jaksa->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_sidang_kode_perilaku_jaksa" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" id="x<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" value="<?= HtmlEncode($Grid->sidang_kode_perilaku_jaksa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_sidang_kode_perilaku_jaksa" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" id="o<?= $Grid->RowIndex ?>_sidang_kode_perilaku_jaksa" value="<?= HtmlEncode($Grid->sidang_kode_perilaku_jaksa->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tempat_sidang_kode_perilaku->Visible) { // tempat_sidang_kode_perilaku ?>
        <td data-name="tempat_sidang_kode_perilaku">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sidang_kode_perilaku_tempat_sidang_kode_perilaku" class="form-group sidang_kode_perilaku_tempat_sidang_kode_perilaku">
    <select
        id="x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku"
        name="x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku"
        class="form-control ew-select<?= $Grid->tempat_sidang_kode_perilaku->isInvalidClass() ?>"
        data-select2-id="sidang_kode_perilaku_x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku"
        data-table="sidang_kode_perilaku"
        data-field="x_tempat_sidang_kode_perilaku"
        data-value-separator="<?= $Grid->tempat_sidang_kode_perilaku->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tempat_sidang_kode_perilaku->getPlaceHolder()) ?>"
        <?= $Grid->tempat_sidang_kode_perilaku->editAttributes() ?>>
        <?= $Grid->tempat_sidang_kode_perilaku->selectOptionListHtml("x{$Grid->RowIndex}_tempat_sidang_kode_perilaku") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tempat_sidang_kode_perilaku->getErrorMessage() ?></div>
<?= $Grid->tempat_sidang_kode_perilaku->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tempat_sidang_kode_perilaku") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='sidang_kode_perilaku_x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku']"),
        options = { name: "x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku", selectId: "sidang_kode_perilaku_x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.sidang_kode_perilaku.fields.tempat_sidang_kode_perilaku.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_sidang_kode_perilaku_tempat_sidang_kode_perilaku" class="form-group sidang_kode_perilaku_tempat_sidang_kode_perilaku">
<span<?= $Grid->tempat_sidang_kode_perilaku->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tempat_sidang_kode_perilaku->getDisplayValue($Grid->tempat_sidang_kode_perilaku->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_tempat_sidang_kode_perilaku" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku" id="x<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku" value="<?= HtmlEncode($Grid->tempat_sidang_kode_perilaku->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_tempat_sidang_kode_perilaku" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku" id="o<?= $Grid->RowIndex ?>_tempat_sidang_kode_perilaku" value="<?= HtmlEncode($Grid->tempat_sidang_kode_perilaku->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->hukuman_administratif->Visible) { // hukuman_administratif ?>
        <td data-name="hukuman_administratif">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sidang_kode_perilaku_hukuman_administratif" class="form-group sidang_kode_perilaku_hukuman_administratif">
<input type="<?= $Grid->hukuman_administratif->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_hukuman_administratif" name="x<?= $Grid->RowIndex ?>_hukuman_administratif" id="x<?= $Grid->RowIndex ?>_hukuman_administratif" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->hukuman_administratif->getPlaceHolder()) ?>" value="<?= $Grid->hukuman_administratif->EditValue ?>"<?= $Grid->hukuman_administratif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hukuman_administratif->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_sidang_kode_perilaku_hukuman_administratif" class="form-group sidang_kode_perilaku_hukuman_administratif">
<span<?= $Grid->hukuman_administratif->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->hukuman_administratif->getDisplayValue($Grid->hukuman_administratif->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_hukuman_administratif" data-hidden="1" name="x<?= $Grid->RowIndex ?>_hukuman_administratif" id="x<?= $Grid->RowIndex ?>_hukuman_administratif" value="<?= HtmlEncode($Grid->hukuman_administratif->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_hukuman_administratif" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hukuman_administratif" id="o<?= $Grid->RowIndex ?>_hukuman_administratif" value="<?= HtmlEncode($Grid->hukuman_administratif->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sk_nomor_kode_perilaku->Visible) { // sk_nomor_kode_perilaku ?>
        <td data-name="sk_nomor_kode_perilaku">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sidang_kode_perilaku_sk_nomor_kode_perilaku" class="form-group sidang_kode_perilaku_sk_nomor_kode_perilaku">
<input type="<?= $Grid->sk_nomor_kode_perilaku->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_sk_nomor_kode_perilaku" name="x<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" id="x<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->sk_nomor_kode_perilaku->getPlaceHolder()) ?>" value="<?= $Grid->sk_nomor_kode_perilaku->EditValue ?>"<?= $Grid->sk_nomor_kode_perilaku->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sk_nomor_kode_perilaku->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_sidang_kode_perilaku_sk_nomor_kode_perilaku" class="form-group sidang_kode_perilaku_sk_nomor_kode_perilaku">
<span<?= $Grid->sk_nomor_kode_perilaku->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sk_nomor_kode_perilaku->getDisplayValue($Grid->sk_nomor_kode_perilaku->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_sk_nomor_kode_perilaku" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" id="x<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" value="<?= HtmlEncode($Grid->sk_nomor_kode_perilaku->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_sk_nomor_kode_perilaku" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" id="o<?= $Grid->RowIndex ?>_sk_nomor_kode_perilaku" value="<?= HtmlEncode($Grid->sk_nomor_kode_perilaku->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tgl_sk_kode_perilaku->Visible) { // tgl_sk_kode_perilaku ?>
        <td data-name="tgl_sk_kode_perilaku">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sidang_kode_perilaku_tgl_sk_kode_perilaku" class="form-group sidang_kode_perilaku_tgl_sk_kode_perilaku">
<input type="<?= $Grid->tgl_sk_kode_perilaku->getInputTextType() ?>" data-table="sidang_kode_perilaku" data-field="x_tgl_sk_kode_perilaku" name="x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" id="x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" placeholder="<?= HtmlEncode($Grid->tgl_sk_kode_perilaku->getPlaceHolder()) ?>" value="<?= $Grid->tgl_sk_kode_perilaku->EditValue ?>"<?= $Grid->tgl_sk_kode_perilaku->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tgl_sk_kode_perilaku->getErrorMessage() ?></div>
<?php if (!$Grid->tgl_sk_kode_perilaku->ReadOnly && !$Grid->tgl_sk_kode_perilaku->Disabled && !isset($Grid->tgl_sk_kode_perilaku->EditAttrs["readonly"]) && !isset($Grid->tgl_sk_kode_perilaku->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsidang_kode_perilakugrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fsidang_kode_perilakugrid", "x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_sidang_kode_perilaku_tgl_sk_kode_perilaku" class="form-group sidang_kode_perilaku_tgl_sk_kode_perilaku">
<span<?= $Grid->tgl_sk_kode_perilaku->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tgl_sk_kode_perilaku->getDisplayValue($Grid->tgl_sk_kode_perilaku->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_tgl_sk_kode_perilaku" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" id="x<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" value="<?= HtmlEncode($Grid->tgl_sk_kode_perilaku->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_tgl_sk_kode_perilaku" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" id="o<?= $Grid->RowIndex ?>_tgl_sk_kode_perilaku" value="<?= HtmlEncode($Grid->tgl_sk_kode_perilaku->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_hukuman_kode_perilaku->Visible) { // status_hukuman_kode_perilaku ?>
        <td data-name="status_hukuman_kode_perilaku">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_sidang_kode_perilaku_status_hukuman_kode_perilaku" class="form-group sidang_kode_perilaku_status_hukuman_kode_perilaku">
<template id="tp_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="sidang_kode_perilaku" data-field="x_status_hukuman_kode_perilaku" name="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" id="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"<?= $Grid->status_hukuman_kode_perilaku->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    name="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    value="<?= HtmlEncode($Grid->status_hukuman_kode_perilaku->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_hukuman_kode_perilaku->isInvalidClass() ?>"
    data-table="sidang_kode_perilaku"
    data-field="x_status_hukuman_kode_perilaku"
    data-value-separator="<?= $Grid->status_hukuman_kode_perilaku->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_hukuman_kode_perilaku->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_hukuman_kode_perilaku->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_sidang_kode_perilaku_status_hukuman_kode_perilaku" class="form-group sidang_kode_perilaku_status_hukuman_kode_perilaku">
<span<?= $Grid->status_hukuman_kode_perilaku->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status_hukuman_kode_perilaku->getDisplayValue($Grid->status_hukuman_kode_perilaku->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_status_hukuman_kode_perilaku" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" id="x<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" value="<?= HtmlEncode($Grid->status_hukuman_kode_perilaku->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sidang_kode_perilaku" data-field="x_status_hukuman_kode_perilaku" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" id="o<?= $Grid->RowIndex ?>_status_hukuman_kode_perilaku" value="<?= HtmlEncode($Grid->status_hukuman_kode_perilaku->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fsidang_kode_perilakugrid","load"], function() {
    fsidang_kode_perilakugrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fsidang_kode_perilakugrid">
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
    ew.addEventHandlers("sidang_kode_perilaku");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
