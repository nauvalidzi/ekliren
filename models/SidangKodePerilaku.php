<?php

namespace PHPMaker2021\eclearance;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for sidang_kode_perilaku
 */
class SidangKodePerilaku extends DbTable
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
    public $id;
    public $pid_request_skk;
    public $sidang_kode_perilaku_jaksa;
    public $tempat_sidang_kode_perilaku;
    public $hukuman_administratif;
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
        $this->TableVar = 'sidang_kode_perilaku';
        $this->TableName = 'sidang_kode_perilaku';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`sidang_kode_perilaku`";
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
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('sidang_kode_perilaku', 'sidang_kode_perilaku', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // pid_request_skk
        $this->pid_request_skk = new DbField('sidang_kode_perilaku', 'sidang_kode_perilaku', 'x_pid_request_skk', 'pid_request_skk', '`pid_request_skk`', '`pid_request_skk`', 3, 11, -1, false, '`pid_request_skk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pid_request_skk->IsForeignKey = true; // Foreign key field
        $this->pid_request_skk->Sortable = true; // Allow sort
        $this->pid_request_skk->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->pid_request_skk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pid_request_skk->Param, "CustomMsg");
        $this->Fields['pid_request_skk'] = &$this->pid_request_skk;

        // sidang_kode_perilaku_jaksa
        $this->sidang_kode_perilaku_jaksa = new DbField('sidang_kode_perilaku', 'sidang_kode_perilaku', 'x_sidang_kode_perilaku_jaksa', 'sidang_kode_perilaku_jaksa', '`sidang_kode_perilaku_jaksa`', '`sidang_kode_perilaku_jaksa`', 202, 5, -1, false, '`sidang_kode_perilaku_jaksa`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->sidang_kode_perilaku_jaksa->Required = true; // Required field
        $this->sidang_kode_perilaku_jaksa->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->sidang_kode_perilaku_jaksa->Lookup = new Lookup('sidang_kode_perilaku_jaksa', 'sidang_kode_perilaku', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->sidang_kode_perilaku_jaksa->Lookup = new Lookup('sidang_kode_perilaku_jaksa', 'sidang_kode_perilaku', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->sidang_kode_perilaku_jaksa->OptionCount = 2;
        $this->sidang_kode_perilaku_jaksa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sidang_kode_perilaku_jaksa->Param, "CustomMsg");
        $this->Fields['sidang_kode_perilaku_jaksa'] = &$this->sidang_kode_perilaku_jaksa;

        // tempat_sidang_kode_perilaku
        $this->tempat_sidang_kode_perilaku = new DbField('sidang_kode_perilaku', 'sidang_kode_perilaku', 'x_tempat_sidang_kode_perilaku', 'tempat_sidang_kode_perilaku', '`tempat_sidang_kode_perilaku`', '`tempat_sidang_kode_perilaku`', 3, 11, -1, false, '`tempat_sidang_kode_perilaku`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->tempat_sidang_kode_perilaku->Sortable = true; // Allow sort
        $this->tempat_sidang_kode_perilaku->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tempat_sidang_kode_perilaku->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
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
        $this->hukuman_administratif = new DbField('sidang_kode_perilaku', 'sidang_kode_perilaku', 'x_hukuman_administratif', 'hukuman_administratif', '`hukuman_administratif`', '`hukuman_administratif`', 200, 255, -1, false, '`hukuman_administratif`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hukuman_administratif->Sortable = true; // Allow sort
        $this->hukuman_administratif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hukuman_administratif->Param, "CustomMsg");
        $this->Fields['hukuman_administratif'] = &$this->hukuman_administratif;

        // sk_nomor_kode_perilaku
        $this->sk_nomor_kode_perilaku = new DbField('sidang_kode_perilaku', 'sidang_kode_perilaku', 'x_sk_nomor_kode_perilaku', 'sk_nomor_kode_perilaku', '`sk_nomor_kode_perilaku`', '`sk_nomor_kode_perilaku`', 200, 255, -1, false, '`sk_nomor_kode_perilaku`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sk_nomor_kode_perilaku->Sortable = true; // Allow sort
        $this->sk_nomor_kode_perilaku->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sk_nomor_kode_perilaku->Param, "CustomMsg");
        $this->Fields['sk_nomor_kode_perilaku'] = &$this->sk_nomor_kode_perilaku;

        // tgl_sk_kode_perilaku
        $this->tgl_sk_kode_perilaku = new DbField('sidang_kode_perilaku', 'sidang_kode_perilaku', 'x_tgl_sk_kode_perilaku', 'tgl_sk_kode_perilaku', '`tgl_sk_kode_perilaku`', CastDateFieldForLike("`tgl_sk_kode_perilaku`", 0, "DB"), 133, 10, 0, false, '`tgl_sk_kode_perilaku`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_sk_kode_perilaku->Sortable = true; // Allow sort
        $this->tgl_sk_kode_perilaku->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgl_sk_kode_perilaku->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_sk_kode_perilaku->Param, "CustomMsg");
        $this->Fields['tgl_sk_kode_perilaku'] = &$this->tgl_sk_kode_perilaku;

        // status_hukuman_kode_perilaku
        $this->status_hukuman_kode_perilaku = new DbField('sidang_kode_perilaku', 'sidang_kode_perilaku', 'x_status_hukuman_kode_perilaku', 'status_hukuman_kode_perilaku', '`status_hukuman_kode_perilaku`', '`status_hukuman_kode_perilaku`', 202, 7, -1, false, '`status_hukuman_kode_perilaku`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->status_hukuman_kode_perilaku->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->status_hukuman_kode_perilaku->Lookup = new Lookup('status_hukuman_kode_perilaku', 'sidang_kode_perilaku', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->status_hukuman_kode_perilaku->Lookup = new Lookup('status_hukuman_kode_perilaku', 'sidang_kode_perilaku', false, '', ["","","",""], [], [], [], [], [], [], '', '');
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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "v_sekretariat") {
            if ($this->pid_request_skk->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id_request`", $this->pid_request_skk->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "v_sekretariat") {
            if ($this->pid_request_skk->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`pid_request_skk`", $this->pid_request_skk->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_v_sekretariat()
    {
        return "`id_request`=@id_request@";
    }
    // Detail filter
    public function sqlDetailFilter_v_sekretariat()
    {
        return "`pid_request_skk`=@pid_request_skk@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`sidang_kode_perilaku`";
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
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
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
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
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
        $this->id->DbValue = $row['id'];
        $this->pid_request_skk->DbValue = $row['pid_request_skk'];
        $this->sidang_kode_perilaku_jaksa->DbValue = $row['sidang_kode_perilaku_jaksa'];
        $this->tempat_sidang_kode_perilaku->DbValue = $row['tempat_sidang_kode_perilaku'];
        $this->hukuman_administratif->DbValue = $row['hukuman_administratif'];
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
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
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
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("SidangKodePerilakuList");
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
        if ($pageName == "SidangKodePerilakuView") {
            return $Language->phrase("View");
        } elseif ($pageName == "SidangKodePerilakuEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "SidangKodePerilakuAdd") {
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
                return "SidangKodePerilakuView";
            case Config("API_ADD_ACTION"):
                return "SidangKodePerilakuAdd";
            case Config("API_EDIT_ACTION"):
                return "SidangKodePerilakuEdit";
            case Config("API_DELETE_ACTION"):
                return "SidangKodePerilakuDelete";
            case Config("API_LIST_ACTION"):
                return "SidangKodePerilakuList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "SidangKodePerilakuList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("SidangKodePerilakuView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("SidangKodePerilakuView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "SidangKodePerilakuAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "SidangKodePerilakuAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("SidangKodePerilakuEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("SidangKodePerilakuAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("SidangKodePerilakuDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "v_sekretariat" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id_request", $this->pid_request_skk->CurrentValue ?? $this->pid_request_skk->getSessionValue());
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id:" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id->CurrentValue);
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
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
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
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
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
        $this->id->setDbValue($row['id']);
        $this->pid_request_skk->setDbValue($row['pid_request_skk']);
        $this->sidang_kode_perilaku_jaksa->setDbValue($row['sidang_kode_perilaku_jaksa']);
        $this->tempat_sidang_kode_perilaku->setDbValue($row['tempat_sidang_kode_perilaku']);
        $this->hukuman_administratif->setDbValue($row['hukuman_administratif']);
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

        // id

        // pid_request_skk

        // sidang_kode_perilaku_jaksa

        // tempat_sidang_kode_perilaku

        // hukuman_administratif

        // sk_nomor_kode_perilaku

        // tgl_sk_kode_perilaku

        // status_hukuman_kode_perilaku

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
        $this->id->ViewCustomAttributes = "";

        // pid_request_skk
        $this->pid_request_skk->ViewValue = $this->pid_request_skk->CurrentValue;
        $this->pid_request_skk->ViewValue = FormatNumber($this->pid_request_skk->ViewValue, 0, -2, -2, -2);
        $this->pid_request_skk->ViewCustomAttributes = "";

        // sidang_kode_perilaku_jaksa
        if (strval($this->sidang_kode_perilaku_jaksa->CurrentValue) != "") {
            $this->sidang_kode_perilaku_jaksa->ViewValue = $this->sidang_kode_perilaku_jaksa->optionCaption($this->sidang_kode_perilaku_jaksa->CurrentValue);
        } else {
            $this->sidang_kode_perilaku_jaksa->ViewValue = null;
        }
        $this->sidang_kode_perilaku_jaksa->ViewCustomAttributes = "";

        // tempat_sidang_kode_perilaku
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

        // sk_nomor_kode_perilaku
        $this->sk_nomor_kode_perilaku->ViewValue = $this->sk_nomor_kode_perilaku->CurrentValue;
        $this->sk_nomor_kode_perilaku->ViewCustomAttributes = "";

        // tgl_sk_kode_perilaku
        $this->tgl_sk_kode_perilaku->ViewValue = $this->tgl_sk_kode_perilaku->CurrentValue;
        $this->tgl_sk_kode_perilaku->ViewValue = FormatDateTime($this->tgl_sk_kode_perilaku->ViewValue, 0);
        $this->tgl_sk_kode_perilaku->ViewCustomAttributes = "";

        // status_hukuman_kode_perilaku
        if (strval($this->status_hukuman_kode_perilaku->CurrentValue) != "") {
            $this->status_hukuman_kode_perilaku->ViewValue = $this->status_hukuman_kode_perilaku->optionCaption($this->status_hukuman_kode_perilaku->CurrentValue);
        } else {
            $this->status_hukuman_kode_perilaku->ViewValue = null;
        }
        $this->status_hukuman_kode_perilaku->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // pid_request_skk
        $this->pid_request_skk->LinkCustomAttributes = "";
        $this->pid_request_skk->HrefValue = "";
        $this->pid_request_skk->TooltipValue = "";

        // sidang_kode_perilaku_jaksa
        $this->sidang_kode_perilaku_jaksa->LinkCustomAttributes = "";
        $this->sidang_kode_perilaku_jaksa->HrefValue = "";
        $this->sidang_kode_perilaku_jaksa->TooltipValue = "";

        // tempat_sidang_kode_perilaku
        $this->tempat_sidang_kode_perilaku->LinkCustomAttributes = "";
        $this->tempat_sidang_kode_perilaku->HrefValue = "";
        $this->tempat_sidang_kode_perilaku->TooltipValue = "";

        // hukuman_administratif
        $this->hukuman_administratif->LinkCustomAttributes = "";
        $this->hukuman_administratif->HrefValue = "";
        $this->hukuman_administratif->TooltipValue = "";

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

        // id
        $this->id->EditAttrs["class"] = "form-control";
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->EditValue = FormatNumber($this->id->EditValue, 0, -2, -2, -2);
        $this->id->ViewCustomAttributes = "";

        // pid_request_skk
        $this->pid_request_skk->EditAttrs["class"] = "form-control";
        $this->pid_request_skk->EditCustomAttributes = "";
        if ($this->pid_request_skk->getSessionValue() != "") {
            $this->pid_request_skk->CurrentValue = GetForeignKeyValue($this->pid_request_skk->getSessionValue());
            $this->pid_request_skk->ViewValue = $this->pid_request_skk->CurrentValue;
            $this->pid_request_skk->ViewValue = FormatNumber($this->pid_request_skk->ViewValue, 0, -2, -2, -2);
            $this->pid_request_skk->ViewCustomAttributes = "";
        } else {
            $this->pid_request_skk->EditValue = $this->pid_request_skk->CurrentValue;
            $this->pid_request_skk->PlaceHolder = RemoveHtml($this->pid_request_skk->caption());
        }

        // sidang_kode_perilaku_jaksa
        $this->sidang_kode_perilaku_jaksa->EditCustomAttributes = "";
        $this->sidang_kode_perilaku_jaksa->EditValue = $this->sidang_kode_perilaku_jaksa->options(false);
        $this->sidang_kode_perilaku_jaksa->PlaceHolder = RemoveHtml($this->sidang_kode_perilaku_jaksa->caption());

        // tempat_sidang_kode_perilaku
        $this->tempat_sidang_kode_perilaku->EditAttrs["class"] = "form-control";
        $this->tempat_sidang_kode_perilaku->EditCustomAttributes = "";
        $this->tempat_sidang_kode_perilaku->PlaceHolder = RemoveHtml($this->tempat_sidang_kode_perilaku->caption());

        // hukuman_administratif
        $this->hukuman_administratif->EditAttrs["class"] = "form-control";
        $this->hukuman_administratif->EditCustomAttributes = "";
        if (!$this->hukuman_administratif->Raw) {
            $this->hukuman_administratif->CurrentValue = HtmlDecode($this->hukuman_administratif->CurrentValue);
        }
        $this->hukuman_administratif->EditValue = $this->hukuman_administratif->CurrentValue;
        $this->hukuman_administratif->PlaceHolder = RemoveHtml($this->hukuman_administratif->caption());

        // sk_nomor_kode_perilaku
        $this->sk_nomor_kode_perilaku->EditAttrs["class"] = "form-control";
        $this->sk_nomor_kode_perilaku->EditCustomAttributes = "";
        if (!$this->sk_nomor_kode_perilaku->Raw) {
            $this->sk_nomor_kode_perilaku->CurrentValue = HtmlDecode($this->sk_nomor_kode_perilaku->CurrentValue);
        }
        $this->sk_nomor_kode_perilaku->EditValue = $this->sk_nomor_kode_perilaku->CurrentValue;
        $this->sk_nomor_kode_perilaku->PlaceHolder = RemoveHtml($this->sk_nomor_kode_perilaku->caption());

        // tgl_sk_kode_perilaku
        $this->tgl_sk_kode_perilaku->EditAttrs["class"] = "form-control";
        $this->tgl_sk_kode_perilaku->EditCustomAttributes = "";
        $this->tgl_sk_kode_perilaku->EditValue = FormatDateTime($this->tgl_sk_kode_perilaku->CurrentValue, 8);
        $this->tgl_sk_kode_perilaku->PlaceHolder = RemoveHtml($this->tgl_sk_kode_perilaku->caption());

        // status_hukuman_kode_perilaku
        $this->status_hukuman_kode_perilaku->EditCustomAttributes = "";
        $this->status_hukuman_kode_perilaku->EditValue = $this->status_hukuman_kode_perilaku->options(false);
        $this->status_hukuman_kode_perilaku->PlaceHolder = RemoveHtml($this->status_hukuman_kode_perilaku->caption());

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
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->pid_request_skk);
                    $doc->exportCaption($this->sidang_kode_perilaku_jaksa);
                    $doc->exportCaption($this->tempat_sidang_kode_perilaku);
                    $doc->exportCaption($this->hukuman_administratif);
                    $doc->exportCaption($this->sk_nomor_kode_perilaku);
                    $doc->exportCaption($this->tgl_sk_kode_perilaku);
                    $doc->exportCaption($this->status_hukuman_kode_perilaku);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->pid_request_skk);
                    $doc->exportCaption($this->sidang_kode_perilaku_jaksa);
                    $doc->exportCaption($this->tempat_sidang_kode_perilaku);
                    $doc->exportCaption($this->hukuman_administratif);
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
                        $doc->exportField($this->id);
                        $doc->exportField($this->pid_request_skk);
                        $doc->exportField($this->sidang_kode_perilaku_jaksa);
                        $doc->exportField($this->tempat_sidang_kode_perilaku);
                        $doc->exportField($this->hukuman_administratif);
                        $doc->exportField($this->sk_nomor_kode_perilaku);
                        $doc->exportField($this->tgl_sk_kode_perilaku);
                        $doc->exportField($this->status_hukuman_kode_perilaku);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->pid_request_skk);
                        $doc->exportField($this->sidang_kode_perilaku_jaksa);
                        $doc->exportField($this->tempat_sidang_kode_perilaku);
                        $doc->exportField($this->hukuman_administratif);
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
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
