<?php

namespace PHPMaker2021\eclearance;

// Set up and run Grid object
$Grid = Container("HukumanDisiplinGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fhukuman_disiplingrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fhukuman_disiplingrid = new ew.Form("fhukuman_disiplingrid", "grid");
    fhukuman_disiplingrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "hukuman_disiplin")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.hukuman_disiplin)
        ew.vars.tables.hukuman_disiplin = currentTable;
    fhukuman_disiplingrid.addFields([
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
        var f = fhukuman_disiplingrid,
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
    fhukuman_disiplingrid.validate = function () {
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
    fhukuman_disiplingrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "pernah_dijatuhi_hukuman", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jenis_hukuman", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "hukuman", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "pasal", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "surat_keputusan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sk_nomor", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tanggal_sk", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "status_hukuman", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fhukuman_disiplingrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fhukuman_disiplingrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fhukuman_disiplingrid.lists.pernah_dijatuhi_hukuman = <?= $Grid->pernah_dijatuhi_hukuman->toClientList($Grid) ?>;
    fhukuman_disiplingrid.lists.jenis_hukuman = <?= $Grid->jenis_hukuman->toClientList($Grid) ?>;
    fhukuman_disiplingrid.lists.surat_keputusan = <?= $Grid->surat_keputusan->toClientList($Grid) ?>;
    fhukuman_disiplingrid.lists.status_hukuman = <?= $Grid->status_hukuman->toClientList($Grid) ?>;
    loadjs.done("fhukuman_disiplingrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> hukuman_disiplin">
<div id="fhukuman_disiplingrid" class="ew-form ew-list-form form-inline">
<div id="gmp_hukuman_disiplin" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_hukuman_disiplingrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->pernah_dijatuhi_hukuman->Visible) { // pernah_dijatuhi_hukuman ?>
        <th data-name="pernah_dijatuhi_hukuman" class="<?= $Grid->pernah_dijatuhi_hukuman->headerCellClass() ?>"><div id="elh_hukuman_disiplin_pernah_dijatuhi_hukuman" class="hukuman_disiplin_pernah_dijatuhi_hukuman"><?= $Grid->renderSort($Grid->pernah_dijatuhi_hukuman) ?></div></th>
<?php } ?>
<?php if ($Grid->jenis_hukuman->Visible) { // jenis_hukuman ?>
        <th data-name="jenis_hukuman" class="<?= $Grid->jenis_hukuman->headerCellClass() ?>"><div id="elh_hukuman_disiplin_jenis_hukuman" class="hukuman_disiplin_jenis_hukuman"><?= $Grid->renderSort($Grid->jenis_hukuman) ?></div></th>
<?php } ?>
<?php if ($Grid->hukuman->Visible) { // hukuman ?>
        <th data-name="hukuman" class="<?= $Grid->hukuman->headerCellClass() ?>"><div id="elh_hukuman_disiplin_hukuman" class="hukuman_disiplin_hukuman"><?= $Grid->renderSort($Grid->hukuman) ?></div></th>
<?php } ?>
<?php if ($Grid->pasal->Visible) { // pasal ?>
        <th data-name="pasal" class="<?= $Grid->pasal->headerCellClass() ?>"><div id="elh_hukuman_disiplin_pasal" class="hukuman_disiplin_pasal"><?= $Grid->renderSort($Grid->pasal) ?></div></th>
<?php } ?>
<?php if ($Grid->surat_keputusan->Visible) { // surat_keputusan ?>
        <th data-name="surat_keputusan" class="<?= $Grid->surat_keputusan->headerCellClass() ?>"><div id="elh_hukuman_disiplin_surat_keputusan" class="hukuman_disiplin_surat_keputusan"><?= $Grid->renderSort($Grid->surat_keputusan) ?></div></th>
<?php } ?>
<?php if ($Grid->sk_nomor->Visible) { // sk_nomor ?>
        <th data-name="sk_nomor" class="<?= $Grid->sk_nomor->headerCellClass() ?>"><div id="elh_hukuman_disiplin_sk_nomor" class="hukuman_disiplin_sk_nomor"><?= $Grid->renderSort($Grid->sk_nomor) ?></div></th>
<?php } ?>
<?php if ($Grid->tanggal_sk->Visible) { // tanggal_sk ?>
        <th data-name="tanggal_sk" class="<?= $Grid->tanggal_sk->headerCellClass() ?>"><div id="elh_hukuman_disiplin_tanggal_sk" class="hukuman_disiplin_tanggal_sk"><?= $Grid->renderSort($Grid->tanggal_sk) ?></div></th>
<?php } ?>
<?php if ($Grid->status_hukuman->Visible) { // status_hukuman ?>
        <th data-name="status_hukuman" class="<?= $Grid->status_hukuman->headerCellClass() ?>"><div id="elh_hukuman_disiplin_status_hukuman" class="hukuman_disiplin_status_hukuman"><?= $Grid->renderSort($Grid->status_hukuman) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_hukuman_disiplin", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->pernah_dijatuhi_hukuman->Visible) { // pernah_dijatuhi_hukuman ?>
        <td data-name="pernah_dijatuhi_hukuman" <?= $Grid->pernah_dijatuhi_hukuman->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_pernah_dijatuhi_hukuman" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_pernah_dijatuhi_hukuman" name="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" id="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"<?= $Grid->pernah_dijatuhi_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    name="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    value="<?= HtmlEncode($Grid->pernah_dijatuhi_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    data-target="dsl_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->pernah_dijatuhi_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_pernah_dijatuhi_hukuman"
    data-value-separator="<?= $Grid->pernah_dijatuhi_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Grid->pernah_dijatuhi_hukuman->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pernah_dijatuhi_hukuman->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_pernah_dijatuhi_hukuman" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" id="o<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" value="<?= HtmlEncode($Grid->pernah_dijatuhi_hukuman->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_pernah_dijatuhi_hukuman" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_pernah_dijatuhi_hukuman" name="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" id="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"<?= $Grid->pernah_dijatuhi_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    name="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    value="<?= HtmlEncode($Grid->pernah_dijatuhi_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    data-target="dsl_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->pernah_dijatuhi_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_pernah_dijatuhi_hukuman"
    data-value-separator="<?= $Grid->pernah_dijatuhi_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Grid->pernah_dijatuhi_hukuman->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pernah_dijatuhi_hukuman->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_pernah_dijatuhi_hukuman">
<span<?= $Grid->pernah_dijatuhi_hukuman->viewAttributes() ?>>
<?= $Grid->pernah_dijatuhi_hukuman->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_pernah_dijatuhi_hukuman" data-hidden="1" name="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" id="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" value="<?= HtmlEncode($Grid->pernah_dijatuhi_hukuman->FormValue) ?>">
<input type="hidden" data-table="hukuman_disiplin" data-field="x_pernah_dijatuhi_hukuman" data-hidden="1" name="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" id="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" value="<?= HtmlEncode($Grid->pernah_dijatuhi_hukuman->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jenis_hukuman->Visible) { // jenis_hukuman ?>
        <td data-name="jenis_hukuman" <?= $Grid->jenis_hukuman->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_jenis_hukuman" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_jenis_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_jenis_hukuman" name="x<?= $Grid->RowIndex ?>_jenis_hukuman" id="x<?= $Grid->RowIndex ?>_jenis_hukuman"<?= $Grid->jenis_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_jenis_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_jenis_hukuman"
    name="x<?= $Grid->RowIndex ?>_jenis_hukuman"
    value="<?= HtmlEncode($Grid->jenis_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_jenis_hukuman"
    data-target="dsl_x<?= $Grid->RowIndex ?>_jenis_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->jenis_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_jenis_hukuman"
    data-value-separator="<?= $Grid->jenis_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Grid->jenis_hukuman->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jenis_hukuman->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_jenis_hukuman" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jenis_hukuman" id="o<?= $Grid->RowIndex ?>_jenis_hukuman" value="<?= HtmlEncode($Grid->jenis_hukuman->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_jenis_hukuman" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_jenis_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_jenis_hukuman" name="x<?= $Grid->RowIndex ?>_jenis_hukuman" id="x<?= $Grid->RowIndex ?>_jenis_hukuman"<?= $Grid->jenis_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_jenis_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_jenis_hukuman"
    name="x<?= $Grid->RowIndex ?>_jenis_hukuman"
    value="<?= HtmlEncode($Grid->jenis_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_jenis_hukuman"
    data-target="dsl_x<?= $Grid->RowIndex ?>_jenis_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->jenis_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_jenis_hukuman"
    data-value-separator="<?= $Grid->jenis_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Grid->jenis_hukuman->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jenis_hukuman->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_jenis_hukuman">
<span<?= $Grid->jenis_hukuman->viewAttributes() ?>>
<?= $Grid->jenis_hukuman->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_jenis_hukuman" data-hidden="1" name="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_jenis_hukuman" id="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_jenis_hukuman" value="<?= HtmlEncode($Grid->jenis_hukuman->FormValue) ?>">
<input type="hidden" data-table="hukuman_disiplin" data-field="x_jenis_hukuman" data-hidden="1" name="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_jenis_hukuman" id="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_jenis_hukuman" value="<?= HtmlEncode($Grid->jenis_hukuman->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->hukuman->Visible) { // hukuman ?>
        <td data-name="hukuman" <?= $Grid->hukuman->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_hukuman" class="form-group">
<textarea data-table="hukuman_disiplin" data-field="x_hukuman" name="x<?= $Grid->RowIndex ?>_hukuman" id="x<?= $Grid->RowIndex ?>_hukuman" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->hukuman->getPlaceHolder()) ?>"<?= $Grid->hukuman->editAttributes() ?>><?= $Grid->hukuman->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->hukuman->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_hukuman" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hukuman" id="o<?= $Grid->RowIndex ?>_hukuman" value="<?= HtmlEncode($Grid->hukuman->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_hukuman" class="form-group">
<textarea data-table="hukuman_disiplin" data-field="x_hukuman" name="x<?= $Grid->RowIndex ?>_hukuman" id="x<?= $Grid->RowIndex ?>_hukuman" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->hukuman->getPlaceHolder()) ?>"<?= $Grid->hukuman->editAttributes() ?>><?= $Grid->hukuman->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->hukuman->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_hukuman">
<span<?= $Grid->hukuman->viewAttributes() ?>>
<?= $Grid->hukuman->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_hukuman" data-hidden="1" name="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_hukuman" id="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_hukuman" value="<?= HtmlEncode($Grid->hukuman->FormValue) ?>">
<input type="hidden" data-table="hukuman_disiplin" data-field="x_hukuman" data-hidden="1" name="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_hukuman" id="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_hukuman" value="<?= HtmlEncode($Grid->hukuman->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->pasal->Visible) { // pasal ?>
        <td data-name="pasal" <?= $Grid->pasal->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_pasal" class="form-group">
<input type="<?= $Grid->pasal->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_pasal" name="x<?= $Grid->RowIndex ?>_pasal" id="x<?= $Grid->RowIndex ?>_pasal" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pasal->getPlaceHolder()) ?>" value="<?= $Grid->pasal->EditValue ?>"<?= $Grid->pasal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pasal->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_pasal" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pasal" id="o<?= $Grid->RowIndex ?>_pasal" value="<?= HtmlEncode($Grid->pasal->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_pasal" class="form-group">
<input type="<?= $Grid->pasal->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_pasal" name="x<?= $Grid->RowIndex ?>_pasal" id="x<?= $Grid->RowIndex ?>_pasal" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pasal->getPlaceHolder()) ?>" value="<?= $Grid->pasal->EditValue ?>"<?= $Grid->pasal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pasal->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_pasal">
<span<?= $Grid->pasal->viewAttributes() ?>>
<?= $Grid->pasal->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_pasal" data-hidden="1" name="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_pasal" id="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_pasal" value="<?= HtmlEncode($Grid->pasal->FormValue) ?>">
<input type="hidden" data-table="hukuman_disiplin" data-field="x_pasal" data-hidden="1" name="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_pasal" id="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_pasal" value="<?= HtmlEncode($Grid->pasal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->surat_keputusan->Visible) { // surat_keputusan ?>
        <td data-name="surat_keputusan" <?= $Grid->surat_keputusan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_surat_keputusan" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_surat_keputusan"
        name="x<?= $Grid->RowIndex ?>_surat_keputusan"
        class="form-control ew-select<?= $Grid->surat_keputusan->isInvalidClass() ?>"
        data-select2-id="hukuman_disiplin_x<?= $Grid->RowIndex ?>_surat_keputusan"
        data-table="hukuman_disiplin"
        data-field="x_surat_keputusan"
        data-value-separator="<?= $Grid->surat_keputusan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->surat_keputusan->getPlaceHolder()) ?>"
        <?= $Grid->surat_keputusan->editAttributes() ?>>
        <?= $Grid->surat_keputusan->selectOptionListHtml("x{$Grid->RowIndex}_surat_keputusan") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->surat_keputusan->getErrorMessage() ?></div>
<?= $Grid->surat_keputusan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_surat_keputusan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='hukuman_disiplin_x<?= $Grid->RowIndex ?>_surat_keputusan']"),
        options = { name: "x<?= $Grid->RowIndex ?>_surat_keputusan", selectId: "hukuman_disiplin_x<?= $Grid->RowIndex ?>_surat_keputusan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.hukuman_disiplin.fields.surat_keputusan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_surat_keputusan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_surat_keputusan" id="o<?= $Grid->RowIndex ?>_surat_keputusan" value="<?= HtmlEncode($Grid->surat_keputusan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_surat_keputusan" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_surat_keputusan"
        name="x<?= $Grid->RowIndex ?>_surat_keputusan"
        class="form-control ew-select<?= $Grid->surat_keputusan->isInvalidClass() ?>"
        data-select2-id="hukuman_disiplin_x<?= $Grid->RowIndex ?>_surat_keputusan"
        data-table="hukuman_disiplin"
        data-field="x_surat_keputusan"
        data-value-separator="<?= $Grid->surat_keputusan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->surat_keputusan->getPlaceHolder()) ?>"
        <?= $Grid->surat_keputusan->editAttributes() ?>>
        <?= $Grid->surat_keputusan->selectOptionListHtml("x{$Grid->RowIndex}_surat_keputusan") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->surat_keputusan->getErrorMessage() ?></div>
<?= $Grid->surat_keputusan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_surat_keputusan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='hukuman_disiplin_x<?= $Grid->RowIndex ?>_surat_keputusan']"),
        options = { name: "x<?= $Grid->RowIndex ?>_surat_keputusan", selectId: "hukuman_disiplin_x<?= $Grid->RowIndex ?>_surat_keputusan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.hukuman_disiplin.fields.surat_keputusan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_surat_keputusan">
<span<?= $Grid->surat_keputusan->viewAttributes() ?>>
<?= $Grid->surat_keputusan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_surat_keputusan" data-hidden="1" name="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_surat_keputusan" id="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_surat_keputusan" value="<?= HtmlEncode($Grid->surat_keputusan->FormValue) ?>">
<input type="hidden" data-table="hukuman_disiplin" data-field="x_surat_keputusan" data-hidden="1" name="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_surat_keputusan" id="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_surat_keputusan" value="<?= HtmlEncode($Grid->surat_keputusan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sk_nomor->Visible) { // sk_nomor ?>
        <td data-name="sk_nomor" <?= $Grid->sk_nomor->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_sk_nomor" class="form-group">
<input type="<?= $Grid->sk_nomor->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_sk_nomor" name="x<?= $Grid->RowIndex ?>_sk_nomor" id="x<?= $Grid->RowIndex ?>_sk_nomor" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->sk_nomor->getPlaceHolder()) ?>" value="<?= $Grid->sk_nomor->EditValue ?>"<?= $Grid->sk_nomor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sk_nomor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_sk_nomor" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sk_nomor" id="o<?= $Grid->RowIndex ?>_sk_nomor" value="<?= HtmlEncode($Grid->sk_nomor->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_sk_nomor" class="form-group">
<input type="<?= $Grid->sk_nomor->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_sk_nomor" name="x<?= $Grid->RowIndex ?>_sk_nomor" id="x<?= $Grid->RowIndex ?>_sk_nomor" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->sk_nomor->getPlaceHolder()) ?>" value="<?= $Grid->sk_nomor->EditValue ?>"<?= $Grid->sk_nomor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sk_nomor->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_sk_nomor">
<span<?= $Grid->sk_nomor->viewAttributes() ?>>
<?= $Grid->sk_nomor->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_sk_nomor" data-hidden="1" name="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_sk_nomor" id="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_sk_nomor" value="<?= HtmlEncode($Grid->sk_nomor->FormValue) ?>">
<input type="hidden" data-table="hukuman_disiplin" data-field="x_sk_nomor" data-hidden="1" name="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_sk_nomor" id="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_sk_nomor" value="<?= HtmlEncode($Grid->sk_nomor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tanggal_sk->Visible) { // tanggal_sk ?>
        <td data-name="tanggal_sk" <?= $Grid->tanggal_sk->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_tanggal_sk" class="form-group">
<input type="<?= $Grid->tanggal_sk->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_tanggal_sk" name="x<?= $Grid->RowIndex ?>_tanggal_sk" id="x<?= $Grid->RowIndex ?>_tanggal_sk" placeholder="<?= HtmlEncode($Grid->tanggal_sk->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_sk->EditValue ?>"<?= $Grid->tanggal_sk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_sk->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_sk->ReadOnly && !$Grid->tanggal_sk->Disabled && !isset($Grid->tanggal_sk->EditAttrs["readonly"]) && !isset($Grid->tanggal_sk->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fhukuman_disiplingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fhukuman_disiplingrid", "x<?= $Grid->RowIndex ?>_tanggal_sk", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_tanggal_sk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal_sk" id="o<?= $Grid->RowIndex ?>_tanggal_sk" value="<?= HtmlEncode($Grid->tanggal_sk->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_tanggal_sk" class="form-group">
<input type="<?= $Grid->tanggal_sk->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_tanggal_sk" name="x<?= $Grid->RowIndex ?>_tanggal_sk" id="x<?= $Grid->RowIndex ?>_tanggal_sk" placeholder="<?= HtmlEncode($Grid->tanggal_sk->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_sk->EditValue ?>"<?= $Grid->tanggal_sk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_sk->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_sk->ReadOnly && !$Grid->tanggal_sk->Disabled && !isset($Grid->tanggal_sk->EditAttrs["readonly"]) && !isset($Grid->tanggal_sk->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fhukuman_disiplingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fhukuman_disiplingrid", "x<?= $Grid->RowIndex ?>_tanggal_sk", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_tanggal_sk">
<span<?= $Grid->tanggal_sk->viewAttributes() ?>>
<?= $Grid->tanggal_sk->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_tanggal_sk" data-hidden="1" name="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_tanggal_sk" id="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_tanggal_sk" value="<?= HtmlEncode($Grid->tanggal_sk->FormValue) ?>">
<input type="hidden" data-table="hukuman_disiplin" data-field="x_tanggal_sk" data-hidden="1" name="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_tanggal_sk" id="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_tanggal_sk" value="<?= HtmlEncode($Grid->tanggal_sk->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_hukuman->Visible) { // status_hukuman ?>
        <td data-name="status_hukuman" <?= $Grid->status_hukuman->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_status_hukuman" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_status_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_status_hukuman" name="x<?= $Grid->RowIndex ?>_status_hukuman" id="x<?= $Grid->RowIndex ?>_status_hukuman"<?= $Grid->status_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_status_hukuman"
    name="x<?= $Grid->RowIndex ?>_status_hukuman"
    value="<?= HtmlEncode($Grid->status_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_hukuman"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_status_hukuman"
    data-value-separator="<?= $Grid->status_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_hukuman->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_hukuman->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_status_hukuman" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_hukuman" id="o<?= $Grid->RowIndex ?>_status_hukuman" value="<?= HtmlEncode($Grid->status_hukuman->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_status_hukuman" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_status_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_status_hukuman" name="x<?= $Grid->RowIndex ?>_status_hukuman" id="x<?= $Grid->RowIndex ?>_status_hukuman"<?= $Grid->status_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_status_hukuman"
    name="x<?= $Grid->RowIndex ?>_status_hukuman"
    value="<?= HtmlEncode($Grid->status_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_hukuman"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_status_hukuman"
    data-value-separator="<?= $Grid->status_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_hukuman->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_hukuman->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_hukuman_disiplin_status_hukuman">
<span<?= $Grid->status_hukuman->viewAttributes() ?>>
<?= $Grid->status_hukuman->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_status_hukuman" data-hidden="1" name="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_status_hukuman" id="fhukuman_disiplingrid$x<?= $Grid->RowIndex ?>_status_hukuman" value="<?= HtmlEncode($Grid->status_hukuman->FormValue) ?>">
<input type="hidden" data-table="hukuman_disiplin" data-field="x_status_hukuman" data-hidden="1" name="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_status_hukuman" id="fhukuman_disiplingrid$o<?= $Grid->RowIndex ?>_status_hukuman" value="<?= HtmlEncode($Grid->status_hukuman->OldValue) ?>">
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
loadjs.ready(["fhukuman_disiplingrid","load"], function () {
    fhukuman_disiplingrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_hukuman_disiplin", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->pernah_dijatuhi_hukuman->Visible) { // pernah_dijatuhi_hukuman ?>
        <td data-name="pernah_dijatuhi_hukuman">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_hukuman_disiplin_pernah_dijatuhi_hukuman" class="form-group hukuman_disiplin_pernah_dijatuhi_hukuman">
<template id="tp_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_pernah_dijatuhi_hukuman" name="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" id="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"<?= $Grid->pernah_dijatuhi_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    name="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    value="<?= HtmlEncode($Grid->pernah_dijatuhi_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    data-target="dsl_x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->pernah_dijatuhi_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_pernah_dijatuhi_hukuman"
    data-value-separator="<?= $Grid->pernah_dijatuhi_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Grid->pernah_dijatuhi_hukuman->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pernah_dijatuhi_hukuman->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_hukuman_disiplin_pernah_dijatuhi_hukuman" class="form-group hukuman_disiplin_pernah_dijatuhi_hukuman">
<span<?= $Grid->pernah_dijatuhi_hukuman->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pernah_dijatuhi_hukuman->getDisplayValue($Grid->pernah_dijatuhi_hukuman->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_pernah_dijatuhi_hukuman" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" id="x<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" value="<?= HtmlEncode($Grid->pernah_dijatuhi_hukuman->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_pernah_dijatuhi_hukuman" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" id="o<?= $Grid->RowIndex ?>_pernah_dijatuhi_hukuman" value="<?= HtmlEncode($Grid->pernah_dijatuhi_hukuman->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jenis_hukuman->Visible) { // jenis_hukuman ?>
        <td data-name="jenis_hukuman">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_hukuman_disiplin_jenis_hukuman" class="form-group hukuman_disiplin_jenis_hukuman">
<template id="tp_x<?= $Grid->RowIndex ?>_jenis_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_jenis_hukuman" name="x<?= $Grid->RowIndex ?>_jenis_hukuman" id="x<?= $Grid->RowIndex ?>_jenis_hukuman"<?= $Grid->jenis_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_jenis_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_jenis_hukuman"
    name="x<?= $Grid->RowIndex ?>_jenis_hukuman"
    value="<?= HtmlEncode($Grid->jenis_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_jenis_hukuman"
    data-target="dsl_x<?= $Grid->RowIndex ?>_jenis_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->jenis_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_jenis_hukuman"
    data-value-separator="<?= $Grid->jenis_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Grid->jenis_hukuman->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jenis_hukuman->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_hukuman_disiplin_jenis_hukuman" class="form-group hukuman_disiplin_jenis_hukuman">
<span<?= $Grid->jenis_hukuman->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jenis_hukuman->getDisplayValue($Grid->jenis_hukuman->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_jenis_hukuman" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jenis_hukuman" id="x<?= $Grid->RowIndex ?>_jenis_hukuman" value="<?= HtmlEncode($Grid->jenis_hukuman->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_jenis_hukuman" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jenis_hukuman" id="o<?= $Grid->RowIndex ?>_jenis_hukuman" value="<?= HtmlEncode($Grid->jenis_hukuman->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->hukuman->Visible) { // hukuman ?>
        <td data-name="hukuman">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_hukuman_disiplin_hukuman" class="form-group hukuman_disiplin_hukuman">
<textarea data-table="hukuman_disiplin" data-field="x_hukuman" name="x<?= $Grid->RowIndex ?>_hukuman" id="x<?= $Grid->RowIndex ?>_hukuman" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->hukuman->getPlaceHolder()) ?>"<?= $Grid->hukuman->editAttributes() ?>><?= $Grid->hukuman->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->hukuman->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_hukuman_disiplin_hukuman" class="form-group hukuman_disiplin_hukuman">
<span<?= $Grid->hukuman->viewAttributes() ?>>
<?= $Grid->hukuman->ViewValue ?></span>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_hukuman" data-hidden="1" name="x<?= $Grid->RowIndex ?>_hukuman" id="x<?= $Grid->RowIndex ?>_hukuman" value="<?= HtmlEncode($Grid->hukuman->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_hukuman" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hukuman" id="o<?= $Grid->RowIndex ?>_hukuman" value="<?= HtmlEncode($Grid->hukuman->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pasal->Visible) { // pasal ?>
        <td data-name="pasal">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_hukuman_disiplin_pasal" class="form-group hukuman_disiplin_pasal">
<input type="<?= $Grid->pasal->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_pasal" name="x<?= $Grid->RowIndex ?>_pasal" id="x<?= $Grid->RowIndex ?>_pasal" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pasal->getPlaceHolder()) ?>" value="<?= $Grid->pasal->EditValue ?>"<?= $Grid->pasal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pasal->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_hukuman_disiplin_pasal" class="form-group hukuman_disiplin_pasal">
<span<?= $Grid->pasal->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pasal->getDisplayValue($Grid->pasal->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_pasal" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pasal" id="x<?= $Grid->RowIndex ?>_pasal" value="<?= HtmlEncode($Grid->pasal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_pasal" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pasal" id="o<?= $Grid->RowIndex ?>_pasal" value="<?= HtmlEncode($Grid->pasal->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->surat_keputusan->Visible) { // surat_keputusan ?>
        <td data-name="surat_keputusan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_hukuman_disiplin_surat_keputusan" class="form-group hukuman_disiplin_surat_keputusan">
    <select
        id="x<?= $Grid->RowIndex ?>_surat_keputusan"
        name="x<?= $Grid->RowIndex ?>_surat_keputusan"
        class="form-control ew-select<?= $Grid->surat_keputusan->isInvalidClass() ?>"
        data-select2-id="hukuman_disiplin_x<?= $Grid->RowIndex ?>_surat_keputusan"
        data-table="hukuman_disiplin"
        data-field="x_surat_keputusan"
        data-value-separator="<?= $Grid->surat_keputusan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->surat_keputusan->getPlaceHolder()) ?>"
        <?= $Grid->surat_keputusan->editAttributes() ?>>
        <?= $Grid->surat_keputusan->selectOptionListHtml("x{$Grid->RowIndex}_surat_keputusan") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->surat_keputusan->getErrorMessage() ?></div>
<?= $Grid->surat_keputusan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_surat_keputusan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='hukuman_disiplin_x<?= $Grid->RowIndex ?>_surat_keputusan']"),
        options = { name: "x<?= $Grid->RowIndex ?>_surat_keputusan", selectId: "hukuman_disiplin_x<?= $Grid->RowIndex ?>_surat_keputusan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.hukuman_disiplin.fields.surat_keputusan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_hukuman_disiplin_surat_keputusan" class="form-group hukuman_disiplin_surat_keputusan">
<span<?= $Grid->surat_keputusan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->surat_keputusan->getDisplayValue($Grid->surat_keputusan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_surat_keputusan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_surat_keputusan" id="x<?= $Grid->RowIndex ?>_surat_keputusan" value="<?= HtmlEncode($Grid->surat_keputusan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_surat_keputusan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_surat_keputusan" id="o<?= $Grid->RowIndex ?>_surat_keputusan" value="<?= HtmlEncode($Grid->surat_keputusan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sk_nomor->Visible) { // sk_nomor ?>
        <td data-name="sk_nomor">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_hukuman_disiplin_sk_nomor" class="form-group hukuman_disiplin_sk_nomor">
<input type="<?= $Grid->sk_nomor->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_sk_nomor" name="x<?= $Grid->RowIndex ?>_sk_nomor" id="x<?= $Grid->RowIndex ?>_sk_nomor" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->sk_nomor->getPlaceHolder()) ?>" value="<?= $Grid->sk_nomor->EditValue ?>"<?= $Grid->sk_nomor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sk_nomor->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_hukuman_disiplin_sk_nomor" class="form-group hukuman_disiplin_sk_nomor">
<span<?= $Grid->sk_nomor->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sk_nomor->getDisplayValue($Grid->sk_nomor->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_sk_nomor" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sk_nomor" id="x<?= $Grid->RowIndex ?>_sk_nomor" value="<?= HtmlEncode($Grid->sk_nomor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_sk_nomor" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sk_nomor" id="o<?= $Grid->RowIndex ?>_sk_nomor" value="<?= HtmlEncode($Grid->sk_nomor->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tanggal_sk->Visible) { // tanggal_sk ?>
        <td data-name="tanggal_sk">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_hukuman_disiplin_tanggal_sk" class="form-group hukuman_disiplin_tanggal_sk">
<input type="<?= $Grid->tanggal_sk->getInputTextType() ?>" data-table="hukuman_disiplin" data-field="x_tanggal_sk" name="x<?= $Grid->RowIndex ?>_tanggal_sk" id="x<?= $Grid->RowIndex ?>_tanggal_sk" placeholder="<?= HtmlEncode($Grid->tanggal_sk->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_sk->EditValue ?>"<?= $Grid->tanggal_sk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_sk->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_sk->ReadOnly && !$Grid->tanggal_sk->Disabled && !isset($Grid->tanggal_sk->EditAttrs["readonly"]) && !isset($Grid->tanggal_sk->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fhukuman_disiplingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fhukuman_disiplingrid", "x<?= $Grid->RowIndex ?>_tanggal_sk", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_hukuman_disiplin_tanggal_sk" class="form-group hukuman_disiplin_tanggal_sk">
<span<?= $Grid->tanggal_sk->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tanggal_sk->getDisplayValue($Grid->tanggal_sk->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_tanggal_sk" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tanggal_sk" id="x<?= $Grid->RowIndex ?>_tanggal_sk" value="<?= HtmlEncode($Grid->tanggal_sk->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_tanggal_sk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal_sk" id="o<?= $Grid->RowIndex ?>_tanggal_sk" value="<?= HtmlEncode($Grid->tanggal_sk->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_hukuman->Visible) { // status_hukuman ?>
        <td data-name="status_hukuman">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_hukuman_disiplin_status_hukuman" class="form-group hukuman_disiplin_status_hukuman">
<template id="tp_x<?= $Grid->RowIndex ?>_status_hukuman">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="hukuman_disiplin" data-field="x_status_hukuman" name="x<?= $Grid->RowIndex ?>_status_hukuman" id="x<?= $Grid->RowIndex ?>_status_hukuman"<?= $Grid->status_hukuman->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_hukuman" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_status_hukuman"
    name="x<?= $Grid->RowIndex ?>_status_hukuman"
    value="<?= HtmlEncode($Grid->status_hukuman->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_hukuman"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status_hukuman"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_hukuman->isInvalidClass() ?>"
    data-table="hukuman_disiplin"
    data-field="x_status_hukuman"
    data-value-separator="<?= $Grid->status_hukuman->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_hukuman->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_hukuman->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_hukuman_disiplin_status_hukuman" class="form-group hukuman_disiplin_status_hukuman">
<span<?= $Grid->status_hukuman->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status_hukuman->getDisplayValue($Grid->status_hukuman->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_status_hukuman" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_hukuman" id="x<?= $Grid->RowIndex ?>_status_hukuman" value="<?= HtmlEncode($Grid->status_hukuman->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="hukuman_disiplin" data-field="x_status_hukuman" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_hukuman" id="o<?= $Grid->RowIndex ?>_status_hukuman" value="<?= HtmlEncode($Grid->status_hukuman->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fhukuman_disiplingrid","load"], function() {
    fhukuman_disiplingrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fhukuman_disiplingrid">
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
    ew.addEventHandlers("hukuman_disiplin");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
