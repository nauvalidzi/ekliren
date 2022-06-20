<?php

namespace PHPMaker2021\eclearance;

// Page object
$SidangKodePerilakuList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsidang_kode_perilakulist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fsidang_kode_perilakulist = currentForm = new ew.Form("fsidang_kode_perilakulist", "list");
    fsidang_kode_perilakulist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fsidang_kode_perilakulist");
});
var fsidang_kode_perilakulistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fsidang_kode_perilakulistsrch = currentSearchForm = new ew.Form("fsidang_kode_perilakulistsrch");

    // Dynamic selection lists

    // Filters
    fsidang_kode_perilakulistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fsidang_kode_perilakulistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "v_sekretariat") {
    if ($Page->MasterRecordExists) {
        include_once "views/VSekretariatMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fsidang_kode_perilakulistsrch" id="fsidang_kode_perilakulistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fsidang_kode_perilakulistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="sidang_kode_perilaku">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> sidang_kode_perilaku">
<form name="fsidang_kode_perilakulist" id="fsidang_kode_perilakulist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sidang_kode_perilaku">
<?php if ($Page->getCurrentMasterTable() == "v_sekretariat" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="v_sekretariat">
<input type="hidden" name="fk_id_request" value="<?= HtmlEncode($Page->pid_request_skk->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_sidang_kode_perilaku" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_sidang_kode_perilakulist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->sidang_kode_perilaku_jaksa->Visible) { // sidang_kode_perilaku_jaksa ?>
        <th data-name="sidang_kode_perilaku_jaksa" class="<?= $Page->sidang_kode_perilaku_jaksa->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_sidang_kode_perilaku_jaksa" class="sidang_kode_perilaku_sidang_kode_perilaku_jaksa"><?= $Page->renderSort($Page->sidang_kode_perilaku_jaksa) ?></div></th>
<?php } ?>
<?php if ($Page->tempat_sidang_kode_perilaku->Visible) { // tempat_sidang_kode_perilaku ?>
        <th data-name="tempat_sidang_kode_perilaku" class="<?= $Page->tempat_sidang_kode_perilaku->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_tempat_sidang_kode_perilaku" class="sidang_kode_perilaku_tempat_sidang_kode_perilaku"><?= $Page->renderSort($Page->tempat_sidang_kode_perilaku) ?></div></th>
<?php } ?>
<?php if ($Page->hukuman_administratif->Visible) { // hukuman_administratif ?>
        <th data-name="hukuman_administratif" class="<?= $Page->hukuman_administratif->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_hukuman_administratif" class="sidang_kode_perilaku_hukuman_administratif"><?= $Page->renderSort($Page->hukuman_administratif) ?></div></th>
<?php } ?>
<?php if ($Page->sk_nomor_kode_perilaku->Visible) { // sk_nomor_kode_perilaku ?>
        <th data-name="sk_nomor_kode_perilaku" class="<?= $Page->sk_nomor_kode_perilaku->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_sk_nomor_kode_perilaku" class="sidang_kode_perilaku_sk_nomor_kode_perilaku"><?= $Page->renderSort($Page->sk_nomor_kode_perilaku) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_sk_kode_perilaku->Visible) { // tgl_sk_kode_perilaku ?>
        <th data-name="tgl_sk_kode_perilaku" class="<?= $Page->tgl_sk_kode_perilaku->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_tgl_sk_kode_perilaku" class="sidang_kode_perilaku_tgl_sk_kode_perilaku"><?= $Page->renderSort($Page->tgl_sk_kode_perilaku) ?></div></th>
<?php } ?>
<?php if ($Page->status_hukuman_kode_perilaku->Visible) { // status_hukuman_kode_perilaku ?>
        <th data-name="status_hukuman_kode_perilaku" class="<?= $Page->status_hukuman_kode_perilaku->headerCellClass() ?>"><div id="elh_sidang_kode_perilaku_status_hukuman_kode_perilaku" class="sidang_kode_perilaku_status_hukuman_kode_perilaku"><?= $Page->renderSort($Page->status_hukuman_kode_perilaku) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_sidang_kode_perilaku", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->sidang_kode_perilaku_jaksa->Visible) { // sidang_kode_perilaku_jaksa ?>
        <td data-name="sidang_kode_perilaku_jaksa" <?= $Page->sidang_kode_perilaku_jaksa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_sidang_kode_perilaku_jaksa">
<span<?= $Page->sidang_kode_perilaku_jaksa->viewAttributes() ?>>
<?= $Page->sidang_kode_perilaku_jaksa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tempat_sidang_kode_perilaku->Visible) { // tempat_sidang_kode_perilaku ?>
        <td data-name="tempat_sidang_kode_perilaku" <?= $Page->tempat_sidang_kode_perilaku->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_tempat_sidang_kode_perilaku">
<span<?= $Page->tempat_sidang_kode_perilaku->viewAttributes() ?>>
<?= $Page->tempat_sidang_kode_perilaku->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hukuman_administratif->Visible) { // hukuman_administratif ?>
        <td data-name="hukuman_administratif" <?= $Page->hukuman_administratif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_hukuman_administratif">
<span<?= $Page->hukuman_administratif->viewAttributes() ?>>
<?= $Page->hukuman_administratif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sk_nomor_kode_perilaku->Visible) { // sk_nomor_kode_perilaku ?>
        <td data-name="sk_nomor_kode_perilaku" <?= $Page->sk_nomor_kode_perilaku->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_sk_nomor_kode_perilaku">
<span<?= $Page->sk_nomor_kode_perilaku->viewAttributes() ?>>
<?= $Page->sk_nomor_kode_perilaku->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_sk_kode_perilaku->Visible) { // tgl_sk_kode_perilaku ?>
        <td data-name="tgl_sk_kode_perilaku" <?= $Page->tgl_sk_kode_perilaku->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_tgl_sk_kode_perilaku">
<span<?= $Page->tgl_sk_kode_perilaku->viewAttributes() ?>>
<?= $Page->tgl_sk_kode_perilaku->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_hukuman_kode_perilaku->Visible) { // status_hukuman_kode_perilaku ?>
        <td data-name="status_hukuman_kode_perilaku" <?= $Page->status_hukuman_kode_perilaku->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_sidang_kode_perilaku_status_hukuman_kode_perilaku">
<span<?= $Page->status_hukuman_kode_perilaku->viewAttributes() ?>>
<?= $Page->status_hukuman_kode_perilaku->getViewValue() ?></span>
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
    ew.addEventHandlers("sidang_kode_perilaku");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
