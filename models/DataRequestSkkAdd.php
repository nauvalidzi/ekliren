<?php

namespace PHPMaker2021\eclearance;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class DataRequestSkkAdd extends DataRequestSkk
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'data_request_skk';

    // Page object name
    public $PageObjName = "DataRequestSkkAdd";

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

        // Table object (data_request_skk)
        if (!isset($GLOBALS["data_request_skk"]) || get_class($GLOBALS["data_request_skk"]) == PROJECT_NAMESPACE . "data_request_skk") {
            $GLOBALS["data_request_skk"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'data_request_skk');
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
                $doc = new $class(Container("data_request_skk"));
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
                    if ($pageName == "DataRequestSkkView") {
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
        $this->id_request->Visible = false;
        $this->nomor_surat->Visible = false;
        $this->tanggal_request->setVisibility();
        $this->nrp->setVisibility();
        $this->nip->setVisibility();
        $this->nama->setVisibility();
        $this->unit_organisasi->setVisibility();
        $this->pangkat->setVisibility();
        $this->jabatan->setVisibility();
        $this->keperluan->setVisibility();
        $this->kategori_pemohon->setVisibility();
        $this->scan_lhkpn->setVisibility();
        $this->scan_lhkasn->setVisibility();
        $this->email_pemohon->setVisibility();
        $this->hukuman_disiplin->setVisibility();
        $this->keterangan->setVisibility();
        $this->status->Visible = false;
        $this->acc->Visible = false;
        $this->hasil_acc->Visible = false;
        $this->user_id->Visible = false;
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
        $this->setupLookupOptions($this->unit_organisasi);
        $this->setupLookupOptions($this->pangkat);
        $this->setupLookupOptions($this->jabatan);
        $this->setupLookupOptions($this->keperluan);

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
            if (($keyValue = Get("id_request") ?? Route("id_request")) !== null) {
                $this->id_request->setQueryStringValue($keyValue);
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
                    $this->terminate("DataRequestSkkList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "DataRequestSkkList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "DataRequestSkkView") {
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
        $this->scan_lhkpn->Upload->Index = $CurrentForm->Index;
        $this->scan_lhkpn->Upload->uploadFile();
        $this->scan_lhkpn->CurrentValue = $this->scan_lhkpn->Upload->FileName;
        $this->scan_lhkasn->Upload->Index = $CurrentForm->Index;
        $this->scan_lhkasn->Upload->uploadFile();
        $this->scan_lhkasn->CurrentValue = $this->scan_lhkasn->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id_request->CurrentValue = null;
        $this->id_request->OldValue = $this->id_request->CurrentValue;
        $this->nomor_surat->CurrentValue = 0;
        $this->tanggal_request->CurrentValue = null;
        $this->tanggal_request->OldValue = $this->tanggal_request->CurrentValue;
        $this->nrp->CurrentValue = null;
        $this->nrp->OldValue = $this->nrp->CurrentValue;
        $this->nip->CurrentValue = null;
        $this->nip->OldValue = $this->nip->CurrentValue;
        $this->nama->CurrentValue = null;
        $this->nama->OldValue = $this->nama->CurrentValue;
        $this->unit_organisasi->CurrentValue = 0;
        $this->pangkat->CurrentValue = 0;
        $this->jabatan->CurrentValue = 0;
        $this->keperluan->CurrentValue = null;
        $this->keperluan->OldValue = $this->keperluan->CurrentValue;
        $this->kategori_pemohon->CurrentValue = null;
        $this->kategori_pemohon->OldValue = $this->kategori_pemohon->CurrentValue;
        $this->scan_lhkpn->Upload->DbValue = null;
        $this->scan_lhkpn->OldValue = $this->scan_lhkpn->Upload->DbValue;
        $this->scan_lhkpn->CurrentValue = null; // Clear file related field
        $this->scan_lhkasn->Upload->DbValue = null;
        $this->scan_lhkasn->OldValue = $this->scan_lhkasn->Upload->DbValue;
        $this->scan_lhkasn->CurrentValue = null; // Clear file related field
        $this->email_pemohon->CurrentValue = null;
        $this->email_pemohon->OldValue = $this->email_pemohon->CurrentValue;
        $this->hukuman_disiplin->CurrentValue = null;
        $this->hukuman_disiplin->OldValue = $this->hukuman_disiplin->CurrentValue;
        $this->keterangan->CurrentValue = null;
        $this->keterangan->OldValue = $this->keterangan->CurrentValue;
        $this->status->CurrentValue = null;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->acc->CurrentValue = null;
        $this->acc->OldValue = $this->acc->CurrentValue;
        $this->hasil_acc->CurrentValue = null;
        $this->hasil_acc->OldValue = $this->hasil_acc->CurrentValue;
        $this->user_id->CurrentValue = null;
        $this->user_id->OldValue = $this->user_id->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'tanggal_request' first before field var 'x_tanggal_request'
        $val = $CurrentForm->hasValue("tanggal_request") ? $CurrentForm->getValue("tanggal_request") : $CurrentForm->getValue("x_tanggal_request");
        if (!$this->tanggal_request->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_request->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_request->setFormValue($val);
            }
            $this->tanggal_request->CurrentValue = UnFormatDateTime($this->tanggal_request->CurrentValue, 7);
        }

        // Check field name 'nrp' first before field var 'x_nrp'
        $val = $CurrentForm->hasValue("nrp") ? $CurrentForm->getValue("nrp") : $CurrentForm->getValue("x_nrp");
        if (!$this->nrp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nrp->Visible = false; // Disable update for API request
            } else {
                $this->nrp->setFormValue($val);
            }
        }

        // Check field name 'nip' first before field var 'x_nip'
        $val = $CurrentForm->hasValue("nip") ? $CurrentForm->getValue("nip") : $CurrentForm->getValue("x_nip");
        if (!$this->nip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nip->Visible = false; // Disable update for API request
            } else {
                $this->nip->setFormValue($val);
            }
        }

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
        }

        // Check field name 'unit_organisasi' first before field var 'x_unit_organisasi'
        $val = $CurrentForm->hasValue("unit_organisasi") ? $CurrentForm->getValue("unit_organisasi") : $CurrentForm->getValue("x_unit_organisasi");
        if (!$this->unit_organisasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unit_organisasi->Visible = false; // Disable update for API request
            } else {
                $this->unit_organisasi->setFormValue($val);
            }
        }

        // Check field name 'pangkat' first before field var 'x_pangkat'
        $val = $CurrentForm->hasValue("pangkat") ? $CurrentForm->getValue("pangkat") : $CurrentForm->getValue("x_pangkat");
        if (!$this->pangkat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pangkat->Visible = false; // Disable update for API request
            } else {
                $this->pangkat->setFormValue($val);
            }
        }

        // Check field name 'jabatan' first before field var 'x_jabatan'
        $val = $CurrentForm->hasValue("jabatan") ? $CurrentForm->getValue("jabatan") : $CurrentForm->getValue("x_jabatan");
        if (!$this->jabatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jabatan->Visible = false; // Disable update for API request
            } else {
                $this->jabatan->setFormValue($val);
            }
        }

        // Check field name 'keperluan' first before field var 'x_keperluan'
        $val = $CurrentForm->hasValue("keperluan") ? $CurrentForm->getValue("keperluan") : $CurrentForm->getValue("x_keperluan");
        if (!$this->keperluan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keperluan->Visible = false; // Disable update for API request
            } else {
                $this->keperluan->setFormValue($val);
            }
        }

        // Check field name 'kategori_pemohon' first before field var 'x_kategori_pemohon'
        $val = $CurrentForm->hasValue("kategori_pemohon") ? $CurrentForm->getValue("kategori_pemohon") : $CurrentForm->getValue("x_kategori_pemohon");
        if (!$this->kategori_pemohon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kategori_pemohon->Visible = false; // Disable update for API request
            } else {
                $this->kategori_pemohon->setFormValue($val);
            }
        }

        // Check field name 'email_pemohon' first before field var 'x_email_pemohon'
        $val = $CurrentForm->hasValue("email_pemohon") ? $CurrentForm->getValue("email_pemohon") : $CurrentForm->getValue("x_email_pemohon");
        if (!$this->email_pemohon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->email_pemohon->Visible = false; // Disable update for API request
            } else {
                $this->email_pemohon->setFormValue($val);
            }
        }

        // Check field name 'hukuman_disiplin' first before field var 'x_hukuman_disiplin'
        $val = $CurrentForm->hasValue("hukuman_disiplin") ? $CurrentForm->getValue("hukuman_disiplin") : $CurrentForm->getValue("x_hukuman_disiplin");
        if (!$this->hukuman_disiplin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hukuman_disiplin->Visible = false; // Disable update for API request
            } else {
                $this->hukuman_disiplin->setFormValue($val);
            }
        }

        // Check field name 'keterangan' first before field var 'x_keterangan'
        $val = $CurrentForm->hasValue("keterangan") ? $CurrentForm->getValue("keterangan") : $CurrentForm->getValue("x_keterangan");
        if (!$this->keterangan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keterangan->Visible = false; // Disable update for API request
            } else {
                $this->keterangan->setFormValue($val);
            }
        }

        // Check field name 'id_request' first before field var 'x_id_request'
        $val = $CurrentForm->hasValue("id_request") ? $CurrentForm->getValue("id_request") : $CurrentForm->getValue("x_id_request");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->tanggal_request->CurrentValue = $this->tanggal_request->FormValue;
        $this->tanggal_request->CurrentValue = UnFormatDateTime($this->tanggal_request->CurrentValue, 7);
        $this->nrp->CurrentValue = $this->nrp->FormValue;
        $this->nip->CurrentValue = $this->nip->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->unit_organisasi->CurrentValue = $this->unit_organisasi->FormValue;
        $this->pangkat->CurrentValue = $this->pangkat->FormValue;
        $this->jabatan->CurrentValue = $this->jabatan->FormValue;
        $this->keperluan->CurrentValue = $this->keperluan->FormValue;
        $this->kategori_pemohon->CurrentValue = $this->kategori_pemohon->FormValue;
        $this->email_pemohon->CurrentValue = $this->email_pemohon->FormValue;
        $this->hukuman_disiplin->CurrentValue = $this->hukuman_disiplin->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
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

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id_request'] = $this->id_request->CurrentValue;
        $row['nomor_surat'] = $this->nomor_surat->CurrentValue;
        $row['tanggal_request'] = $this->tanggal_request->CurrentValue;
        $row['nrp'] = $this->nrp->CurrentValue;
        $row['nip'] = $this->nip->CurrentValue;
        $row['nama'] = $this->nama->CurrentValue;
        $row['unit_organisasi'] = $this->unit_organisasi->CurrentValue;
        $row['pangkat'] = $this->pangkat->CurrentValue;
        $row['jabatan'] = $this->jabatan->CurrentValue;
        $row['keperluan'] = $this->keperluan->CurrentValue;
        $row['kategori_pemohon'] = $this->kategori_pemohon->CurrentValue;
        $row['scan_lhkpn'] = $this->scan_lhkpn->Upload->DbValue;
        $row['scan_lhkasn'] = $this->scan_lhkasn->Upload->DbValue;
        $row['email_pemohon'] = $this->email_pemohon->CurrentValue;
        $row['hukuman_disiplin'] = $this->hukuman_disiplin->CurrentValue;
        $row['keterangan'] = $this->keterangan->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['acc'] = $this->acc->CurrentValue;
        $row['hasil_acc'] = $this->hasil_acc->CurrentValue;
        $row['user_id'] = $this->user_id->CurrentValue;
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

        // user_id
        if ($this->RowType == ROWTYPE_VIEW) {
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

            // user_id
            $this->user_id->ViewValue = $this->user_id->CurrentValue;
            $this->user_id->ViewValue = FormatNumber($this->user_id->ViewValue, 0, -2, -2, -2);
            $this->user_id->ViewCustomAttributes = "";

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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // tanggal_request

            // nrp
            $this->nrp->EditAttrs["class"] = "form-control";
            $this->nrp->EditCustomAttributes = "";
            if (!$this->nrp->Raw) {
                $this->nrp->CurrentValue = HtmlDecode($this->nrp->CurrentValue);
            }
            $this->nrp->EditValue = HtmlEncode($this->nrp->CurrentValue);
            $this->nrp->PlaceHolder = RemoveHtml($this->nrp->caption());

            // nip
            $this->nip->EditAttrs["class"] = "form-control";
            $this->nip->EditCustomAttributes = "";
            if (!$this->nip->Raw) {
                $this->nip->CurrentValue = HtmlDecode($this->nip->CurrentValue);
            }
            $this->nip->EditValue = HtmlEncode($this->nip->CurrentValue);
            $this->nip->PlaceHolder = RemoveHtml($this->nip->caption());

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // unit_organisasi
            $this->unit_organisasi->EditAttrs["class"] = "form-control";
            $this->unit_organisasi->EditCustomAttributes = "";
            $curVal = trim(strval($this->unit_organisasi->CurrentValue));
            if ($curVal != "") {
                $this->unit_organisasi->ViewValue = $this->unit_organisasi->lookupCacheOption($curVal);
            } else {
                $this->unit_organisasi->ViewValue = $this->unit_organisasi->Lookup !== null && is_array($this->unit_organisasi->Lookup->Options) ? $curVal : null;
            }
            if ($this->unit_organisasi->ViewValue !== null) { // Load from cache
                $this->unit_organisasi->EditValue = array_values($this->unit_organisasi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->unit_organisasi->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->unit_organisasi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->unit_organisasi->EditValue = $arwrk;
            }
            $this->unit_organisasi->PlaceHolder = RemoveHtml($this->unit_organisasi->caption());

            // pangkat
            $this->pangkat->EditAttrs["class"] = "form-control";
            $this->pangkat->EditCustomAttributes = "";
            $curVal = trim(strval($this->pangkat->CurrentValue));
            if ($curVal != "") {
                $this->pangkat->ViewValue = $this->pangkat->lookupCacheOption($curVal);
            } else {
                $this->pangkat->ViewValue = $this->pangkat->Lookup !== null && is_array($this->pangkat->Lookup->Options) ? $curVal : null;
            }
            if ($this->pangkat->ViewValue !== null) { // Load from cache
                $this->pangkat->EditValue = array_values($this->pangkat->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->pangkat->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->pangkat->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->pangkat->EditValue = $arwrk;
            }
            $this->pangkat->PlaceHolder = RemoveHtml($this->pangkat->caption());

            // jabatan
            $this->jabatan->EditAttrs["class"] = "form-control";
            $this->jabatan->EditCustomAttributes = "";
            $curVal = trim(strval($this->jabatan->CurrentValue));
            if ($curVal != "") {
                $this->jabatan->ViewValue = $this->jabatan->lookupCacheOption($curVal);
            } else {
                $this->jabatan->ViewValue = $this->jabatan->Lookup !== null && is_array($this->jabatan->Lookup->Options) ? $curVal : null;
            }
            if ($this->jabatan->ViewValue !== null) { // Load from cache
                $this->jabatan->EditValue = array_values($this->jabatan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->jabatan->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->jabatan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->jabatan->EditValue = $arwrk;
            }
            $this->jabatan->PlaceHolder = RemoveHtml($this->jabatan->caption());

            // keperluan
            $this->keperluan->EditAttrs["class"] = "form-control";
            $this->keperluan->EditCustomAttributes = "";
            $curVal = trim(strval($this->keperluan->CurrentValue));
            if ($curVal != "") {
                $this->keperluan->ViewValue = $this->keperluan->lookupCacheOption($curVal);
            } else {
                $this->keperluan->ViewValue = $this->keperluan->Lookup !== null && is_array($this->keperluan->Lookup->Options) ? $curVal : null;
            }
            if ($this->keperluan->ViewValue !== null) { // Load from cache
                $this->keperluan->EditValue = array_values($this->keperluan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->keperluan->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->keperluan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->keperluan->EditValue = $arwrk;
            }
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
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->scan_lhkpn);
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
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->scan_lhkasn);
            }

            // email_pemohon
            $this->email_pemohon->EditAttrs["class"] = "form-control";
            $this->email_pemohon->EditCustomAttributes = "";
            if (!$this->email_pemohon->Raw) {
                $this->email_pemohon->CurrentValue = HtmlDecode($this->email_pemohon->CurrentValue);
            }
            $this->email_pemohon->EditValue = HtmlEncode($this->email_pemohon->CurrentValue);
            $this->email_pemohon->PlaceHolder = RemoveHtml($this->email_pemohon->caption());

            // hukuman_disiplin
            $this->hukuman_disiplin->EditCustomAttributes = "";
            $this->hukuman_disiplin->EditValue = $this->hukuman_disiplin->options(false);
            $this->hukuman_disiplin->PlaceHolder = RemoveHtml($this->hukuman_disiplin->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // Add refer script

            // tanggal_request
            $this->tanggal_request->LinkCustomAttributes = "";
            $this->tanggal_request->HrefValue = "";

            // nrp
            $this->nrp->LinkCustomAttributes = "";
            $this->nrp->HrefValue = "";

            // nip
            $this->nip->LinkCustomAttributes = "";
            $this->nip->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // unit_organisasi
            $this->unit_organisasi->LinkCustomAttributes = "";
            $this->unit_organisasi->HrefValue = "";

            // pangkat
            $this->pangkat->LinkCustomAttributes = "";
            $this->pangkat->HrefValue = "";

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";

            // keperluan
            $this->keperluan->LinkCustomAttributes = "";
            $this->keperluan->HrefValue = "";

            // kategori_pemohon
            $this->kategori_pemohon->LinkCustomAttributes = "";
            $this->kategori_pemohon->HrefValue = "";

            // scan_lhkpn
            $this->scan_lhkpn->LinkCustomAttributes = "";
            $this->scan_lhkpn->HrefValue = "";
            $this->scan_lhkpn->ExportHrefValue = $this->scan_lhkpn->UploadPath . $this->scan_lhkpn->Upload->DbValue;

            // scan_lhkasn
            $this->scan_lhkasn->LinkCustomAttributes = "";
            $this->scan_lhkasn->HrefValue = "";
            $this->scan_lhkasn->ExportHrefValue = $this->scan_lhkasn->UploadPath . $this->scan_lhkasn->Upload->DbValue;

            // email_pemohon
            $this->email_pemohon->LinkCustomAttributes = "";
            $this->email_pemohon->HrefValue = "";

            // hukuman_disiplin
            $this->hukuman_disiplin->LinkCustomAttributes = "";
            $this->hukuman_disiplin->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
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
        if ($this->tanggal_request->Required) {
            if (!$this->tanggal_request->IsDetailKey && EmptyValue($this->tanggal_request->FormValue)) {
                $this->tanggal_request->addErrorMessage(str_replace("%s", $this->tanggal_request->caption(), $this->tanggal_request->RequiredErrorMessage));
            }
        }
        if ($this->nrp->Required) {
            if (!$this->nrp->IsDetailKey && EmptyValue($this->nrp->FormValue)) {
                $this->nrp->addErrorMessage(str_replace("%s", $this->nrp->caption(), $this->nrp->RequiredErrorMessage));
            }
        }
        if ($this->nip->Required) {
            if (!$this->nip->IsDetailKey && EmptyValue($this->nip->FormValue)) {
                $this->nip->addErrorMessage(str_replace("%s", $this->nip->caption(), $this->nip->RequiredErrorMessage));
            }
        }
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->unit_organisasi->Required) {
            if (!$this->unit_organisasi->IsDetailKey && EmptyValue($this->unit_organisasi->FormValue)) {
                $this->unit_organisasi->addErrorMessage(str_replace("%s", $this->unit_organisasi->caption(), $this->unit_organisasi->RequiredErrorMessage));
            }
        }
        if ($this->pangkat->Required) {
            if (!$this->pangkat->IsDetailKey && EmptyValue($this->pangkat->FormValue)) {
                $this->pangkat->addErrorMessage(str_replace("%s", $this->pangkat->caption(), $this->pangkat->RequiredErrorMessage));
            }
        }
        if ($this->jabatan->Required) {
            if (!$this->jabatan->IsDetailKey && EmptyValue($this->jabatan->FormValue)) {
                $this->jabatan->addErrorMessage(str_replace("%s", $this->jabatan->caption(), $this->jabatan->RequiredErrorMessage));
            }
        }
        if ($this->keperluan->Required) {
            if (!$this->keperluan->IsDetailKey && EmptyValue($this->keperluan->FormValue)) {
                $this->keperluan->addErrorMessage(str_replace("%s", $this->keperluan->caption(), $this->keperluan->RequiredErrorMessage));
            }
        }
        if ($this->kategori_pemohon->Required) {
            if ($this->kategori_pemohon->FormValue == "") {
                $this->kategori_pemohon->addErrorMessage(str_replace("%s", $this->kategori_pemohon->caption(), $this->kategori_pemohon->RequiredErrorMessage));
            }
        }
        if ($this->scan_lhkpn->Required) {
            if ($this->scan_lhkpn->Upload->FileName == "" && !$this->scan_lhkpn->Upload->KeepFile) {
                $this->scan_lhkpn->addErrorMessage(str_replace("%s", $this->scan_lhkpn->caption(), $this->scan_lhkpn->RequiredErrorMessage));
            }
        }
        if ($this->scan_lhkasn->Required) {
            if ($this->scan_lhkasn->Upload->FileName == "" && !$this->scan_lhkasn->Upload->KeepFile) {
                $this->scan_lhkasn->addErrorMessage(str_replace("%s", $this->scan_lhkasn->caption(), $this->scan_lhkasn->RequiredErrorMessage));
            }
        }
        if ($this->email_pemohon->Required) {
            if (!$this->email_pemohon->IsDetailKey && EmptyValue($this->email_pemohon->FormValue)) {
                $this->email_pemohon->addErrorMessage(str_replace("%s", $this->email_pemohon->caption(), $this->email_pemohon->RequiredErrorMessage));
            }
        }
        if (!CheckEmail($this->email_pemohon->FormValue)) {
            $this->email_pemohon->addErrorMessage($this->email_pemohon->getErrorMessage(false));
        }
        if ($this->hukuman_disiplin->Required) {
            if ($this->hukuman_disiplin->FormValue == "") {
                $this->hukuman_disiplin->addErrorMessage(str_replace("%s", $this->hukuman_disiplin->caption(), $this->hukuman_disiplin->RequiredErrorMessage));
            }
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
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

        // tanggal_request
        $this->tanggal_request->CurrentValue = CurrentDateTime();
        $this->tanggal_request->setDbValueDef($rsnew, $this->tanggal_request->CurrentValue, CurrentDate());

        // nrp
        $this->nrp->setDbValueDef($rsnew, $this->nrp->CurrentValue, "", false);

        // nip
        $this->nip->setDbValueDef($rsnew, $this->nip->CurrentValue, "", false);

        // nama
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, "", false);

        // unit_organisasi
        $this->unit_organisasi->setDbValueDef($rsnew, $this->unit_organisasi->CurrentValue, 0, strval($this->unit_organisasi->CurrentValue) == "");

        // pangkat
        $this->pangkat->setDbValueDef($rsnew, $this->pangkat->CurrentValue, 0, strval($this->pangkat->CurrentValue) == "");

        // jabatan
        $this->jabatan->setDbValueDef($rsnew, $this->jabatan->CurrentValue, 0, strval($this->jabatan->CurrentValue) == "");

        // keperluan
        $this->keperluan->setDbValueDef($rsnew, $this->keperluan->CurrentValue, 0, false);

        // kategori_pemohon
        $this->kategori_pemohon->setDbValueDef($rsnew, $this->kategori_pemohon->CurrentValue, "", false);

        // scan_lhkpn
        if ($this->scan_lhkpn->Visible && !$this->scan_lhkpn->Upload->KeepFile) {
            $this->scan_lhkpn->Upload->DbValue = ""; // No need to delete old file
            if ($this->scan_lhkpn->Upload->FileName == "") {
                $rsnew['scan_lhkpn'] = null;
            } else {
                $rsnew['scan_lhkpn'] = $this->scan_lhkpn->Upload->FileName;
            }
        }

        // scan_lhkasn
        if ($this->scan_lhkasn->Visible && !$this->scan_lhkasn->Upload->KeepFile) {
            $this->scan_lhkasn->Upload->DbValue = ""; // No need to delete old file
            if ($this->scan_lhkasn->Upload->FileName == "") {
                $rsnew['scan_lhkasn'] = null;
            } else {
                $rsnew['scan_lhkasn'] = $this->scan_lhkasn->Upload->FileName;
            }
        }

        // email_pemohon
        $this->email_pemohon->setDbValueDef($rsnew, $this->email_pemohon->CurrentValue, null, false);

        // hukuman_disiplin
        $this->hukuman_disiplin->setDbValueDef($rsnew, $this->hukuman_disiplin->CurrentValue, null, false);

        // keterangan
        $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, null, false);
        if ($this->scan_lhkpn->Visible && !$this->scan_lhkpn->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->scan_lhkpn->Upload->DbValue) ? [] : [$this->scan_lhkpn->htmlDecode($this->scan_lhkpn->Upload->DbValue)];
            if (!EmptyValue($this->scan_lhkpn->Upload->FileName)) {
                $newFiles = [$this->scan_lhkpn->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->scan_lhkpn, $this->scan_lhkpn->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->scan_lhkpn->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->scan_lhkpn->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->scan_lhkpn->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->scan_lhkpn->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->scan_lhkpn->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->scan_lhkpn->setDbValueDef($rsnew, $this->scan_lhkpn->Upload->FileName, null, false);
            }
        }
        if ($this->scan_lhkasn->Visible && !$this->scan_lhkasn->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->scan_lhkasn->Upload->DbValue) ? [] : [$this->scan_lhkasn->htmlDecode($this->scan_lhkasn->Upload->DbValue)];
            if (!EmptyValue($this->scan_lhkasn->Upload->FileName)) {
                $newFiles = [$this->scan_lhkasn->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->scan_lhkasn, $this->scan_lhkasn->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->scan_lhkasn->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->scan_lhkasn->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->scan_lhkasn->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->scan_lhkasn->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->scan_lhkasn->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->scan_lhkasn->setDbValueDef($rsnew, $this->scan_lhkasn->Upload->FileName, null, false);
            }
        }

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
                if ($this->scan_lhkpn->Visible && !$this->scan_lhkpn->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->scan_lhkpn->Upload->DbValue) ? [] : [$this->scan_lhkpn->htmlDecode($this->scan_lhkpn->Upload->DbValue)];
                    if (!EmptyValue($this->scan_lhkpn->Upload->FileName)) {
                        $newFiles = [$this->scan_lhkpn->Upload->FileName];
                        $newFiles2 = [$this->scan_lhkpn->htmlDecode($rsnew['scan_lhkpn'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->scan_lhkpn, $this->scan_lhkpn->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->scan_lhkpn->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->scan_lhkpn->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->scan_lhkasn->Visible && !$this->scan_lhkasn->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->scan_lhkasn->Upload->DbValue) ? [] : [$this->scan_lhkasn->htmlDecode($this->scan_lhkasn->Upload->DbValue)];
                    if (!EmptyValue($this->scan_lhkasn->Upload->FileName)) {
                        $newFiles = [$this->scan_lhkasn->Upload->FileName];
                        $newFiles2 = [$this->scan_lhkasn->htmlDecode($rsnew['scan_lhkasn'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->scan_lhkasn, $this->scan_lhkasn->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->scan_lhkasn->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->scan_lhkasn->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
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
            if ($this->SendEmail) {
                $this->sendEmailOnAdd($rsnew);
            }
        }

        // Clean upload path if any
        if ($addRow) {
            // scan_lhkpn
            CleanUploadTempPath($this->scan_lhkpn, $this->scan_lhkpn->Upload->Index);

            // scan_lhkasn
            CleanUploadTempPath($this->scan_lhkasn, $this->scan_lhkasn->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("DataRequestSkkList"), "", $this->TableVar, true);
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
                case "x_unit_organisasi":
                    break;
                case "x_pangkat":
                    break;
                case "x_jabatan":
                    break;
                case "x_keperluan":
                    break;
                case "x_kategori_pemohon":
                    break;
                case "x_hukuman_disiplin":
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
    	$satker = CurrentUserInfo('unit_organisasi');
    	if($satker != '' OR $satker != FALSE){
    		$this->unit_organisasi->CurrentValue = $satker;
    		$this->unit_organisasi->ReadOnly = TRUE;
    	}
        //Log("Page Render");
        $this->hukuman_disiplin->CurrentValue = 'Tidak';
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
