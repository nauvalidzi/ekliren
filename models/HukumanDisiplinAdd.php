<?php

namespace PHPMaker2021\eclearance;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class HukumanDisiplinAdd extends HukumanDisiplin
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'hukuman_disiplin';

    // Page object name
    public $PageObjName = "HukumanDisiplinAdd";

    // Rendering View
    public $RenderingView = false;

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

        // Table object (hukuman_disiplin)
        if (!isset($GLOBALS["hukuman_disiplin"]) || get_class($GLOBALS["hukuman_disiplin"]) == PROJECT_NAMESPACE . "hukuman_disiplin") {
            $GLOBALS["hukuman_disiplin"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'hukuman_disiplin');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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
                $doc = new $class(Container("hukuman_disiplin"));
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "HukumanDisiplinView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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
            $key .= @$ar['id'];
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
            $this->id->Visible = false;
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
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->pid_request_skk->setVisibility();
        $this->pernah_dijatuhi_hukuman->setVisibility();
        $this->jenis_hukuman->setVisibility();
        $this->hukuman->setVisibility();
        $this->pasal->setVisibility();
        $this->surat_keputusan->setVisibility();
        $this->sk_nomor->setVisibility();
        $this->tanggal_sk->setVisibility();
        $this->status_hukuman->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->surat_keputusan);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("HukumanDisiplinList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "HukumanDisiplinList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "HukumanDisiplinView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->pid_request_skk->CurrentValue = null;
        $this->pid_request_skk->OldValue = $this->pid_request_skk->CurrentValue;
        $this->pernah_dijatuhi_hukuman->CurrentValue = null;
        $this->pernah_dijatuhi_hukuman->OldValue = $this->pernah_dijatuhi_hukuman->CurrentValue;
        $this->jenis_hukuman->CurrentValue = null;
        $this->jenis_hukuman->OldValue = $this->jenis_hukuman->CurrentValue;
        $this->hukuman->CurrentValue = null;
        $this->hukuman->OldValue = $this->hukuman->CurrentValue;
        $this->pasal->CurrentValue = null;
        $this->pasal->OldValue = $this->pasal->CurrentValue;
        $this->surat_keputusan->CurrentValue = null;
        $this->surat_keputusan->OldValue = $this->surat_keputusan->CurrentValue;
        $this->sk_nomor->CurrentValue = null;
        $this->sk_nomor->OldValue = $this->sk_nomor->CurrentValue;
        $this->tanggal_sk->CurrentValue = null;
        $this->tanggal_sk->OldValue = $this->tanggal_sk->CurrentValue;
        $this->status_hukuman->CurrentValue = null;
        $this->status_hukuman->OldValue = $this->status_hukuman->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'pid_request_skk' first before field var 'x_pid_request_skk'
        $val = $CurrentForm->hasValue("pid_request_skk") ? $CurrentForm->getValue("pid_request_skk") : $CurrentForm->getValue("x_pid_request_skk");
        if (!$this->pid_request_skk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pid_request_skk->Visible = false; // Disable update for API request
            } else {
                $this->pid_request_skk->setFormValue($val);
            }
        }

        // Check field name 'pernah_dijatuhi_hukuman' first before field var 'x_pernah_dijatuhi_hukuman'
        $val = $CurrentForm->hasValue("pernah_dijatuhi_hukuman") ? $CurrentForm->getValue("pernah_dijatuhi_hukuman") : $CurrentForm->getValue("x_pernah_dijatuhi_hukuman");
        if (!$this->pernah_dijatuhi_hukuman->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pernah_dijatuhi_hukuman->Visible = false; // Disable update for API request
            } else {
                $this->pernah_dijatuhi_hukuman->setFormValue($val);
            }
        }

        // Check field name 'jenis_hukuman' first before field var 'x_jenis_hukuman'
        $val = $CurrentForm->hasValue("jenis_hukuman") ? $CurrentForm->getValue("jenis_hukuman") : $CurrentForm->getValue("x_jenis_hukuman");
        if (!$this->jenis_hukuman->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenis_hukuman->Visible = false; // Disable update for API request
            } else {
                $this->jenis_hukuman->setFormValue($val);
            }
        }

        // Check field name 'hukuman' first before field var 'x_hukuman'
        $val = $CurrentForm->hasValue("hukuman") ? $CurrentForm->getValue("hukuman") : $CurrentForm->getValue("x_hukuman");
        if (!$this->hukuman->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hukuman->Visible = false; // Disable update for API request
            } else {
                $this->hukuman->setFormValue($val);
            }
        }

        // Check field name 'pasal' first before field var 'x_pasal'
        $val = $CurrentForm->hasValue("pasal") ? $CurrentForm->getValue("pasal") : $CurrentForm->getValue("x_pasal");
        if (!$this->pasal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pasal->Visible = false; // Disable update for API request
            } else {
                $this->pasal->setFormValue($val);
            }
        }

        // Check field name 'surat_keputusan' first before field var 'x_surat_keputusan'
        $val = $CurrentForm->hasValue("surat_keputusan") ? $CurrentForm->getValue("surat_keputusan") : $CurrentForm->getValue("x_surat_keputusan");
        if (!$this->surat_keputusan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->surat_keputusan->Visible = false; // Disable update for API request
            } else {
                $this->surat_keputusan->setFormValue($val);
            }
        }

        // Check field name 'sk_nomor' first before field var 'x_sk_nomor'
        $val = $CurrentForm->hasValue("sk_nomor") ? $CurrentForm->getValue("sk_nomor") : $CurrentForm->getValue("x_sk_nomor");
        if (!$this->sk_nomor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sk_nomor->Visible = false; // Disable update for API request
            } else {
                $this->sk_nomor->setFormValue($val);
            }
        }

        // Check field name 'tanggal_sk' first before field var 'x_tanggal_sk'
        $val = $CurrentForm->hasValue("tanggal_sk") ? $CurrentForm->getValue("tanggal_sk") : $CurrentForm->getValue("x_tanggal_sk");
        if (!$this->tanggal_sk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_sk->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_sk->setFormValue($val);
            }
            $this->tanggal_sk->CurrentValue = UnFormatDateTime($this->tanggal_sk->CurrentValue, 0);
        }

        // Check field name 'status_hukuman' first before field var 'x_status_hukuman'
        $val = $CurrentForm->hasValue("status_hukuman") ? $CurrentForm->getValue("status_hukuman") : $CurrentForm->getValue("x_status_hukuman");
        if (!$this->status_hukuman->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_hukuman->Visible = false; // Disable update for API request
            } else {
                $this->status_hukuman->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->pid_request_skk->CurrentValue = $this->pid_request_skk->FormValue;
        $this->pernah_dijatuhi_hukuman->CurrentValue = $this->pernah_dijatuhi_hukuman->FormValue;
        $this->jenis_hukuman->CurrentValue = $this->jenis_hukuman->FormValue;
        $this->hukuman->CurrentValue = $this->hukuman->FormValue;
        $this->pasal->CurrentValue = $this->pasal->FormValue;
        $this->surat_keputusan->CurrentValue = $this->surat_keputusan->FormValue;
        $this->sk_nomor->CurrentValue = $this->sk_nomor->FormValue;
        $this->tanggal_sk->CurrentValue = $this->tanggal_sk->FormValue;
        $this->tanggal_sk->CurrentValue = UnFormatDateTime($this->tanggal_sk->CurrentValue, 0);
        $this->status_hukuman->CurrentValue = $this->status_hukuman->FormValue;
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
        $this->id->setDbValue($row['id']);
        $this->pid_request_skk->setDbValue($row['pid_request_skk']);
        $this->pernah_dijatuhi_hukuman->setDbValue($row['pernah_dijatuhi_hukuman']);
        $this->jenis_hukuman->setDbValue($row['jenis_hukuman']);
        $this->hukuman->setDbValue($row['hukuman']);
        $this->pasal->setDbValue($row['pasal']);
        $this->surat_keputusan->setDbValue($row['surat_keputusan']);
        $this->sk_nomor->setDbValue($row['sk_nomor']);
        $this->tanggal_sk->setDbValue($row['tanggal_sk']);
        $this->status_hukuman->setDbValue($row['status_hukuman']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['pid_request_skk'] = $this->pid_request_skk->CurrentValue;
        $row['pernah_dijatuhi_hukuman'] = $this->pernah_dijatuhi_hukuman->CurrentValue;
        $row['jenis_hukuman'] = $this->jenis_hukuman->CurrentValue;
        $row['hukuman'] = $this->hukuman->CurrentValue;
        $row['pasal'] = $this->pasal->CurrentValue;
        $row['surat_keputusan'] = $this->surat_keputusan->CurrentValue;
        $row['sk_nomor'] = $this->sk_nomor->CurrentValue;
        $row['tanggal_sk'] = $this->tanggal_sk->CurrentValue;
        $row['status_hukuman'] = $this->status_hukuman->CurrentValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // pid_request_skk

        // pernah_dijatuhi_hukuman

        // jenis_hukuman

        // hukuman

        // pasal

        // surat_keputusan

        // sk_nomor

        // tanggal_sk

        // status_hukuman
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // pid_request_skk
            $this->pid_request_skk->ViewValue = $this->pid_request_skk->CurrentValue;
            $this->pid_request_skk->ViewValue = FormatNumber($this->pid_request_skk->ViewValue, 0, -2, -2, -2);
            $this->pid_request_skk->ViewCustomAttributes = "";

            // pernah_dijatuhi_hukuman
            if (strval($this->pernah_dijatuhi_hukuman->CurrentValue) != "") {
                $this->pernah_dijatuhi_hukuman->ViewValue = $this->pernah_dijatuhi_hukuman->optionCaption($this->pernah_dijatuhi_hukuman->CurrentValue);
            } else {
                $this->pernah_dijatuhi_hukuman->ViewValue = null;
            }
            $this->pernah_dijatuhi_hukuman->ViewCustomAttributes = "";

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
            $this->tanggal_sk->ViewValue = FormatDateTime($this->tanggal_sk->ViewValue, 0);
            $this->tanggal_sk->ViewCustomAttributes = "";

            // status_hukuman
            if (strval($this->status_hukuman->CurrentValue) != "") {
                $this->status_hukuman->ViewValue = $this->status_hukuman->optionCaption($this->status_hukuman->CurrentValue);
            } else {
                $this->status_hukuman->ViewValue = null;
            }
            $this->status_hukuman->ViewCustomAttributes = "";

            // pid_request_skk
            $this->pid_request_skk->LinkCustomAttributes = "";
            $this->pid_request_skk->HrefValue = "";
            $this->pid_request_skk->TooltipValue = "";

            // pernah_dijatuhi_hukuman
            $this->pernah_dijatuhi_hukuman->LinkCustomAttributes = "";
            $this->pernah_dijatuhi_hukuman->HrefValue = "";
            $this->pernah_dijatuhi_hukuman->TooltipValue = "";

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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // pid_request_skk
            $this->pid_request_skk->EditAttrs["class"] = "form-control";
            $this->pid_request_skk->EditCustomAttributes = "";
            if ($this->pid_request_skk->getSessionValue() != "") {
                $this->pid_request_skk->CurrentValue = GetForeignKeyValue($this->pid_request_skk->getSessionValue());
                $this->pid_request_skk->ViewValue = $this->pid_request_skk->CurrentValue;
                $this->pid_request_skk->ViewValue = FormatNumber($this->pid_request_skk->ViewValue, 0, -2, -2, -2);
                $this->pid_request_skk->ViewCustomAttributes = "";
            } else {
                $this->pid_request_skk->EditValue = HtmlEncode($this->pid_request_skk->CurrentValue);
                $this->pid_request_skk->PlaceHolder = RemoveHtml($this->pid_request_skk->caption());
            }

            // pernah_dijatuhi_hukuman
            $this->pernah_dijatuhi_hukuman->EditCustomAttributes = "";
            $this->pernah_dijatuhi_hukuman->EditValue = $this->pernah_dijatuhi_hukuman->options(false);
            $this->pernah_dijatuhi_hukuman->PlaceHolder = RemoveHtml($this->pernah_dijatuhi_hukuman->caption());

            // jenis_hukuman
            $this->jenis_hukuman->EditCustomAttributes = "";
            $this->jenis_hukuman->EditValue = $this->jenis_hukuman->options(false);
            $this->jenis_hukuman->PlaceHolder = RemoveHtml($this->jenis_hukuman->caption());

            // hukuman
            $this->hukuman->EditAttrs["class"] = "form-control";
            $this->hukuman->EditCustomAttributes = "";
            $this->hukuman->EditValue = HtmlEncode($this->hukuman->CurrentValue);
            $this->hukuman->PlaceHolder = RemoveHtml($this->hukuman->caption());

            // pasal
            $this->pasal->EditAttrs["class"] = "form-control";
            $this->pasal->EditCustomAttributes = "";
            if (!$this->pasal->Raw) {
                $this->pasal->CurrentValue = HtmlDecode($this->pasal->CurrentValue);
            }
            $this->pasal->EditValue = HtmlEncode($this->pasal->CurrentValue);
            $this->pasal->PlaceHolder = RemoveHtml($this->pasal->caption());

            // surat_keputusan
            $this->surat_keputusan->EditAttrs["class"] = "form-control";
            $this->surat_keputusan->EditCustomAttributes = "";
            $curVal = trim(strval($this->surat_keputusan->CurrentValue));
            if ($curVal != "") {
                $this->surat_keputusan->ViewValue = $this->surat_keputusan->lookupCacheOption($curVal);
            } else {
                $this->surat_keputusan->ViewValue = $this->surat_keputusan->Lookup !== null && is_array($this->surat_keputusan->Lookup->Options) ? $curVal : null;
            }
            if ($this->surat_keputusan->ViewValue !== null) { // Load from cache
                $this->surat_keputusan->EditValue = array_values($this->surat_keputusan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->surat_keputusan->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->surat_keputusan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->surat_keputusan->EditValue = $arwrk;
            }
            $this->surat_keputusan->PlaceHolder = RemoveHtml($this->surat_keputusan->caption());

            // sk_nomor
            $this->sk_nomor->EditAttrs["class"] = "form-control";
            $this->sk_nomor->EditCustomAttributes = "";
            if (!$this->sk_nomor->Raw) {
                $this->sk_nomor->CurrentValue = HtmlDecode($this->sk_nomor->CurrentValue);
            }
            $this->sk_nomor->EditValue = HtmlEncode($this->sk_nomor->CurrentValue);
            $this->sk_nomor->PlaceHolder = RemoveHtml($this->sk_nomor->caption());

            // tanggal_sk
            $this->tanggal_sk->EditAttrs["class"] = "form-control";
            $this->tanggal_sk->EditCustomAttributes = "";
            $this->tanggal_sk->EditValue = HtmlEncode(FormatDateTime($this->tanggal_sk->CurrentValue, 8));
            $this->tanggal_sk->PlaceHolder = RemoveHtml($this->tanggal_sk->caption());

            // status_hukuman
            $this->status_hukuman->EditCustomAttributes = "";
            $this->status_hukuman->EditValue = $this->status_hukuman->options(false);
            $this->status_hukuman->PlaceHolder = RemoveHtml($this->status_hukuman->caption());

            // Add refer script

            // pid_request_skk
            $this->pid_request_skk->LinkCustomAttributes = "";
            $this->pid_request_skk->HrefValue = "";

            // pernah_dijatuhi_hukuman
            $this->pernah_dijatuhi_hukuman->LinkCustomAttributes = "";
            $this->pernah_dijatuhi_hukuman->HrefValue = "";

            // jenis_hukuman
            $this->jenis_hukuman->LinkCustomAttributes = "";
            $this->jenis_hukuman->HrefValue = "";

            // hukuman
            $this->hukuman->LinkCustomAttributes = "";
            $this->hukuman->HrefValue = "";

            // pasal
            $this->pasal->LinkCustomAttributes = "";
            $this->pasal->HrefValue = "";

            // surat_keputusan
            $this->surat_keputusan->LinkCustomAttributes = "";
            $this->surat_keputusan->HrefValue = "";

            // sk_nomor
            $this->sk_nomor->LinkCustomAttributes = "";
            $this->sk_nomor->HrefValue = "";

            // tanggal_sk
            $this->tanggal_sk->LinkCustomAttributes = "";
            $this->tanggal_sk->HrefValue = "";

            // status_hukuman
            $this->status_hukuman->LinkCustomAttributes = "";
            $this->status_hukuman->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->pid_request_skk->Required) {
            if (!$this->pid_request_skk->IsDetailKey && EmptyValue($this->pid_request_skk->FormValue)) {
                $this->pid_request_skk->addErrorMessage(str_replace("%s", $this->pid_request_skk->caption(), $this->pid_request_skk->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->pid_request_skk->FormValue)) {
            $this->pid_request_skk->addErrorMessage($this->pid_request_skk->getErrorMessage(false));
        }
        if ($this->pernah_dijatuhi_hukuman->Required) {
            if ($this->pernah_dijatuhi_hukuman->FormValue == "") {
                $this->pernah_dijatuhi_hukuman->addErrorMessage(str_replace("%s", $this->pernah_dijatuhi_hukuman->caption(), $this->pernah_dijatuhi_hukuman->RequiredErrorMessage));
            }
        }
        if ($this->jenis_hukuman->Required) {
            if ($this->jenis_hukuman->FormValue == "") {
                $this->jenis_hukuman->addErrorMessage(str_replace("%s", $this->jenis_hukuman->caption(), $this->jenis_hukuman->RequiredErrorMessage));
            }
        }
        if ($this->hukuman->Required) {
            if (!$this->hukuman->IsDetailKey && EmptyValue($this->hukuman->FormValue)) {
                $this->hukuman->addErrorMessage(str_replace("%s", $this->hukuman->caption(), $this->hukuman->RequiredErrorMessage));
            }
        }
        if ($this->pasal->Required) {
            if (!$this->pasal->IsDetailKey && EmptyValue($this->pasal->FormValue)) {
                $this->pasal->addErrorMessage(str_replace("%s", $this->pasal->caption(), $this->pasal->RequiredErrorMessage));
            }
        }
        if ($this->surat_keputusan->Required) {
            if (!$this->surat_keputusan->IsDetailKey && EmptyValue($this->surat_keputusan->FormValue)) {
                $this->surat_keputusan->addErrorMessage(str_replace("%s", $this->surat_keputusan->caption(), $this->surat_keputusan->RequiredErrorMessage));
            }
        }
        if ($this->sk_nomor->Required) {
            if (!$this->sk_nomor->IsDetailKey && EmptyValue($this->sk_nomor->FormValue)) {
                $this->sk_nomor->addErrorMessage(str_replace("%s", $this->sk_nomor->caption(), $this->sk_nomor->RequiredErrorMessage));
            }
        }
        if ($this->tanggal_sk->Required) {
            if (!$this->tanggal_sk->IsDetailKey && EmptyValue($this->tanggal_sk->FormValue)) {
                $this->tanggal_sk->addErrorMessage(str_replace("%s", $this->tanggal_sk->caption(), $this->tanggal_sk->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_sk->FormValue)) {
            $this->tanggal_sk->addErrorMessage($this->tanggal_sk->getErrorMessage(false));
        }
        if ($this->status_hukuman->Required) {
            if ($this->status_hukuman->FormValue == "") {
                $this->status_hukuman->addErrorMessage(str_replace("%s", $this->status_hukuman->caption(), $this->status_hukuman->RequiredErrorMessage));
            }
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // pid_request_skk
        $this->pid_request_skk->setDbValueDef($rsnew, $this->pid_request_skk->CurrentValue, null, false);

        // pernah_dijatuhi_hukuman
        $this->pernah_dijatuhi_hukuman->setDbValueDef($rsnew, $this->pernah_dijatuhi_hukuman->CurrentValue, null, false);

        // jenis_hukuman
        $this->jenis_hukuman->setDbValueDef($rsnew, $this->jenis_hukuman->CurrentValue, null, false);

        // hukuman
        $this->hukuman->setDbValueDef($rsnew, $this->hukuman->CurrentValue, null, false);

        // pasal
        $this->pasal->setDbValueDef($rsnew, $this->pasal->CurrentValue, null, false);

        // surat_keputusan
        $this->surat_keputusan->setDbValueDef($rsnew, $this->surat_keputusan->CurrentValue, null, false);

        // sk_nomor
        $this->sk_nomor->setDbValueDef($rsnew, $this->sk_nomor->CurrentValue, null, false);

        // tanggal_sk
        $this->tanggal_sk->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_sk->CurrentValue, 0), null, false);

        // status_hukuman
        $this->status_hukuman->setDbValueDef($rsnew, $this->status_hukuman->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "v_sekretariat") {
                $validMaster = true;
                $masterTbl = Container("v_sekretariat");
                if (($parm = Get("fk_id_request", Get("pid_request_skk"))) !== null) {
                    $masterTbl->id_request->setQueryStringValue($parm);
                    $this->pid_request_skk->setQueryStringValue($masterTbl->id_request->QueryStringValue);
                    $this->pid_request_skk->setSessionValue($this->pid_request_skk->QueryStringValue);
                    if (!is_numeric($masterTbl->id_request->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "v_sekretariat") {
                $validMaster = true;
                $masterTbl = Container("v_sekretariat");
                if (($parm = Post("fk_id_request", Post("pid_request_skk"))) !== null) {
                    $masterTbl->id_request->setFormValue($parm);
                    $this->pid_request_skk->setFormValue($masterTbl->id_request->FormValue);
                    $this->pid_request_skk->setSessionValue($this->pid_request_skk->FormValue);
                    if (!is_numeric($masterTbl->id_request->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "v_sekretariat") {
                if ($this->pid_request_skk->CurrentValue == "") {
                    $this->pid_request_skk->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("HukumanDisiplinList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_pernah_dijatuhi_hukuman":
                    break;
                case "x_jenis_hukuman":
                    break;
                case "x_surat_keputusan":
                    break;
                case "x_status_hukuman":
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
}
