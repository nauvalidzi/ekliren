<?php

namespace PHPMaker2021\eclearance;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(36, "mi_dashboard2", $MenuLanguage->MenuPhrase("36", "MenuText"), $MenuRelativePath . "Dashboard2", -1, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}dashboard.php'), false, false, "fas fa-tachometer-alt", "", false);
$sideMenu->addMenuItem(2, "mi_data_request_skk", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "DataRequestSkkList", -1, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}data_request_skk'), false, false, "fa-envelope", "", false);
$sideMenu->addMenuItem(28, "mi_v_sekretariat", $MenuLanguage->MenuPhrase("28", "MenuText"), $MenuRelativePath . "VSekretariatList", -1, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}v_sekretariat'), false, false, "fa-envelope-open-text", "", false);
$sideMenu->addMenuItem(34, "mi_v_pemeriksa", $MenuLanguage->MenuPhrase("34", "MenuText"), $MenuRelativePath . "VPemeriksaList", -1, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}v_pemeriksa'), false, false, "fa-envelope-open-text", "", false);
$sideMenu->addMenuItem(29, "mi_v_aswas", $MenuLanguage->MenuPhrase("29", "MenuText"), $MenuRelativePath . "VAswasList", -1, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}v_aswas'), false, false, "fa-envelope-open-text", "", false);
$sideMenu->addMenuItem(37, "mi_v_kirim_skk", $MenuLanguage->MenuPhrase("37", "MenuText"), $MenuRelativePath . "VKirimSkkList", -1, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}v_kirim_skk'), false, false, "fas fa-list-ol", "", false);
$sideMenu->addMenuItem(38, "mi_v_arsip_skk", $MenuLanguage->MenuPhrase("38", "MenuText"), $MenuRelativePath . "VArsipSkkList", -1, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}v_arsip_skk'), false, false, "fas fa-archive", "", false);
$sideMenu->addMenuItem(21, "mci_Master_Data", $MenuLanguage->MenuPhrase("21", "MenuText"), "", -1, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(3, "mi_data_user", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "DataUserList", 21, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}data_user'), false, false, "fa-users", "", false);
$sideMenu->addMenuItem(11, "mi_m_jabatan", $MenuLanguage->MenuPhrase("11", "MenuText"), $MenuRelativePath . "MJabatanList", 21, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}m_jabatan'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(12, "mi_m_pangkat", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "MPangkatList", 21, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}m_pangkat'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(13, "mi_m_satuan_kerja", $MenuLanguage->MenuPhrase("13", "MenuText"), $MenuRelativePath . "MSatuanKerjaList", 21, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}m_satuan_kerja'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(14, "mi_m_keperluan", $MenuLanguage->MenuPhrase("14", "MenuText"), $MenuRelativePath . "MKeperluanList", 21, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}m_keperluan'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(39, "mi_m_surat_keputusan", $MenuLanguage->MenuPhrase("39", "MenuText"), $MenuRelativePath . "MSuratKeputusanList", 21, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}m_surat_keputusan'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(42, "mi_v_paraf_konfigurasi", $MenuLanguage->MenuPhrase("42", "MenuText"), $MenuRelativePath . "VParafKonfigurasiList", 21, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}v_paraf_konfigurasi'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(41, "mi_v_kajati_konfigurasi", $MenuLanguage->MenuPhrase("41", "MenuText"), $MenuRelativePath . "VKajatiKonfigurasiList", 21, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}v_kajati_konfigurasi'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(6, "mi_userlevels", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "UserlevelsList", 21, "", AllowListMenu('{200E8565-2236-41C6-8CFB-5B83286F42BD}userlevels'), false, false, "far fa-circle", "", false);
echo $sideMenu->toScript();
