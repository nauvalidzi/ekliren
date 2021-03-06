<?php

namespace PHPMaker2021\eclearance;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class VSekretariatEdit extends VSekretariat
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'v_sekretariat';

    // Page object name
    public $PageObjName = "VSekretariatEdit";

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

        // Table object (v_sekretariat)
        if (!isset($GLOBALS["v_sekretariat"]) || get_class($GLOBALS["v_sekretariat"]) == PROJECT_NAMESPACE . "v_sekretariat") {
            $GLOBALS["v_sekretariat"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'v_sekretariat');
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
                $doc = new $class(Container("v_sekretariat"));
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
                    if ($pageName == "VSekretariatView") {
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
    public $DetailPages; // Detail pages object

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
        $this->tanggal_request->setVisibility();
        $this->nip->setVisibility();
        $this->nrp->setVisibility();
        $this->nama->setVisibility();
        $this->unit_organisasi->setVisibility();
        $this->pangkat->setVisibility();
        $this->jabatan->setVisibility();
        $this->keperluan->setVisibility();
        $this->kategori_pemohon->Visible = false;
        $this->scan_lhkpn->setVisibility();
        $this->scan_lhkasn->setVisibility();
        $this->keterangan->setVisibility();
        $this->nomor_surat->setVisibility();
        $this->acc->setVisibility();
        $this->status->setVisibility();
        $this->hideFieldsForAddEdit();
        $this->nip->Required = false;
        $this->nrp->Required = false;
        $this->nama->Required = false;
        $this->keperluan->Required = false;

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Set up detail page object
        $this->setupDetailPages();

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
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id_request") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_request->setQueryStringValue($keyValue);
                $this->id_request->setOldValue($this->id_request->QueryStringValue);
            } elseif (Post("id_request") !== null) {
                $this->id_request->setFormValue(Post("id_request"));
                $this->id_request->setOldValue($this->id_request->FormValue);
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
                if (($keyValue = Get("id_request") ?? Route("id_request")) !== null) {
                    $this->id_request->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_request->CurrentValue = null;
                }
            }

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

            // Set up detail parameters
            $this->setupDetailParms();
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
                    $this->terminate("VSekretariatList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                $returnUrl = "VSekretariatList";
                if (GetPageName($returnUrl) == "VSekretariatList") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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

        // Check field name 'tanggal_request' first before field var 'x_tanggal_request'
        $val = $CurrentForm->hasValue("tanggal_request") ? $CurrentForm->getValue("tanggal_request") : $CurrentForm->getValue("x_tanggal_request");
        if (!$this->tanggal_request->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_request->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_request->setFormValue($val);
            }
            $this->tanggal_request->CurrentValue = UnFormatDateTime($this->tanggal_request->CurrentValue, 117);
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

        // Check field name 'nrp' first before field var 'x_nrp'
        $val = $CurrentForm->hasValue("nrp") ? $CurrentForm->getValue("nrp") : $CurrentForm->getValue("x_nrp");
        if (!$this->nrp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nrp->Visible = false; // Disable update for API request
            } else {
                $this->nrp->setFormValue($val);
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

        // Check field name 'scan_lhkpn' first before field var 'x_scan_lhkpn'
        $val = $CurrentForm->hasValue("scan_lhkpn") ? $CurrentForm->getValue("scan_lhkpn") : $CurrentForm->getValue("x_scan_lhkpn");
        if (!$this->scan_lhkpn->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->scan_lhkpn->Visible = false; // Disable update for API request
            } else {
                $this->scan_lhkpn->setFormValue($val);
            }
        }

        // Check field name 'scan_lhkasn' first before field var 'x_scan_lhkasn'
        $val = $CurrentForm->hasValue("scan_lhkasn") ? $CurrentForm->getValue("scan_lhkasn") : $CurrentForm->getValue("x_scan_lhkasn");
        if (!$this->scan_lhkasn->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->scan_lhkasn->Visible = false; // Disable update for API request
            } else {
                $this->scan_lhkasn->setFormValue($val);
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

        // Check field name 'nomor_surat' first before field var 'x_nomor_surat'
        $val = $CurrentForm->hasValue("nomor_surat") ? $CurrentForm->getValue("nomor_surat") : $CurrentForm->getValue("x_nomor_surat");
        if (!$this->nomor_surat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nomor_surat->Visible = false; // Disable update for API request
            } else {
                $this->nomor_surat->setFormValue($val);
            }
        }

        // Check field name 'acc' first before field var 'x_acc'
        $val = $CurrentForm->hasValue("acc") ? $CurrentForm->getValue("acc") : $CurrentForm->getValue("x_acc");
        if (!$this->acc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->acc->Visible = false; // Disable update for API request
            } else {
                $this->acc->setFormValue($val);
            }
            $this->acc->CurrentValue = UnFormatDateTime($this->acc->CurrentValue, 0);
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }

        // Check field name 'id_request' first before field var 'x_id_request'
        $val = $CurrentForm->hasValue("id_request") ? $CurrentForm->getValue("id_request") : $CurrentForm->getValue("x_id_request");
        if (!$this->id_request->IsDetailKey) {
            $this->id_request->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_request->CurrentValue = $this->id_request->FormValue;
        $this->tanggal_request->CurrentValue = $this->tanggal_request->FormValue;
        $this->tanggal_request->CurrentValue = UnFormatDateTime($this->tanggal_request->CurrentValue, 117);
        $this->nip->CurrentValue = $this->nip->FormValue;
        $this->nrp->CurrentValue = $this->nrp->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->unit_organisasi->CurrentValue = $this->unit_organisasi->FormValue;
        $this->pangkat->CurrentValue = $this->pangkat->FormValue;
        $this->jabatan->CurrentValue = $this->jabatan->FormValue;
        $this->keperluan->CurrentValue = $this->keperluan->FormValue;
        $this->scan_lhkpn->CurrentValue = $this->scan_lhkpn->FormValue;
        $this->scan_lhkasn->CurrentValue = $this->scan_lhkasn->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
        $this->nomor_surat->CurrentValue = $this->nomor_surat->FormValue;
        $this->acc->CurrentValue = $this->acc->FormValue;
        $this->acc->CurrentValue = UnFormatDateTime($this->acc->CurrentValue, 0);
        $this->status->CurrentValue = $this->status->FormValue;
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
        $this->keperluan->setDbValue($row['keperluan']);
        $this->kategori_pemohon->setDbValue($row['kategori_pemohon']);
        $this->scan_lhkpn->setDbValue($row['scan_lhkpn']);
        $this->scan_lhkasn->setDbValue($row['scan_lhkasn']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->nomor_surat->setDbValue($row['nomor_surat']);
        $this->acc->setDbValue($row['acc']);
        $this->status->setDbValue($row['status']);
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
        $row['keperluan'] = null;
        $row['kategori_pemohon'] = null;
        $row['scan_lhkpn'] = null;
        $row['scan_lhkasn'] = null;
        $row['keterangan'] = null;
        $row['nomor_surat'] = null;
        $row['acc'] = null;
        $row['status'] = null;
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

        // nomor_surat

        // acc

        // status
        if ($this->RowType == ROWTYPE_VIEW) {
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
            $this->scan_lhkpn->ViewValue = $this->scan_lhkpn->CurrentValue;
            $this->scan_lhkpn->ViewCustomAttributes = "";

            // scan_lhkasn
            $this->scan_lhkasn->ViewValue = $this->scan_lhkasn->CurrentValue;
            $this->scan_lhkasn->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // nomor_surat
            $this->nomor_surat->ViewValue = $this->nomor_surat->CurrentValue;
            $this->nomor_surat->ViewCustomAttributes = "";

            // acc
            $this->acc->ViewValue = $this->acc->CurrentValue;
            $this->acc->ViewValue = FormatDateTime($this->acc->ViewValue, 0);
            $this->acc->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

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

            // nomor_surat
            $this->nomor_surat->LinkCustomAttributes = "";
            $this->nomor_surat->HrefValue = "";
            $this->nomor_surat->TooltipValue = "";

            // acc
            $this->acc->LinkCustomAttributes = "";
            $this->acc->HrefValue = "";
            $this->acc->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
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

            // nomor_surat
            $this->nomor_surat->EditAttrs["class"] = "form-control";
            $this->nomor_surat->EditCustomAttributes = "";
            if (!$this->nomor_surat->Raw) {
                $this->nomor_surat->CurrentValue = HtmlDecode($this->nomor_surat->CurrentValue);
            }
            $this->nomor_surat->EditValue = HtmlEncode($this->nomor_surat->CurrentValue);
            $this->nomor_surat->PlaceHolder = RemoveHtml($this->nomor_surat->caption());

            // acc
            $this->acc->EditAttrs["class"] = "form-control";
            $this->acc->EditCustomAttributes = "";
            $this->acc->EditValue = HtmlEncode(FormatDateTime($this->acc->CurrentValue, 8));
            $this->acc->PlaceHolder = RemoveHtml($this->acc->caption());

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // Edit refer script

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

            // nomor_surat
            $this->nomor_surat->LinkCustomAttributes = "";
            $this->nomor_surat->HrefValue = "";

            // acc
            $this->acc->LinkCustomAttributes = "";
            $this->acc->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
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
        if ($this->nip->Required) {
            if (!$this->nip->IsDetailKey && EmptyValue($this->nip->FormValue)) {
                $this->nip->addErrorMessage(str_replace("%s", $this->nip->caption(), $this->nip->RequiredErrorMessage));
            }
        }
        if ($this->nrp->Required) {
            if (!$this->nrp->IsDetailKey && EmptyValue($this->nrp->FormValue)) {
                $this->nrp->addErrorMessage(str_replace("%s", $this->nrp->caption(), $this->nrp->RequiredErrorMessage));
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
        if ($this->scan_lhkpn->Required) {
            if (!$this->scan_lhkpn->IsDetailKey && EmptyValue($this->scan_lhkpn->FormValue)) {
                $this->scan_lhkpn->addErrorMessage(str_replace("%s", $this->scan_lhkpn->caption(), $this->scan_lhkpn->RequiredErrorMessage));
            }
        }
        if ($this->scan_lhkasn->Required) {
            if (!$this->scan_lhkasn->IsDetailKey && EmptyValue($this->scan_lhkasn->FormValue)) {
                $this->scan_lhkasn->addErrorMessage(str_replace("%s", $this->scan_lhkasn->caption(), $this->scan_lhkasn->RequiredErrorMessage));
            }
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
            }
        }
        if ($this->nomor_surat->Required) {
            if (!$this->nomor_surat->IsDetailKey && EmptyValue($this->nomor_surat->FormValue)) {
                $this->nomor_surat->addErrorMessage(str_replace("%s", $this->nomor_surat->caption(), $this->nomor_surat->RequiredErrorMessage));
            }
        }
        if ($this->acc->Required) {
            if (!$this->acc->IsDetailKey && EmptyValue($this->acc->FormValue)) {
                $this->acc->addErrorMessage(str_replace("%s", $this->acc->caption(), $this->acc->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->acc->FormValue)) {
            $this->acc->addErrorMessage($this->acc->getErrorMessage(false));
        }
        if ($this->status->Required) {
            if ($this->status->FormValue == "") {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("HukumanDisiplinGrid");
        if (in_array("hukuman_disiplin", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("BandingGrid");
        if (in_array("banding", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("InspeksiGrid");
        if (in_array("inspeksi", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("SidangKodePerilakuGrid");
        if (in_array("sidang_kode_perilaku", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
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
            // Begin transaction
            if ($this->getCurrentDetailTable() != "") {
                $conn->beginTransaction();
            }

            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // nomor_surat
            $this->nomor_surat->setDbValueDef($rsnew, $this->nomor_surat->CurrentValue, null, $this->nomor_surat->ReadOnly);

            // acc
            $this->acc->setDbValueDef($rsnew, UnFormatDateTime($this->acc->CurrentValue, 0), null, $this->acc->ReadOnly);

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, $this->status->ReadOnly);

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

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("HukumanDisiplinGrid");
                    if (in_array("hukuman_disiplin", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "hukuman_disiplin"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("BandingGrid");
                    if (in_array("banding", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "banding"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("InspeksiGrid");
                    if (in_array("inspeksi", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "inspeksi"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("SidangKodePerilakuGrid");
                    if (in_array("sidang_kode_perilaku", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "sidang_kode_perilaku"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }

                // Commit/Rollback transaction
                if ($this->getCurrentDetailTable() != "") {
                    if ($editRow) {
                        $conn->commit(); // Commit transaction
                    } else {
                        $conn->rollback(); // Rollback transaction
                    }
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

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("hukuman_disiplin", $detailTblVar)) {
                $detailPageObj = Container("HukumanDisiplinGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid_request_skk->IsDetailKey = true;
                    $detailPageObj->pid_request_skk->CurrentValue = $this->id_request->CurrentValue;
                    $detailPageObj->pid_request_skk->setSessionValue($detailPageObj->pid_request_skk->CurrentValue);
                }
            }
            if (in_array("banding", $detailTblVar)) {
                $detailPageObj = Container("BandingGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid_request_skk->IsDetailKey = true;
                    $detailPageObj->pid_request_skk->CurrentValue = $this->id_request->CurrentValue;
                    $detailPageObj->pid_request_skk->setSessionValue($detailPageObj->pid_request_skk->CurrentValue);
                }
            }
            if (in_array("inspeksi", $detailTblVar)) {
                $detailPageObj = Container("InspeksiGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid_request_skk->IsDetailKey = true;
                    $detailPageObj->pid_request_skk->CurrentValue = $this->id_request->CurrentValue;
                    $detailPageObj->pid_request_skk->setSessionValue($detailPageObj->pid_request_skk->CurrentValue);
                }
            }
            if (in_array("sidang_kode_perilaku", $detailTblVar)) {
                $detailPageObj = Container("SidangKodePerilakuGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid_request_skk->IsDetailKey = true;
                    $detailPageObj->pid_request_skk->CurrentValue = $this->id_request->CurrentValue;
                    $detailPageObj->pid_request_skk->setSessionValue($detailPageObj->pid_request_skk->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("VSekretariatList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('hukuman_disiplin');
        $pages->add('banding');
        $pages->add('inspeksi');
        $pages->add('sidang_kode_perilaku');
        $this->DetailPages = $pages;
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
                case "x_status":
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
