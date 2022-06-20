<?php

namespace PHPMaker2021\eclearance;

// Page object
$VPemeriksaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_pemeriksalist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fv_pemeriksalist = currentForm = new ew.Form("fv_pemeriksalist", "list");
    fv_pemeriksalist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fv_pemeriksalist");
});
var fv_pemeriksalistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fv_pemeriksalistsrch = currentSearchForm = new ew.Form("fv_pemeriksalistsrch");

    // Dynamic selection lists

    // Filters
    fv_pemeriksalistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fv_pemeriksalistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    function checkSelected(){var e=$("input#check-all")[0],t=$("input#check-row").length,c=$("input#check-row:checked:checked").length;e.checked=c===t}$("#fv_pemeriksalistsrch").append('<button type="button" class="btn btn-primary ml-4 mb-3 mass-request" data-request="accept">Acc Request</button><button type="button" class="btn btn-danger mb-3 ml-2 mass-request" data-request="reject">Tolak Request</button>'),$(".mass-request").on("click",(function(){var e=[],t=$(this).attr("data-request");if($("input#check-row:checked:checked").each((function(t,c){e[t]=c.value})),e.length<1)return Swal.fire({icon:"error",title:"Oops...",text:"Pilih data terlebih dahulu!"}),!1;$.get("api/pemeriksa-massal?type="+t+"&items="+encodeURIComponent(e),(function(e){!1!==e.status&&Swal.fire({icon:"success",title:"Success",text:"Data berhasil diproses!"}).then((function(){location.reload()}))}))})),$(document).on("click","input#check-all",(function(){var e=this.checked;$("input#check-row").each((function(t,c){c.checked=e}))})),$(document).on("click","#check-row",(function(){this.value;checkSelected()}));
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fv_pemeriksalistsrch" id="fv_pemeriksalistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fv_pemeriksalistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="v_pemeriksa">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> v_pemeriksa">
<form name="fv_pemeriksalist" id="fv_pemeriksalist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_pemeriksa">
<div id="gmp_v_pemeriksa" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_v_pemeriksalist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
        <th data-name="tanggal_request" class="<?= $Page->tanggal_request->headerCellClass() ?>"><div id="elh_v_pemeriksa_tanggal_request" class="v_pemeriksa_tanggal_request"><?= $Page->renderSort($Page->tanggal_request) ?></div></th>
<?php } ?>
<?php if ($Page->nip->Visible) { // nip ?>
        <th data-name="nip" class="<?= $Page->nip->headerCellClass() ?>"><div id="elh_v_pemeriksa_nip" class="v_pemeriksa_nip"><?= $Page->renderSort($Page->nip) ?></div></th>
<?php } ?>
<?php if ($Page->nrp->Visible) { // nrp ?>
        <th data-name="nrp" class="<?= $Page->nrp->headerCellClass() ?>"><div id="elh_v_pemeriksa_nrp" class="v_pemeriksa_nrp"><?= $Page->renderSort($Page->nrp) ?></div></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Page->nama->headerCellClass() ?>"><div id="elh_v_pemeriksa_nama" class="v_pemeriksa_nama"><?= $Page->renderSort($Page->nama) ?></div></th>
<?php } ?>
<?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
        <th data-name="unit_organisasi" class="<?= $Page->unit_organisasi->headerCellClass() ?>"><div id="elh_v_pemeriksa_unit_organisasi" class="v_pemeriksa_unit_organisasi"><?= $Page->renderSort($Page->unit_organisasi) ?></div></th>
<?php } ?>
<?php if ($Page->keperluan->Visible) { // keperluan ?>
        <th data-name="keperluan" class="<?= $Page->keperluan->headerCellClass() ?>"><div id="elh_v_pemeriksa_keperluan" class="v_pemeriksa_keperluan"><?= $Page->renderSort($Page->keperluan) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_v_pemeriksa_status" class="v_pemeriksa_status"><?= $Page->renderSort($Page->status) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_v_pemeriksa", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
        <td data-name="tanggal_request" <?= $Page->tanggal_request->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pemeriksa_tanggal_request">
<span<?= $Page->tanggal_request->viewAttributes() ?>>
<?= $Page->tanggal_request->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nip->Visible) { // nip ?>
        <td data-name="nip" <?= $Page->nip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pemeriksa_nip">
<span<?= $Page->nip->viewAttributes() ?>>
<?= $Page->nip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nrp->Visible) { // nrp ?>
        <td data-name="nrp" <?= $Page->nrp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pemeriksa_nrp">
<span<?= $Page->nrp->viewAttributes() ?>>
<?= $Page->nrp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pemeriksa_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->unit_organisasi->Visible) { // unit_organisasi ?>
        <td data-name="unit_organisasi" <?= $Page->unit_organisasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pemeriksa_unit_organisasi">
<span<?= $Page->unit_organisasi->viewAttributes() ?>>
<?= $Page->unit_organisasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keperluan->Visible) { // keperluan ?>
        <td data-name="keperluan" <?= $Page->keperluan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pemeriksa_keperluan">
<span<?= $Page->keperluan->viewAttributes() ?>>
<?= $Page->keperluan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_pemeriksa_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("v_pemeriksa");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
