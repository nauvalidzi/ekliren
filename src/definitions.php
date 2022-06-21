<?php

namespace PHPMaker2021\eclearance;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("log/audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log/log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        $loggers[] = $c->get("debugsqllogger");
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "data_request_skk" => \DI\create(DataRequestSkk::class),
    "data_user" => \DI\create(DataUser::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "cetak_skk" => \DI\create(CetakSkk::class),
    "m_jabatan" => \DI\create(MJabatan::class),
    "m_pangkat" => \DI\create(MPangkat::class),
    "m_satuan_kerja" => \DI\create(MSatuanKerja::class),
    "m_keperluan" => \DI\create(MKeperluan::class),
    "v_sekretariat" => \DI\create(VSekretariat::class),
    "hukuman_disiplin" => \DI\create(HukumanDisiplin::class),
    "banding" => \DI\create(Banding::class),
    "inspeksi" => \DI\create(Inspeksi::class),
    "sidang_kode_perilaku" => \DI\create(SidangKodePerilaku::class),
    "v_pemeriksa" => \DI\create(VPemeriksa::class),
    "v_aswas" => \DI\create(VAswas::class),
    "v_kirim_skk" => \DI\create(VKirimSkk::class),
    "alert" => \DI\create(Alert::class),
    "riwayat_acc" => \DI\create(RiwayatAcc::class),
    "v_arsip_skk" => \DI\create(VArsipSkk::class),
    "print_skk" => \DI\create(PrintSkk::class),
    "dashboard2" => \DI\create(Dashboard2::class),
    "v_kajati" => \DI\create(VKajati::class),
    "m_surat_keputusan" => \DI\create(MSuratKeputusan::class),
    "konfigurasi" => \DI\create(Konfigurasi::class),
    "v_kajati_konfigurasi" => \DI\create(VKajatiKonfigurasi::class),
    "v_paraf_konfigurasi" => \DI\create(VParafKonfigurasi::class),
    "v_kajari" => \DI\create(VKajari::class),

    // User table
    "usertable" => \DI\get("data_user"),
];
