<?php

namespace PHPMaker2021\eclearance;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class VAswasEdit extends VAswas
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'v_aswas';

    // Page object name
    public $PageObjName = "VAswasEdit";

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

        // Custom template
        $this->UseCustomTemplate = true;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (v_aswas)
        if (!isset($GLOBALS["v_aswas"]) || get_class($GLOBALS["v_aswas"]) == PROJECT_NAMESPACE . "v_aswas") {
            $GLOBALS["v_aswas"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'v_aswas');
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
        if (Post("customexport") === null) {
             // Page Unload event
            if (method_exists($this, "pageUnload")) {
                $this->pageUnload();
            }

            // Global Page Unloaded event (in userfn*.php)
            Page_Unloaded();
        }

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            if (is_array(Session(SESSION_TEMP_IMAGES))) { // Restore temp images
                $TempImages = Session(SESSION_TEMP_IMAGES);
            }
            if (Post("data") !== null) {
                $content = Post("data");
            }
            $ExportFileName = Post("filename", "");
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("v_aswas"));
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
        if ($this->CustomExport) { // Save temp images array for custom export
            if (is_array($TempImages)) {
                $_SESSION[SESSION_TEMP_IMAGES] = $TempImages;
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
                    if ($pageName == "VAswasView") {
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
        $this->id_request->Visible = false;
        $this->tanggal_request->setVisibility();
        $this->nip->setVisibility();
        $this->nrp->setVisibility();
        $this->nama->setVisibility();
        $this->pangkat->setVisibility();
        $this->jabatan->setVisibility();
        $this->unit_organisasi->setVisibility();
        $this->scan_lhkpn->setVisibility();
        $this->scan_lhkasn->setVisibility();
        $this->kategori_pemohon->setVisibility();
        $this->keperluan->setVisibility();
        $this->email_pemohon->setVisibility();
        $this->hukuman_disiplin->setVisibility();
        $this->keterangan->setVisibility();
        $this->status->setVisibility();
        $this->pernah_dijatuhi_hukuman->setVisibility();
        $this->jenis_hukuman->setVisibility();
        $this->hukuman->setVisibility();
        $this->pasal->setVisibility();
        $this->surat_keputusan->setVisibility();
        $this->sk_nomor->setVisibility();
        $this->tanggal_sk->setVisibility();
        $this->status_hukuman->setVisibility();
        $this->mengajukan_keberatan_banding->setVisibility();
        $this->tgl_sk_banding->setVisibility();
        $this->inspeksi_kasus->setVisibility();
        $this->pelanggaran_disiplin->setVisibility();
        $this->sidang_kode_perilaku_jaksa->setVisibility();
        $this->tempat_sidang_kode_perilaku->setVisibility();
        $this->hukuman_administratif->setVisibility();
        $this->sk_nomor_kode_perilaku->setVisibility();
        $this->tgl_sk_kode_perilaku->setVisibility();
        $this->status_hukuman_kode_perilaku->setVisibility();
        $this->sk_banding_nomor->setVisibility();
        $this->hideFieldsForAddEdit();
        $this->nip->Required = false;
        $this->nrp->Required = false;
        $this->nama->Required = false;
        $this->kategori_pemohon->Required = false;
        $this->keperluan->Required = false;
        $this->keterangan->Required = false;

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->pangkat);
        $this->setupLookupOptions($this->jabatan);
        $this->setupLookupOptions($this->unit_organisasi);
        $this->setupLookupOptions($this->keperluan);
        $this->setupLookupOptions($this->surat_keputusan);
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
                    $this->terminate("VAswasList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "VAswasList") {
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

        // Check field name 'unit_organisasi' first before field var 'x_unit_organisasi'
        $val = $CurrentForm->hasValue("unit_organisasi") ? $CurrentForm->getValue("unit_organisasi") : $CurrentForm->getValue("x_unit_organisasi");
        if (!$this->unit_organisasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unit_organisasi->Visible = false; // Disable update for API request
            } else {
                $this->unit_organisasi->setFormValue($val);
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

        // Check field name 'kategori_pemohon' first before field var 'x_kategori_pemohon'
        $val = $CurrentForm->hasValue("kategori_pemohon") ? $CurrentForm->getValue("kategori_pemohon") : $CurrentForm->getValue("x_kategori_pemohon");
        if (!$this->kategori_pemohon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kategori_pemohon->Visible = false; // Disable update for API request
            } else {
                $this->kategori_pemohon->setFormValue($val);
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

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
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
            $this->tanggal_sk->CurrentValue = UnFormatDateTime($this->tanggal_sk->CurrentValue, 7);
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

        // Check field name 'mengajukan_keberatan_banding' first before field var 'x_mengajukan_keberatan_banding'
        $val = $CurrentForm->hasValue("mengajukan_keberatan_banding") ? $CurrentForm->getValue("mengajukan_keberatan_banding") : $CurrentForm->getValue("x_mengajukan_keberatan_banding");
        if (!$this->mengajukan_keberatan_banding->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mengajukan_keberatan_banding->Visible = false; // Disable update for API request
            } else {
                $this->mengajukan_keberatan_banding->setFormValue($val);
            }
        }

        // Check field name 'tgl_sk_banding' first before field var 'x_tgl_sk_banding'
        $val = $CurrentForm->hasValue("tgl_sk_banding") ? $CurrentForm->getValue("tgl_sk_banding") : $CurrentForm->getValue("x_tgl_sk_banding");
        if (!$this->tgl_sk_banding->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgl_sk_banding->Visible = false; // Disable update for API request
            } else {
                $this->tgl_sk_banding->setFormValue($val);
            }
            $this->tgl_sk_banding->CurrentValue = UnFormatDateTime($this->tgl_sk_banding->CurrentValue, 7);
        }

        // Check field name 'inspeksi_kasus' first before field var 'x_inspeksi_kasus'
        $val = $CurrentForm->hasValue("inspeksi_kasus") ? $CurrentForm->getValue("inspeksi_kasus") : $CurrentForm->getValue("x_inspeksi_kasus");
        if (!$this->inspeksi_kasus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->inspeksi_kasus->Visible = false; // Disable update for API request
            } else {
                $this->inspeksi_kasus->setFormValue($val);
            }
        }

        // Check field name 'pelanggaran_disiplin' first before field var 'x_pelanggaran_disiplin'
        $val = $CurrentForm->hasValue("pelanggaran_disiplin") ? $CurrentForm->getValue("pelanggaran_disiplin") : $CurrentForm->getValue("x_pelanggaran_disiplin");
        if (!$this->pelanggaran_disiplin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pelanggaran_disiplin->Visible = false; // Disable update for API request
            } else {
                $this->pelanggaran_disiplin->setFormValue($val);
            }
        }

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
            $this->tgl_sk_kode_perilaku->CurrentValue = UnFormatDateTime($this->tgl_sk_kode_perilaku->CurrentValue, 7);
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

        // Check field name 'sk_banding_nomor' first before field var 'x_sk_banding_nomor'
        $val = $CurrentForm->hasValue("sk_banding_nomor") ? $CurrentForm->getValue("sk_banding_nomor") : $CurrentForm->getValue("x_sk_banding_nomor");
        if (!$this->sk_banding_nomor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sk_banding_nomor->Visible = false; // Disable update for API request
            } else {
                $this->sk_banding_nomor->setFormValue($val);
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
        $this->pangkat->CurrentValue = $this->pangkat->FormValue;
        $this->jabatan->CurrentValue = $this->jabatan->FormValue;
        $this->unit_organisasi->CurrentValue = $this->unit_organisasi->FormValue;
        $this->scan_lhkpn->CurrentValue = $this->scan_lhkpn->FormValue;
        $this->scan_lhkasn->CurrentValue = $this->scan_lhkasn->FormValue;
        $this->kategori_pemohon->CurrentValue = $this->kategori_pemohon->FormValue;
        $this->keperluan->CurrentValue = $this->keperluan->FormValue;
        $this->email_pemohon->CurrentValue = $this->email_pemohon->FormValue;
        $this->hukuman_disiplin->CurrentValue = $this->hukuman_disiplin->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->pernah_dijatuhi_hukuman->CurrentValue = $this->pernah_dijatuhi_hukuman->FormValue;
        $this->jenis_hukuman->CurrentValue = $this->jenis_hukuman->FormValue;
        $this->hukuman->CurrentValue = $this->hukuman->FormValue;
        $this->pasal->CurrentValue = $this->pasal->FormValue;
        $this->surat_keputusan->CurrentValue = $this->surat_keputusan->FormValue;
        $this->sk_nomor->CurrentValue = $this->sk_nomor->FormValue;
        $this->tanggal_sk->CurrentValue = $this->tanggal_sk->FormValue;
        $this->tanggal_sk->CurrentValue = UnFormatDateTime($this->tanggal_sk->CurrentValue, 7);
        $this->status_hukuman->CurrentValue = $this->status_hukuman->FormValue;
        $this->mengajukan_keberatan_banding->CurrentValue = $this->mengajukan_keberatan_banding->FormValue;
        $this->tgl_sk_banding->CurrentValue = $this->tgl_sk_banding->FormValue;
        $this->tgl_sk_banding->CurrentValue = UnFormatDateTime($this->tgl_sk_banding->CurrentValue, 7);
        $this->inspeksi_kasus->CurrentValue = $this->inspeksi_kasus->FormValue;
        $this->pelanggaran_disiplin->CurrentValue = $this->pelanggaran_disiplin->FormValue;
        $this->sidang_kode_perilaku_jaksa->CurrentValue = $this->sidang_kode_perilaku_jaksa->FormValue;
        $this->tempat_sidang_kode_perilaku->CurrentValue = $this->tempat_sidang_kode_perilaku->FormValue;
        $this->hukuman_administratif->CurrentValue = $this->hukuman_administratif->FormValue;
        $this->sk_nomor_kode_perilaku->CurrentValue = $this->sk_nomor_kode_perilaku->FormValue;
        $this->tgl_sk_kode_perilaku->CurrentValue = $this->tgl_sk_kode_perilaku->FormValue;
        $this->tgl_sk_kode_perilaku->CurrentValue = UnFormatDateTime($this->tgl_sk_kode_perilaku->CurrentValue, 7);
        $this->status_hukuman_kode_perilaku->CurrentValue = $this->status_hukuman_kode_perilaku->FormValue;
        $this->sk_banding_nomor->CurrentValue = $this->sk_banding_nomor->FormValue;
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
        $this->pangkat->setDbValue($row['pangkat']);
        $this->jabatan->setDbValue($row['jabatan']);
        $this->unit_organisasi->setDbValue($row['unit_organisasi']);
        $this->scan_lhkpn->setDbValue($row['scan_lhkpn']);
        $this->scan_lhkasn->setDbValue($row['scan_lhkasn']);
        $this->kategori_pemohon->setDbValue($row['kategori_pemohon']);
        $this->keperluan->setDbValue($row['keperluan']);
        $this->email_pemohon->setDbValue($row['email_pemohon']);
        $this->hukuman_disiplin->setDbValue($row['hukuman_disiplin']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->status->setDbValue($row['status']);
        $this->pernah_dijatuhi_hukuman->setDbValue($row['pernah_dijatuhi_hukuman']);
        $this->jenis_hukuman->setDbValue($row['jenis_hukuman']);
        $this->hukuman->setDbValue($row['hukuman']);
        $this->pasal->setDbValue($row['pasal']);
        $this->surat_keputusan->setDbValue($row['surat_keputusan']);
        $this->sk_nomor->setDbValue($row['sk_nomor']);
        $this->tanggal_sk->setDbValue($row['tanggal_sk']);
        $this->status_hukuman->setDbValue($row['status_hukuman']);
        $this->mengajukan_keberatan_banding->setDbValue($row['mengajukan_keberatan_banding']);
        $this->tgl_sk_banding->setDbValue($row['tgl_sk_banding']);
        $this->inspeksi_kasus->setDbValue($row['inspeksi_kasus']);
        $this->pelanggaran_disiplin->setDbValue($row['pelanggaran_disiplin']);
        $this->sidang_kode_perilaku_jaksa->setDbValue($row['sidang_kode_perilaku_jaksa']);
        $this->tempat_sidang_kode_perilaku->setDbValue($row['tempat_sidang_kode_perilaku']);
        $this->hukuman_administratif->setDbValue($row['hukuman_administratif']);
        $this->sk_nomor_kode_perilaku->setDbValue($row['sk_nomor_kode_perilaku']);
        $this->tgl_sk_kode_perilaku->setDbValue($row['tgl_sk_kode_perilaku']);
        $this->status_hukuman_kode_perilaku->setDbValue($row['status_hukuman_kode_perilaku']);
        $this->sk_banding_nomor->setDbValue($row['sk_banding_nomor']);
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
        $row['pangkat'] = null;
        $row['jabatan'] = null;
        $row['unit_organisasi'] = null;
        $row['scan_lhkpn'] = null;
        $row['scan_lhkasn'] = null;
        $row['kategori_pemohon'] = null;
        $row['keperluan'] = null;
        $row['email_pemohon'] = null;
        $row['hukuman_disiplin'] = null;
        $row['keterangan'] = null;
        $row['status'] = null;
        $row['pernah_dijatuhi_hukuman'] = null;
        $row['jenis_hukuman'] = null;
        $row['hukuman'] = null;
        $row['pasal'] = null;
        $row['surat_keputusan'] = null;
        $row['sk_nomor'] = null;
        $row['tanggal_sk'] = null;
        $row['status_hukuman'] = null;
        $row['mengajukan_keberatan_banding'] = null;
        $row['tgl_sk_banding'] = null;
        $row['inspeksi_kasus'] = null;
        $row['pelanggaran_disiplin'] = null;
        $row['sidang_kode_perilaku_jaksa'] = null;
        $row['tempat_sidang_kode_perilaku'] = null;
        $row['hukuman_administratif'] = null;
        $row['sk_nomor_kode_perilaku'] = null;
        $row['tgl_sk_kode_perilaku'] = null;
        $row['status_hukuman_kode_perilaku'] = null;
        $row['sk_banding_nomor'] = null;
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

        // pangkat

        // jabatan

        // unit_organisasi

        // scan_lhkpn

        // scan_lhkasn

        // kategori_pemohon

        // keperluan

        // email_pemohon

        // hukuman_disiplin

        // keterangan

        // status

        // pernah_dijatuhi_hukuman

        // jenis_hukuman

        // hukuman

        // pasal

        // surat_keputusan

        // sk_nomor

        // tanggal_sk

        // status_hukuman

        // mengajukan_keberatan_banding

        // tgl_sk_banding

        // inspeksi_kasus

        // pelanggaran_disiplin

        // sidang_kode_perilaku_jaksa

        // tempat_sidang_kode_perilaku

        // hukuman_administratif

        // sk_nomor_kode_perilaku

        // tgl_sk_kode_perilaku

        // status_hukuman_kode_perilaku

        // sk_banding_nomor
        if ($this->RowType == ROWTYPE_VIEW) {
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
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

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
            $this->tanggal_sk->ViewValue = FormatDateTime($this->tanggal_sk->ViewValue, 7);
            $this->tanggal_sk->ViewCustomAttributes = "";

            // status_hukuman
            if (strval($this->status_hukuman->CurrentValue) != "") {
                $this->status_hukuman->ViewValue = $this->status_hukuman->optionCaption($this->status_hukuman->CurrentValue);
            } else {
                $this->status_hukuman->ViewValue = null;
            }
            $this->status_hukuman->ViewCustomAttributes = "";

            // mengajukan_keberatan_banding
            $this->mengajukan_keberatan_banding->ViewValue = $this->mengajukan_keberatan_banding->CurrentValue;
            $this->mengajukan_keberatan_banding->ViewCustomAttributes = "";

            // tgl_sk_banding
            $this->tgl_sk_banding->ViewValue = $this->tgl_sk_banding->CurrentValue;
            $this->tgl_sk_banding->ViewValue = FormatDateTime($this->tgl_sk_banding->ViewValue, 7);
            $this->tgl_sk_banding->ViewCustomAttributes = "";

            // inspeksi_kasus
            $this->inspeksi_kasus->ViewValue = $this->inspeksi_kasus->CurrentValue;
            $this->inspeksi_kasus->ViewCustomAttributes = "";

            // pelanggaran_disiplin
            $this->pelanggaran_disiplin->ViewValue = $this->pelanggaran_disiplin->CurrentValue;
            $this->pelanggaran_disiplin->ViewCustomAttributes = "";

            // sidang_kode_perilaku_jaksa
            $this->sidang_kode_perilaku_jaksa->ViewValue = $this->sidang_kode_perilaku_jaksa->CurrentValue;
            $this->sidang_kode_perilaku_jaksa->ViewCustomAttributes = "";

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

            // sk_banding_nomor
            $this->sk_banding_nomor->ViewValue = $this->sk_banding_nomor->CurrentValue;
            $this->sk_banding_nomor->ViewCustomAttributes = "";

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

            // pangkat
            $this->pangkat->LinkCustomAttributes = "";
            $this->pangkat->HrefValue = "";
            $this->pangkat->TooltipValue = "";

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";
            $this->jabatan->TooltipValue = "";

            // unit_organisasi
            $this->unit_organisasi->LinkCustomAttributes = "";
            $this->unit_organisasi->HrefValue = "";
            $this->unit_organisasi->TooltipValue = "";

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

            // mengajukan_keberatan_banding
            $this->mengajukan_keberatan_banding->LinkCustomAttributes = "";
            $this->mengajukan_keberatan_banding->HrefValue = "";
            $this->mengajukan_keberatan_banding->TooltipValue = "";

            // tgl_sk_banding
            $this->tgl_sk_banding->LinkCustomAttributes = "";
            $this->tgl_sk_banding->HrefValue = "";
            $this->tgl_sk_banding->TooltipValue = "";

            // inspeksi_kasus
            $this->inspeksi_kasus->LinkCustomAttributes = "";
            $this->inspeksi_kasus->HrefValue = "";
            $this->inspeksi_kasus->TooltipValue = "";

            // pelanggaran_disiplin
            $this->pelanggaran_disiplin->LinkCustomAttributes = "";
            $this->pelanggaran_disiplin->HrefValue = "";
            $this->pelanggaran_disiplin->TooltipValue = "";

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

            // sk_banding_nomor
            $this->sk_banding_nomor->LinkCustomAttributes = "";
            $this->sk_banding_nomor->HrefValue = "";
            $this->sk_banding_nomor->TooltipValue = "";
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

            // email_pemohon
            $this->email_pemohon->EditAttrs["class"] = "form-control";
            $this->email_pemohon->EditCustomAttributes = "";
            $this->email_pemohon->EditValue = $this->email_pemohon->CurrentValue;
            $this->email_pemohon->ViewCustomAttributes = "";

            // hukuman_disiplin
            $this->hukuman_disiplin->EditAttrs["class"] = "form-control";
            $this->hukuman_disiplin->EditCustomAttributes = "";
            if (strval($this->hukuman_disiplin->CurrentValue) != "") {
                $this->hukuman_disiplin->EditValue = $this->hukuman_disiplin->optionCaption($this->hukuman_disiplin->CurrentValue);
            } else {
                $this->hukuman_disiplin->EditValue = null;
            }
            $this->hukuman_disiplin->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // pernah_dijatuhi_hukuman
            $this->pernah_dijatuhi_hukuman->EditAttrs["class"] = "form-control";
            $this->pernah_dijatuhi_hukuman->EditCustomAttributes = "";
            if (strval($this->pernah_dijatuhi_hukuman->CurrentValue) != "") {
                $this->pernah_dijatuhi_hukuman->EditValue = $this->pernah_dijatuhi_hukuman->optionCaption($this->pernah_dijatuhi_hukuman->CurrentValue);
            } else {
                $this->pernah_dijatuhi_hukuman->EditValue = null;
            }
            $this->pernah_dijatuhi_hukuman->ViewCustomAttributes = "";

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

            // mengajukan_keberatan_banding
            $this->mengajukan_keberatan_banding->EditAttrs["class"] = "form-control";
            $this->mengajukan_keberatan_banding->EditCustomAttributes = "";
            $this->mengajukan_keberatan_banding->EditValue = $this->mengajukan_keberatan_banding->CurrentValue;
            $this->mengajukan_keberatan_banding->ViewCustomAttributes = "";

            // tgl_sk_banding
            $this->tgl_sk_banding->EditAttrs["class"] = "form-control";
            $this->tgl_sk_banding->EditCustomAttributes = "";
            $this->tgl_sk_banding->EditValue = $this->tgl_sk_banding->CurrentValue;
            $this->tgl_sk_banding->EditValue = FormatDateTime($this->tgl_sk_banding->EditValue, 7);
            $this->tgl_sk_banding->ViewCustomAttributes = "";

            // inspeksi_kasus
            $this->inspeksi_kasus->EditAttrs["class"] = "form-control";
            $this->inspeksi_kasus->EditCustomAttributes = "";
            $this->inspeksi_kasus->EditValue = $this->inspeksi_kasus->CurrentValue;
            $this->inspeksi_kasus->ViewCustomAttributes = "";

            // pelanggaran_disiplin
            $this->pelanggaran_disiplin->EditAttrs["class"] = "form-control";
            $this->pelanggaran_disiplin->EditCustomAttributes = "";
            $this->pelanggaran_disiplin->EditValue = $this->pelanggaran_disiplin->CurrentValue;
            $this->pelanggaran_disiplin->ViewCustomAttributes = "";

            // sidang_kode_perilaku_jaksa
            $this->sidang_kode_perilaku_jaksa->EditAttrs["class"] = "form-control";
            $this->sidang_kode_perilaku_jaksa->EditCustomAttributes = "";
            $this->sidang_kode_perilaku_jaksa->EditValue = $this->sidang_kode_perilaku_jaksa->CurrentValue;
            $this->sidang_kode_perilaku_jaksa->ViewCustomAttributes = "";

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

            // sk_banding_nomor
            $this->sk_banding_nomor->EditAttrs["class"] = "form-control";
            $this->sk_banding_nomor->EditCustomAttributes = "";
            $this->sk_banding_nomor->EditValue = $this->sk_banding_nomor->CurrentValue;
            $this->sk_banding_nomor->ViewCustomAttributes = "";

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

            // pangkat
            $this->pangkat->LinkCustomAttributes = "";
            $this->pangkat->HrefValue = "";
            $this->pangkat->TooltipValue = "";

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";
            $this->jabatan->TooltipValue = "";

            // unit_organisasi
            $this->unit_organisasi->LinkCustomAttributes = "";
            $this->unit_organisasi->HrefValue = "";
            $this->unit_organisasi->TooltipValue = "";

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

            // mengajukan_keberatan_banding
            $this->mengajukan_keberatan_banding->LinkCustomAttributes = "";
            $this->mengajukan_keberatan_banding->HrefValue = "";
            $this->mengajukan_keberatan_banding->TooltipValue = "";

            // tgl_sk_banding
            $this->tgl_sk_banding->LinkCustomAttributes = "";
            $this->tgl_sk_banding->HrefValue = "";
            $this->tgl_sk_banding->TooltipValue = "";

            // inspeksi_kasus
            $this->inspeksi_kasus->LinkCustomAttributes = "";
            $this->inspeksi_kasus->HrefValue = "";
            $this->inspeksi_kasus->TooltipValue = "";

            // pelanggaran_disiplin
            $this->pelanggaran_disiplin->LinkCustomAttributes = "";
            $this->pelanggaran_disiplin->HrefValue = "";
            $this->pelanggaran_disiplin->TooltipValue = "";

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

            // sk_banding_nomor
            $this->sk_banding_nomor->LinkCustomAttributes = "";
            $this->sk_banding_nomor->HrefValue = "";
            $this->sk_banding_nomor->TooltipValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }

        // Save data for Custom Template
        if ($this->RowType == ROWTYPE_VIEW || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_ADD) {
            $this->Rows[] = $this->customTemplateFieldValues();
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
        if ($this->unit_organisasi->Required) {
            if (!$this->unit_organisasi->IsDetailKey && EmptyValue($this->unit_organisasi->FormValue)) {
                $this->unit_organisasi->addErrorMessage(str_replace("%s", $this->unit_organisasi->caption(), $this->unit_organisasi->RequiredErrorMessage));
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
        if ($this->kategori_pemohon->Required) {
            if ($this->kategori_pemohon->FormValue == "") {
                $this->kategori_pemohon->addErrorMessage(str_replace("%s", $this->kategori_pemohon->caption(), $this->kategori_pemohon->RequiredErrorMessage));
            }
        }
        if ($this->keperluan->Required) {
            if (!$this->keperluan->IsDetailKey && EmptyValue($this->keperluan->FormValue)) {
                $this->keperluan->addErrorMessage(str_replace("%s", $this->keperluan->caption(), $this->keperluan->RequiredErrorMessage));
            }
        }
        if ($this->email_pemohon->Required) {
            if (!$this->email_pemohon->IsDetailKey && EmptyValue($this->email_pemohon->FormValue)) {
                $this->email_pemohon->addErrorMessage(str_replace("%s", $this->email_pemohon->caption(), $this->email_pemohon->RequiredErrorMessage));
            }
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
        if ($this->status->Required) {
            if ($this->status->FormValue == "") {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
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
        if ($this->status_hukuman->Required) {
            if ($this->status_hukuman->FormValue == "") {
                $this->status_hukuman->addErrorMessage(str_replace("%s", $this->status_hukuman->caption(), $this->status_hukuman->RequiredErrorMessage));
            }
        }
        if ($this->mengajukan_keberatan_banding->Required) {
            if (!$this->mengajukan_keberatan_banding->IsDetailKey && EmptyValue($this->mengajukan_keberatan_banding->FormValue)) {
                $this->mengajukan_keberatan_banding->addErrorMessage(str_replace("%s", $this->mengajukan_keberatan_banding->caption(), $this->mengajukan_keberatan_banding->RequiredErrorMessage));
            }
        }
        if ($this->tgl_sk_banding->Required) {
            if (!$this->tgl_sk_banding->IsDetailKey && EmptyValue($this->tgl_sk_banding->FormValue)) {
                $this->tgl_sk_banding->addErrorMessage(str_replace("%s", $this->tgl_sk_banding->caption(), $this->tgl_sk_banding->RequiredErrorMessage));
            }
        }
        if ($this->inspeksi_kasus->Required) {
            if (!$this->inspeksi_kasus->IsDetailKey && EmptyValue($this->inspeksi_kasus->FormValue)) {
                $this->inspeksi_kasus->addErrorMessage(str_replace("%s", $this->inspeksi_kasus->caption(), $this->inspeksi_kasus->RequiredErrorMessage));
            }
        }
        if ($this->pelanggaran_disiplin->Required) {
            if (!$this->pelanggaran_disiplin->IsDetailKey && EmptyValue($this->pelanggaran_disiplin->FormValue)) {
                $this->pelanggaran_disiplin->addErrorMessage(str_replace("%s", $this->pelanggaran_disiplin->caption(), $this->pelanggaran_disiplin->RequiredErrorMessage));
            }
        }
        if ($this->sidang_kode_perilaku_jaksa->Required) {
            if (!$this->sidang_kode_perilaku_jaksa->IsDetailKey && EmptyValue($this->sidang_kode_perilaku_jaksa->FormValue)) {
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
        if ($this->status_hukuman_kode_perilaku->Required) {
            if ($this->status_hukuman_kode_perilaku->FormValue == "") {
                $this->status_hukuman_kode_perilaku->addErrorMessage(str_replace("%s", $this->status_hukuman_kode_perilaku->caption(), $this->status_hukuman_kode_perilaku->RequiredErrorMessage));
            }
        }
        if ($this->sk_banding_nomor->Required) {
            if (!$this->sk_banding_nomor->IsDetailKey && EmptyValue($this->sk_banding_nomor->FormValue)) {
                $this->sk_banding_nomor->addErrorMessage(str_replace("%s", $this->sk_banding_nomor->caption(), $this->sk_banding_nomor->RequiredErrorMessage));
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("VAswasList"), "", $this->TableVar, true);
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
                case "x_pangkat":
                    break;
                case "x_jabatan":
                    break;
                case "x_unit_organisasi":
                    break;
                case "x_kategori_pemohon":
                    break;
                case "x_keperluan":
                    break;
                case "x_hukuman_disiplin":
                    break;
                case "x_status":
                    break;
                case "x_pernah_dijatuhi_hukuman":
                    break;
                case "x_jenis_hukuman":
                    break;
                case "x_surat_keputusan":
                    break;
                case "x_status_hukuman":
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
