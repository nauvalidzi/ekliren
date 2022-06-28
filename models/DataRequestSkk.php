<?php

namespace PHPMaker2021\eclearance;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for data_request_skk
 */
class DataRequestSkk extends DbTable
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
    public $nomor_surat;
    public $tanggal_request;
    public $nrp;
    public $nip;
    public $nama;
    public $unit_organisasi;
    public $pangkat;
    public $jabatan;
    public $keperluan;
    public $kategori_pemohon;
    public $scan_lhkpn;
    public $scan_lhkasn;
    public $email_pemohon;
    public $hukuman_disiplin;
    public $keterangan;
    public $status;
    public $acc;
    public $hasil_acc;
    public $user_id;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'data_request_skk';
        $this->TableName = 'data_request_skk';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`data_request_skk`";
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
        $this->id_request = new DbField('data_request_skk', 'data_request_skk', 'x_id_request', 'id_request', '`id_request`', '`id_request`', 20, 20, -1, false, '`id_request`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_request->IsAutoIncrement = true; // Autoincrement field
        $this->id_request->IsPrimaryKey = true; // Primary key field
        $this->id_request->Sortable = true; // Allow sort
        $this->id_request->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_request->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_request->Param, "CustomMsg");
        $this->Fields['id_request'] = &$this->id_request;

        // nomor_surat
        $this->nomor_surat = new DbField('data_request_skk', 'data_request_skk', 'x_nomor_surat', 'nomor_surat', '`nomor_surat`', '`nomor_surat`', 200, 10, -1, false, '`nomor_surat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nomor_surat->Sortable = false; // Allow sort
        $this->nomor_surat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nomor_surat->Param, "CustomMsg");
        $this->Fields['nomor_surat'] = &$this->nomor_surat;

        // tanggal_request
        $this->tanggal_request = new DbField('data_request_skk', 'data_request_skk', 'x_tanggal_request', 'tanggal_request', '`tanggal_request`', CastDateFieldForLike("`tanggal_request`", 7, "DB"), 135, 19, 7, false, '`tanggal_request`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_request->Nullable = false; // NOT NULL field
        $this->tanggal_request->Sortable = true; // Allow sort
        $this->tanggal_request->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->tanggal_request->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_request->Param, "CustomMsg");
        $this->Fields['tanggal_request'] = &$this->tanggal_request;

        // nrp
        $this->nrp = new DbField('data_request_skk', 'data_request_skk', 'x_nrp', 'nrp', '`nrp`', '`nrp`', 200, 255, -1, false, '`nrp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nrp->Nullable = false; // NOT NULL field
        $this->nrp->Required = true; // Required field
        $this->nrp->Sortable = true; // Allow sort
        $this->nrp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nrp->Param, "CustomMsg");
        $this->Fields['nrp'] = &$this->nrp;

        // nip
        $this->nip = new DbField('data_request_skk', 'data_request_skk', 'x_nip', 'nip', '`nip`', '`nip`', 200, 255, -1, false, '`nip`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nip->Nullable = false; // NOT NULL field
        $this->nip->Required = true; // Required field
        $this->nip->Sortable = true; // Allow sort
        $this->nip->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nip->Param, "CustomMsg");
        $this->Fields['nip'] = &$this->nip;

        // nama
        $this->nama = new DbField('data_request_skk', 'data_request_skk', 'x_nama', 'nama', '`nama`', '`nama`', 200, 255, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Nullable = false; // NOT NULL field
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // unit_organisasi
        $this->unit_organisasi = new DbField('data_request_skk', 'data_request_skk', 'x_unit_organisasi', 'unit_organisasi', '`unit_organisasi`', '`unit_organisasi`', 3, 11, -1, false, '`unit_organisasi`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->unit_organisasi->Nullable = false; // NOT NULL field
        $this->unit_organisasi->Sortable = true; // Allow sort
        $this->unit_organisasi->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->unit_organisasi->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
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
        $this->pangkat = new DbField('data_request_skk', 'data_request_skk', 'x_pangkat', 'pangkat', '`pangkat`', '`pangkat`', 3, 11, -1, false, '`pangkat`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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
        $this->jabatan = new DbField('data_request_skk', 'data_request_skk', 'x_jabatan', 'jabatan', '`jabatan`', '`jabatan`', 3, 11, -1, false, '`jabatan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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

        // keperluan
        $this->keperluan = new DbField('data_request_skk', 'data_request_skk', 'x_keperluan', 'keperluan', '`keperluan`', '`keperluan`', 3, 11, -1, false, '`keperluan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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

        // kategori_pemohon
        $this->kategori_pemohon = new DbField('data_request_skk', 'data_request_skk', 'x_kategori_pemohon', 'kategori_pemohon', '`kategori_pemohon`', '`kategori_pemohon`', 200, 255, -1, false, '`kategori_pemohon`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->kategori_pemohon->Nullable = false; // NOT NULL field
        $this->kategori_pemohon->Required = true; // Required field
        $this->kategori_pemohon->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->kategori_pemohon->Lookup = new Lookup('kategori_pemohon', 'data_request_skk', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->kategori_pemohon->Lookup = new Lookup('kategori_pemohon', 'data_request_skk', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->kategori_pemohon->OptionCount = 2;
        $this->kategori_pemohon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategori_pemohon->Param, "CustomMsg");
        $this->Fields['kategori_pemohon'] = &$this->kategori_pemohon;

        // scan_lhkpn
        $this->scan_lhkpn = new DbField('data_request_skk', 'data_request_skk', 'x_scan_lhkpn', 'scan_lhkpn', '`scan_lhkpn`', '`scan_lhkpn`', 200, 255, -1, true, '`scan_lhkpn`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->scan_lhkpn->Sortable = true; // Allow sort
        $this->scan_lhkpn->UploadMaxFileSize = 1572864;
        $this->scan_lhkpn->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->scan_lhkpn->Param, "CustomMsg");
        $this->Fields['scan_lhkpn'] = &$this->scan_lhkpn;

        // scan_lhkasn
        $this->scan_lhkasn = new DbField('data_request_skk', 'data_request_skk', 'x_scan_lhkasn', 'scan_lhkasn', '`scan_lhkasn`', '`scan_lhkasn`', 200, 255, -1, true, '`scan_lhkasn`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->scan_lhkasn->Sortable = true; // Allow sort
        $this->scan_lhkasn->UploadMaxFileSize = 1572864;
        $this->scan_lhkasn->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->scan_lhkasn->Param, "CustomMsg");
        $this->Fields['scan_lhkasn'] = &$this->scan_lhkasn;

        // email_pemohon
        $this->email_pemohon = new DbField('data_request_skk', 'data_request_skk', 'x_email_pemohon', 'email_pemohon', '`email_pemohon`', '`email_pemohon`', 200, 255, -1, false, '`email_pemohon`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->email_pemohon->Required = true; // Required field
        $this->email_pemohon->Sortable = true; // Allow sort
        $this->email_pemohon->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->email_pemohon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->email_pemohon->Param, "CustomMsg");
        $this->Fields['email_pemohon'] = &$this->email_pemohon;

        // hukuman_disiplin
        $this->hukuman_disiplin = new DbField('data_request_skk', 'data_request_skk', 'x_hukuman_disiplin', 'hukuman_disiplin', '`hukuman_disiplin`', '`hukuman_disiplin`', 202, 5, -1, false, '`hukuman_disiplin`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->hukuman_disiplin->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->hukuman_disiplin->Lookup = new Lookup('hukuman_disiplin', 'data_request_skk', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->hukuman_disiplin->Lookup = new Lookup('hukuman_disiplin', 'data_request_skk', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->hukuman_disiplin->OptionCount = 2;
        $this->hukuman_disiplin->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hukuman_disiplin->Param, "CustomMsg");
        $this->Fields['hukuman_disiplin'] = &$this->hukuman_disiplin;

        // keterangan
        $this->keterangan = new DbField('data_request_skk', 'data_request_skk', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, 65535, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;

        // status
        $this->status = new DbField('data_request_skk', 'data_request_skk', 'x_status', 'status', '`status`', '`status`', 200, 255, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status->Sortable = true; // Allow sort
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // acc
        $this->acc = new DbField('data_request_skk', 'data_request_skk', 'x_acc', 'acc', '`acc`', CastDateFieldForLike("`acc`", 0, "DB"), 133, 10, 0, false, '`acc`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->acc->Sortable = true; // Allow sort
        $this->acc->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->acc->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->acc->Param, "CustomMsg");
        $this->Fields['acc'] = &$this->acc;

        // hasil_acc
        $this->hasil_acc = new DbField('data_request_skk', 'data_request_skk', 'x_hasil_acc', 'hasil_acc', '`hasil_acc`', '`hasil_acc`', 200, 255, -1, false, '`hasil_acc`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hasil_acc->Sortable = false; // Allow sort
        $this->hasil_acc->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hasil_acc->Param, "CustomMsg");
        $this->Fields['hasil_acc'] = &$this->hasil_acc;

        // user_id
        $this->user_id = new DbField('data_request_skk', 'data_request_skk', 'x_user_id', 'user_id', '`user_id`', '`user_id`', 20, 20, -1, false, '`user_id`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->user_id->Sortable = true; // Allow sort
        $this->user_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->user_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->user_id->Param, "CustomMsg");
        $this->Fields['user_id'] = &$this->user_id;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`data_request_skk`";
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
        $this->nomor_surat->DbValue = $row['nomor_surat'];
        $this->tanggal_request->DbValue = $row['tanggal_request'];
        $this->nrp->DbValue = $row['nrp'];
        $this->nip->DbValue = $row['nip'];
        $this->nama->DbValue = $row['nama'];
        $this->unit_organisasi->DbValue = $row['unit_organisasi'];
        $this->pangkat->DbValue = $row['pangkat'];
        $this->jabatan->DbValue = $row['jabatan'];
        $this->keperluan->DbValue = $row['keperluan'];
        $this->kategori_pemohon->DbValue = $row['kategori_pemohon'];
        $this->scan_lhkpn->Upload->DbValue = $row['scan_lhkpn'];
        $this->scan_lhkasn->Upload->DbValue = $row['scan_lhkasn'];
        $this->email_pemohon->DbValue = $row['email_pemohon'];
        $this->hukuman_disiplin->DbValue = $row['hukuman_disiplin'];
        $this->keterangan->DbValue = $row['keterangan'];
        $this->status->DbValue = $row['status'];
        $this->acc->DbValue = $row['acc'];
        $this->hasil_acc->DbValue = $row['hasil_acc'];
        $this->user_id->DbValue = $row['user_id'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['scan_lhkpn']) ? [] : [$row['scan_lhkpn']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->scan_lhkpn->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->scan_lhkpn->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['scan_lhkasn']) ? [] : [$row['scan_lhkasn']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->scan_lhkasn->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->scan_lhkasn->oldPhysicalUploadPath() . $oldFile);
            }
        }
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
        return $_SESSION[$name] ?? GetUrl("DataRequestSkkList");
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
        if ($pageName == "DataRequestSkkView") {
            return $Language->phrase("View");
        } elseif ($pageName == "DataRequestSkkEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "DataRequestSkkAdd") {
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
                return "DataRequestSkkView";
            case Config("API_ADD_ACTION"):
                return "DataRequestSkkAdd";
            case Config("API_EDIT_ACTION"):
                return "DataRequestSkkEdit";
            case Config("API_DELETE_ACTION"):
                return "DataRequestSkkDelete";
            case Config("API_LIST_ACTION"):
                return "DataRequestSkkList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "DataRequestSkkList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("DataRequestSkkView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("DataRequestSkkView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "DataRequestSkkAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "DataRequestSkkAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("DataRequestSkkEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("DataRequestSkkAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("DataRequestSkkDelete", $this->getUrlParm());
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
        $this->nomor_surat->setDbValue($row['nomor_surat']);
        $this->tanggal_request->setDbValue($row['tanggal_request']);
        $this->nrp->setDbValue($row['nrp']);
        $this->nip->setDbValue($row['nip']);
        $this->nama->setDbValue($row['nama']);
        $this->unit_organisasi->setDbValue($row['unit_organisasi']);
        $this->pangkat->setDbValue($row['pangkat']);
        $this->jabatan->setDbValue($row['jabatan']);
        $this->keperluan->setDbValue($row['keperluan']);
        $this->kategori_pemohon->setDbValue($row['kategori_pemohon']);
        $this->scan_lhkpn->Upload->DbValue = $row['scan_lhkpn'];
        $this->scan_lhkpn->setDbValue($this->scan_lhkpn->Upload->DbValue);
        $this->scan_lhkasn->Upload->DbValue = $row['scan_lhkasn'];
        $this->scan_lhkasn->setDbValue($this->scan_lhkasn->Upload->DbValue);
        $this->email_pemohon->setDbValue($row['email_pemohon']);
        $this->hukuman_disiplin->setDbValue($row['hukuman_disiplin']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->status->setDbValue($row['status']);
        $this->acc->setDbValue($row['acc']);
        $this->hasil_acc->setDbValue($row['hasil_acc']);
        $this->user_id->setDbValue($row['user_id']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id_request

        // nomor_surat

        // tanggal_request

        // nrp

        // nip

        // nama

        // unit_organisasi

        // pangkat

        // jabatan

        // keperluan

        // kategori_pemohon

        // scan_lhkpn

        // scan_lhkasn

        // email_pemohon

        // hukuman_disiplin

        // keterangan

        // status

        // acc

        // hasil_acc
        $this->hasil_acc->CellCssStyle = "white-space: nowrap;";

        // user_id

        // id_request
        $this->id_request->ViewValue = $this->id_request->CurrentValue;
        $this->id_request->ViewCustomAttributes = "";

        // nomor_surat
        $this->nomor_surat->ViewValue = $this->nomor_surat->CurrentValue;
        $this->nomor_surat->ViewCustomAttributes = "";

        // tanggal_request
        $this->tanggal_request->ViewValue = $this->tanggal_request->CurrentValue;
        $this->tanggal_request->ViewValue = FormatDateTime($this->tanggal_request->ViewValue, 7);
        $this->tanggal_request->ViewCustomAttributes = "";

        // nrp
        $this->nrp->ViewValue = $this->nrp->CurrentValue;
        $this->nrp->ViewCustomAttributes = "";

        // nip
        $this->nip->ViewValue = $this->nip->CurrentValue;
        $this->nip->ViewCustomAttributes = "";

        // nama
        $this->nama->ViewValue = $this->nama->CurrentValue;
        $this->nama->ViewCustomAttributes = "";

        // unit_organisasi
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

        // kategori_pemohon
        if (strval($this->kategori_pemohon->CurrentValue) != "") {
            $this->kategori_pemohon->ViewValue = $this->kategori_pemohon->optionCaption($this->kategori_pemohon->CurrentValue);
        } else {
            $this->kategori_pemohon->ViewValue = null;
        }
        $this->kategori_pemohon->ViewCustomAttributes = "";

        // scan_lhkpn
        if (!EmptyValue($this->scan_lhkpn->Upload->DbValue)) {
            $this->scan_lhkpn->ViewValue = $this->scan_lhkpn->Upload->DbValue;
        } else {
            $this->scan_lhkpn->ViewValue = "";
        }
        $this->scan_lhkpn->ViewCustomAttributes = "";

        // scan_lhkasn
        if (!EmptyValue($this->scan_lhkasn->Upload->DbValue)) {
            $this->scan_lhkasn->ViewValue = $this->scan_lhkasn->Upload->DbValue;
        } else {
            $this->scan_lhkasn->ViewValue = "";
        }
        $this->scan_lhkasn->ViewCustomAttributes = "";

        // email_pemohon
        $this->email_pemohon->ViewValue = $this->email_pemohon->CurrentValue;
        $this->email_pemohon->ViewCustomAttributes = "";

        // hukuman_disiplin
        if (strval($this->hukuman_disiplin->CurrentValue) != "") {
            $this->hukuman_disiplin->ViewValue = $this->hukuman_disiplin->optionCaption($this->hukuman_disiplin->CurrentValue);
        } else {
            $this->hukuman_disiplin->ViewValue = null;
        }
        $this->hukuman_disiplin->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewCustomAttributes = "";

        // acc
        $this->acc->ViewValue = $this->acc->CurrentValue;
        $this->acc->ViewValue = FormatDateTime($this->acc->ViewValue, 0);
        $this->acc->ViewCustomAttributes = "";

        // hasil_acc
        $this->hasil_acc->ViewValue = $this->hasil_acc->CurrentValue;
        $this->hasil_acc->ViewCustomAttributes = "";

        // user_id
        $this->user_id->ViewValue = $this->user_id->CurrentValue;
        $this->user_id->ViewValue = FormatNumber($this->user_id->ViewValue, 0, -2, -2, -2);
        $this->user_id->ViewCustomAttributes = "";

        // id_request
        $this->id_request->LinkCustomAttributes = "";
        $this->id_request->HrefValue = "";
        $this->id_request->TooltipValue = "";

        // nomor_surat
        $this->nomor_surat->LinkCustomAttributes = "";
        $this->nomor_surat->HrefValue = "";
        $this->nomor_surat->TooltipValue = "";

        // tanggal_request
        $this->tanggal_request->LinkCustomAttributes = "";
        $this->tanggal_request->HrefValue = "";
        $this->tanggal_request->TooltipValue = "";

        // nrp
        $this->nrp->LinkCustomAttributes = "";
        $this->nrp->HrefValue = "";
        $this->nrp->TooltipValue = "";

        // nip
        $this->nip->LinkCustomAttributes = "";
        $this->nip->HrefValue = "";
        $this->nip->TooltipValue = "";

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

        // keperluan
        $this->keperluan->LinkCustomAttributes = "";
        $this->keperluan->HrefValue = "";
        $this->keperluan->TooltipValue = "";

        // kategori_pemohon
        $this->kategori_pemohon->LinkCustomAttributes = "";
        $this->kategori_pemohon->HrefValue = "";
        $this->kategori_pemohon->TooltipValue = "";

        // scan_lhkpn
        $this->scan_lhkpn->LinkCustomAttributes = "";
        $this->scan_lhkpn->HrefValue = "";
        $this->scan_lhkpn->ExportHrefValue = $this->scan_lhkpn->UploadPath . $this->scan_lhkpn->Upload->DbValue;
        $this->scan_lhkpn->TooltipValue = "";

        // scan_lhkasn
        $this->scan_lhkasn->LinkCustomAttributes = "";
        $this->scan_lhkasn->HrefValue = "";
        $this->scan_lhkasn->ExportHrefValue = $this->scan_lhkasn->UploadPath . $this->scan_lhkasn->Upload->DbValue;
        $this->scan_lhkasn->TooltipValue = "";

        // email_pemohon
        $this->email_pemohon->LinkCustomAttributes = "";
        $this->email_pemohon->HrefValue = "";
        $this->email_pemohon->TooltipValue = "";

        // hukuman_disiplin
        $this->hukuman_disiplin->LinkCustomAttributes = "";
        $this->hukuman_disiplin->HrefValue = "";
        $this->hukuman_disiplin->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // acc
        $this->acc->LinkCustomAttributes = "";
        $this->acc->HrefValue = "";
        $this->acc->TooltipValue = "";

        // hasil_acc
        $this->hasil_acc->LinkCustomAttributes = "";
        $this->hasil_acc->HrefValue = "";
        $this->hasil_acc->TooltipValue = "";

        // user_id
        $this->user_id->LinkCustomAttributes = "";
        $this->user_id->HrefValue = "";
        $this->user_id->TooltipValue = "";

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

        // nomor_surat
        $this->nomor_surat->EditAttrs["class"] = "form-control";
        $this->nomor_surat->EditCustomAttributes = "";
        if (!$this->nomor_surat->Raw) {
            $this->nomor_surat->CurrentValue = HtmlDecode($this->nomor_surat->CurrentValue);
        }
        $this->nomor_surat->EditValue = $this->nomor_surat->CurrentValue;
        $this->nomor_surat->PlaceHolder = RemoveHtml($this->nomor_surat->caption());

        // tanggal_request

        // nrp
        $this->nrp->EditAttrs["class"] = "form-control";
        $this->nrp->EditCustomAttributes = "";
        if (!$this->nrp->Raw) {
            $this->nrp->CurrentValue = HtmlDecode($this->nrp->CurrentValue);
        }
        $this->nrp->EditValue = $this->nrp->CurrentValue;
        $this->nrp->PlaceHolder = RemoveHtml($this->nrp->caption());

        // nip
        $this->nip->EditAttrs["class"] = "form-control";
        $this->nip->EditCustomAttributes = "";
        if (!$this->nip->Raw) {
            $this->nip->CurrentValue = HtmlDecode($this->nip->CurrentValue);
        }
        $this->nip->EditValue = $this->nip->CurrentValue;
        $this->nip->PlaceHolder = RemoveHtml($this->nip->caption());

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

        // unit_organisasi
        $this->unit_organisasi->EditAttrs["class"] = "form-control";
        $this->unit_organisasi->EditCustomAttributes = "";
        $this->unit_organisasi->PlaceHolder = RemoveHtml($this->unit_organisasi->caption());

        // pangkat
        $this->pangkat->EditAttrs["class"] = "form-control";
        $this->pangkat->EditCustomAttributes = "";
        $this->pangkat->PlaceHolder = RemoveHtml($this->pangkat->caption());

        // jabatan
        $this->jabatan->EditAttrs["class"] = "form-control";
        $this->jabatan->EditCustomAttributes = "";
        $this->jabatan->PlaceHolder = RemoveHtml($this->jabatan->caption());

        // keperluan
        $this->keperluan->EditAttrs["class"] = "form-control";
        $this->keperluan->EditCustomAttributes = "";
        $this->keperluan->PlaceHolder = RemoveHtml($this->keperluan->caption());

        // kategori_pemohon
        $this->kategori_pemohon->EditCustomAttributes = "";
        $this->kategori_pemohon->EditValue = $this->kategori_pemohon->options(false);
        $this->kategori_pemohon->PlaceHolder = RemoveHtml($this->kategori_pemohon->caption());

        // scan_lhkpn
        $this->scan_lhkpn->EditAttrs["class"] = "form-control";
        $this->scan_lhkpn->EditAttrs["accept"] = "image/*,application/pdf";
        $this->scan_lhkpn->EditCustomAttributes = "";
        if (!EmptyValue($this->scan_lhkpn->Upload->DbValue)) {
            $this->scan_lhkpn->EditValue = $this->scan_lhkpn->Upload->DbValue;
        } else {
            $this->scan_lhkpn->EditValue = "";
        }
        if (!EmptyValue($this->scan_lhkpn->CurrentValue)) {
            $this->scan_lhkpn->Upload->FileName = $this->scan_lhkpn->CurrentValue;
        }

        // scan_lhkasn
        $this->scan_lhkasn->EditAttrs["class"] = "form-control";
        $this->scan_lhkasn->EditAttrs["accept"] = "image/*,application/pdf";
        $this->scan_lhkasn->EditCustomAttributes = "";
        if (!EmptyValue($this->scan_lhkasn->Upload->DbValue)) {
            $this->scan_lhkasn->EditValue = $this->scan_lhkasn->Upload->DbValue;
        } else {
            $this->scan_lhkasn->EditValue = "";
        }
        if (!EmptyValue($this->scan_lhkasn->CurrentValue)) {
            $this->scan_lhkasn->Upload->FileName = $this->scan_lhkasn->CurrentValue;
        }

        // email_pemohon
        $this->email_pemohon->EditAttrs["class"] = "form-control";
        $this->email_pemohon->EditCustomAttributes = "";
        if (!$this->email_pemohon->Raw) {
            $this->email_pemohon->CurrentValue = HtmlDecode($this->email_pemohon->CurrentValue);
        }
        $this->email_pemohon->EditValue = $this->email_pemohon->CurrentValue;
        $this->email_pemohon->PlaceHolder = RemoveHtml($this->email_pemohon->caption());

        // hukuman_disiplin
        $this->hukuman_disiplin->EditCustomAttributes = "";
        $this->hukuman_disiplin->EditValue = $this->hukuman_disiplin->options(false);
        $this->hukuman_disiplin->PlaceHolder = RemoveHtml($this->hukuman_disiplin->caption());

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // acc
        $this->acc->EditAttrs["class"] = "form-control";
        $this->acc->EditCustomAttributes = "";
        $this->acc->EditValue = FormatDateTime($this->acc->CurrentValue, 8);
        $this->acc->PlaceHolder = RemoveHtml($this->acc->caption());

        // hasil_acc
        $this->hasil_acc->EditAttrs["class"] = "form-control";
        $this->hasil_acc->EditCustomAttributes = "";
        if (!$this->hasil_acc->Raw) {
            $this->hasil_acc->CurrentValue = HtmlDecode($this->hasil_acc->CurrentValue);
        }
        $this->hasil_acc->EditValue = $this->hasil_acc->CurrentValue;
        $this->hasil_acc->PlaceHolder = RemoveHtml($this->hasil_acc->caption());

        // user_id
        $this->user_id->EditAttrs["class"] = "form-control";
        $this->user_id->EditCustomAttributes = "";
        $this->user_id->EditValue = $this->user_id->CurrentValue;
        $this->user_id->PlaceHolder = RemoveHtml($this->user_id->caption());

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
                    $doc->exportCaption($this->nomor_surat);
                    $doc->exportCaption($this->tanggal_request);
                    $doc->exportCaption($this->nrp);
                    $doc->exportCaption($this->nip);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->unit_organisasi);
                    $doc->exportCaption($this->pangkat);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->keperluan);
                    $doc->exportCaption($this->kategori_pemohon);
                    $doc->exportCaption($this->scan_lhkpn);
                    $doc->exportCaption($this->scan_lhkasn);
                    $doc->exportCaption($this->email_pemohon);
                    $doc->exportCaption($this->hukuman_disiplin);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->acc);
                } else {
                    $doc->exportCaption($this->id_request);
                    $doc->exportCaption($this->nomor_surat);
                    $doc->exportCaption($this->tanggal_request);
                    $doc->exportCaption($this->nrp);
                    $doc->exportCaption($this->nip);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->unit_organisasi);
                    $doc->exportCaption($this->pangkat);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->keperluan);
                    $doc->exportCaption($this->kategori_pemohon);
                    $doc->exportCaption($this->scan_lhkpn);
                    $doc->exportCaption($this->scan_lhkasn);
                    $doc->exportCaption($this->email_pemohon);
                    $doc->exportCaption($this->hukuman_disiplin);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->acc);
                    $doc->exportCaption($this->user_id);
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
                        $doc->exportField($this->nomor_surat);
                        $doc->exportField($this->tanggal_request);
                        $doc->exportField($this->nrp);
                        $doc->exportField($this->nip);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->unit_organisasi);
                        $doc->exportField($this->pangkat);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->keperluan);
                        $doc->exportField($this->kategori_pemohon);
                        $doc->exportField($this->scan_lhkpn);
                        $doc->exportField($this->scan_lhkasn);
                        $doc->exportField($this->email_pemohon);
                        $doc->exportField($this->hukuman_disiplin);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->status);
                        $doc->exportField($this->acc);
                    } else {
                        $doc->exportField($this->id_request);
                        $doc->exportField($this->nomor_surat);
                        $doc->exportField($this->tanggal_request);
                        $doc->exportField($this->nrp);
                        $doc->exportField($this->nip);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->unit_organisasi);
                        $doc->exportField($this->pangkat);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->keperluan);
                        $doc->exportField($this->kategori_pemohon);
                        $doc->exportField($this->scan_lhkpn);
                        $doc->exportField($this->scan_lhkasn);
                        $doc->exportField($this->email_pemohon);
                        $doc->exportField($this->hukuman_disiplin);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->status);
                        $doc->exportField($this->acc);
                        $doc->exportField($this->user_id);
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
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'scan_lhkpn') {
            $fldName = "scan_lhkpn";
            $fileNameFld = "scan_lhkpn";
        } elseif ($fldparm == 'scan_lhkasn') {
            $fldName = "scan_lhkasn";
            $fileNameFld = "scan_lhkasn";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id_request->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssoc($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, 100, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Table level events
    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
    	$userlevel = CurrentUserLevel();
    	if($userlevel != '2' AND $userlevel != '4'){
    		$unit_organ = CurrentUserInfo("unit_organisasi");
    		if($unit_organ != '' OR $unit_organ != FALSE) {
    			AddFilter($filter, "unit_organisasi = '".$unit_organ."'");
    		}	
    	}
    	if (CurrentUserLevel() == 1) {
            AddFilter($filter, "user_id = ".CurrentUserInfo('id_user'));
        }
    	AddFilter($filter, "status != 'SELESAI'");
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
    	$rsnew['status'] = 'DIAJUKAN';
    	$rsnew['nomor_surat'] = 0;
    	if ($rsnew['scan_lhkpn']) {
    		$rsnew['scan_lhkpn'] = "LHKPN-{$rsnew['nip']}-{$rsnew['nrp']}-".date('YmdHis').".pdf";
    	}
    	if ($rsnew['scan_lhkasn']) {
    		$rsnew['scan_lhkasn'] = "LHKASN-{$rsnew['nip']}-{$rsnew['nrp']}-".date('YmdHis').".pdf";
    	}
    	if (CurrentUserLevel() == 1) {
            $rsnew['user_id'] = CurrentUserInfo('id_user');
        }
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        $hukuman = $rsnew['hukuman_disiplin'];
    	if($hukuman != '' OR $hukuman != false){
    		ExecuteUpdate("INSERT INTO hukuman_disiplin (pid_request_skk, pernah_dijatuhi_hukuman) VALUES ('{$rsnew['id_request']}', '{$rsnew['hukuman_disiplin']}')");
    	}
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
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
        if (CurrentPageID() == "add") { // If Add page
        	$email->Recipient = $args['rsnew']['email_pemohon'].",noreply@eclearance.kejati-jatim.go.id";
            $email->Subject = "[BARU] Permohonan SKK ({$args['rsnew']['kategori_pemohon']})";
            $email->Content = "Berikut adalah data Pengajuan Permohonan ".$args["rsnew"]["kategori_pemohon"]." oleh:";
            $email->Content .= "<br>Nama: ".$args["rsnew"]["nama"];
            $email->Content .= "<br>NRP/NIP: ".$args["rsnew"]["nrp"]."/".$args["rsnew"]["nip"];
            $email->Content .= "<br>Pangkat: ".$args["rsnew"]["pangkat"];
            $email->Content .= "<br>Jabatan: ".$args["rsnew"]["jabatan"];
            $email->Content .= "<br>Keperluan: ".$args["rsnew"]["keperluan"];
            $email->Content .= "<br>Tgl Request: ".date('d/m/Y H:i', strtotime($args["rsnew"]["tanggal_request"]));
            $email->Content .= "<br>Hukuman Disiplin: ".$args["rsnew"]["hukuman_disiplin"];
            if ($args["rsnew"]["hukuman_disiplin"] == 'Ya') {
                $email->Content .= "<br>Keterangan: ".$args["rsnew"]["keterangan"];
            }
            $email->Content .= "<br><br><br>Pesan ini dibuat otomatis oleh sistem.";
            if($args["rsnew"]["kategori_pemohon"] == 'Wajib LHKPN'){
                $email->Attachments = $args["rsnew"]["scan_lhkpn"];
            } else {
                $email->Attachments = $args["rsnew"]["scan_lhkasn"];
            }
        }
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
    	$this->status->ViewAttrs["class"] = " badge badge-info";
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
