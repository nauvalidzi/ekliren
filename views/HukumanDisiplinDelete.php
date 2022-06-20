<?php

namespace PHPMaker2021\eclearance;

// Page object
$HukumanDisiplinDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fhukuman_disiplindelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fhukuman_disiplindelete = currentForm = new ew.Form("fhukuman_disiplindelete", "delete");
    loadjs.done("fhukuman_disiplindelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.hukuman_disiplin) ew.vars.tables.hukuman_disiplin = <?= JsonEncode(GetClientVar("tables", "hukuman_disiplin")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fhukuman_disiplindelete" id="fhukuman_disiplindelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="hukuman_disiplin">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->pernah_dijatuhi_hukuman->Visible) { // pernah_dijatuhi_hukuman ?>
        <th class="<?= $Page->pernah_dijatuhi_hukuman->headerCellClass() ?>"><span id="elh_hukuman_disiplin_pernah_dijatuhi_hukuman" class="hukuman_disiplin_pernah_dijatuhi_hukuman"><?= $Page->pernah_dijatuhi_hukuman->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jenis_hukuman->Visible) { // jenis_hukuman ?>
        <th class="<?= $Page->jenis_hukuman->headerCellClass() ?>"><span id="elh_hukuman_disiplin_jenis_hukuman" class="hukuman_disiplin_jenis_hukuman"><?= $Page->jenis_hukuman->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hukuman->Visible) { // hukuman ?>
        <th class="<?= $Page->hukuman->headerCellClass() ?>"><span id="elh_hukuman_disiplin_hukuman" class="hukuman_disiplin_hukuman"><?= $Page->hukuman->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pasal->Visible) { // pasal ?>
        <th class="<?= $Page->pasal->headerCellClass() ?>"><span id="elh_hukuman_disiplin_pasal" class="hukuman_disiplin_pasal"><?= $Page->pasal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->surat_keputusan->Visible) { // surat_keputusan ?>
        <th class="<?= $Page->surat_keputusan->headerCellClass() ?>"><span id="elh_hukuman_disiplin_surat_keputusan" class="hukuman_disiplin_surat_keputusan"><?= $Page->surat_keputusan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sk_nomor->Visible) { // sk_nomor ?>
        <th class="<?= $Page->sk_nomor->headerCellClass() ?>"><span id="elh_hukuman_disiplin_sk_nomor" class="hukuman_disiplin_sk_nomor"><?= $Page->sk_nomor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_sk->Visible) { // tanggal_sk ?>
        <th class="<?= $Page->tanggal_sk->headerCellClass() ?>"><span id="elh_hukuman_disiplin_tanggal_sk" class="hukuman_disiplin_tanggal_sk"><?= $Page->tanggal_sk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_hukuman->Visible) { // status_hukuman ?>
        <th class="<?= $Page->status_hukuman->headerCellClass() ?>"><span id="elh_hukuman_disiplin_status_hukuman" class="hukuman_disiplin_status_hukuman"><?= $Page->status_hukuman->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->pernah_dijatuhi_hukuman->Visible) { // pernah_dijatuhi_hukuman ?>
        <td <?= $Page->pernah_dijatuhi_hukuman->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_pernah_dijatuhi_hukuman" class="hukuman_disiplin_pernah_dijatuhi_hukuman">
<span<?= $Page->pernah_dijatuhi_hukuman->viewAttributes() ?>>
<?= $Page->pernah_dijatuhi_hukuman->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jenis_hukuman->Visible) { // jenis_hukuman ?>
        <td <?= $Page->jenis_hukuman->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_jenis_hukuman" class="hukuman_disiplin_jenis_hukuman">
<span<?= $Page->jenis_hukuman->viewAttributes() ?>>
<?= $Page->jenis_hukuman->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hukuman->Visible) { // hukuman ?>
        <td <?= $Page->hukuman->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_hukuman" class="hukuman_disiplin_hukuman">
<span<?= $Page->hukuman->viewAttributes() ?>>
<?= $Page->hukuman->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pasal->Visible) { // pasal ?>
        <td <?= $Page->pasal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_pasal" class="hukuman_disiplin_pasal">
<span<?= $Page->pasal->viewAttributes() ?>>
<?= $Page->pasal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->surat_keputusan->Visible) { // surat_keputusan ?>
        <td <?= $Page->surat_keputusan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_surat_keputusan" class="hukuman_disiplin_surat_keputusan">
<span<?= $Page->surat_keputusan->viewAttributes() ?>>
<?= $Page->surat_keputusan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sk_nomor->Visible) { // sk_nomor ?>
        <td <?= $Page->sk_nomor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_sk_nomor" class="hukuman_disiplin_sk_nomor">
<span<?= $Page->sk_nomor->viewAttributes() ?>>
<?= $Page->sk_nomor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_sk->Visible) { // tanggal_sk ?>
        <td <?= $Page->tanggal_sk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_tanggal_sk" class="hukuman_disiplin_tanggal_sk">
<span<?= $Page->tanggal_sk->viewAttributes() ?>>
<?= $Page->tanggal_sk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_hukuman->Visible) { // status_hukuman ?>
        <td <?= $Page->status_hukuman->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_hukuman_disiplin_status_hukuman" class="hukuman_disiplin_status_hukuman">
<span<?= $Page->status_hukuman->viewAttributes() ?>>
<?= $Page->status_hukuman->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
