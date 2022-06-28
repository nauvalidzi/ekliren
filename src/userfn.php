<?php

namespace PHPMaker2021\eclearance;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions

// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    // Return false if menu item not allowed
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

function url(){
  return "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"], 2).'/';
}

function base_url($uri_param=null) {
    return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ?  "https" : "http") . "://".$_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']).'/'.$uri_param;
}

function update_massal($data, $type, $verifikator) {
    $status = true;
    switch ($verifikator) {
        case 'sekretariat':
            $status_skk = ($type == 'accept') ? 'ACC_SEKRETARIAT' : 'REJECT_SEKRETARIAT';
            break;
        case 'pemeriksa':
            $status_skk = ($type == 'accept') ? 'ACC_PEMERIKSA' : 'REJECT_PEMERIKSA';
            break;
        case 'aswas':
            $status_skk = ($type == 'accept') ? 'ACC_ASWAS' : 'REJECT_ASWAS';
            break;
        // case 'kajati':
        //     $status_skk = (strpos($type,"accept") !== FALSE) ? 'Sudah di ACC Kajati' : 'Request ditolak Kajati';
        //     $acc = ", acc =  '".date('Y-m-d')."', ttd_pemeriksa = 1, ttd_aswas = 1";
        //     break;
        default:
            // code...
            break;
    }
    foreach ($data as $key => $value) {
        $update = ExecuteUpdate("UPDATE data_request_skk SET status = '{$status_skk}' WHERE id_request = {$value}");
        $riwayat = ExecuteUpdate("INSERT INTO riwayat_acc (id_skk, status, verifikator, tanggal) VALUES ({$value}, '{$status_skk}', '{$verifikator}', '".date('Y-m-d H:i:s')."')");
        if (!$update && !$riwayat) {
            $status = false;
        }
    }
    return $status;
}
$API_ACTIONS["sekretariat-massal"] = function(Request $request, Response &$response) {
    $type = Param("type", Route(1));
    $items = Param("items", Route(2));
    $data = explode(',', urldecode($items));
    $status = update_massal($data, $type, 'sekretariat');
    WriteJson(['status' => $status]);
};
$API_ACTIONS["pemeriksa-massal"] = function(Request $request, Response &$response) {
    $type = Param("type", Route(1));
    $items = Param("items", Route(2));
    $data = explode(',', urldecode($items));
    $status = update_massal($data, $type, 'pemeriksa');
    WriteJson(['status' => $status]);
};
$API_ACTIONS["aswas-massal"] = function(Request $request, Response &$response) {
    $type = Param("type", Route(1));
    $items = Param("items", Route(2));
    $data = explode(',', urldecode($items));
    $status = update_massal($data, $type, 'aswas');
    WriteJson(['status' => $status]);
};
$API_ACTIONS["kajati-massal"] = function(Request $request, Response &$response) {
    $type = Param("type", Route(1));
    $items = Param("items", Route(2));
    $data = explode(',', urldecode($items));
    $status = update_massal($data, $type, 'kajati');
    WriteJson(['status' => $status]);
};
$API_ACTIONS["grafik-tahun"] = function(Request $request, Response &$response) {
    // $type = Param("type", Route(1));
    $query = ExecuteQuery("SELECT DATE_FORMAT(tanggal_request, '%Y') AS `tahun`, COUNT(id_request) AS `total`
                            FROM data_request_skk
                            GROUP BY DATE_FORMAT(tanggal_request, '%Y')");
    $data = [];
    foreach ($query->fetchAll() as $key => $value) {
        $data[$key]['tahun'] = $value['tahun'];
        $data[$key]['total'] = $value['total'];
    }
    echo json_encode($data);
};
$API_ACTIONS["grafik-bulan"] = function(Request $request, Response &$response) {
    $tahun = Param("tahun", Route(1));
    if (empty($tahun)) {
        return WriteJson('');
    }
    $query = ExecuteQuery("SELECT DATE_FORMAT(tanggal_request, '%m') AS `bulan`,COUNT(id_request_skk) AS `total`
                            FROM data_request_skk
                            WHERE YEAR(tanggal_request) = '{$tahun}'
                            GROUP BY DATE_FORMAT(tanggal_request, '%m')");
    $data = [];
    foreach ($query->fetchAll() as $key => $value) {
        $data[$key]['bulan'] = $value['bulan'];
        $data[$key]['total'] = $value['total'];
    }
    echo json_encode($data);
};

function tgl_indo($tanggal, $month_only="no"){
	//if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $tanggal)) {
    //    return '----NIHIL----';
    //}
    $bulan = [
        '----NIHIL----',
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $pecahkan = explode('-', date('Y-m-d', strtotime($tanggal)));
    if ($month_only == "yes") {
        return $bulan[(int) @$pecahkan[1]] . ' ' . $pecahkan[0];
    }
    if (is_array($pecahkan)) {
        return @$pecahkan[2] . ' ' .  $bulan[ (int) @$pecahkan[1] ] . ' ' . @$pecahkan[0];
    }
    return "----NIHIL----";
}
