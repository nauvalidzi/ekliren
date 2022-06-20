<?php

namespace PHPMaker2021\eclearance;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class VPemeriksaList extends VPemeriksa
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'v_pemeriksa';

    // Page object name
    public $PageObjName = "VPemeriksaList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fv_pemeriksalist";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (v_pemeriksa)
        if (!isset($GLOBALS["v_pemeriksa"]) || get_class($GLOBALS["v_pemeriksa"]) == PROJECT_NAMESPACE . "v_pemeriksa") {
            $GLOBALS["v_pemeriksa"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->AddUrl = "VPemeriksaAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "VPemeriksaDelete";
        $this->MultiUpdateUrl = "VPemeriksaUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'v_pemeriksa');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Import options
        $this->ImportOptions = new ListOptions("div");
        $this->ImportOptions->TagClassName = "ew-import-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";

        // Filter options
        $this->FilterOptions = new ListOptions("div");
        $this->FilterOptions->TagClassName = "ew-filter-option fv_pemeriksalistsrch";

        // List actions
        $this->ListActions = new ListActions();
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("v_pemeriksa"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id_request'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id_request->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 20;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->id_request->Visible = false;
        $this->tanggal_request->setVisibility();
        $this->nip->setVisibility();
        $this->nrp->setVisibility();
        $this->nama->setVisibility();
        $this->unit_organisasi->setVisibility();
        $this->pangkat->Visible = false;
        $this->jabatan->Visible = false;
        $this->scan_lhkpn->Visible = false;
        $this->scan_lhkasn->Visible = false;
        $this->kategori_pemohon->Visible = false;
        $this->keperluan->setVisibility();
        $this->hukuman_disiplin->Visible = false;
        $this->email_pemohon->Visible = false;
        $this->keterangan->Visible = false;
        $this->status->setVisibility();
        $this->jenis_hukuman->Visible = false;
        $this->hukuman->Visible = false;
        $this->pasal->Visible = false;
        $this->surat_keputusan->Visible = false;
        $this->sk_nomor->Visible = false;
        $this->tanggal_sk->Visible = false;
        $this->status_hukuman->Visible = false;
        $this->pernah_dijatuhi_hukuman->Visible = false;
        $this->sk_banding_nomor->Visible = false;
        $this->tgl_sk_banding->Visible = false;
        $this->mengajukan_keberatan_banding->Visible = false;
        $this->pelanggaran_disiplin->Visible = false;
        $this->inspeksi_kasus->Visible = false;
        $this->tempat_sidang_kode_perilaku->Visible = false;
        $this->hukuman_administratif->Visible = false;
        $this->sidang_kode_perilaku_jaksa->Visible = false;
        $this->sk_nomor_kode_perilaku->Visible = false;
        $this->tgl_sk_kode_perilaku->Visible = false;
        $this->status_hukuman_kode_perilaku->Visible = false;
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Show checkbox column if multiple action
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE && $listaction->Allow) {
                $this->ListOptions["checkbox"]->Visible = true;
                break;
            }
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->unit_organisasi);
        $this->setupLookupOptions($this->pangkat);
        $this->setupLookupOptions($this->jabatan);
        $this->setupLookupOptions($this->keperluan);
        $this->setupLookupOptions($this->surat_keputusan);
        $this->setupLookupOptions($this->tempat_sidang_kode_perilaku);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->id_request->AdvancedSearch->toJson(), ","); // Field id_request
        $filterList = Concat($filterList, $this->tanggal_request->AdvancedSearch->toJson(), ","); // Field tanggal_request
        $filterList = Concat($filterList, $this->nip->AdvancedSearch->toJson(), ","); // Field nip
        $filterList = Concat($filterList, $this->nrp->AdvancedSearch->toJson(), ","); // Field nrp
        $filterList = Concat($filterList, $this->nama->AdvancedSearch->toJson(), ","); // Field nama
        $filterList = Concat($filterList, $this->unit_organisasi->AdvancedSearch->toJson(), ","); // Field unit_organisasi
        $filterList = Concat($filterList, $this->pangkat->AdvancedSearch->toJson(), ","); // Field pangkat
        $filterList = Concat($filterList, $this->jabatan->AdvancedSearch->toJson(), ","); // Field jabatan
        $filterList = Concat($filterList, $this->scan_lhkpn->AdvancedSearch->toJson(), ","); // Field scan_lhkpn
        $filterList = Concat($filterList, $this->scan_lhkasn->AdvancedSearch->toJson(), ","); // Field scan_lhkasn
        $filterList = Concat($filterList, $this->kategori_pemohon->AdvancedSearch->toJson(), ","); // Field kategori_pemohon
        $filterList = Concat($filterList, $this->keperluan->AdvancedSearch->toJson(), ","); // Field keperluan
        $filterList = Concat($filterList, $this->hukuman_disiplin->AdvancedSearch->toJson(), ","); // Field hukuman_disiplin
        $filterList = Concat($filterList, $this->email_pemohon->AdvancedSearch->toJson(), ","); // Field email_pemohon
        $filterList = Concat($filterList, $this->keterangan->AdvancedSearch->toJson(), ","); // Field keterangan
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status
        $filterList = Concat($filterList, $this->jenis_hukuman->AdvancedSearch->toJson(), ","); // Field jenis_hukuman
        $filterList = Concat($filterList, $this->hukuman->AdvancedSearch->toJson(), ","); // Field hukuman
        $filterList = Concat($filterList, $this->pasal->AdvancedSearch->toJson(), ","); // Field pasal
        $filterList = Concat($filterList, $this->surat_keputusan->AdvancedSearch->toJson(), ","); // Field surat_keputusan
        $filterList = Concat($filterList, $this->sk_nomor->AdvancedSearch->toJson(), ","); // Field sk_nomor
        $filterList = Concat($filterList, $this->tanggal_sk->AdvancedSearch->toJson(), ","); // Field tanggal_sk
        $filterList = Concat($filterList, $this->status_hukuman->AdvancedSearch->toJson(), ","); // Field status_hukuman
        $filterList = Concat($filterList, $this->pernah_dijatuhi_hukuman->AdvancedSearch->toJson(), ","); // Field pernah_dijatuhi_hukuman
        $filterList = Concat($filterList, $this->sk_banding_nomor->AdvancedSearch->toJson(), ","); // Field sk_banding_nomor
        $filterList = Concat($filterList, $this->tgl_sk_banding->AdvancedSearch->toJson(), ","); // Field tgl_sk_banding
        $filterList = Concat($filterList, $this->mengajukan_keberatan_banding->AdvancedSearch->toJson(), ","); // Field mengajukan_keberatan_banding
        $filterList = Concat($filterList, $this->pelanggaran_disiplin->AdvancedSearch->toJson(), ","); // Field pelanggaran_disiplin
        $filterList = Concat($filterList, $this->inspeksi_kasus->AdvancedSearch->toJson(), ","); // Field inspeksi_kasus
        $filterList = Concat($filterList, $this->tempat_sidang_kode_perilaku->AdvancedSearch->toJson(), ","); // Field tempat_sidang_kode_perilaku
        $filterList = Concat($filterList, $this->hukuman_administratif->AdvancedSearch->toJson(), ","); // Field hukuman_administratif
        $filterList = Concat($filterList, $this->sidang_kode_perilaku_jaksa->AdvancedSearch->toJson(), ","); // Field sidang_kode_perilaku_jaksa
        $filterList = Concat($filterList, $this->sk_nomor_kode_perilaku->AdvancedSearch->toJson(), ","); // Field sk_nomor_kode_perilaku
        $filterList = Concat($filterList, $this->tgl_sk_kode_perilaku->AdvancedSearch->toJson(), ","); // Field tgl_sk_kode_perilaku
        $filterList = Concat($filterList, $this->status_hukuman_kode_perilaku->AdvancedSearch->toJson(), ","); // Field status_hukuman_kode_perilaku
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fv_pemeriksalistsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field id_request
        $this->id_request->AdvancedSearch->SearchValue = @$filter["x_id_request"];
        $this->id_request->AdvancedSearch->SearchOperator = @$filter["z_id_request"];
        $this->id_request->AdvancedSearch->SearchCondition = @$filter["v_id_request"];
        $this->id_request->AdvancedSearch->SearchValue2 = @$filter["y_id_request"];
        $this->id_request->AdvancedSearch->SearchOperator2 = @$filter["w_id_request"];
        $this->id_request->AdvancedSearch->save();

        // Field tanggal_request
        $this->tanggal_request->AdvancedSearch->SearchValue = @$filter["x_tanggal_request"];
        $this->tanggal_request->AdvancedSearch->SearchOperator = @$filter["z_tanggal_request"];
        $this->tanggal_request->AdvancedSearch->SearchCondition = @$filter["v_tanggal_request"];
        $this->tanggal_request->AdvancedSearch->SearchValue2 = @$filter["y_tanggal_request"];
        $this->tanggal_request->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal_request"];
        $this->tanggal_request->AdvancedSearch->save();

        // Field nip
        $this->nip->AdvancedSearch->SearchValue = @$filter["x_nip"];
        $this->nip->AdvancedSearch->SearchOperator = @$filter["z_nip"];
        $this->nip->AdvancedSearch->SearchCondition = @$filter["v_nip"];
        $this->nip->AdvancedSearch->SearchValue2 = @$filter["y_nip"];
        $this->nip->AdvancedSearch->SearchOperator2 = @$filter["w_nip"];
        $this->nip->AdvancedSearch->save();

        // Field nrp
        $this->nrp->AdvancedSearch->SearchValue = @$filter["x_nrp"];
        $this->nrp->AdvancedSearch->SearchOperator = @$filter["z_nrp"];
        $this->nrp->AdvancedSearch->SearchCondition = @$filter["v_nrp"];
        $this->nrp->AdvancedSearch->SearchValue2 = @$filter["y_nrp"];
        $this->nrp->AdvancedSearch->SearchOperator2 = @$filter["w_nrp"];
        $this->nrp->AdvancedSearch->save();

        // Field nama
        $this->nama->AdvancedSearch->SearchValue = @$filter["x_nama"];
        $this->nama->AdvancedSearch->SearchOperator = @$filter["z_nama"];
        $this->nama->AdvancedSearch->SearchCondition = @$filter["v_nama"];
        $this->nama->AdvancedSearch->SearchValue2 = @$filter["y_nama"];
        $this->nama->AdvancedSearch->SearchOperator2 = @$filter["w_nama"];
        $this->nama->AdvancedSearch->save();

        // Field unit_organisasi
        $this->unit_organisasi->AdvancedSearch->SearchValue = @$filter["x_unit_organisasi"];
        $this->unit_organisasi->AdvancedSearch->SearchOperator = @$filter["z_unit_organisasi"];
        $this->unit_organisasi->AdvancedSearch->SearchCondition = @$filter["v_unit_organisasi"];
        $this->unit_organisasi->AdvancedSearch->SearchValue2 = @$filter["y_unit_organisasi"];
        $this->unit_organisasi->AdvancedSearch->SearchOperator2 = @$filter["w_unit_organisasi"];
        $this->unit_organisasi->AdvancedSearch->save();

        // Field pangkat
        $this->pangkat->AdvancedSearch->SearchValue = @$filter["x_pangkat"];
        $this->pangkat->AdvancedSearch->SearchOperator = @$filter["z_pangkat"];
        $this->pangkat->AdvancedSearch->SearchCondition = @$filter["v_pangkat"];
        $this->pangkat->AdvancedSearch->SearchValue2 = @$filter["y_pangkat"];
        $this->pangkat->AdvancedSearch->SearchOperator2 = @$filter["w_pangkat"];
        $this->pangkat->AdvancedSearch->save();

        // Field jabatan
        $this->jabatan->AdvancedSearch->SearchValue = @$filter["x_jabatan"];
        $this->jabatan->AdvancedSearch->SearchOperator = @$filter["z_jabatan"];
        $this->jabatan->AdvancedSearch->SearchCondition = @$filter["v_jabatan"];
        $this->jabatan->AdvancedSearch->SearchValue2 = @$filter["y_jabatan"];
        $this->jabatan->AdvancedSearch->SearchOperator2 = @$filter["w_jabatan"];
        $this->jabatan->AdvancedSearch->save();

        // Field scan_lhkpn
        $this->scan_lhkpn->AdvancedSearch->SearchValue = @$filter["x_scan_lhkpn"];
        $this->scan_lhkpn->AdvancedSearch->SearchOperator = @$filter["z_scan_lhkpn"];
        $this->scan_lhkpn->AdvancedSearch->SearchCondition = @$filter["v_scan_lhkpn"];
        $this->scan_lhkpn->AdvancedSearch->SearchValue2 = @$filter["y_scan_lhkpn"];
        $this->scan_lhkpn->AdvancedSearch->SearchOperator2 = @$filter["w_scan_lhkpn"];
        $this->scan_lhkpn->AdvancedSearch->save();

        // Field scan_lhkasn
        $this->scan_lhkasn->AdvancedSearch->SearchValue = @$filter["x_scan_lhkasn"];
        $this->scan_lhkasn->AdvancedSearch->SearchOperator = @$filter["z_scan_lhkasn"];
        $this->scan_lhkasn->AdvancedSearch->SearchCondition = @$filter["v_scan_lhkasn"];
        $this->scan_lhkasn->AdvancedSearch->SearchValue2 = @$filter["y_scan_lhkasn"];
        $this->scan_lhkasn->AdvancedSearch->SearchOperator2 = @$filter["w_scan_lhkasn"];
        $this->scan_lhkasn->AdvancedSearch->save();

        // Field kategori_pemohon
        $this->kategori_pemohon->AdvancedSearch->SearchValue = @$filter["x_kategori_pemohon"];
        $this->kategori_pemohon->AdvancedSearch->SearchOperator = @$filter["z_kategori_pemohon"];
        $this->kategori_pemohon->AdvancedSearch->SearchCondition = @$filter["v_kategori_pemohon"];
        $this->kategori_pemohon->AdvancedSearch->SearchValue2 = @$filter["y_kategori_pemohon"];
        $this->kategori_pemohon->AdvancedSearch->SearchOperator2 = @$filter["w_kategori_pemohon"];
        $this->kategori_pemohon->AdvancedSearch->save();

        // Field keperluan
        $this->keperluan->AdvancedSearch->SearchValue = @$filter["x_keperluan"];
        $this->keperluan->AdvancedSearch->SearchOperator = @$filter["z_keperluan"];
        $this->keperluan->AdvancedSearch->SearchCondition = @$filter["v_keperluan"];
        $this->keperluan->AdvancedSearch->SearchValue2 = @$filter["y_keperluan"];
        $this->keperluan->AdvancedSearch->SearchOperator2 = @$filter["w_keperluan"];
        $this->keperluan->AdvancedSearch->save();

        // Field hukuman_disiplin
        $this->hukuman_disiplin->AdvancedSearch->SearchValue = @$filter["x_hukuman_disiplin"];
        $this->hukuman_disiplin->AdvancedSearch->SearchOperator = @$filter["z_hukuman_disiplin"];
        $this->hukuman_disiplin->AdvancedSearch->SearchCondition = @$filter["v_hukuman_disiplin"];
        $this->hukuman_disiplin->AdvancedSearch->SearchValue2 = @$filter["y_hukuman_disiplin"];
        $this->hukuman_disiplin->AdvancedSearch->SearchOperator2 = @$filter["w_hukuman_disiplin"];
        $this->hukuman_disiplin->AdvancedSearch->save();

        // Field email_pemohon
        $this->email_pemohon->AdvancedSearch->SearchValue = @$filter["x_email_pemohon"];
        $this->email_pemohon->AdvancedSearch->SearchOperator = @$filter["z_email_pemohon"];
        $this->email_pemohon->AdvancedSearch->SearchCondition = @$filter["v_email_pemohon"];
        $this->email_pemohon->AdvancedSearch->SearchValue2 = @$filter["y_email_pemohon"];
        $this->email_pemohon->AdvancedSearch->SearchOperator2 = @$filter["w_email_pemohon"];
        $this->email_pemohon->AdvancedSearch->save();

        // Field keterangan
        $this->keterangan->AdvancedSearch->SearchValue = @$filter["x_keterangan"];
        $this->keterangan->AdvancedSearch->SearchOperator = @$filter["z_keterangan"];
        $this->keterangan->AdvancedSearch->SearchCondition = @$filter["v_keterangan"];
        $this->keterangan->AdvancedSearch->SearchValue2 = @$filter["y_keterangan"];
        $this->keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_keterangan"];
        $this->keterangan->AdvancedSearch->save();

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();

        // Field jenis_hukuman
        $this->jenis_hukuman->AdvancedSearch->SearchValue = @$filter["x_jenis_hukuman"];
        $this->jenis_hukuman->AdvancedSearch->SearchOperator = @$filter["z_jenis_hukuman"];
        $this->jenis_hukuman->AdvancedSearch->SearchCondition = @$filter["v_jenis_hukuman"];
        $this->jenis_hukuman->AdvancedSearch->SearchValue2 = @$filter["y_jenis_hukuman"];
        $this->jenis_hukuman->AdvancedSearch->SearchOperator2 = @$filter["w_jenis_hukuman"];
        $this->jenis_hukuman->AdvancedSearch->save();

        // Field hukuman
        $this->hukuman->AdvancedSearch->SearchValue = @$filter["x_hukuman"];
        $this->hukuman->AdvancedSearch->SearchOperator = @$filter["z_hukuman"];
        $this->hukuman->AdvancedSearch->SearchCondition = @$filter["v_hukuman"];
        $this->hukuman->AdvancedSearch->SearchValue2 = @$filter["y_hukuman"];
        $this->hukuman->AdvancedSearch->SearchOperator2 = @$filter["w_hukuman"];
        $this->hukuman->AdvancedSearch->save();

        // Field pasal
        $this->pasal->AdvancedSearch->SearchValue = @$filter["x_pasal"];
        $this->pasal->AdvancedSearch->SearchOperator = @$filter["z_pasal"];
        $this->pasal->AdvancedSearch->SearchCondition = @$filter["v_pasal"];
        $this->pasal->AdvancedSearch->SearchValue2 = @$filter["y_pasal"];
        $this->pasal->AdvancedSearch->SearchOperator2 = @$filter["w_pasal"];
        $this->pasal->AdvancedSearch->save();

        // Field surat_keputusan
        $this->surat_keputusan->AdvancedSearch->SearchValue = @$filter["x_surat_keputusan"];
        $this->surat_keputusan->AdvancedSearch->SearchOperator = @$filter["z_surat_keputusan"];
        $this->surat_keputusan->AdvancedSearch->SearchCondition = @$filter["v_surat_keputusan"];
        $this->surat_keputusan->AdvancedSearch->SearchValue2 = @$filter["y_surat_keputusan"];
        $this->surat_keputusan->AdvancedSearch->SearchOperator2 = @$filter["w_surat_keputusan"];
        $this->surat_keputusan->AdvancedSearch->save();

        // Field sk_nomor
        $this->sk_nomor->AdvancedSearch->SearchValue = @$filter["x_sk_nomor"];
        $this->sk_nomor->AdvancedSearch->SearchOperator = @$filter["z_sk_nomor"];
        $this->sk_nomor->AdvancedSearch->SearchCondition = @$filter["v_sk_nomor"];
        $this->sk_nomor->AdvancedSearch->SearchValue2 = @$filter["y_sk_nomor"];
        $this->sk_nomor->AdvancedSearch->SearchOperator2 = @$filter["w_sk_nomor"];
        $this->sk_nomor->AdvancedSearch->save();

        // Field tanggal_sk
        $this->tanggal_sk->AdvancedSearch->SearchValue = @$filter["x_tanggal_sk"];
        $this->tanggal_sk->AdvancedSearch->SearchOperator = @$filter["z_tanggal_sk"];
        $this->tanggal_sk->AdvancedSearch->SearchCondition = @$filter["v_tanggal_sk"];
        $this->tanggal_sk->AdvancedSearch->SearchValue2 = @$filter["y_tanggal_sk"];
        $this->tanggal_sk->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal_sk"];
        $this->tanggal_sk->AdvancedSearch->save();

        // Field status_hukuman
        $this->status_hukuman->AdvancedSearch->SearchValue = @$filter["x_status_hukuman"];
        $this->status_hukuman->AdvancedSearch->SearchOperator = @$filter["z_status_hukuman"];
        $this->status_hukuman->AdvancedSearch->SearchCondition = @$filter["v_status_hukuman"];
        $this->status_hukuman->AdvancedSearch->SearchValue2 = @$filter["y_status_hukuman"];
        $this->status_hukuman->AdvancedSearch->SearchOperator2 = @$filter["w_status_hukuman"];
        $this->status_hukuman->AdvancedSearch->save();

        // Field pernah_dijatuhi_hukuman
        $this->pernah_dijatuhi_hukuman->AdvancedSearch->SearchValue = @$filter["x_pernah_dijatuhi_hukuman"];
        $this->pernah_dijatuhi_hukuman->AdvancedSearch->SearchOperator = @$filter["z_pernah_dijatuhi_hukuman"];
        $this->pernah_dijatuhi_hukuman->AdvancedSearch->SearchCondition = @$filter["v_pernah_dijatuhi_hukuman"];
        $this->pernah_dijatuhi_hukuman->AdvancedSearch->SearchValue2 = @$filter["y_pernah_dijatuhi_hukuman"];
        $this->pernah_dijatuhi_hukuman->AdvancedSearch->SearchOperator2 = @$filter["w_pernah_dijatuhi_hukuman"];
        $this->pernah_dijatuhi_hukuman->AdvancedSearch->save();

        // Field sk_banding_nomor
        $this->sk_banding_nomor->AdvancedSearch->SearchValue = @$filter["x_sk_banding_nomor"];
        $this->sk_banding_nomor->AdvancedSearch->SearchOperator = @$filter["z_sk_banding_nomor"];
        $this->sk_banding_nomor->AdvancedSearch->SearchCondition = @$filter["v_sk_banding_nomor"];
        $this->sk_banding_nomor->AdvancedSearch->SearchValue2 = @$filter["y_sk_banding_nomor"];
        $this->sk_banding_nomor->AdvancedSearch->SearchOperator2 = @$filter["w_sk_banding_nomor"];
        $this->sk_banding_nomor->AdvancedSearch->save();

        // Field tgl_sk_banding
        $this->tgl_sk_banding->AdvancedSearch->SearchValue = @$filter["x_tgl_sk_banding"];
        $this->tgl_sk_banding->AdvancedSearch->SearchOperator = @$filter["z_tgl_sk_banding"];
        $this->tgl_sk_banding->AdvancedSearch->SearchCondition = @$filter["v_tgl_sk_banding"];
        $this->tgl_sk_banding->AdvancedSearch->SearchValue2 = @$filter["y_tgl_sk_banding"];
        $this->tgl_sk_banding->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_sk_banding"];
        $this->tgl_sk_banding->AdvancedSearch->save();

        // Field mengajukan_keberatan_banding
        $this->mengajukan_keberatan_banding->AdvancedSearch->SearchValue = @$filter["x_mengajukan_keberatan_banding"];
        $this->mengajukan_keberatan_banding->AdvancedSearch->SearchOperator = @$filter["z_mengajukan_keberatan_banding"];
        $this->mengajukan_keberatan_banding->AdvancedSearch->SearchCondition = @$filter["v_mengajukan_keberatan_banding"];
        $this->mengajukan_keberatan_banding->AdvancedSearch->SearchValue2 = @$filter["y_mengajukan_keberatan_banding"];
        $this->mengajukan_keberatan_banding->AdvancedSearch->SearchOperator2 = @$filter["w_mengajukan_keberatan_banding"];
        $this->mengajukan_keberatan_banding->AdvancedSearch->save();

        // Field pelanggaran_disiplin
        $this->pelanggaran_disiplin->AdvancedSearch->SearchValue = @$filter["x_pelanggaran_disiplin"];
        $this->pelanggaran_disiplin->AdvancedSearch->SearchOperator = @$filter["z_pelanggaran_disiplin"];
        $this->pelanggaran_disiplin->AdvancedSearch->SearchCondition = @$filter["v_pelanggaran_disiplin"];
        $this->pelanggaran_disiplin->AdvancedSearch->SearchValue2 = @$filter["y_pelanggaran_disiplin"];
        $this->pelanggaran_disiplin->AdvancedSearch->SearchOperator2 = @$filter["w_pelanggaran_disiplin"];
        $this->pelanggaran_disiplin->AdvancedSearch->save();

        // Field inspeksi_kasus
        $this->inspeksi_kasus->AdvancedSearch->SearchValue = @$filter["x_inspeksi_kasus"];
        $this->inspeksi_kasus->AdvancedSearch->SearchOperator = @$filter["z_inspeksi_kasus"];
        $this->inspeksi_kasus->AdvancedSearch->SearchCondition = @$filter["v_inspeksi_kasus"];
        $this->inspeksi_kasus->AdvancedSearch->SearchValue2 = @$filter["y_inspeksi_kasus"];
        $this->inspeksi_kasus->AdvancedSearch->SearchOperator2 = @$filter["w_inspeksi_kasus"];
        $this->inspeksi_kasus->AdvancedSearch->save();

        // Field tempat_sidang_kode_perilaku
        $this->tempat_sidang_kode_perilaku->AdvancedSearch->SearchValue = @$filter["x_tempat_sidang_kode_perilaku"];
        $this->tempat_sidang_kode_perilaku->AdvancedSearch->SearchOperator = @$filter["z_tempat_sidang_kode_perilaku"];
        $this->tempat_sidang_kode_perilaku->AdvancedSearch->SearchCondition = @$filter["v_tempat_sidang_kode_perilaku"];
        $this->tempat_sidang_kode_perilaku->AdvancedSearch->SearchValue2 = @$filter["y_tempat_sidang_kode_perilaku"];
        $this->tempat_sidang_kode_perilaku->AdvancedSearch->SearchOperator2 = @$filter["w_tempat_sidang_kode_perilaku"];
        $this->tempat_sidang_kode_perilaku->AdvancedSearch->save();

        // Field hukuman_administratif
        $this->hukuman_administratif->AdvancedSearch->SearchValue = @$filter["x_hukuman_administratif"];
        $this->hukuman_administratif->AdvancedSearch->SearchOperator = @$filter["z_hukuman_administratif"];
        $this->hukuman_administratif->AdvancedSearch->SearchCondition = @$filter["v_hukuman_administratif"];
        $this->hukuman_administratif->AdvancedSearch->SearchValue2 = @$filter["y_hukuman_administratif"];
        $this->hukuman_administratif->AdvancedSearch->SearchOperator2 = @$filter["w_hukuman_administratif"];
        $this->hukuman_administratif->AdvancedSearch->save();

        // Field sidang_kode_perilaku_jaksa
        $this->sidang_kode_perilaku_jaksa->AdvancedSearch->SearchValue = @$filter["x_sidang_kode_perilaku_jaksa"];
        $this->sidang_kode_perilaku_jaksa->AdvancedSearch->SearchOperator = @$filter["z_sidang_kode_perilaku_jaksa"];
        $this->sidang_kode_perilaku_jaksa->AdvancedSearch->SearchCondition = @$filter["v_sidang_kode_perilaku_jaksa"];
        $this->sidang_kode_perilaku_jaksa->AdvancedSearch->SearchValue2 = @$filter["y_sidang_kode_perilaku_jaksa"];
        $this->sidang_kode_perilaku_jaksa->AdvancedSearch->SearchOperator2 = @$filter["w_sidang_kode_perilaku_jaksa"];
        $this->sidang_kode_perilaku_jaksa->AdvancedSearch->save();

        // Field sk_nomor_kode_perilaku
        $this->sk_nomor_kode_perilaku->AdvancedSearch->SearchValue = @$filter["x_sk_nomor_kode_perilaku"];
        $this->sk_nomor_kode_perilaku->AdvancedSearch->SearchOperator = @$filter["z_sk_nomor_kode_perilaku"];
        $this->sk_nomor_kode_perilaku->AdvancedSearch->SearchCondition = @$filter["v_sk_nomor_kode_perilaku"];
        $this->sk_nomor_kode_perilaku->AdvancedSearch->SearchValue2 = @$filter["y_sk_nomor_kode_perilaku"];
        $this->sk_nomor_kode_perilaku->AdvancedSearch->SearchOperator2 = @$filter["w_sk_nomor_kode_perilaku"];
        $this->sk_nomor_kode_perilaku->AdvancedSearch->save();

        // Field tgl_sk_kode_perilaku
        $this->tgl_sk_kode_perilaku->AdvancedSearch->SearchValue = @$filter["x_tgl_sk_kode_perilaku"];
        $this->tgl_sk_kode_perilaku->AdvancedSearch->SearchOperator = @$filter["z_tgl_sk_kode_perilaku"];
        $this->tgl_sk_kode_perilaku->AdvancedSearch->SearchCondition = @$filter["v_tgl_sk_kode_perilaku"];
        $this->tgl_sk_kode_perilaku->AdvancedSearch->SearchValue2 = @$filter["y_tgl_sk_kode_perilaku"];
        $this->tgl_sk_kode_perilaku->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_sk_kode_perilaku"];
        $this->tgl_sk_kode_perilaku->AdvancedSearch->save();

        // Field status_hukuman_kode_perilaku
        $this->status_hukuman_kode_perilaku->AdvancedSearch->SearchValue = @$filter["x_status_hukuman_kode_perilaku"];
        $this->status_hukuman_kode_perilaku->AdvancedSearch->SearchOperator = @$filter["z_status_hukuman_kode_perilaku"];
        $this->status_hukuman_kode_perilaku->AdvancedSearch->SearchCondition = @$filter["v_status_hukuman_kode_perilaku"];
        $this->status_hukuman_kode_perilaku->AdvancedSearch->SearchValue2 = @$filter["y_status_hukuman_kode_perilaku"];
        $this->status_hukuman_kode_perilaku->AdvancedSearch->SearchOperator2 = @$filter["w_status_hukuman_kode_perilaku"];
        $this->status_hukuman_kode_perilaku->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->nip, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->nrp, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->nama, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->scan_lhkpn, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->scan_lhkasn, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->email_pemohon, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->keterangan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->status, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->hukuman, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->pasal, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->sk_nomor, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->sk_banding_nomor, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->tgl_sk_banding, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->mengajukan_keberatan_banding, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->pelanggaran_disiplin, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->inspeksi_kasus, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->hukuman_administratif, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->sidang_kode_perilaku_jaksa, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->sk_nomor_kode_perilaku, $arKeywords, $type);
        return $where;
    }

    // Build basic search SQL
    protected function buildBasicSearchSql(&$where, &$fld, $arKeywords, $type)
    {
        $defCond = ($type == "OR") ? "OR" : "AND";
        $arSql = []; // Array for SQL parts
        $arCond = []; // Array for search conditions
        $cnt = count($arKeywords);
        $j = 0; // Number of SQL parts
        for ($i = 0; $i < $cnt; $i++) {
            $keyword = $arKeywords[$i];
            $keyword = trim($keyword);
            if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
                $keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
                $ar = explode("\\", $keyword);
            } else {
                $ar = [$keyword];
            }
            foreach ($ar as $keyword) {
                if ($keyword != "") {
                    $wrk = "";
                    if ($keyword == "OR" && $type == "") {
                        if ($j > 0) {
                            $arCond[$j - 1] = "OR";
                        }
                    } elseif ($keyword == Config("NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NULL";
                    } elseif ($keyword == Config("NOT_NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NOT NULL";
                    } elseif ($fld->IsVirtual && $fld->Visible) {
                        $wrk = $fld->VirtualExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    } elseif ($fld->DataType != DATATYPE_NUMBER || is_numeric($keyword)) {
                        $wrk = $fld->BasicSearchExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    }
                    if ($wrk != "") {
                        $arSql[$j] = $wrk;
                        $arCond[$j] = $defCond;
                        $j += 1;
                    }
                }
            }
        }
        $cnt = count($arSql);
        $quoted = false;
        $sql = "";
        if ($cnt > 0) {
            for ($i = 0; $i < $cnt - 1; $i++) {
                if ($arCond[$i] == "OR") {
                    if (!$quoted) {
                        $sql .= "(";
                    }
                    $quoted = true;
                }
                $sql .= $arSql[$i];
                if ($quoted && $arCond[$i] != "OR") {
                    $sql .= ")";
                    $quoted = false;
                }
                $sql .= " " . $arCond[$i] . " ";
            }
            $sql .= $arSql[$cnt - 1];
            if ($quoted) {
                $sql .= ")";
            }
        }
        if ($sql != "") {
            if ($where != "") {
                $where .= " OR ";
            }
            $where .= "(" . $sql . ")";
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $searchKeyword = ($default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = ($default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            // Search keyword in any fields
            if (($searchType == "OR" || $searchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
                foreach ($ar as $keyword) {
                    if ($keyword != "") {
                        if ($searchStr != "") {
                            $searchStr .= " " . $searchType . " ";
                        }
                        $searchStr .= "(" . $this->basicSearchSql([$keyword], $searchType) . ")";
                    }
                }
            } else {
                $searchStr = $this->basicSearchSql($ar, $searchType);
            }
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->tanggal_request); // tanggal_request
            $this->updateSort($this->nip); // nip
            $this->updateSort($this->nrp); // nrp
            $this->updateSort($this->nama); // nama
            $this->updateSort($this->unit_organisasi); // unit_organisasi
            $this->updateSort($this->keperluan); // keperluan
            $this->updateSort($this->status); // status
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "`id_request` DESC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->id_request->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->id_request->setSort("DESC");
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->id_request->setSort("");
                $this->tanggal_request->setSort("");
                $this->nip->setSort("");
                $this->nrp->setSort("");
                $this->nama->setSort("");
                $this->unit_organisasi->setSort("");
                $this->pangkat->setSort("");
                $this->jabatan->setSort("");
                $this->scan_lhkpn->setSort("");
                $this->scan_lhkasn->setSort("");
                $this->kategori_pemohon->setSort("");
                $this->keperluan->setSort("");
                $this->hukuman_disiplin->setSort("");
                $this->email_pemohon->setSort("");
                $this->keterangan->setSort("");
                $this->status->setSort("");
                $this->jenis_hukuman->setSort("");
                $this->hukuman->setSort("");
                $this->pasal->setSort("");
                $this->surat_keputusan->setSort("");
                $this->sk_nomor->setSort("");
                $this->tanggal_sk->setSort("");
                $this->status_hukuman->setSort("");
                $this->pernah_dijatuhi_hukuman->setSort("");
                $this->sk_banding_nomor->setSort("");
                $this->tgl_sk_banding->setSort("");
                $this->mengajukan_keberatan_banding->setSort("");
                $this->pelanggaran_disiplin->setSort("");
                $this->inspeksi_kasus->setSort("");
                $this->tempat_sidang_kode_perilaku->setSort("");
                $this->hukuman_administratif->setSort("");
                $this->sidang_kode_perilaku_jaksa->setSort("");
                $this->sk_nomor_kode_perilaku->setSort("");
                $this->tgl_sk_kode_perilaku->setSort("");
                $this->status_hukuman_kode_perilaku->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = false;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = false;
        $item->Header = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"custom-control-input\" onclick=\"ew.selectAllKey(this);\"><label class=\"custom-control-label\" for=\"key\"></label></div>";
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $pageUrl = $this->pageUrl();
        if ($this->CurrentMode == "view") {
            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_SINGLE && $listaction->Allow) {
                    $action = $listaction->Action;
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $links[] = "<li><a class=\"dropdown-item ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a></li>";
                    if (count($links) == 1) { // Single button
                        $body = "<a class=\"ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a>";
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
                $opt->Visible = true;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->id_request->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Set up options default
        foreach ($options as $option) {
            $option->UseDropDownButton = false;
            $option->UseButtonGroup = true;
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->add($option->GroupOptionName);
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fv_pemeriksalistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fv_pemeriksalistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listaction->Action);
                $caption = $listaction->Caption;
                $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fv_pemeriksalist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
                $item->Visible = $listaction->Allow;
            }
        }

        // Hide grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn, \PDO::FETCH_ASSOC);
            $this->CurrentAction = $userAction;

            // Call row action event
            if ($rs) {
                $conn->beginTransaction();
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    $conn->commit(); // Commit the changes
                    if ($this->getSuccessMessage() == "" && !ob_get_length()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    $conn->rollback(); // Rollback changes

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            $this->CurrentAction = ""; // Clear action
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
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

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_request'] = null;
        $row['tanggal_request'] = null;
        $row['nip'] = null;
        $row['nrp'] = null;
        $row['nama'] = null;
        $row['unit_organisasi'] = null;
        $row['pangkat'] = null;
        $row['jabatan'] = null;
        $row['scan_lhkpn'] = null;
        $row['scan_lhkasn'] = null;
        $row['kategori_pemohon'] = null;
        $row['keperluan'] = null;
        $row['hukuman_disiplin'] = null;
        $row['email_pemohon'] = null;
        $row['keterangan'] = null;
        $row['status'] = null;
        $row['jenis_hukuman'] = null;
        $row['hukuman'] = null;
        $row['pasal'] = null;
        $row['surat_keputusan'] = null;
        $row['sk_nomor'] = null;
        $row['tanggal_sk'] = null;
        $row['status_hukuman'] = null;
        $row['pernah_dijatuhi_hukuman'] = null;
        $row['sk_banding_nomor'] = null;
        $row['tgl_sk_banding'] = null;
        $row['mengajukan_keberatan_banding'] = null;
        $row['pelanggaran_disiplin'] = null;
        $row['inspeksi_kasus'] = null;
        $row['tempat_sidang_kode_perilaku'] = null;
        $row['hukuman_administratif'] = null;
        $row['sidang_kode_perilaku_jaksa'] = null;
        $row['sk_nomor_kode_perilaku'] = null;
        $row['tgl_sk_kode_perilaku'] = null;
        $row['status_hukuman_kode_perilaku'] = null;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

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
        if ($this->RowType == ROWTYPE_VIEW) {
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

            // keperluan
            $this->keperluan->LinkCustomAttributes = "";
            $this->keperluan->HrefValue = "";
            $this->keperluan->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions("div");
        $this->SearchOptions->TagClassName = "ew-search-option";

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fv_pemeriksalistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->add($this->SearchOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_unit_organisasi":
                    break;
                case "x_pangkat":
                    break;
                case "x_jabatan":
                    break;
                case "x_kategori_pemohon":
                    break;
                case "x_keperluan":
                    break;
                case "x_hukuman_disiplin":
                    break;
                case "x_status":
                    break;
                case "x_jenis_hukuman":
                    break;
                case "x_surat_keputusan":
                    break;
                case "x_status_hukuman":
                    break;
                case "x_pernah_dijatuhi_hukuman":
                    break;
                case "x_mengajukan_keberatan_banding":
                    break;
                case "x_inspeksi_kasus":
                    break;
                case "x_tempat_sidang_kode_perilaku":
                    break;
                case "x_sidang_kode_perilaku_jaksa":
                    break;
                case "x_status_hukuman_kode_perilaku":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    	$opt = &$this->ListOptions->add("print");
        $opt->Header = "Print";
        $opt = &$this->ListOptions->add("selecting");
        $opt->Header = "<input type=\"checkbox\" id=\"check-all\">";
        $opt->OnLeft = true;
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
        $this->ListOptions->Items["print"]->Body = "<div class=\"btn-group btn-group-sm\" role=\"group\" aria-label=\"Small button group\">    	
            <a href=\"./PrintSkk?id={$this->id_request->CurrentValue}&signature=false\" target=\"_blank\" class=\"btn btn-success\" title=\"Print without signature\"><i class=\"fas fa-file-contract\"></i> Print</a>
            <a href=\"./PrintSkk?id={$this->id_request->CurrentValue}&signature=true\" target=\"_blank\" class=\"btn btn-dark\" title=\"Print with signature\"><i class=\"fas fa-file-signature\"></i> Print</a>
          </div>";
        //$this->ListOptions->Items["print"]->Body = "<a href=\"./PrintSkk?id={$this->id_request_sktm->CurrentValue}\" class=\"btn btn-outline-info btn-sm\"><i class=\"fas fa-receipt\"></i> Cetak Surat</a>";
        $this->ListOptions->Items["selecting"]->Body = "<input type=\"checkbox\" id=\"check-row\" value=\"{$this->id_request->CurrentValue}\">";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
