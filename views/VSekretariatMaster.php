<?php

namespace PHPMaker2021\eclearance;

// Table
$v_sekretariat = Container("v_sekretariat");
?>
<?php if ($v_sekretariat->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_v_sekretariatmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($v_sekretariat->tanggal_request->Visible) { // tanggal_request ?>
        <tr id="r_tanggal_request">
            <td class="<?= $v_sekretariat->TableLeftColumnClass ?>"><?= $v_sekretariat->tanggal_request->caption() ?></td>
            <td <?= $v_sekretariat->tanggal_request->cellAttributes() ?>>
<span id="el_v_sekretariat_tanggal_request">
<span<?= $v_sekretariat->tanggal_request->viewAttributes() ?>>
<?= $v_sekretariat->tanggal_request->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_sekretariat->nip->Visible) { // nip ?>
        <tr id="r_nip">
            <td class="<?= $v_sekretariat->TableLeftColumnClass ?>"><?= $v_sekretariat->nip->caption() ?></td>
            <td <?= $v_sekretariat->nip->cellAttributes() ?>>
<span id="el_v_sekretariat_nip">
<span<?= $v_sekretariat->nip->viewAttributes() ?>>
<?= $v_sekretariat->nip->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_sekretariat->nrp->Visible) { // nrp ?>
        <tr id="r_nrp">
            <td class="<?= $v_sekretariat->TableLeftColumnClass ?>"><?= $v_sekretariat->nrp->caption() ?></td>
            <td <?= $v_sekretariat->nrp->cellAttributes() ?>>
<span id="el_v_sekretariat_nrp">
<span<?= $v_sekretariat->nrp->viewAttributes() ?>>
<?= $v_sekretariat->nrp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_sekretariat->nama->Visible) { // nama ?>
        <tr id="r_nama">
            <td class="<?= $v_sekretariat->TableLeftColumnClass ?>"><?= $v_sekretariat->nama->caption() ?></td>
            <td <?= $v_sekretariat->nama->cellAttributes() ?>>
<span id="el_v_sekretariat_nama">
<span<?= $v_sekretariat->nama->viewAttributes() ?>>
<?= $v_sekretariat->nama->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_sekretariat->unit_organisasi->Visible) { // unit_organisasi ?>
        <tr id="r_unit_organisasi">
            <td class="<?= $v_sekretariat->TableLeftColumnClass ?>"><?= $v_sekretariat->unit_organisasi->caption() ?></td>
            <td <?= $v_sekretariat->unit_organisasi->cellAttributes() ?>>
<span id="el_v_sekretariat_unit_organisasi">
<span<?= $v_sekretariat->unit_organisasi->viewAttributes() ?>>
<?= $v_sekretariat->unit_organisasi->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_sekretariat->keperluan->Visible) { // keperluan ?>
        <tr id="r_keperluan">
            <td class="<?= $v_sekretariat->TableLeftColumnClass ?>"><?= $v_sekretariat->keperluan->caption() ?></td>
            <td <?= $v_sekretariat->keperluan->cellAttributes() ?>>
<span id="el_v_sekretariat_keperluan">
<span<?= $v_sekretariat->keperluan->viewAttributes() ?>>
<?= $v_sekretariat->keperluan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_sekretariat->keterangan->Visible) { // keterangan ?>
        <tr id="r_keterangan">
            <td class="<?= $v_sekretariat->TableLeftColumnClass ?>"><?= $v_sekretariat->keterangan->caption() ?></td>
            <td <?= $v_sekretariat->keterangan->cellAttributes() ?>>
<span id="el_v_sekretariat_keterangan">
<span<?= $v_sekretariat->keterangan->viewAttributes() ?>>
<?= $v_sekretariat->keterangan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_sekretariat->status->Visible) { // status ?>
        <tr id="r_status">
            <td class="<?= $v_sekretariat->TableLeftColumnClass ?>"><?= $v_sekretariat->status->caption() ?></td>
            <td <?= $v_sekretariat->status->cellAttributes() ?>>
<span id="el_v_sekretariat_status">
<span<?= $v_sekretariat->status->viewAttributes() ?>>
<?= $v_sekretariat->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
