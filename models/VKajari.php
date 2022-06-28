<?php

namespace PHPMaker2021\eclearance;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for v_kajari
 */
class VKajari extends DbTable
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
    public $keperluan;
    public $kategori_pemohon;
    public $scan_lhkpn;
    public $scan_lhkasn;
    public $keterangan;
    public $status;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'v_kajari';
        $this->TableName = 'v_kajari';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`v_kajari`";
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
        $this->id_request = new DbField('v_kajari', 'v_kajari', 'x_id_request', 'id_request', '`id_request`', '`id_request`', 20, 20, -1, false, '`id_request`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_request->IsAutoIncrement = true; // Autoincrement field
        $this->id_request->IsPrimaryKey = true; // Primary key field
        $this->id_request->Sortable = true; // Allow sort
        $this->id_request->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_request->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_request->Param, "CustomMsg");
        $this->Fields['id_request'] = &$this->id_request;

        // tanggal_request
        $this->tanggal_request = new DbField('v_kajari', 'v_kajari', 'x_tanggal_request', 'tanggal_request', '`tanggal_request`', CastDateFieldForLike("`tanggal_request`", 117, "DB"), 135, 19, 117, false, '`tanggal_request`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_request->Nullable = false; // NOT NULL field
        $this->tanggal_request->Sortable = true; // Allow sort
        $this->tanggal_request->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectShortDateDMY"));
        $this->tanggal_request->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_request->Param, "CustomMsg");
        $this->Fields['tanggal_request'] = &$this->tanggal_request;

        // nip
        $this->nip = new DbField('v_kajari', 'v_kajari', 'x_nip', 'nip', '`nip`', '`nip`', 200, 255, -1, false, '`nip`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nip->Nullable = false; // NOT NULL field
        $this->nip->Required = true; // Required field
        $this->nip->Sortable = true; // Allow sort
        $this->nip->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nip->Param, "CustomMsg");
        $this->Fields['nip'] = &$this->nip;

        // nrp
        $this->nrp = new DbField('v_kajari', 'v_kajari', 'x_nrp', 'nrp', '`nrp`', '`nrp`', 200, 255, -1, false, '`nrp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nrp->Nullable = false; // NOT NULL field
        $this->nrp->Required = true; // Required field
        $this->nrp->Sortable = true; // Allow sort
        $this->nrp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nrp->Param, "CustomMsg");
        $this->Fields['nrp'] = &$this->nrp;

        // nama
        $this->nama = new DbField('v_kajari', 'v_kajari', 'x_nama', 'nama', '`nama`', '`nama`', 200, 255, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Nullable = false; // NOT NULL field
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // unit_organisasi
        $this->unit_organisasi = new DbField('v_kajari', 'v_kajari', 'x_unit_organisasi', 'unit_organisasi', '`unit_organisasi`', '`unit_organisasi`', 3, 11, -1, false, '`unit_organisasi`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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
        $this->pangkat = new DbField('v_kajari', 'v_kajari', 'x_pangkat', 'pangkat', '`pangkat`', '`pangkat`', 3, 11, -1, false, '`pangkat`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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
        $this->jabatan = new DbField('v_kajari', 'v_kajari', 'x_jabatan', 'jabatan', '`jabatan`', '`jabatan`', 3, 11, -1, false, '`jabatan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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
        $this->keperluan = new DbField('v_kajari', 'v_kajari', 'x_keperluan', 'keperluan', '`keperluan`', '`keperluan`', 3, 11, -1, false, '`keperluan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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
        $this->kategori_pemohon = new DbField('v_kajari', 'v_kajari', 'x_kategori_pemohon', 'kategori_pemohon', '`kategori_pemohon`', '`kategori_pemohon`', 200, 255, -1, false, '`kategori_pemohon`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kategori_pemohon->Nullable = false; // NOT NULL field
        $this->kategori_pemohon->Required = true; // Required field
        $this->kategori_pemohon->Sortable = true; // Allow sort
        $this->kategori_pemohon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategori_pemohon->Param, "CustomMsg");
        $this->Fields['kategori_pemohon'] = &$this->kategori_pemohon;

        // scan_lhkpn
        $this->scan_lhkpn = new DbField('v_kajari', 'v_kajari', 'x_scan_lhkpn', 'scan_lhkpn', '`scan_lhkpn`', '`scan_lhkpn`', 200, 255, -1, false, '`scan_lhkpn`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->scan_lhkpn->Sortable = true; // Allow sort
        $this->scan_lhkpn->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->scan_lhkpn->Param, "CustomMsg");
        $this->Fields['scan_lhkpn'] = &$this->scan_lhkpn;

        // scan_lhkasn
        $this->scan_lhkasn = new DbField('v_kajari', 'v_kajari', 'x_scan_lhkasn', 'scan_lhkasn', '`scan_lhkasn`', '`scan_lhkasn`', 200, 255, -1, false, '`scan_lhkasn`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->scan_lhkasn->Sortable = true; // Allow sort
        $this->scan_lhkasn->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->scan_lhkasn->Param, "CustomMsg");
        $this->Fields['scan_lhkasn'] = &$this->scan_lhkasn;

        // keterangan
        $this->keterangan = new DbField('v_kajari', 'v_kajari', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, 65535, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;

        // status
        $this->status = new DbField('v_kajari', 'v_kajari', 'x_status', 'status', '`status`', '`status`', 200, 255, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->status->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->status->Lookup = new Lookup('status', 'v_kajari', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->status->Lookup = new Lookup('status', 'v_kajari', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->status->OptionCount = 2;
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`v_kajari`";
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
        $this->keperluan->DbValue = $row['keperluan'];
        $this->kategori_pemohon->DbValue = $row['kategori_pemohon'];
        $this->scan_lhkpn->DbValue = $row['scan_lhkpn'];
        $this->scan_lhkasn->DbValue = $row['scan_lhkasn'];
        $this->keterangan->DbValue = $row['keterangan'];
        $this->status->DbValue = $row['status'];
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
        return $_SESSION[$name] ?? GetUrl("VKajariList");
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
        if ($pageName == "VKajariView") {
            return $Language->phrase("View");
        } elseif ($pageName == "VKajariEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "VKajariAdd") {
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
                return "VKajariView";
            case Config("API_ADD_ACTION"):
                return "VKajariAdd";
            case Config("API_EDIT_ACTION"):
                return "VKajariEdit";
            case Config("API_DELETE_ACTION"):
                return "VKajariDelete";
            case Config("API_LIST_ACTION"):
                return "VKajariList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "VKajariList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("VKajariView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("VKajariView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "VKajariAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "VKajariAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("VKajariEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("VKajariAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("VKajariDelete", $this->getUrlParm());
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
        $this->keperluan->setDbValue($row['keperluan']);
        $this->kategori_pemohon->setDbValue($row['kategori_pemohon']);
        $this->scan_lhkpn->setDbValue($row['scan_lhkpn']);
        $this->scan_lhkasn->setDbValue($row['scan_lhkasn']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->status->setDbValue($row['status']);
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

        // keperluan

        // kategori_pemohon

        // scan_lhkpn

        // scan_lhkasn

        // keterangan

        // status

        // id_request
        $this->id_request->ViewValue = $this->id_request->CurrentValue;
        $this->id_request->ViewCustomAttributes = "";

        // tanggal_request
        $this->tanggal_request->ViewValue = $this->tanggal_request->CurrentValue;
        $this->tanggal_request->ViewValue = FormatDateTime($this->tanggal_request->ViewValue, 117);
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
        $this->kategori_pemohon->ViewValue = $this->kategori_pemohon->CurrentValue;
        $this->kategori_pemohon->ViewCustomAttributes = "";

        // scan_lhkpn
        $this->scan_lhkpn->ViewValue = $this->scan_lhkpn->CurrentValue;
        $this->scan_lhkpn->ViewCustomAttributes = "";

        // scan_lhkasn
        $this->scan_lhkasn->ViewValue = $this->scan_lhkasn->CurrentValue;
        $this->scan_lhkasn->ViewCustomAttributes = "";

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

        // keperluan
        $this->keperluan->LinkCustomAttributes = "";
        $this->keperluan->HrefValue = "";
        $this->keperluan->TooltipValue = "";

        // kategori_pemohon
        $this->kategori_pemohon->LinkCustomAttributes = "";
        $this->kategori_pemohon->HrefValue = "";
        $this->kategori_pemohon->TooltipValue = "";

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

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

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
        $this->tanggal_request->EditValue = FormatDateTime($this->tanggal_request->EditValue, 117);
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

        // kategori_pemohon
        $this->kategori_pemohon->EditAttrs["class"] = "form-control";
        $this->kategori_pemohon->EditCustomAttributes = "";
        $this->kategori_pemohon->EditValue = $this->kategori_pemohon->CurrentValue;
        $this->kategori_pemohon->ViewCustomAttributes = "";

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

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // status
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->options(false);
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

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
                    $doc->exportCaption($this->keperluan);
                    $doc->exportCaption($this->scan_lhkpn);
                    $doc->exportCaption($this->scan_lhkasn);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->status);
                } else {
                    $doc->exportCaption($this->id_request);
                    $doc->exportCaption($this->tanggal_request);
                    $doc->exportCaption($this->nip);
                    $doc->exportCaption($this->nrp);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->unit_organisasi);
                    $doc->exportCaption($this->pangkat);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->keperluan);
                    $doc->exportCaption($this->kategori_pemohon);
                    $doc->exportCaption($this->scan_lhkpn);
                    $doc->exportCaption($this->scan_lhkasn);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->status);
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
                        $doc->exportField($this->keperluan);
                        $doc->exportField($this->scan_lhkpn);
                        $doc->exportField($this->scan_lhkasn);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->status);
                    } else {
                        $doc->exportField($this->id_request);
                        $doc->exportField($this->tanggal_request);
                        $doc->exportField($this->nip);
                        $doc->exportField($this->nrp);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->unit_organisasi);
                        $doc->exportField($this->pangkat);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->keperluan);
                        $doc->exportField($this->kategori_pemohon);
                        $doc->exportField($this->scan_lhkpn);
                        $doc->exportField($this->scan_lhkasn);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->status);
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
        // Enter your code here
        $status = 'DIAJUKAN';
    	if($status != '' OR $status != FALSE) {
    		AddFilter($filter, "status = '{$status}'");
    	}
    	if (!empty(CurrentUserInfo('unit_organisasi'))) {
            AddFilter($filter, "unit_organisasi = ".CurrentUserInfo('unit_organisasi'));
        }
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
        // Enter your code here
        // To cancel, set return value to false
        $rsnew['status'] = empty($rsnew['status']) ? $rsold['status'] : $rsnew['status'];
        $this->UpdateTable = "data_request_skk";
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
        ExecuteUpdate("INSERT INTO riwayat_acc (id_skk, status, verifikator, tanggal) VALUES ({$rsold['id_request']}, '{$rsnew['status']}', 'kajari', '".date('Y-m-d H:i:s')."')");
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
    	$this->status->ViewAttrs["class"] = " badge badge-info";
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
