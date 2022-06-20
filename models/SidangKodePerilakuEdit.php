<?php

namespace PHPMaker2021\eclearance;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class SidangKodePerilakuEdit extends SidangKodePerilaku
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'sidang_kode_perilaku';

    // Page object name
    public $PageObjName = "SidangKodePerilakuEdit";

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

        // Table object (sidang_kode_perilaku)
        if (!isset($GLOBALS["sidang_kode_perilaku"]) || get_class($GLOBALS["sidang_kode_perilaku"]) == PROJECT_NAMESPACE . "sidang_kode_perilaku") {
            $GLOBALS["sidang_kode_perilaku"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sidang_kode_perilaku');
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
                $doc = new $class(Container("sidang_kode_perilaku"));
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
                    if ($pageName == "SidangKodePerilakuView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->pid_request_skk->Visible = false;
        $this->sidang_kode_perilaku_jaksa->setVisibility();
        $this->tempat_sidang_kode_perilaku->setVisibility();
        $this->hukuman_administratif->setVisibility();
        $this->sk_nomor_kode_perilaku->setVisibility();
        $this->tgl_sk_kode_perilaku->setVisibility();
        $this->status_hukuman_kode_perilaku->setVisibility();
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
        $this->setupLookupOptions($this->tempat_sidang_kode_perilaku);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("SidangKodePerilakuList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "SidangKodePerilakuList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'sidang_kode_perilaku_jaksa' first before field var 'x_sidang_kode_perilaku_jaksa'
        $val = $CurrentForm->hasValue("sidang_kode_perilaku_jaksa") ? $CurrentForm->getValue("sidang_kode_perilaku_jaksa") : $CurrentForm->getValue("x_sidang_kode_perilaku_jaksa");
        if (!$this->sidang_kode_perilaku_jaksa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sidang_kode_perilaku_jaksa->Visible = false; // Disable update for API request
            } else {
                $this->sidang_kode_perilaku_jaksa->setFormValue($val);
            }
        }

        // Check field name 'tempat_sidang_kode_perilaku' first before field var 'x_tempat_sidang_kode_perilaku'
        $val = $CurrentForm->hasValue("tempat_sidang_kode_perilaku") ? $CurrentForm->getValue("tempat_sidang_kode_perilaku") : $CurrentForm->getValue("x_tempat_sidang_kode_perilaku");
        if (!$this->tempat_sidang_kode_perilaku->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tempat_sidang_kode_perilaku->Visible = false; // Disable update for API request
            } else {
                $this->tempat_sidang_kode_perilaku->setFormValue($val);
            }
        }

        // Check field name 'hukuman_administratif' first before field var 'x_hukuman_administratif'
        $val = $CurrentForm->hasValue("hukuman_administratif") ? $CurrentForm->getValue("hukuman_administratif") : $CurrentForm->getValue("x_hukuman_administratif");
        if (!$this->hukuman_administratif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hukuman_administratif->Visible = false; // Disable update for API request
            } else {
                $this->hukuman_administratif->setFormValue($val);
            }
        }

        // Check field name 'sk_nomor_kode_perilaku' first before field var 'x_sk_nomor_kode_perilaku'
        $val = $CurrentForm->hasValue("sk_nomor_kode_perilaku") ? $CurrentForm->getValue("sk_nomor_kode_perilaku") : $CurrentForm->getValue("x_sk_nomor_kode_perilaku");
        if (!$this->sk_nomor_kode_perilaku->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sk_nomor_kode_perilaku->Visible = false; // Disable update for API request
            } else {
                $this->sk_nomor_kode_perilaku->setFormValue($val);
            }
        }

        // Check field name 'tgl_sk_kode_perilaku' first before field var 'x_tgl_sk_kode_perilaku'
        $val = $CurrentForm->hasValue("tgl_sk_kode_perilaku") ? $CurrentForm->getValue("tgl_sk_kode_perilaku") : $CurrentForm->getValue("x_tgl_sk_kode_perilaku");
        if (!$this->tgl_sk_kode_perilaku->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgl_sk_kode_perilaku->Visible = false; // Disable update for API request
            } else {
                $this->tgl_sk_kode_perilaku->setFormValue($val);
            }
            $this->tgl_sk_kode_perilaku->CurrentValue = UnFormatDateTime($this->tgl_sk_kode_perilaku->CurrentValue, 0);
        }

        // Check field name 'status_hukuman_kode_perilaku' first before field var 'x_status_hukuman_kode_perilaku'
        $val = $CurrentForm->hasValue("status_hukuman_kode_perilaku") ? $CurrentForm->getValue("status_hukuman_kode_perilaku") : $CurrentForm->getValue("x_status_hukuman_kode_perilaku");
        if (!$this->status_hukuman_kode_perilaku->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_hukuman_kode_perilaku->Visible = false; // Disable update for API request
            } else {
                $this->status_hukuman_kode_perilaku->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->sidang_kode_perilaku_jaksa->CurrentValue = $this->sidang_kode_perilaku_jaksa->FormValue;
        $this->tempat_sidang_kode_perilaku->CurrentValue = $this->tempat_sidang_kode_perilaku->FormValue;
        $this->hukuman_administratif->CurrentValue = $this->hukuman_administratif->FormValue;
        $this->sk_nomor_kode_perilaku->CurrentValue = $this->sk_nomor_kode_perilaku->FormValue;
        $this->tgl_sk_kode_perilaku->CurrentValue = $this->tgl_sk_kode_perilaku->FormValue;
        $this->tgl_sk_kode_perilaku->CurrentValue = UnFormatDateTime($this->tgl_sk_kode_perilaku->CurrentValue, 0);
        $this->status_hukuman_kode_perilaku->CurrentValue = $this->status_hukuman_kode_perilaku->FormValue;
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
        $this->sidang_kode_perilaku_jaksa->setDbValue($row['sidang_kode_perilaku_jaksa']);
        $this->tempat_sidang_kode_perilaku->setDbValue($row['tempat_sidang_kode_perilaku']);
        $this->hukuman_administratif->setDbValue($row['hukuman_administratif']);
        $this->sk_nomor_kode_perilaku->setDbValue($row['sk_nomor_kode_perilaku']);
        $this->tgl_sk_kode_perilaku->setDbValue($row['tgl_sk_kode_perilaku']);
        $this->status_hukuman_kode_perilaku->setDbValue($row['status_hukuman_kode_perilaku']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['pid_request_skk'] = null;
        $row['sidang_kode_perilaku_jaksa'] = null;
        $row['tempat_sidang_kode_perilaku'] = null;
        $row['hukuman_administratif'] = null;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // pid_request_skk

        // sidang_kode_perilaku_jaksa

        // tempat_sidang_kode_perilaku

        // hukuman_administratif

        // sk_nomor_kode_perilaku

        // tgl_sk_kode_perilaku

        // status_hukuman_kode_perilaku
        if ($this->RowType == ROWTYPE_VIEW) {
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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // sidang_kode_perilaku_jaksa
            $this->sidang_kode_perilaku_jaksa->EditCustomAttributes = "";
            $this->sidang_kode_perilaku_jaksa->EditValue = $this->sidang_kode_perilaku_jaksa->options(false);
            $this->sidang_kode_perilaku_jaksa->PlaceHolder = RemoveHtml($this->sidang_kode_perilaku_jaksa->caption());

            // tempat_sidang_kode_perilaku
            $this->tempat_sidang_kode_perilaku->EditAttrs["class"] = "form-control";
            $this->tempat_sidang_kode_perilaku->EditCustomAttributes = "";
            $curVal = trim(strval($this->tempat_sidang_kode_perilaku->CurrentValue));
            if ($curVal != "") {
                $this->tempat_sidang_kode_perilaku->ViewValue = $this->tempat_sidang_kode_perilaku->lookupCacheOption($curVal);
            } else {
                $this->tempat_sidang_kode_perilaku->ViewValue = $this->tempat_sidang_kode_perilaku->Lookup !== null && is_array($this->tempat_sidang_kode_perilaku->Lookup->Options) ? $curVal : null;
            }
            if ($this->tempat_sidang_kode_perilaku->ViewValue !== null) { // Load from cache
                $this->tempat_sidang_kode_perilaku->EditValue = array_values($this->tempat_sidang_kode_perilaku->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->tempat_sidang_kode_perilaku->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->tempat_sidang_kode_perilaku->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tempat_sidang_kode_perilaku->EditValue = $arwrk;
            }
            $this->tempat_sidang_kode_perilaku->PlaceHolder = RemoveHtml($this->tempat_sidang_kode_perilaku->caption());

            // hukuman_administratif
            $this->hukuman_administratif->EditAttrs["class"] = "form-control";
            $this->hukuman_administratif->EditCustomAttributes = "";
            if (!$this->hukuman_administratif->Raw) {
                $this->hukuman_administratif->CurrentValue = HtmlDecode($this->hukuman_administratif->CurrentValue);
            }
            $this->hukuman_administratif->EditValue = HtmlEncode($this->hukuman_administratif->CurrentValue);
            $this->hukuman_administratif->PlaceHolder = RemoveHtml($this->hukuman_administratif->caption());

            // sk_nomor_kode_perilaku
            $this->sk_nomor_kode_perilaku->EditAttrs["class"] = "form-control";
            $this->sk_nomor_kode_perilaku->EditCustomAttributes = "";
            if (!$this->sk_nomor_kode_perilaku->Raw) {
                $this->sk_nomor_kode_perilaku->CurrentValue = HtmlDecode($this->sk_nomor_kode_perilaku->CurrentValue);
            }
            $this->sk_nomor_kode_perilaku->EditValue = HtmlEncode($this->sk_nomor_kode_perilaku->CurrentValue);
            $this->sk_nomor_kode_perilaku->PlaceHolder = RemoveHtml($this->sk_nomor_kode_perilaku->caption());

            // tgl_sk_kode_perilaku
            $this->tgl_sk_kode_perilaku->EditAttrs["class"] = "form-control";
            $this->tgl_sk_kode_perilaku->EditCustomAttributes = "";
            $this->tgl_sk_kode_perilaku->EditValue = HtmlEncode(FormatDateTime($this->tgl_sk_kode_perilaku->CurrentValue, 8));
            $this->tgl_sk_kode_perilaku->PlaceHolder = RemoveHtml($this->tgl_sk_kode_perilaku->caption());

            // status_hukuman_kode_perilaku
            $this->status_hukuman_kode_perilaku->EditCustomAttributes = "";
            $this->status_hukuman_kode_perilaku->EditValue = $this->status_hukuman_kode_perilaku->options(false);
            $this->status_hukuman_kode_perilaku->PlaceHolder = RemoveHtml($this->status_hukuman_kode_perilaku->caption());

            // Edit refer script

            // sidang_kode_perilaku_jaksa
            $this->sidang_kode_perilaku_jaksa->LinkCustomAttributes = "";
            $this->sidang_kode_perilaku_jaksa->HrefValue = "";

            // tempat_sidang_kode_perilaku
            $this->tempat_sidang_kode_perilaku->LinkCustomAttributes = "";
            $this->tempat_sidang_kode_perilaku->HrefValue = "";

            // hukuman_administratif
            $this->hukuman_administratif->LinkCustomAttributes = "";
            $this->hukuman_administratif->HrefValue = "";

            // sk_nomor_kode_perilaku
            $this->sk_nomor_kode_perilaku->LinkCustomAttributes = "";
            $this->sk_nomor_kode_perilaku->HrefValue = "";

            // tgl_sk_kode_perilaku
            $this->tgl_sk_kode_perilaku->LinkCustomAttributes = "";
            $this->tgl_sk_kode_perilaku->HrefValue = "";

            // status_hukuman_kode_perilaku
            $this->status_hukuman_kode_perilaku->LinkCustomAttributes = "";
            $this->status_hukuman_kode_perilaku->HrefValue = "";
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
        if ($this->sidang_kode_perilaku_jaksa->Required) {
            if ($this->sidang_kode_perilaku_jaksa->FormValue == "") {
                $this->sidang_kode_perilaku_jaksa->addErrorMessage(str_replace("%s", $this->sidang_kode_perilaku_jaksa->caption(), $this->sidang_kode_perilaku_jaksa->RequiredErrorMessage));
            }
        }
        if ($this->tempat_sidang_kode_perilaku->Required) {
            if (!$this->tempat_sidang_kode_perilaku->IsDetailKey && EmptyValue($this->tempat_sidang_kode_perilaku->FormValue)) {
                $this->tempat_sidang_kode_perilaku->addErrorMessage(str_replace("%s", $this->tempat_sidang_kode_perilaku->caption(), $this->tempat_sidang_kode_perilaku->RequiredErrorMessage));
            }
        }
        if ($this->hukuman_administratif->Required) {
            if (!$this->hukuman_administratif->IsDetailKey && EmptyValue($this->hukuman_administratif->FormValue)) {
                $this->hukuman_administratif->addErrorMessage(str_replace("%s", $this->hukuman_administratif->caption(), $this->hukuman_administratif->RequiredErrorMessage));
            }
        }
        if ($this->sk_nomor_kode_perilaku->Required) {
            if (!$this->sk_nomor_kode_perilaku->IsDetailKey && EmptyValue($this->sk_nomor_kode_perilaku->FormValue)) {
                $this->sk_nomor_kode_perilaku->addErrorMessage(str_replace("%s", $this->sk_nomor_kode_perilaku->caption(), $this->sk_nomor_kode_perilaku->RequiredErrorMessage));
            }
        }
        if ($this->tgl_sk_kode_perilaku->Required) {
            if (!$this->tgl_sk_kode_perilaku->IsDetailKey && EmptyValue($this->tgl_sk_kode_perilaku->FormValue)) {
                $this->tgl_sk_kode_perilaku->addErrorMessage(str_replace("%s", $this->tgl_sk_kode_perilaku->caption(), $this->tgl_sk_kode_perilaku->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgl_sk_kode_perilaku->FormValue)) {
            $this->tgl_sk_kode_perilaku->addErrorMessage($this->tgl_sk_kode_perilaku->getErrorMessage(false));
        }
        if ($this->status_hukuman_kode_perilaku->Required) {
            if ($this->status_hukuman_kode_perilaku->FormValue == "") {
                $this->status_hukuman_kode_perilaku->addErrorMessage(str_replace("%s", $this->status_hukuman_kode_perilaku->caption(), $this->status_hukuman_kode_perilaku->RequiredErrorMessage));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // sidang_kode_perilaku_jaksa
            $this->sidang_kode_perilaku_jaksa->setDbValueDef($rsnew, $this->sidang_kode_perilaku_jaksa->CurrentValue, null, $this->sidang_kode_perilaku_jaksa->ReadOnly);

            // tempat_sidang_kode_perilaku
            $this->tempat_sidang_kode_perilaku->setDbValueDef($rsnew, $this->tempat_sidang_kode_perilaku->CurrentValue, null, $this->tempat_sidang_kode_perilaku->ReadOnly);

            // hukuman_administratif
            $this->hukuman_administratif->setDbValueDef($rsnew, $this->hukuman_administratif->CurrentValue, null, $this->hukuman_administratif->ReadOnly);

            // sk_nomor_kode_perilaku
            $this->sk_nomor_kode_perilaku->setDbValueDef($rsnew, $this->sk_nomor_kode_perilaku->CurrentValue, null, $this->sk_nomor_kode_perilaku->ReadOnly);

            // tgl_sk_kode_perilaku
            $this->tgl_sk_kode_perilaku->setDbValueDef($rsnew, UnFormatDateTime($this->tgl_sk_kode_perilaku->CurrentValue, 0), null, $this->tgl_sk_kode_perilaku->ReadOnly);

            // status_hukuman_kode_perilaku
            $this->status_hukuman_kode_perilaku->setDbValueDef($rsnew, $this->status_hukuman_kode_perilaku->CurrentValue, null, $this->status_hukuman_kode_perilaku->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
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
            $this->setSessionWhere($this->getDetailFilter());

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("SidangKodePerilakuList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_sidang_kode_perilaku_jaksa":
                    break;
                case "x_tempat_sidang_kode_perilaku":
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
}
