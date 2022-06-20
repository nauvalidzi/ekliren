<?php

namespace PHPMaker2021\eclearance;

// Page object
$HukumanDisiplinList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fhukuman_disiplinlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fhukuman_disiplinlist = currentForm = new ew.Form("fhukuman_disiplinlist", "list");
    fhukuman_disiplinlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fhukuman_disiplinlist");
});
var fhukuman_disiplinlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fhukuman_disiplinlistsrch = currentSearchForm = new ew.Form("fhukuman_disiplinlistsrch");

    // Dynamic selection lists

    // Filters
    fhukuman_disiplinlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fhukuman_disiplinlistsrch");
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
<form name="fhukuman_disiplinlistsrch" id="fhukuman_disiplinlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fhukuman_disiplinlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="hukuman_disiplin">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> hukuman_disiplin">
<form name="fhukuman_disiplinlist" id="fhukuman_disiplinlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="hukuman_disiplin">
<?php if ($Page->getCurrentMasterTable() == "v_sekretariat" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="v_sekretariat">
<input type="hidden" name="fk_id_request" value="<?= HtmlEncode($Page->pid_request_skk->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_hukuman_disiplin" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_hukuman_disiplinlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->pernah_dijatuhi_hukuman->Visible) { // pernah_dijatuhi_hukuman ?>
        <th data-name="pernah_dijatuhi_hukuman" class="<?= $Page->pernah_dijatuhi_hukuman->headerCellClass() ?>"><div id="elh_hukuman_disiplin_pernah_dijatuhi_hukuman" class="hukuman_disiplin_pernah_dijatuhi_hukuman"><?= $Page->renderSort($Page->pernah_dijatuhi_hukuman) ?></div></th>
<?php } ?>
<?php if ($Page->jenis_hukuman->Visible) { // jenis_hukuman ?>
        <th data-name="jenis_hukuman" class="<?= $Page->jenis_hukuman->headerCellClass() ?>"><div id="elh_hukuman_disiplin_jenis_hukuman" class="hukuman_disiplin_jenis_hukuman"><?= $Page->renderSort($Page->jenis_hukuman) ?></div></th>
<?php } ?>
<?php if ($Page->hukuman->Visible) { // hukuman ?>
        <th data-name="hukuman" class="<?= $Page->hukuman->headerCellClass() ?>"><div id="elh_hukuman_disiplin_hukuman" class="hukuman_disiplin_hukuman"><?= $Page->renderSort($Page->hukuman) ?></div></th>
<?php } ?>
<?php if ($Page->pasal->Visible) { // pasal ?>
        <th data-name="pasal" class="<?= $Page->pasal->headerCellClass() ?>"><div id="elh_hukuman_disiplin_pasal" class="hukuman_disiplin_pasal"><?= $Page->renderSort($Page->pasal) ?></div></th>
<?php } ?>
<?php if ($Page->surat_keputusan->Visible) { // surat_keputusan ?>
        <th data-name="surat_keputusan" class="<?= $Page->surat_keputusan->headerCellClass() ?>"><div id="elh_hukuman_disiplin_surat_keputusan" class="hukuman_disiplin_surat_keputusan"><?= $Page->renderSort($Page->surat_keputusan) ?></div></th>
<?php } ?>
<?php if ($Page->sk_nomor->Visible) { // sk_nomor ?>
        <th data-name="sk_nomor" class="<?= $Page->sk_nomor->headerCellClass() ?>"><div id="elh_hukuman_disiplin_sk_nomor" class="hukuman_disiplin_sk_nomor"><?= $Page->renderSort($Page->sk_nomor) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_sk->Visible) { // tanggal_sk ?>
        <th data-name="tanggal_sk" class="<?= $Page->tanggal_sk->headerCellClass() ?>"><div id="elh_hukuman_disiplin_tanggal_sk" class="hukuman_disiplin_tanggal_sk"><?= $Page->renderSort($Page->tanggal_sk) ?></div></th>
<?php } ?>
<?php if ($Page->status_hukuman->Visible) { // status_hukuman ?>
        <th data-name="status_hukuman" class="<?= $Page->status_hukuman->headerCellClass() ?>"><div id="elh_hukuman_disiplin_status_hukuman" class="hukuman_disiplin_status_hukuman"><?= $Page->renderSort($Page->status_hukuman) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_hukuman_disiplin", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->pernah_dijatuhi_hukuman->Visible) { // pernah_dijatuhi_hukuman ?>
        <td data-name="pernah_dijatuhi_hukuman" <?= $Page->pernah_dijatuhi_hukuman->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_pernah_dijatuhi_hukuman">
<span<?= $Page->pernah_dijatuhi_hukuman->viewAttributes() ?>>
<?= $Page->pernah_dijatuhi_hukuman->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jenis_hukuman->Visible) { // jenis_hukuman ?>
        <td data-name="jenis_hukuman" <?= $Page->jenis_hukuman->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_jenis_hukuman">
<span<?= $Page->jenis_hukuman->viewAttributes() ?>>
<?= $Page->jenis_hukuman->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hukuman->Visible) { // hukuman ?>
        <td data-name="hukuman" <?= $Page->hukuman->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_hukuman">
<span<?= $Page->hukuman->viewAttributes() ?>>
<?= $Page->hukuman->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pasal->Visible) { // pasal ?>
        <td data-name="pasal" <?= $Page->pasal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_pasal">
<span<?= $Page->pasal->viewAttributes() ?>>
<?= $Page->pasal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->surat_keputusan->Visible) { // surat_keputusan ?>
        <td data-name="surat_keputusan" <?= $Page->surat_keputusan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_surat_keputusan">
<span<?= $Page->surat_keputusan->viewAttributes() ?>>
<?= $Page->surat_keputusan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sk_nomor->Visible) { // sk_nomor ?>
        <td data-name="sk_nomor" <?= $Page->sk_nomor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_sk_nomor">
<span<?= $Page->sk_nomor->viewAttributes() ?>>
<?= $Page->sk_nomor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_sk->Visible) { // tanggal_sk ?>
        <td data-name="tanggal_sk" <?= $Page->tanggal_sk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_tanggal_sk">
<span<?= $Page->tanggal_sk->viewAttributes() ?>>
<?= $Page->tanggal_sk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_hukuman->Visible) { // status_hukuman ?>
        <td data-name="status_hukuman" <?= $Page->status_hukuman->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_status_hukuman">
<span<?= $Page->status_hukuman->viewAttributes() ?>>
<?= $Page->status_hukuman->getViewValue() ?></span>
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
    ew.addEventHandlers("hukuman_disiplin");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
