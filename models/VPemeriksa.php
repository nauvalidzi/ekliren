<?php

namespace PHPMaker2021\eclearance;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for v_pemeriksa
 */
class VPemeriksa extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $id_request;
    public $tanggal_request;
    public $nip;
    public $nrp;
    public $nama;
    public $unit_organisasi;
    public $pangkat;
    public $jabatan;
    public $scan_lhkpn;
    public $scan_lhkasn;
    public $kategori_pemohon;
    public $keperluan;
    public $hukuman_disiplin;
    public $email_pemohon;
    public $keterangan;
    public $status;
    public $jenis_hukuman;
    public $hukuman;
    public $pasal;
    public $surat_keputusan;
    public $sk_nomor;
    public $tanggal_sk;
    public $status_hukuman;
    public $pernah_dijatuhi_hukuman;
    public $sk_banding_nomor;
    public $tgl_sk_banding;
    public $mengajukan_keberatan_banding;
    public $pelanggaran_disiplin;
    public $inspeksi_kasus;
    public $tempat_sidang_kode_perilaku;
    public $hukuman_administratif;
    public $sidang_kode_perilaku_jaksa;
    public $sk_nomor_kode_perilaku;
    public $tgl_sk_kode_perilaku;
    public $status_hukuman_kode_perilaku;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'v_pemeriksa';
        $this->TableName = 'v_pemeriksa';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`v_pemeriksa`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id_request
        $this->id_request = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_id_request', 'id_request', '`id_request`', '`id_request`', 20, 20, -1, false, '`id_request`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_request->IsAutoIncrement = true; // Autoincrement field
        $this->id_request->IsPrimaryKey = true; // Primary key field
        $this->id_request->Sortable = true; // Allow sort
        $this->id_request->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_request->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_request->Param, "CustomMsg");
        $this->Fields['id_request'] = &$this->id_request;

        // tanggal_request
        $this->tanggal_request = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_tanggal_request', 'tanggal_request', '`tanggal_request`', CastDateFieldForLike("`tanggal_request`", 111, "DB"), 135, 19, 111, false, '`tanggal_request`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_request->Nullable = false; // NOT NULL field
        $this->tanggal_request->Sortable = true; // Allow sort
        $this->tanggal_request->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->tanggal_request->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_request->Param, "CustomMsg");
        $this->Fields['tanggal_request'] = &$this->tanggal_request;

        // nip
        $this->nip = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_nip', 'nip', '`nip`', '`nip`', 200, 255, -1, false, '`nip`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nip->Nullable = false; // NOT NULL field
        $this->nip->Required = true; // Required field
        $this->nip->Sortable = true; // Allow sort
        $this->nip->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nip->Param, "CustomMsg");
        $this->Fields['nip'] = &$this->nip;

        // nrp
        $this->nrp = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_nrp', 'nrp', '`nrp`', '`nrp`', 200, 255, -1, false, '`nrp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nrp->Nullable = false; // NOT NULL field
        $this->nrp->Required = true; // Required field
        $this->nrp->Sortable = true; // Allow sort
        $this->nrp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nrp->Param, "CustomMsg");
        $this->Fields['nrp'] = &$this->nrp;

        // nama
        $this->nama = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_nama', 'nama', '`nama`', '`nama`', 200, 255, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Nullable = false; // NOT NULL field
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // unit_organisasi
        $this->unit_organisasi = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_unit_organisasi', 'unit_organisasi', '`unit_organisasi`', '`unit_organisasi`', 3, 11, -1, false, '`unit_organisasi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->unit_organisasi->Nullable = false; // NOT NULL field
        $this->unit_organisasi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->unit_organisasi->Lookup = new Lookup('unit_organisasi', 'm_satuan_kerja', false, 'id', ["satuan_kerja","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->unit_organisasi->Lookup = new Lookup('unit_organisasi', 'm_satuan_kerja', false, 'id', ["satuan_kerja","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->unit_organisasi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->unit_organisasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->unit_organisasi->Param, "CustomMsg");
        $this->Fields['unit_organisasi'] = &$this->unit_organisasi;

        // pangkat
        $this->pangkat = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_pangkat', 'pangkat', '`pangkat`', '`pangkat`', 3, 11, -1, false, '`pangkat`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->pangkat->Nullable = false; // NOT NULL field
        $this->pangkat->Sortable = true; // Allow sort
        $this->pangkat->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->pangkat->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->pangkat->Lookup = new Lookup('pangkat', 'm_pangkat', false, 'id', ["pangkat","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->pangkat->Lookup = new Lookup('pangkat', 'm_pangkat', false, 'id', ["pangkat","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->pangkat->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->pangkat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pangkat->Param, "CustomMsg");
        $this->Fields['pangkat'] = &$this->pangkat;

        // jabatan
        $this->jabatan = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_jabatan', 'jabatan', '`jabatan`', '`jabatan`', 3, 11, -1, false, '`jabatan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->jabatan->Nullable = false; // NOT NULL field
        $this->jabatan->Sortable = true; // Allow sort
        $this->jabatan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->jabatan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->jabatan->Lookup = new Lookup('jabatan', 'm_jabatan', false, 'id', ["nama_jabatan","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->jabatan->Lookup = new Lookup('jabatan', 'm_jabatan', false, 'id', ["nama_jabatan","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->jabatan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jabatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jabatan->Param, "CustomMsg");
        $this->Fields['jabatan'] = &$this->jabatan;

        // scan_lhkpn
        $this->scan_lhkpn = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_scan_lhkpn', 'scan_lhkpn', '`scan_lhkpn`', '`scan_lhkpn`', 200, 255, -1, false, '`scan_lhkpn`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->scan_lhkpn->Sortable = true; // Allow sort
        $this->scan_lhkpn->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->scan_lhkpn->Param, "CustomMsg");
        $this->Fields['scan_lhkpn'] = &$this->scan_lhkpn;

        // scan_lhkasn
        $this->scan_lhkasn = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_scan_lhkasn', 'scan_lhkasn', '`scan_lhkasn`', '`scan_lhkasn`', 200, 255, -1, false, '`scan_lhkasn`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->scan_lhkasn->Sortable = true; // Allow sort
        $this->scan_lhkasn->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->scan_lhkasn->Param, "CustomMsg");
        $this->Fields['scan_lhkasn'] = &$this->scan_lhkasn;

        // kategori_pemohon
        $this->kategori_pemohon = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_kategori_pemohon', 'kategori_pemohon', '`kategori_pemohon`', '`kategori_pemohon`', 200, 255, -1, false, '`kategori_pemohon`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->kategori_pemohon->Nullable = false; // NOT NULL field
        $this->kategori_pemohon->Required = true; // Required field
        $this->kategori_pemohon->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->kategori_pemohon->Lookup = new Lookup('kategori_pemohon', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->kategori_pemohon->Lookup = new Lookup('kategori_pemohon', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->kategori_pemohon->OptionCount = 2;
        $this->kategori_pemohon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategori_pemohon->Param, "CustomMsg");
        $this->Fields['kategori_pemohon'] = &$this->kategori_pemohon;

        // keperluan
        $this->keperluan = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_keperluan', 'keperluan', '`keperluan`', '`keperluan`', 3, 11, -1, false, '`keperluan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->keperluan->Nullable = false; // NOT NULL field
        $this->keperluan->Required = true; // Required field
        $this->keperluan->Sortable = true; // Allow sort
        $this->keperluan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->keperluan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->keperluan->Lookup = new Lookup('keperluan', 'm_keperluan', false, 'id', ["keperluan","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->keperluan->Lookup = new Lookup('keperluan', 'm_keperluan', false, 'id', ["keperluan","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->keperluan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->keperluan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keperluan->Param, "CustomMsg");
        $this->Fields['keperluan'] = &$this->keperluan;

        // hukuman_disiplin
        $this->hukuman_disiplin = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_hukuman_disiplin', 'hukuman_disiplin', '`hukuman_disiplin`', '`hukuman_disiplin`', 202, 5, -1, false, '`hukuman_disiplin`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->hukuman_disiplin->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->hukuman_disiplin->Lookup = new Lookup('hukuman_disiplin', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->hukuman_disiplin->Lookup = new Lookup('hukuman_disiplin', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->hukuman_disiplin->OptionCount = 2;
        $this->hukuman_disiplin->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hukuman_disiplin->Param, "CustomMsg");
        $this->Fields['hukuman_disiplin'] = &$this->hukuman_disiplin;

        // email_pemohon
        $this->email_pemohon = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_email_pemohon', 'email_pemohon', '`email_pemohon`', '`email_pemohon`', 200, 255, -1, false, '`email_pemohon`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->email_pemohon->Sortable = true; // Allow sort
        $this->email_pemohon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->email_pemohon->Param, "CustomMsg");
        $this->Fields['email_pemohon'] = &$this->email_pemohon;

        // keterangan
        $this->keterangan = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, 65535, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;

        // status
        $this->status = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_status', 'status', '`status`', '`status`', 200, 255, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->status->Required = true; // Required field
        $this->status->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->status->Lookup = new Lookup('status', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->status->Lookup = new Lookup('status', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->status->OptionCount = 2;
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // jenis_hukuman
        $this->jenis_hukuman = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_jenis_hukuman', 'jenis_hukuman', '`jenis_hukuman`', '`jenis_hukuman`', 202, 6, -1, false, '`jenis_hukuman`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->jenis_hukuman->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->jenis_hukuman->Lookup = new Lookup('jenis_hukuman', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->jenis_hukuman->Lookup = new Lookup('jenis_hukuman', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->jenis_hukuman->OptionCount = 3;
        $this->jenis_hukuman->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jenis_hukuman->Param, "CustomMsg");
        $this->Fields['jenis_hukuman'] = &$this->jenis_hukuman;

        // hukuman
        $this->hukuman = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_hukuman', 'hukuman', '`hukuman`', '`hukuman`', 201, 65535, -1, false, '`hukuman`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hukuman->Sortable = true; // Allow sort
        $this->hukuman->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hukuman->Param, "CustomMsg");
        $this->Fields['hukuman'] = &$this->hukuman;

        // pasal
        $this->pasal = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_pasal', 'pasal', '`pasal`', '`pasal`', 200, 255, -1, false, '`pasal`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pasal->Sortable = true; // Allow sort
        $this->pasal->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pasal->Param, "CustomMsg");
        $this->Fields['pasal'] = &$this->pasal;

        // surat_keputusan
        $this->surat_keputusan = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_surat_keputusan', 'surat_keputusan', '`surat_keputusan`', '`surat_keputusan`', 3, 11, -1, false, '`surat_keputusan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->surat_keputusan->Sortable = true; // Allow sort
        $this->surat_keputusan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->surat_keputusan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->surat_keputusan->Lookup = new Lookup('surat_keputusan', 'm_surat_keputusan', false, 'id', ["title","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->surat_keputusan->Lookup = new Lookup('surat_keputusan', 'm_surat_keputusan', false, 'id', ["title","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->surat_keputusan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->surat_keputusan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->surat_keputusan->Param, "CustomMsg");
        $this->Fields['surat_keputusan'] = &$this->surat_keputusan;

        // sk_nomor
        $this->sk_nomor = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_sk_nomor', 'sk_nomor', '`sk_nomor`', '`sk_nomor`', 200, 255, -1, false, '`sk_nomor`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sk_nomor->Sortable = true; // Allow sort
        $this->sk_nomor->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sk_nomor->Param, "CustomMsg");
        $this->Fields['sk_nomor'] = &$this->sk_nomor;

        // tanggal_sk
        $this->tanggal_sk = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_tanggal_sk', 'tanggal_sk', '`tanggal_sk`', CastDateFieldForLike("`tanggal_sk`", 7, "DB"), 133, 10, 7, false, '`tanggal_sk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_sk->Sortable = true; // Allow sort
        $this->tanggal_sk->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->tanggal_sk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_sk->Param, "CustomMsg");
        $this->Fields['tanggal_sk'] = &$this->tanggal_sk;

        // status_hukuman
        $this->status_hukuman = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_status_hukuman', 'status_hukuman', '`status_hukuman`', '`status_hukuman`', 202, 7, -1, false, '`status_hukuman`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->status_hukuman->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->status_hukuman->Lookup = new Lookup('status_hukuman', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->status_hukuman->Lookup = new Lookup('status_hukuman', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->status_hukuman->OptionCount = 3;
        $this->status_hukuman->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status_hukuman->Param, "CustomMsg");
        $this->Fields['status_hukuman'] = &$this->status_hukuman;

        // pernah_dijatuhi_hukuman
        $this->pernah_dijatuhi_hukuman = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_pernah_dijatuhi_hukuman', 'pernah_dijatuhi_hukuman', '`pernah_dijatuhi_hukuman`', '`pernah_dijatuhi_hukuman`', 202, 5, -1, false, '`pernah_dijatuhi_hukuman`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->pernah_dijatuhi_hukuman->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->pernah_dijatuhi_hukuman->Lookup = new Lookup('pernah_dijatuhi_hukuman', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->pernah_dijatuhi_hukuman->Lookup = new Lookup('pernah_dijatuhi_hukuman', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->pernah_dijatuhi_hukuman->OptionCount = 2;
        $this->pernah_dijatuhi_hukuman->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pernah_dijatuhi_hukuman->Param, "CustomMsg");
        $this->Fields['pernah_dijatuhi_hukuman'] = &$this->pernah_dijatuhi_hukuman;

        // sk_banding_nomor
        $this->sk_banding_nomor = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_sk_banding_nomor', 'sk_banding_nomor', '`sk_banding_nomor`', '`sk_banding_nomor`', 200, 255, -1, false, '`sk_banding_nomor`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sk_banding_nomor->Sortable = true; // Allow sort
        $this->sk_banding_nomor->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sk_banding_nomor->Param, "CustomMsg");
        $this->Fields['sk_banding_nomor'] = &$this->sk_banding_nomor;

        // tgl_sk_banding
        $this->tgl_sk_banding = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_tgl_sk_banding', 'tgl_sk_banding', '`tgl_sk_banding`', CastDateFieldForLike("`tgl_sk_banding`", 7, "DB"), 133, 10, 7, false, '`tgl_sk_banding`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_sk_banding->Sortable = true; // Allow sort
        $this->tgl_sk_banding->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->tgl_sk_banding->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_sk_banding->Param, "CustomMsg");
        $this->Fields['tgl_sk_banding'] = &$this->tgl_sk_banding;

        // mengajukan_keberatan_banding
        $this->mengajukan_keberatan_banding = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_mengajukan_keberatan_banding', 'mengajukan_keberatan_banding', '`mengajukan_keberatan_banding`', '`mengajukan_keberatan_banding`', 202, 5, -1, false, '`mengajukan_keberatan_banding`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->mengajukan_keberatan_banding->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->mengajukan_keberatan_banding->Lookup = new Lookup('mengajukan_keberatan_banding', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->mengajukan_keberatan_banding->Lookup = new Lookup('mengajukan_keberatan_banding', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->mengajukan_keberatan_banding->OptionCount = 2;
        $this->mengajukan_keberatan_banding->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->mengajukan_keberatan_banding->Param, "CustomMsg");
        $this->Fields['mengajukan_keberatan_banding'] = &$this->mengajukan_keberatan_banding;

        // pelanggaran_disiplin
        $this->pelanggaran_disiplin = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_pelanggaran_disiplin', 'pelanggaran_disiplin', '`pelanggaran_disiplin`', '`pelanggaran_disiplin`', 201, 65535, -1, false, '`pelanggaran_disiplin`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pelanggaran_disiplin->Sortable = true; // Allow sort
        $this->pelanggaran_disiplin->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pelanggaran_disiplin->Param, "CustomMsg");
        $this->Fields['pelanggaran_disiplin'] = &$this->pelanggaran_disiplin;

        // inspeksi_kasus
        $this->inspeksi_kasus = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_inspeksi_kasus', 'inspeksi_kasus', '`inspeksi_kasus`', '`inspeksi_kasus`', 202, 5, -1, false, '`inspeksi_kasus`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->inspeksi_kasus->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->inspeksi_kasus->Lookup = new Lookup('inspeksi_kasus', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->inspeksi_kasus->Lookup = new Lookup('inspeksi_kasus', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->inspeksi_kasus->OptionCount = 2;
        $this->inspeksi_kasus->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->inspeksi_kasus->Param, "CustomMsg");
        $this->Fields['inspeksi_kasus'] = &$this->inspeksi_kasus;

        // tempat_sidang_kode_perilaku
        $this->tempat_sidang_kode_perilaku = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_tempat_sidang_kode_perilaku', 'tempat_sidang_kode_perilaku', '`tempat_sidang_kode_perilaku`', '`tempat_sidang_kode_perilaku`', 3, 11, -1, false, '`tempat_sidang_kode_perilaku`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tempat_sidang_kode_perilaku->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->tempat_sidang_kode_perilaku->Lookup = new Lookup('tempat_sidang_kode_perilaku', 'm_satuan_kerja', false, 'id', ["satuan_kerja","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->tempat_sidang_kode_perilaku->Lookup = new Lookup('tempat_sidang_kode_perilaku', 'm_satuan_kerja', false, 'id', ["satuan_kerja","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->tempat_sidang_kode_perilaku->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tempat_sidang_kode_perilaku->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tempat_sidang_kode_perilaku->Param, "CustomMsg");
        $this->Fields['tempat_sidang_kode_perilaku'] = &$this->tempat_sidang_kode_perilaku;

        // hukuman_administratif
        $this->hukuman_administratif = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_hukuman_administratif', 'hukuman_administratif', '`hukuman_administratif`', '`hukuman_administratif`', 200, 255, -1, false, '`hukuman_administratif`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hukuman_administratif->Sortable = true; // Allow sort
        $this->hukuman_administratif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hukuman_administratif->Param, "CustomMsg");
        $this->Fields['hukuman_administratif'] = &$this->hukuman_administratif;

        // sidang_kode_perilaku_jaksa
        $this->sidang_kode_perilaku_jaksa = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_sidang_kode_perilaku_jaksa', 'sidang_kode_perilaku_jaksa', '`sidang_kode_perilaku_jaksa`', '`sidang_kode_perilaku_jaksa`', 202, 5, -1, false, '`sidang_kode_perilaku_jaksa`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->sidang_kode_perilaku_jaksa->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->sidang_kode_perilaku_jaksa->Lookup = new Lookup('sidang_kode_perilaku_jaksa', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->sidang_kode_perilaku_jaksa->Lookup = new Lookup('sidang_kode_perilaku_jaksa', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->sidang_kode_perilaku_jaksa->OptionCount = 2;
        $this->sidang_kode_perilaku_jaksa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sidang_kode_perilaku_jaksa->Param, "CustomMsg");
        $this->Fields['sidang_kode_perilaku_jaksa'] = &$this->sidang_kode_perilaku_jaksa;

        // sk_nomor_kode_perilaku
        $this->sk_nomor_kode_perilaku = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_sk_nomor_kode_perilaku', 'sk_nomor_kode_perilaku', '`sk_nomor_kode_perilaku`', '`sk_nomor_kode_perilaku`', 200, 255, -1, false, '`sk_nomor_kode_perilaku`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sk_nomor_kode_perilaku->Sortable = true; // Allow sort
        $this->sk_nomor_kode_perilaku->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sk_nomor_kode_perilaku->Param, "CustomMsg");
        $this->Fields['sk_nomor_kode_perilaku'] = &$this->sk_nomor_kode_perilaku;

        // tgl_sk_kode_perilaku
        $this->tgl_sk_kode_perilaku = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_tgl_sk_kode_perilaku', 'tgl_sk_kode_perilaku', '`tgl_sk_kode_perilaku`', CastDateFieldForLike("`tgl_sk_kode_perilaku`", 7, "DB"), 133, 10, 7, false, '`tgl_sk_kode_perilaku`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_sk_kode_perilaku->Sortable = true; // Allow sort
        $this->tgl_sk_kode_perilaku->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->tgl_sk_kode_perilaku->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_sk_kode_perilaku->Param, "CustomMsg");
        $this->Fields['tgl_sk_kode_perilaku'] = &$this->tgl_sk_kode_perilaku;

        // status_hukuman_kode_perilaku
        $this->status_hukuman_kode_perilaku = new DbField('v_pemeriksa', 'v_pemeriksa', 'x_status_hukuman_kode_perilaku', 'status_hukuman_kode_perilaku', '`status_hukuman_kode_perilaku`', '`status_hukuman_kode_perilaku`', 202, 7, -1, false, '`status_hukuman_kode_perilaku`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->status_hukuman_kode_perilaku->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->status_hukuman_kode_perilaku->Lookup = new Lookup('status_hukuman_kode_perilaku', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->status_hukuman_kode_perilaku->Lookup = new Lookup('status_hukuman_kode_perilaku', 'v_pemeriksa', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->status_hukuman_kode_perilaku->OptionCount = 2;
        $this->status_hukuman_kode_perilaku->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status_hukuman_kode_perilaku->Param, "CustomMsg");
        $this->Fields['status_hukuman_kode_perilaku'] = &$this->status_hukuman_kode_perilaku;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`v_pemeriksa`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->id_request->setDbValue($conn->lastInsertId());
            $rs['id_request'] = $this->id_request->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id_request', $rs)) {
                AddFilter($where, QuotedName('id_request', $this->Dbid) . '=' . QuotedValue($rs['id_request'], $this->id_request->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id_request->DbValue = $row['id_request'];
        $this->tanggal_request->DbValue = $row['tanggal_request'];
        $this->nip->DbValue = $row['nip'];
        $this->nrp->DbValue = $row['nrp'];
        $this->nama->DbValue = $row['nama'];
        $this->unit_organisasi->DbValue = $row['unit_organisasi'];
        $this->pangkat->DbValue = $row['pangkat'];
        $this->jabatan->DbValue = $row['jabatan'];
        $this->scan_lhkpn->DbValue = $row['scan_lhkpn'];
        $this->scan_lhkasn->DbValue = $row['scan_lhkasn'];
        $this->kategori_pemohon->DbValue = $row['kategori_pemohon'];
        $this->keperluan->DbValue = $row['keperluan'];
        $this->hukuman_disiplin->DbValue = $row['hukuman_disiplin'];
        $this->email_pemohon->DbValue = $row['email_pemohon'];
        $this->keterangan->DbValue = $row['keterangan'];
        $this->status->DbValue = $row['status'];
        $this->jenis_hukuman->DbValue = $row['jenis_hukuman'];
        $this->hukuman->DbValue = $row['hukuman'];
        $this->pasal->DbValue = $row['pasal'];
        $this->surat_keputusan->DbValue = $row['surat_keputusan'];
        $this->sk_nomor->DbValue = $row['sk_nomor'];
        $this->tanggal_sk->DbValue = $row['tanggal_sk'];
        $this->status_hukuman->DbValue = $row['status_hukuman'];
        $this->pernah_dijatuhi_hukuman->DbValue = $row['pernah_dijatuhi_hukuman'];
        $this->sk_banding_nomor->DbValue = $row['sk_banding_nomor'];
        $this->tgl_sk_banding->DbValue = $row['tgl_sk_banding'];
        $this->mengajukan_keberatan_banding->DbValue = $row['mengajukan_keberatan_banding'];
        $this->pelanggaran_disiplin->DbValue = $row['pelanggaran_disiplin'];
        $this->inspeksi_kasus->DbValue = $row['inspeksi_kasus'];
        $this->tempat_sidang_kode_perilaku->DbValue = $row['tempat_sidang_kode_perilaku'];
        $this->hukuman_administratif->DbValue = $row['hukuman_administratif'];
        $this->sidang_kode_perilaku_jaksa->DbValue = $row['sidang_kode_perilaku_jaksa'];
        $this->sk_nomor_kode_perilaku->DbValue = $row['sk_nomor_kode_perilaku'];
        $this->tgl_sk_kode_perilaku->DbValue = $row['tgl_sk_kode_perilaku'];
        $this->status_hukuman_kode_perilaku->DbValue = $row['status_hukuman_kode_perilaku'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id_request` = @id_request@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id_request->CurrentValue : $this->id_request->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id_request->CurrentValue = $keys[0];
            } else {
                $this->id_request->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id_request', $row) ? $row['id_request'] : null;
        } else {
            $val = $this->id_request->OldValue !== null ? $this->id_request->OldValue : $this->id_request->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id_request@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("VPemeriksaList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "VPemeriksaView") {
            return $Language->phrase("View");
        } elseif ($pageName == "VPemeriksaEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "VPemeriksaAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "VPemeriksaView";
            case Config("API_ADD_ACTION"):
                return "VPemeriksaAdd";
            case Config("API_EDIT_ACTION"):
                return "VPemeriksaEdit";
            case Config("API_DELETE_ACTION"):
                return "VPemeriksaDelete";
            case Config("API_LIST_ACTION"):
                return "VPemeriksaList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "VPemeriksaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("VPemeriksaView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("VPemeriksaView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "VPemeriksaAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "VPemeriksaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("VPemeriksaEdit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("VPemeriksaAdd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("VPemeriksaDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id_request:" . JsonEncode($this->id_request->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id_request->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id_request->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id_request") ?? Route("id_request")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id_request->CurrentValue = $key;
            } else {
                $this->id_request->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->id_request->setDbValue($row['id_request']);
        $this->tanggal_request->setDbValue($row['tanggal_request']);
        $this->nip->setDbValue($row['nip']);
        $this->nrp->setDbValue($row['nrp']);
        $this->nama->setDbValue($row['nama']);
        $this->unit_organisasi->setDbValue($row['unit_organisasi']);
        $this->pangkat->setDbValue($row['pangkat']);
        $this->jabatan->setDbValue($row['jabatan']);
        $this->scan_lhkpn->setDbValue($row['scan_lhkpn']);
        $this->scan_lhkasn->setDbValue($row['scan_lhkasn']);
        $this->kategori_pemohon->setDbValue($row['kategori_pemohon']);
        $this->keperluan->setDbValue($row['keperluan']);
        $this->hukuman_disiplin->setDbValue($row['hukuman_disiplin']);
        $this->email_pemohon->setDbValue($row['email_pemohon']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->status->setDbValue($row['status']);
        $this->jenis_hukuman->setDbValue($row['jenis_hukuman']);
        $this->hukuman->setDbValue($row['hukuman']);
        $this->pasal->setDbValue($row['pasal']);
        $this->surat_keputusan->setDbValue($row['surat_keputusan']);
        $this->sk_nomor->setDbValue($row['sk_nomor']);
        $this->tanggal_sk->setDbValue($row['tanggal_sk']);
        $this->status_hukuman->setDbValue($row['status_hukuman']);
        $this->pernah_dijatuhi_hukuman->setDbValue($row['pernah_dijatuhi_hukuman']);
        $this->sk_banding_nomor->setDbValue($row['sk_banding_nomor']);
        $this->tgl_sk_banding->setDbValue($row['tgl_sk_banding']);
        $this->mengajukan_keberatan_banding->setDbValue($row['mengajukan_keberatan_banding']);
        $this->pelanggaran_disiplin->setDbValue($row['pelanggaran_disiplin']);
        $this->inspeksi_kasus->setDbValue($row['inspeksi_kasus']);
        $this->tempat_sidang_kode_perilaku->setDbValue($row['tempat_sidang_kode_perilaku']);
        $this->hukuman_administratif->setDbValue($row['hukuman_administratif']);
        $this->sidang_kode_perilaku_jaksa->setDbValue($row['sidang_kode_perilaku_jaksa']);
        $this->sk_nomor_kode_perilaku->setDbValue($row['sk_nomor_kode_perilaku']);
        $this->tgl_sk_kode_perilaku->setDbValue($row['tgl_sk_kode_perilaku']);
        $this->status_hukuman_kode_perilaku->setDbValue($row['status_hukuman_kode_perilaku']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id_request

        // tanggal_request

        // nip

        // nrp

        // nama

        // unit_organisasi

        // pangkat

        // jabatan

        // scan_lhkpn

        // scan_lhkasn

        // kategori_pemohon

        // keperluan

        // hukuman_disiplin

        // email_pemohon

        // keterangan

        // status

        // jenis_hukuman

        // hukuman

        // pasal

        // surat_keputusan

        // sk_nomor

        // tanggal_sk

        // status_hukuman

        // pernah_dijatuhi_hukuman

        // sk_banding_nomor

        // tgl_sk_banding

        // mengajukan_keberatan_banding

        // pelanggaran_disiplin

        // inspeksi_kasus

        // tempat_sidang_kode_perilaku

        // hukuman_administratif

        // sidang_kode_perilaku_jaksa

        // sk_nomor_kode_perilaku

        // tgl_sk_kode_perilaku

        // status_hukuman_kode_perilaku

        // id_request
        $this->id_request->ViewValue = $this->id_request->CurrentValue;
        $this->id_request->ViewCustomAttributes = "";

        // tanggal_request
        $this->tanggal_request->ViewValue = $this->tanggal_request->CurrentValue;
        $this->tanggal_request->ViewValue = FormatDateTime($this->tanggal_request->ViewValue, 111);
        $this->tanggal_request->ViewCustomAttributes = "";

        // nip
        $this->nip->ViewValue = $this->nip->CurrentValue;
        $this->nip->ViewCustomAttributes = "";

        // nrp
        $this->nrp->ViewValue = $this->nrp->CurrentValue;
        $this->nrp->ViewCustomAttributes = "";

        // nama
        $this->nama->ViewValue = $this->nama->CurrentValue;
        $this->nama->ViewCustomAttributes = "";

        // unit_organisasi
        $this->unit_organisasi->ViewValue = $this->unit_organisasi->CurrentValue;
        $curVal = trim(strval($this->unit_organisasi->CurrentValue));
        if ($curVal != "") {
            $this->unit_organisasi->ViewValue = $this->unit_organisasi->lookupCacheOption($curVal);
            if ($this->unit_organisasi->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->unit_organisasi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->unit_organisasi->Lookup->renderViewRow($rswrk[0]);
                    $this->unit_organisasi->ViewValue = $this->unit_organisasi->displayValue($arwrk);
                } else {
                    $this->unit_organisasi->ViewValue = $this->unit_organisasi->CurrentValue;
                }
            }
        } else {
            $this->unit_organisasi->ViewValue = null;
        }
        $this->unit_organisasi->ViewCustomAttributes = "";

        // pangkat
        $curVal = trim(strval($this->pangkat->CurrentValue));
        if ($curVal != "") {
            $this->pangkat->ViewValue = $this->pangkat->lookupCacheOption($curVal);
            if ($this->pangkat->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->pangkat->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->pangkat->Lookup->renderViewRow($rswrk[0]);
                    $this->pangkat->ViewValue = $this->pangkat->displayValue($arwrk);
                } else {
                    $this->pangkat->ViewValue = $this->pangkat->CurrentValue;
                }
            }
        } else {
            $this->pangkat->ViewValue = null;
        }
        $this->pangkat->ViewCustomAttributes = "";

        // jabatan
        $curVal = trim(strval($this->jabatan->CurrentValue));
        if ($curVal != "") {
            $this->jabatan->ViewValue = $this->jabatan->lookupCacheOption($curVal);
            if ($this->jabatan->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->jabatan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->jabatan->Lookup->renderViewRow($rswrk[0]);
                    $this->jabatan->ViewValue = $this->jabatan->displayValue($arwrk);
                } else {
                    $this->jabatan->ViewValue = $this->jabatan->CurrentValue;
                }
            }
        } else {
            $this->jabatan->ViewValue = null;
        }
        $this->jabatan->ViewCustomAttributes = "";

        // scan_lhkpn
        $this->scan_lhkpn->ViewValue = $this->scan_lhkpn->CurrentValue;
        $this->scan_lhkpn->ViewCustomAttributes = "";

        // scan_lhkasn
        $this->scan_lhkasn->ViewValue = $this->scan_lhkasn->CurrentValue;
        $this->scan_lhkasn->ViewCustomAttributes = "";

        // kategori_pemohon
        if (strval($this->kategori_pemohon->CurrentValue) != "") {
            $this->kategori_pemohon->ViewValue = $this->kategori_pemohon->optionCaption($this->kategori_pemohon->CurrentValue);
        } else {
            $this->kategori_pemohon->ViewValue = null;
        }
        $this->kategori_pemohon->ViewCustomAttributes = "";

        // keperluan
        $curVal = trim(strval($this->keperluan->CurrentValue));
        if ($curVal != "") {
            $this->keperluan->ViewValue = $this->keperluan->lookupCacheOption($curVal);
            if ($this->keperluan->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->keperluan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->keperluan->Lookup->renderViewRow($rswrk[0]);
                    $this->keperluan->ViewValue = $this->keperluan->displayValue($arwrk);
                } else {
                    $this->keperluan->ViewValue = $this->keperluan->CurrentValue;
                }
            }
        } else {
            $this->keperluan->ViewValue = null;
        }
        $this->keperluan->ViewCustomAttributes = "";

        // hukuman_disiplin
        if (strval($this->hukuman_disiplin->CurrentValue) != "") {
            $this->hukuman_disiplin->ViewValue = $this->hukuman_disiplin->optionCaption($this->hukuman_disiplin->CurrentValue);
        } else {
            $this->hukuman_disiplin->ViewValue = null;
        }
        $this->hukuman_disiplin->ViewCustomAttributes = "";

        // email_pemohon
        $this->email_pemohon->ViewValue = $this->email_pemohon->CurrentValue;
        $this->email_pemohon->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // status
        if (strval($this->status->CurrentValue) != "") {
            $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
        } else {
            $this->status->ViewValue = null;
        }
        $this->status->ViewCustomAttributes = "";

        // jenis_hukuman
        if (strval($this->jenis_hukuman->CurrentValue) != "") {
            $this->jenis_hukuman->ViewValue = $this->jenis_hukuman->optionCaption($this->jenis_hukuman->CurrentValue);
        } else {
            $this->jenis_hukuman->ViewValue = null;
        }
        $this->jenis_hukuman->ViewCustomAttributes = "";

        // hukuman
        $this->hukuman->ViewValue = $this->hukuman->CurrentValue;
        $this->hukuman->ViewCustomAttributes = "";

        // pasal
        $this->pasal->ViewValue = $this->pasal->CurrentValue;
        $this->pasal->ViewCustomAttributes = "";

        // surat_keputusan
        $curVal = trim(strval($this->surat_keputusan->CurrentValue));
        if ($curVal != "") {
            $this->surat_keputusan->ViewValue = $this->surat_keputusan->lookupCacheOption($curVal);
            if ($this->surat_keputusan->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->surat_keputusan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->surat_keputusan->Lookup->renderViewRow($rswrk[0]);
                    $this->surat_keputusan->ViewValue = $this->surat_keputusan->displayValue($arwrk);
                } else {
                    $this->surat_keputusan->ViewValue = $this->surat_keputusan->CurrentValue;
                }
            }
        } else {
            $this->surat_keputusan->ViewValue = null;
        }
        $this->surat_keputusan->ViewCustomAttributes = "";

        // sk_nomor
        $this->sk_nomor->ViewValue = $this->sk_nomor->CurrentValue;
        $this->sk_nomor->ViewCustomAttributes = "";

        // tanggal_sk
        $this->tanggal_sk->ViewValue = $this->tanggal_sk->CurrentValue;
        $this->tanggal_sk->ViewValue = FormatDateTime($this->tanggal_sk->ViewValue, 7);
        $this->tanggal_sk->ViewCustomAttributes = "";

        // status_hukuman
        if (strval($this->status_hukuman->CurrentValue) != "") {
            $this->status_hukuman->ViewValue = $this->status_hukuman->optionCaption($this->status_hukuman->CurrentValue);
        } else {
            $this->status_hukuman->ViewValue = null;
        }
        $this->status_hukuman->ViewCustomAttributes = "";

        // pernah_dijatuhi_hukuman
        if (strval($this->pernah_dijatuhi_hukuman->CurrentValue) != "") {
            $this->pernah_dijatuhi_hukuman->ViewValue = $this->pernah_dijatuhi_hukuman->optionCaption($this->pernah_dijatuhi_hukuman->CurrentValue);
        } else {
            $this->pernah_dijatuhi_hukuman->ViewValue = null;
        }
        $this->pernah_dijatuhi_hukuman->ViewCustomAttributes = "";

        // sk_banding_nomor
        $this->sk_banding_nomor->ViewValue = $this->sk_banding_nomor->CurrentValue;
        $this->sk_banding_nomor->ViewCustomAttributes = "";

        // tgl_sk_banding
        $this->tgl_sk_banding->ViewValue = $this->tgl_sk_banding->CurrentValue;
        $this->tgl_sk_banding->ViewValue = FormatDateTime($this->tgl_sk_banding->ViewValue, 7);
        $this->tgl_sk_banding->ViewCustomAttributes = "";

        // mengajukan_keberatan_banding
        if (strval($this->mengajukan_keberatan_banding->CurrentValue) != "") {
            $this->mengajukan_keberatan_banding->ViewValue = $this->mengajukan_keberatan_banding->optionCaption($this->mengajukan_keberatan_banding->CurrentValue);
        } else {
            $this->mengajukan_keberatan_banding->ViewValue = null;
        }
        $this->mengajukan_keberatan_banding->ViewCustomAttributes = "";

        // pelanggaran_disiplin
        $this->pelanggaran_disiplin->ViewValue = $this->pelanggaran_disiplin->CurrentValue;
        $this->pelanggaran_disiplin->ViewCustomAttributes = "";

        // inspeksi_kasus
        if (strval($this->inspeksi_kasus->CurrentValue) != "") {
            $this->inspeksi_kasus->ViewValue = $this->inspeksi_kasus->optionCaption($this->inspeksi_kasus->CurrentValue);
        } else {
            $this->inspeksi_kasus->ViewValue = null;
        }
        $this->inspeksi_kasus->ViewCustomAttributes = "";

        // tempat_sidang_kode_perilaku
        $this->tempat_sidang_kode_perilaku->ViewValue = $this->tempat_sidang_kode_perilaku->CurrentValue;
        $curVal = trim(strval($this->tempat_sidang_kode_perilaku->CurrentValue));
        if ($curVal != "") {
            $this->tempat_sidang_kode_perilaku->ViewValue = $this->tempat_sidang_kode_perilaku->lookupCacheOption($curVal);
            if ($this->tempat_sidang_kode_perilaku->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->tempat_sidang_kode_perilaku->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tempat_sidang_kode_perilaku->Lookup->renderViewRow($rswrk[0]);
                    $this->tempat_sidang_kode_perilaku->ViewValue = $this->tempat_sidang_kode_perilaku->displayValue($arwrk);
                } else {
                    $this->tempat_sidang_kode_perilaku->ViewValue = $this->tempat_sidang_kode_perilaku->CurrentValue;
                }
            }
        } else {
            $this->tempat_sidang_kode_perilaku->ViewValue = null;
        }
        $this->tempat_sidang_kode_perilaku->ViewCustomAttributes = "";

        // hukuman_administratif
        $this->hukuman_administratif->ViewValue = $this->hukuman_administratif->CurrentValue;
        $this->hukuman_administratif->ViewCustomAttributes = "";

        // sidang_kode_perilaku_jaksa
        if (strval($this->sidang_kode_perilaku_jaksa->CurrentValue) != "") {
            $this->sidang_kode_perilaku_jaksa->ViewValue = $this->sidang_kode_perilaku_jaksa->optionCaption($this->sidang_kode_perilaku_jaksa->CurrentValue);
        } else {
            $this->sidang_kode_perilaku_jaksa->ViewValue = null;
        }
        $this->sidang_kode_perilaku_jaksa->ViewCustomAttributes = "";

        // sk_nomor_kode_perilaku
        $this->sk_nomor_kode_perilaku->ViewValue = $this->sk_nomor_kode_perilaku->CurrentValue;
        $this->sk_nomor_kode_perilaku->ViewCustomAttributes = "";

        // tgl_sk_kode_perilaku
        $this->tgl_sk_kode_perilaku->ViewValue = $this->tgl_sk_kode_perilaku->CurrentValue;
        $this->tgl_sk_kode_perilaku->ViewValue = FormatDateTime($this->tgl_sk_kode_perilaku->ViewValue, 7);
        $this->tgl_sk_kode_perilaku->ViewCustomAttributes = "";

        // status_hukuman_kode_perilaku
        if (strval($this->status_hukuman_kode_perilaku->CurrentValue) != "") {
            $this->status_hukuman_kode_perilaku->ViewValue = $this->status_hukuman_kode_perilaku->optionCaption($this->status_hukuman_kode_perilaku->CurrentValue);
        } else {
            $this->status_hukuman_kode_perilaku->ViewValue = null;
        }
        $this->status_hukuman_kode_perilaku->ViewCustomAttributes = "";

        // id_request
        $this->id_request->LinkCustomAttributes = "";
        $this->id_request->HrefValue = "";
        $this->id_request->TooltipValue = "";

        // tanggal_request
        $this->tanggal_request->LinkCustomAttributes = "";
        $this->tanggal_request->HrefValue = "";
        $this->tanggal_request->TooltipValue = "";

        // nip
        $this->nip->LinkCustomAttributes = "";
        $this->nip->HrefValue = "";
        $this->nip->TooltipValue = "";

        // nrp
        $this->nrp->LinkCustomAttributes = "";
        $this->nrp->HrefValue = "";
        $this->nrp->TooltipValue = "";

        // nama
        $this->nama->LinkCustomAttributes = "";
        $this->nama->HrefValue = "";
        $this->nama->TooltipValue = "";

        // unit_organisasi
        $this->unit_organisasi->LinkCustomAttributes = "";
        $this->unit_organisasi->HrefValue = "";
        $this->unit_organisasi->TooltipValue = "";

        // pangkat
        $this->pangkat->LinkCustomAttributes = "";
        $this->pangkat->HrefValue = "";
        $this->pangkat->TooltipValue = "";

        // jabatan
        $this->jabatan->LinkCustomAttributes = "";
        $this->jabatan->HrefValue = "";
        $this->jabatan->TooltipValue = "";

        // scan_lhkpn
        $this->scan_lhkpn->LinkCustomAttributes = "data-toggle=\"modal\"";
        if (!EmptyValue($this->scan_lhkpn->CurrentValue)) {
            $this->scan_lhkpn->HrefValue = $this->scan_lhkpn->CurrentValue; // Add prefix/suffix
            $this->scan_lhkpn->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->scan_lhkpn->HrefValue = FullUrl($this->scan_lhkpn->HrefValue, "href");
            }
        } else {
            $this->scan_lhkpn->HrefValue = "";
        }
        $this->scan_lhkpn->TooltipValue = "";

        // scan_lhkasn
        $this->scan_lhkasn->LinkCustomAttributes = "data-toggle=\"modal\"";
        if (!EmptyValue($this->scan_lhkasn->CurrentValue)) {
            $this->scan_lhkasn->HrefValue = $this->scan_lhkasn->CurrentValue; // Add prefix/suffix
            $this->scan_lhkasn->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->scan_lhkasn->HrefValue = FullUrl($this->scan_lhkasn->HrefValue, "href");
            }
        } else {
            $this->scan_lhkasn->HrefValue = "";
        }
        $this->scan_lhkasn->TooltipValue = "";

        // kategori_pemohon
        $this->kategori_pemohon->LinkCustomAttributes = "";
        $this->kategori_pemohon->HrefValue = "";
        $this->kategori_pemohon->TooltipValue = "";

        // keperluan
        $this->keperluan->LinkCustomAttributes = "";
        $this->keperluan->HrefValue = "";
        $this->keperluan->TooltipValue = "";

        // hukuman_disiplin
        $this->hukuman_disiplin->LinkCustomAttributes = "";
        $this->hukuman_disiplin->HrefValue = "";
        $this->hukuman_disiplin->TooltipValue = "";

        // email_pemohon
        $this->email_pemohon->LinkCustomAttributes = "";
        $this->email_pemohon->HrefValue = "";
        $this->email_pemohon->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // jenis_hukuman
        $this->jenis_hukuman->LinkCustomAttributes = "";
        $this->jenis_hukuman->HrefValue = "";
        $this->jenis_hukuman->TooltipValue = "";

        // hukuman
        $this->hukuman->LinkCustomAttributes = "";
        $this->hukuman->HrefValue = "";
        $this->hukuman->TooltipValue = "";

        // pasal
        $this->pasal->LinkCustomAttributes = "";
        $this->pasal->HrefValue = "";
        $this->pasal->TooltipValue = "";

        // surat_keputusan
        $this->surat_keputusan->LinkCustomAttributes = "";
        $this->surat_keputusan->HrefValue = "";
        $this->surat_keputusan->TooltipValue = "";

        // sk_nomor
        $this->sk_nomor->LinkCustomAttributes = "";
        $this->sk_nomor->HrefValue = "";
        $this->sk_nomor->TooltipValue = "";

        // tanggal_sk
        $this->tanggal_sk->LinkCustomAttributes = "";
        $this->tanggal_sk->HrefValue = "";
        $this->tanggal_sk->TooltipValue = "";

        // status_hukuman
        $this->status_hukuman->LinkCustomAttributes = "";
        $this->status_hukuman->HrefValue = "";
        $this->status_hukuman->TooltipValue = "";

        // pernah_dijatuhi_hukuman
        $this->pernah_dijatuhi_hukuman->LinkCustomAttributes = "";
        $this->pernah_dijatuhi_hukuman->HrefValue = "";
        $this->pernah_dijatuhi_hukuman->TooltipValue = "";

        // sk_banding_nomor
        $this->sk_banding_nomor->LinkCustomAttributes = "";
        $this->sk_banding_nomor->HrefValue = "";
        $this->sk_banding_nomor->TooltipValue = "";

        // tgl_sk_banding
        $this->tgl_sk_banding->LinkCustomAttributes = "";
        $this->tgl_sk_banding->HrefValue = "";
        $this->tgl_sk_banding->TooltipValue = "";

        // mengajukan_keberatan_banding
        $this->mengajukan_keberatan_banding->LinkCustomAttributes = "";
        $this->mengajukan_keberatan_banding->HrefValue = "";
        $this->mengajukan_keberatan_banding->TooltipValue = "";

        // pelanggaran_disiplin
        $this->pelanggaran_disiplin->LinkCustomAttributes = "";
        $this->pelanggaran_disiplin->HrefValue = "";
        $this->pelanggaran_disiplin->TooltipValue = "";

        // inspeksi_kasus
        $this->inspeksi_kasus->LinkCustomAttributes = "";
        $this->inspeksi_kasus->HrefValue = "";
        $this->inspeksi_kasus->TooltipValue = "";

        // tempat_sidang_kode_perilaku
        $this->tempat_sidang_kode_perilaku->LinkCustomAttributes = "";
        $this->tempat_sidang_kode_perilaku->HrefValue = "";
        $this->tempat_sidang_kode_perilaku->TooltipValue = "";

        // hukuman_administratif
        $this->hukuman_administratif->LinkCustomAttributes = "";
        $this->hukuman_administratif->HrefValue = "";
        $this->hukuman_administratif->TooltipValue = "";

        // sidang_kode_perilaku_jaksa
        $this->sidang_kode_perilaku_jaksa->LinkCustomAttributes = "";
        $this->sidang_kode_perilaku_jaksa->HrefValue = "";
        $this->sidang_kode_perilaku_jaksa->TooltipValue = "";

        // sk_nomor_kode_perilaku
        $this->sk_nomor_kode_perilaku->LinkCustomAttributes = "";
        $this->sk_nomor_kode_perilaku->HrefValue = "";
        $this->sk_nomor_kode_perilaku->TooltipValue = "";

        // tgl_sk_kode_perilaku
        $this->tgl_sk_kode_perilaku->LinkCustomAttributes = "";
        $this->tgl_sk_kode_perilaku->HrefValue = "";
        $this->tgl_sk_kode_perilaku->TooltipValue = "";

        // status_hukuman_kode_perilaku
        $this->status_hukuman_kode_perilaku->LinkCustomAttributes = "";
        $this->status_hukuman_kode_perilaku->HrefValue = "";
        $this->status_hukuman_kode_perilaku->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id_request
        $this->id_request->EditAttrs["class"] = "form-control";
        $this->id_request->EditCustomAttributes = "";
        $this->id_request->EditValue = $this->id_request->CurrentValue;
        $this->id_request->ViewCustomAttributes = "";

        // tanggal_request
        $this->tanggal_request->EditAttrs["class"] = "form-control";
        $this->tanggal_request->EditCustomAttributes = "";
        $this->tanggal_request->EditValue = $this->tanggal_request->CurrentValue;
        $this->tanggal_request->EditValue = FormatDateTime($this->tanggal_request->EditValue, 111);
        $this->tanggal_request->ViewCustomAttributes = "";

        // nip
        $this->nip->EditAttrs["class"] = "form-control";
        $this->nip->EditCustomAttributes = "";
        $this->nip->EditValue = $this->nip->CurrentValue;
        $this->nip->ViewCustomAttributes = "";

        // nrp
        $this->nrp->EditAttrs["class"] = "form-control";
        $this->nrp->EditCustomAttributes = "";
        $this->nrp->EditValue = $this->nrp->CurrentValue;
        $this->nrp->ViewCustomAttributes = "";

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->ViewCustomAttributes = "";

        // unit_organisasi
        $this->unit_organisasi->EditAttrs["class"] = "form-control";
        $this->unit_organisasi->EditCustomAttributes = "";
        $this->unit_organisasi->EditValue = $this->unit_organisasi->CurrentValue;
        $curVal = trim(strval($this->unit_organisasi->CurrentValue));
        if ($curVal != "") {
            $this->unit_organisasi->EditValue = $this->unit_organisasi->lookupCacheOption($curVal);
            if ($this->unit_organisasi->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->unit_organisasi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->unit_organisasi->Lookup->renderViewRow($rswrk[0]);
                    $this->unit_organisasi->EditValue = $this->unit_organisasi->displayValue($arwrk);
                } else {
                    $this->unit_organisasi->EditValue = $this->unit_organisasi->CurrentValue;
                }
            }
        } else {
            $this->unit_organisasi->EditValue = null;
        }
        $this->unit_organisasi->ViewCustomAttributes = "";

        // pangkat
        $this->pangkat->EditAttrs["class"] = "form-control";
        $this->pangkat->EditCustomAttributes = "";
        $curVal = trim(strval($this->pangkat->CurrentValue));
        if ($curVal != "") {
            $this->pangkat->EditValue = $this->pangkat->lookupCacheOption($curVal);
            if ($this->pangkat->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->pangkat->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->pangkat->Lookup->renderViewRow($rswrk[0]);
                    $this->pangkat->EditValue = $this->pangkat->displayValue($arwrk);
                } else {
                    $this->pangkat->EditValue = $this->pangkat->CurrentValue;
                }
            }
        } else {
            $this->pangkat->EditValue = null;
        }
        $this->pangkat->ViewCustomAttributes = "";

        // jabatan
        $this->jabatan->EditAttrs["class"] = "form-control";
        $this->jabatan->EditCustomAttributes = "";
        $curVal = trim(strval($this->jabatan->CurrentValue));
        if ($curVal != "") {
            $this->jabatan->EditValue = $this->jabatan->lookupCacheOption($curVal);
            if ($this->jabatan->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->jabatan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->jabatan->Lookup->renderViewRow($rswrk[0]);
                    $this->jabatan->EditValue = $this->jabatan->displayValue($arwrk);
                } else {
                    $this->jabatan->EditValue = $this->jabatan->CurrentValue;
                }
            }
        } else {
            $this->jabatan->EditValue = null;
        }
        $this->jabatan->ViewCustomAttributes = "";

        // scan_lhkpn
        $this->scan_lhkpn->EditAttrs["class"] = "form-control";
        $this->scan_lhkpn->EditCustomAttributes = "";
        $this->scan_lhkpn->EditValue = $this->scan_lhkpn->CurrentValue;
        $this->scan_lhkpn->ViewCustomAttributes = "";

        // scan_lhkasn
        $this->scan_lhkasn->EditAttrs["class"] = "form-control";
        $this->scan_lhkasn->EditCustomAttributes = "";
        $this->scan_lhkasn->EditValue = $this->scan_lhkasn->CurrentValue;
        $this->scan_lhkasn->ViewCustomAttributes = "";

        // kategori_pemohon
        $this->kategori_pemohon->EditAttrs["class"] = "form-control";
        $this->kategori_pemohon->EditCustomAttributes = "";
        if (strval($this->kategori_pemohon->CurrentValue) != "") {
            $this->kategori_pemohon->EditValue = $this->kategori_pemohon->optionCaption($this->kategori_pemohon->CurrentValue);
        } else {
            $this->kategori_pemohon->EditValue = null;
        }
        $this->kategori_pemohon->ViewCustomAttributes = "";

        // keperluan
        $this->keperluan->EditAttrs["class"] = "form-control";
        $this->keperluan->EditCustomAttributes = "";
        $curVal = trim(strval($this->keperluan->CurrentValue));
        if ($curVal != "") {
            $this->keperluan->EditValue = $this->keperluan->lookupCacheOption($curVal);
            if ($this->keperluan->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->keperluan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->keperluan->Lookup->renderViewRow($rswrk[0]);
                    $this->keperluan->EditValue = $this->keperluan->displayValue($arwrk);
                } else {
                    $this->keperluan->EditValue = $this->keperluan->CurrentValue;
                }
            }
        } else {
            $this->keperluan->EditValue = null;
        }
        $this->keperluan->ViewCustomAttributes = "";

        // hukuman_disiplin
        $this->hukuman_disiplin->EditAttrs["class"] = "form-control";
        $this->hukuman_disiplin->EditCustomAttributes = "";
        if (strval($this->hukuman_disiplin->CurrentValue) != "") {
            $this->hukuman_disiplin->EditValue = $this->hukuman_disiplin->optionCaption($this->hukuman_disiplin->CurrentValue);
        } else {
            $this->hukuman_disiplin->EditValue = null;
        }
        $this->hukuman_disiplin->ViewCustomAttributes = "";

        // email_pemohon
        $this->email_pemohon->EditAttrs["class"] = "form-control";
        $this->email_pemohon->EditCustomAttributes = "";
        $this->email_pemohon->EditValue = $this->email_pemohon->CurrentValue;
        $this->email_pemohon->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // status
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->options(false);
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // jenis_hukuman
        $this->jenis_hukuman->EditAttrs["class"] = "form-control";
        $this->jenis_hukuman->EditCustomAttributes = "";
        if (strval($this->jenis_hukuman->CurrentValue) != "") {
            $this->jenis_hukuman->EditValue = $this->jenis_hukuman->optionCaption($this->jenis_hukuman->CurrentValue);
        } else {
            $this->jenis_hukuman->EditValue = null;
        }
        $this->jenis_hukuman->ViewCustomAttributes = "";

        // hukuman
        $this->hukuman->EditAttrs["class"] = "form-control";
        $this->hukuman->EditCustomAttributes = "";
        $this->hukuman->EditValue = $this->hukuman->CurrentValue;
        $this->hukuman->ViewCustomAttributes = "";

        // pasal
        $this->pasal->EditAttrs["class"] = "form-control";
        $this->pasal->EditCustomAttributes = "";
        $this->pasal->EditValue = $this->pasal->CurrentValue;
        $this->pasal->ViewCustomAttributes = "";

        // surat_keputusan
        $this->surat_keputusan->EditAttrs["class"] = "form-control";
        $this->surat_keputusan->EditCustomAttributes = "";
        $curVal = trim(strval($this->surat_keputusan->CurrentValue));
        if ($curVal != "") {
            $this->surat_keputusan->EditValue = $this->surat_keputusan->lookupCacheOption($curVal);
            if ($this->surat_keputusan->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->surat_keputusan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->surat_keputusan->Lookup->renderViewRow($rswrk[0]);
                    $this->surat_keputusan->EditValue = $this->surat_keputusan->displayValue($arwrk);
                } else {
                    $this->surat_keputusan->EditValue = $this->surat_keputusan->CurrentValue;
                }
            }
        } else {
            $this->surat_keputusan->EditValue = null;
        }
        $this->surat_keputusan->ViewCustomAttributes = "";

        // sk_nomor
        $this->sk_nomor->EditAttrs["class"] = "form-control";
        $this->sk_nomor->EditCustomAttributes = "";
        $this->sk_nomor->EditValue = $this->sk_nomor->CurrentValue;
        $this->sk_nomor->ViewCustomAttributes = "";

        // tanggal_sk
        $this->tanggal_sk->EditAttrs["class"] = "form-control";
        $this->tanggal_sk->EditCustomAttributes = "";
        $this->tanggal_sk->EditValue = $this->tanggal_sk->CurrentValue;
        $this->tanggal_sk->EditValue = FormatDateTime($this->tanggal_sk->EditValue, 7);
        $this->tanggal_sk->ViewCustomAttributes = "";

        // status_hukuman
        $this->status_hukuman->EditAttrs["class"] = "form-control";
        $this->status_hukuman->EditCustomAttributes = "";
        if (strval($this->status_hukuman->CurrentValue) != "") {
            $this->status_hukuman->EditValue = $this->status_hukuman->optionCaption($this->status_hukuman->CurrentValue);
        } else {
            $this->status_hukuman->EditValue = null;
        }
        $this->status_hukuman->ViewCustomAttributes = "";

        // pernah_dijatuhi_hukuman
        $this->pernah_dijatuhi_hukuman->EditAttrs["class"] = "form-control";
        $this->pernah_dijatuhi_hukuman->EditCustomAttributes = "";
        if (strval($this->pernah_dijatuhi_hukuman->CurrentValue) != "") {
            $this->pernah_dijatuhi_hukuman->EditValue = $this->pernah_dijatuhi_hukuman->optionCaption($this->pernah_dijatuhi_hukuman->CurrentValue);
        } else {
            $this->pernah_dijatuhi_hukuman->EditValue = null;
        }
        $this->pernah_dijatuhi_hukuman->ViewCustomAttributes = "";

        // sk_banding_nomor
        $this->sk_banding_nomor->EditAttrs["class"] = "form-control";
        $this->sk_banding_nomor->EditCustomAttributes = "";
        $this->sk_banding_nomor->EditValue = $this->sk_banding_nomor->CurrentValue;
        $this->sk_banding_nomor->ViewCustomAttributes = "";

        // tgl_sk_banding
        $this->tgl_sk_banding->EditAttrs["class"] = "form-control";
        $this->tgl_sk_banding->EditCustomAttributes = "";
        $this->tgl_sk_banding->EditValue = $this->tgl_sk_banding->CurrentValue;
        $this->tgl_sk_banding->EditValue = FormatDateTime($this->tgl_sk_banding->EditValue, 7);
        $this->tgl_sk_banding->ViewCustomAttributes = "";

        // mengajukan_keberatan_banding
        $this->mengajukan_keberatan_banding->EditAttrs["class"] = "form-control";
        $this->mengajukan_keberatan_banding->EditCustomAttributes = "";
        if (strval($this->mengajukan_keberatan_banding->CurrentValue) != "") {
            $this->mengajukan_keberatan_banding->EditValue = $this->mengajukan_keberatan_banding->optionCaption($this->mengajukan_keberatan_banding->CurrentValue);
        } else {
            $this->mengajukan_keberatan_banding->EditValue = null;
        }
        $this->mengajukan_keberatan_banding->ViewCustomAttributes = "";

        // pelanggaran_disiplin
        $this->pelanggaran_disiplin->EditAttrs["class"] = "form-control";
        $this->pelanggaran_disiplin->EditCustomAttributes = "";
        $this->pelanggaran_disiplin->EditValue = $this->pelanggaran_disiplin->CurrentValue;
        $this->pelanggaran_disiplin->ViewCustomAttributes = "";

        // inspeksi_kasus
        $this->inspeksi_kasus->EditAttrs["class"] = "form-control";
        $this->inspeksi_kasus->EditCustomAttributes = "";
        if (strval($this->inspeksi_kasus->CurrentValue) != "") {
            $this->inspeksi_kasus->EditValue = $this->inspeksi_kasus->optionCaption($this->inspeksi_kasus->CurrentValue);
        } else {
            $this->inspeksi_kasus->EditValue = null;
        }
        $this->inspeksi_kasus->ViewCustomAttributes = "";

        // tempat_sidang_kode_perilaku
        $this->tempat_sidang_kode_perilaku->EditAttrs["class"] = "form-control";
        $this->tempat_sidang_kode_perilaku->EditCustomAttributes = "";
        $this->tempat_sidang_kode_perilaku->EditValue = $this->tempat_sidang_kode_perilaku->CurrentValue;
        $curVal = trim(strval($this->tempat_sidang_kode_perilaku->CurrentValue));
        if ($curVal != "") {
            $this->tempat_sidang_kode_perilaku->EditValue = $this->tempat_sidang_kode_perilaku->lookupCacheOption($curVal);
            if ($this->tempat_sidang_kode_perilaku->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->tempat_sidang_kode_perilaku->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tempat_sidang_kode_perilaku->Lookup->renderViewRow($rswrk[0]);
                    $this->tempat_sidang_kode_perilaku->EditValue = $this->tempat_sidang_kode_perilaku->displayValue($arwrk);
                } else {
                    $this->tempat_sidang_kode_perilaku->EditValue = $this->tempat_sidang_kode_perilaku->CurrentValue;
                }
            }
        } else {
            $this->tempat_sidang_kode_perilaku->EditValue = null;
        }
        $this->tempat_sidang_kode_perilaku->ViewCustomAttributes = "";

        // hukuman_administratif
        $this->hukuman_administratif->EditAttrs["class"] = "form-control";
        $this->hukuman_administratif->EditCustomAttributes = "";
        $this->hukuman_administratif->EditValue = $this->hukuman_administratif->CurrentValue;
        $this->hukuman_administratif->ViewCustomAttributes = "";

        // sidang_kode_perilaku_jaksa
        $this->sidang_kode_perilaku_jaksa->EditAttrs["class"] = "form-control";
        $this->sidang_kode_perilaku_jaksa->EditCustomAttributes = "";
        if (strval($this->sidang_kode_perilaku_jaksa->CurrentValue) != "") {
            $this->sidang_kode_perilaku_jaksa->EditValue = $this->sidang_kode_perilaku_jaksa->optionCaption($this->sidang_kode_perilaku_jaksa->CurrentValue);
        } else {
            $this->sidang_kode_perilaku_jaksa->EditValue = null;
        }
        $this->sidang_kode_perilaku_jaksa->ViewCustomAttributes = "";

        // sk_nomor_kode_perilaku
        $this->sk_nomor_kode_perilaku->EditAttrs["class"] = "form-control";
        $this->sk_nomor_kode_perilaku->EditCustomAttributes = "";
        $this->sk_nomor_kode_perilaku->EditValue = $this->sk_nomor_kode_perilaku->CurrentValue;
        $this->sk_nomor_kode_perilaku->ViewCustomAttributes = "";

        // tgl_sk_kode_perilaku
        $this->tgl_sk_kode_perilaku->EditAttrs["class"] = "form-control";
        $this->tgl_sk_kode_perilaku->EditCustomAttributes = "";
        $this->tgl_sk_kode_perilaku->EditValue = $this->tgl_sk_kode_perilaku->CurrentValue;
        $this->tgl_sk_kode_perilaku->EditValue = FormatDateTime($this->tgl_sk_kode_perilaku->EditValue, 7);
        $this->tgl_sk_kode_perilaku->ViewCustomAttributes = "";

        // status_hukuman_kode_perilaku
        $this->status_hukuman_kode_perilaku->EditAttrs["class"] = "form-control";
        $this->status_hukuman_kode_perilaku->EditCustomAttributes = "";
        if (strval($this->status_hukuman_kode_perilaku->CurrentValue) != "") {
            $this->status_hukuman_kode_perilaku->EditValue = $this->status_hukuman_kode_perilaku->optionCaption($this->status_hukuman_kode_perilaku->CurrentValue);
        } else {
            $this->status_hukuman_kode_perilaku->EditValue = null;
        }
        $this->status_hukuman_kode_perilaku->ViewCustomAttributes = "";

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->id_request);
                    $doc->exportCaption($this->tanggal_request);
                    $doc->exportCaption($this->nip);
                    $doc->exportCaption($this->nrp);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->unit_organisasi);
                    $doc->exportCaption($this->pangkat);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->scan_lhkpn);
                    $doc->exportCaption($this->scan_lhkasn);
                    $doc->exportCaption($this->kategori_pemohon);
                    $doc->exportCaption($this->keperluan);
                    $doc->exportCaption($this->hukuman_disiplin);
                    $doc->exportCaption($this->email_pemohon);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->jenis_hukuman);
                    $doc->exportCaption($this->hukuman);
                    $doc->exportCaption($this->pasal);
                    $doc->exportCaption($this->surat_keputusan);
                    $doc->exportCaption($this->sk_nomor);
                    $doc->exportCaption($this->tanggal_sk);
                    $doc->exportCaption($this->status_hukuman);
                    $doc->exportCaption($this->pernah_dijatuhi_hukuman);
                    $doc->exportCaption($this->sk_banding_nomor);
                    $doc->exportCaption($this->tgl_sk_banding);
                    $doc->exportCaption($this->mengajukan_keberatan_banding);
                    $doc->exportCaption($this->pelanggaran_disiplin);
                    $doc->exportCaption($this->inspeksi_kasus);
                    $doc->exportCaption($this->tempat_sidang_kode_perilaku);
                    $doc->exportCaption($this->hukuman_administratif);
                    $doc->exportCaption($this->sidang_kode_perilaku_jaksa);
                    $doc->exportCaption($this->sk_nomor_kode_perilaku);
                    $doc->exportCaption($this->tgl_sk_kode_perilaku);
                    $doc->exportCaption($this->status_hukuman_kode_perilaku);
                } else {
                    $doc->exportCaption($this->id_request);
                    $doc->exportCaption($this->tanggal_request);
                    $doc->exportCaption($this->nip);
                    $doc->exportCaption($this->nrp);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->unit_organisasi);
                    $doc->exportCaption($this->pangkat);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->scan_lhkpn);
                    $doc->exportCaption($this->scan_lhkasn);
                    $doc->exportCaption($this->kategori_pemohon);
                    $doc->exportCaption($this->keperluan);
                    $doc->exportCaption($this->hukuman_disiplin);
                    $doc->exportCaption($this->email_pemohon);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->jenis_hukuman);
                    $doc->exportCaption($this->hukuman);
                    $doc->exportCaption($this->pasal);
                    $doc->exportCaption($this->surat_keputusan);
                    $doc->exportCaption($this->sk_nomor);
                    $doc->exportCaption($this->tanggal_sk);
                    $doc->exportCaption($this->status_hukuman);
                    $doc->exportCaption($this->pernah_dijatuhi_hukuman);
                    $doc->exportCaption($this->sk_banding_nomor);
                    $doc->exportCaption($this->tgl_sk_banding);
                    $doc->exportCaption($this->mengajukan_keberatan_banding);
                    $doc->exportCaption($this->pelanggaran_disiplin);
                    $doc->exportCaption($this->inspeksi_kasus);
                    $doc->exportCaption($this->tempat_sidang_kode_perilaku);
                    $doc->exportCaption($this->hukuman_administratif);
                    $doc->exportCaption($this->sidang_kode_perilaku_jaksa);
                    $doc->exportCaption($this->sk_nomor_kode_perilaku);
                    $doc->exportCaption($this->tgl_sk_kode_perilaku);
                    $doc->exportCaption($this->status_hukuman_kode_perilaku);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->id_request);
                        $doc->exportField($this->tanggal_request);
                        $doc->exportField($this->nip);
                        $doc->exportField($this->nrp);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->unit_organisasi);
                        $doc->exportField($this->pangkat);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->scan_lhkpn);
                        $doc->exportField($this->scan_lhkasn);
                        $doc->exportField($this->kategori_pemohon);
                        $doc->exportField($this->keperluan);
                        $doc->exportField($this->hukuman_disiplin);
                        $doc->exportField($this->email_pemohon);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->status);
                        $doc->exportField($this->jenis_hukuman);
                        $doc->exportField($this->hukuman);
                        $doc->exportField($this->pasal);
                        $doc->exportField($this->surat_keputusan);
                        $doc->exportField($this->sk_nomor);
                        $doc->exportField($this->tanggal_sk);
                        $doc->exportField($this->status_hukuman);
                        $doc->exportField($this->pernah_dijatuhi_hukuman);
                        $doc->exportField($this->sk_banding_nomor);
                        $doc->exportField($this->tgl_sk_banding);
                        $doc->exportField($this->mengajukan_keberatan_banding);
                        $doc->exportField($this->pelanggaran_disiplin);
                        $doc->exportField($this->inspeksi_kasus);
                        $doc->exportField($this->tempat_sidang_kode_perilaku);
                        $doc->exportField($this->hukuman_administratif);
                        $doc->exportField($this->sidang_kode_perilaku_jaksa);
                        $doc->exportField($this->sk_nomor_kode_perilaku);
                        $doc->exportField($this->tgl_sk_kode_perilaku);
                        $doc->exportField($this->status_hukuman_kode_perilaku);
                    } else {
                        $doc->exportField($this->id_request);
                        $doc->exportField($this->tanggal_request);
                        $doc->exportField($this->nip);
                        $doc->exportField($this->nrp);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->unit_organisasi);
                        $doc->exportField($this->pangkat);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->scan_lhkpn);
                        $doc->exportField($this->scan_lhkasn);
                        $doc->exportField($this->kategori_pemohon);
                        $doc->exportField($this->keperluan);
                        $doc->exportField($this->hukuman_disiplin);
                        $doc->exportField($this->email_pemohon);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->status);
                        $doc->exportField($this->jenis_hukuman);
                        $doc->exportField($this->hukuman);
                        $doc->exportField($this->pasal);
                        $doc->exportField($this->surat_keputusan);
                        $doc->exportField($this->sk_nomor);
                        $doc->exportField($this->tanggal_sk);
                        $doc->exportField($this->status_hukuman);
                        $doc->exportField($this->pernah_dijatuhi_hukuman);
                        $doc->exportField($this->sk_banding_nomor);
                        $doc->exportField($this->tgl_sk_banding);
                        $doc->exportField($this->mengajukan_keberatan_banding);
                        $doc->exportField($this->pelanggaran_disiplin);
                        $doc->exportField($this->inspeksi_kasus);
                        $doc->exportField($this->tempat_sidang_kode_perilaku);
                        $doc->exportField($this->hukuman_administratif);
                        $doc->exportField($this->sidang_kode_perilaku_jaksa);
                        $doc->exportField($this->sk_nomor_kode_perilaku);
                        $doc->exportField($this->tgl_sk_kode_perilaku);
                        $doc->exportField($this->status_hukuman_kode_perilaku);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events
    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
    	$status = 'ACC_SEKRETARIAT';
    	if($status != '' OR $status != FALSE) {
    		AddFilter($filter, "status = '{$status}'");
    	}
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        $rsnew['status'] = empty($rsnew['status']) ? $rsold['status'] : $rsnew['status'];
        $this->UpdateTable = "data_request_skk";
        unset($rsnew['pernah_dijatuhi_hukuman']);
        unset($rsnew['jenis_hukuman']);
        unset($rsnew['hukuman']);
        unset($rsnew['pasal']);
        unset($rsnew['sk_nomor']);
        unset($rsnew['tanggal_sk']);
        unset($rsnew['status_hukuman']);
        unset($rsnew['mengajukan_keberatan_banding']);
        unset($rsnew['sk_bandng_nomor']);
        unset($rsnew['tgl_sk_banding']);
        unset($rsnew['inspeksi_kasus']);
        unset($rsnew['pelanggaran_disiplin']);
        unset($rsnew['sidang_kode_perilaku_jaksa']);
        unset($rsnew['tempat_sidang_kode_perilaku']);
        unset($rsnew['hukuman_administratif']);
        unset($rsnew['sk_nomor_kode_perilaku']);
        unset($rsnew['tgl_sk_kode_perilaku']);
        unset($rsnew['status_hukuman_kode_perilaku']);
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
       	ExecuteUpdate("INSERT INTO riwayat_acc (id_skk, status, verifikator, tanggal) VALUES ({$rsold['id_request']}, '{$rsnew['status']}', 'pemeriksa', '".date('Y-m-d H:i:s')."')");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
        if ($this->kategori_pemohon->CurrentValue == 'Wajib LHKPN') {
        	$this->scan_lhkasn->Visible = false;
        } else {
        	$this->scan_lhkpn->Visible = false;
        }
    	$this->status->ViewAttrs["class"] = " badge  badge-info";
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
