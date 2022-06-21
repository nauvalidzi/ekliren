<?php namespace PHPMaker2021\eclearance; ?>
<?php

namespace PHPMaker2021\eclearance;

// Page object
$Login = &$Page;
?>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<script>
var flogin;
loadjs.ready("head", function() {
    var $ = jQuery;
    flogin = new ew.Form("flogin");

    // Add fields
    flogin.addFields([
        ["username", ew.Validators.required(ew.language.phrase("UserName")), <?= $Page->Username->IsInvalid ? "true" : "false" ?>],
        ["password", ew.Validators.required(ew.language.phrase("Password")), <?= $Page->Password->IsInvalid ? "true" : "false" ?>]
    ]);

    // Captcha
    <?= Captcha()->getScript("flogin") ?>

    // Set invalid fields
    $(function() {
        flogin.setInvalid();
    });

    // Validate
    flogin.validate = function() {
        if (!this.validateRequired)
            return true; // Ignore validation
        var $ = jQuery,
            fobj = this.getForm();

        // Validate fields
        if (!this.validateFields())
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    flogin.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation
    flogin.validateRequired = <?= JsonEncode(Config("CLIENT_VALIDATE")) ?>;
    loadjs.done("flogin");
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="flogin" id="flogin" class="ew-form ew-login-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-login-box">
<div class="login-logo"></div>
<div class="card">
    <div class="card-body">
    <p class="login-box-msg"><?= $Language->phrase("LoginMsg") ?></p>
    <div class="form-group row">
        <input type="text" name="<?= $Page->Username->FieldVar ?>" id="<?= $Page->Username->FieldVar ?>" autocomplete="username" value="<?= HtmlEncode($Page->Username->CurrentValue) ?>" placeholder="<?= HtmlEncode($Language->phrase("Username")) ?>"<?= $Page->Username->editAttributes() ?>>
        <div class="invalid-feedback"><?= $Page->Username->getErrorMessage() ?></div>
    </div>
    <div class="form-group row">
        <div class="input-group"><input type="password" name="<?= $Page->Password->FieldVar ?>" id="<?= $Page->Password->FieldVar ?>" autocomplete="current-password" placeholder="<?= HtmlEncode($Language->phrase("Password")) ?>"<?= $Page->Password->editAttributes() ?>><div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div></div>
        <div class="invalid-feedback"><?= $Page->Password->getErrorMessage() ?></div>
    </div>
<?php if (!$Page->IsModal) { ?>
    <button class="btn btn-primary ew-btn" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("Login") ?></button>
<?php } ?>
<?php
// OAuth login
$providers = Config("AUTH_CONFIG.providers");
$cntProviders = 0;
foreach ($providers as $id => $provider) {
    if ($provider["enabled"]) {
        $cntProviders++;
    }
}
if ($cntProviders > 0) {
?>
    <div class="social-auth-links text-center mt-3">
        <p><?= $Language->phrase("LoginOr") ?></p>
<?php
        foreach ($providers as $id => $provider) {
            if ($provider["enabled"]) {
?>
            <a href="<?= CurrentPageUrl(false) ?>?provider=<?= $id ?>" class="btn btn-block btn-<?= strtolower($provider["color"]) ?>"><i class="fab fa-<?= strtolower($id) ?> mr-2"></i><?= $Language->phrase("Login" . $id) ?></a>
<?php
            }
        }
?>
    </div>
<?php
}
?>
<div class="social-auth-links text-center mt-3">
</div>
</div>
</div>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Startup script
    document.body.style.backgroundImage="url('images/kantor-kejati-jatim.jpg')",document.body.style.backgroundPosition="bottom center",document.body.style.backgroundSize="cover",document.body.style.backgroundRepeat="no-repeat",$(".login-box-msg").html("<h2>e-Clearance</h2><span>Surat Keterangan Kepegawaian</span>"),$(document).ready((async function(){$("input[name=username]").focus(),Swal.fire({title:"<strong>INFORMASI</strong>",icon:"info",html:"<h6><p>Bagi User (Pemohon) Surat Keterangan Kepegawaian untuk dapat memperhatikan beberapa poin berikut ini :</p><p>1.\te-Clearance merupakan aplikasi permohonan Surat Keterangan Kepegawaian secara online sebagai pengganti permohonan melalui surat.</p><p>2.\tUntuk pemohon dari Jaksa, PPK, Bendahara diharuskan mengunggah (upload) bukti pengiriman e-LHKPN periode terbaru sedangkan untuk pegawai Tata Usaha diharuskan mengunggah (upload) LHKASN terbaru ke dalam form permohonan dengan tipe file .pdf/.jpg dengan ukuran maksimal 2 MB. </p><p>3.\tBidang Pengawasan akan melakukan verifikasi persyaratan dan catatan hukuman disiplin serta akan menerbitkan Surat Keterangan Kepegawaian meskipun ada catatan hukuman disiplin. </p><p>4.\tUntuk Surat Keterangan Kepegawaian yang sudah terbit akan dikirim kepada pemohon melalui email pemohon (user). </p><p>5.\tUntuk informasi lebih lanjut bisa menghubungi Sdr. M. Yusuf (081332661551). </p></h6>"}),$("div[class=swal2-content]").css({"text-align":"left"}),$("div[class=swal2-popup]").css({width:"850px !important"})}));
});
</script>
