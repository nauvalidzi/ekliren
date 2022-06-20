<?php

namespace PHPMaker2021\eclearance;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // data_request_skk
    $app->any('/DataRequestSkkList[/{id_request}]', DataRequestSkkController::class . ':list')->add(PermissionMiddleware::class)->setName('DataRequestSkkList-data_request_skk-list'); // list
    $app->any('/DataRequestSkkAdd[/{id_request}]', DataRequestSkkController::class . ':add')->add(PermissionMiddleware::class)->setName('DataRequestSkkAdd-data_request_skk-add'); // add
    $app->any('/DataRequestSkkView[/{id_request}]', DataRequestSkkController::class . ':view')->add(PermissionMiddleware::class)->setName('DataRequestSkkView-data_request_skk-view'); // view
    $app->any('/DataRequestSkkEdit[/{id_request}]', DataRequestSkkController::class . ':edit')->add(PermissionMiddleware::class)->setName('DataRequestSkkEdit-data_request_skk-edit'); // edit
    $app->any('/DataRequestSkkDelete[/{id_request}]', DataRequestSkkController::class . ':delete')->add(PermissionMiddleware::class)->setName('DataRequestSkkDelete-data_request_skk-delete'); // delete
    $app->group(
        '/data_request_skk',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_request}]', DataRequestSkkController::class . ':list')->add(PermissionMiddleware::class)->setName('data_request_skk/list-data_request_skk-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_request}]', DataRequestSkkController::class . ':add')->add(PermissionMiddleware::class)->setName('data_request_skk/add-data_request_skk-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_request}]', DataRequestSkkController::class . ':view')->add(PermissionMiddleware::class)->setName('data_request_skk/view-data_request_skk-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_request}]', DataRequestSkkController::class . ':edit')->add(PermissionMiddleware::class)->setName('data_request_skk/edit-data_request_skk-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_request}]', DataRequestSkkController::class . ':delete')->add(PermissionMiddleware::class)->setName('data_request_skk/delete-data_request_skk-delete-2'); // delete
        }
    );

    // data_user
    $app->any('/DataUserList[/{id_user}]', DataUserController::class . ':list')->add(PermissionMiddleware::class)->setName('DataUserList-data_user-list'); // list
    $app->any('/DataUserAdd[/{id_user}]', DataUserController::class . ':add')->add(PermissionMiddleware::class)->setName('DataUserAdd-data_user-add'); // add
    $app->any('/DataUserView[/{id_user}]', DataUserController::class . ':view')->add(PermissionMiddleware::class)->setName('DataUserView-data_user-view'); // view
    $app->any('/DataUserEdit[/{id_user}]', DataUserController::class . ':edit')->add(PermissionMiddleware::class)->setName('DataUserEdit-data_user-edit'); // edit
    $app->any('/DataUserDelete[/{id_user}]', DataUserController::class . ':delete')->add(PermissionMiddleware::class)->setName('DataUserDelete-data_user-delete'); // delete
    $app->group(
        '/data_user',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_user}]', DataUserController::class . ':list')->add(PermissionMiddleware::class)->setName('data_user/list-data_user-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_user}]', DataUserController::class . ':add')->add(PermissionMiddleware::class)->setName('data_user/add-data_user-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_user}]', DataUserController::class . ':view')->add(PermissionMiddleware::class)->setName('data_user/view-data_user-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_user}]', DataUserController::class . ':edit')->add(PermissionMiddleware::class)->setName('data_user/edit-data_user-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_user}]', DataUserController::class . ':delete')->add(PermissionMiddleware::class)->setName('data_user/delete-data_user-delete-2'); // delete
        }
    );

    // userlevelpermissions
    $app->any('/UserlevelpermissionsList[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsList-userlevelpermissions-list'); // list
    $app->any('/UserlevelpermissionsAdd[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsAdd-userlevelpermissions-add'); // add
    $app->any('/UserlevelpermissionsView[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsView-userlevelpermissions-view'); // view
    $app->any('/UserlevelpermissionsEdit[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsEdit-userlevelpermissions-edit'); // edit
    $app->any('/UserlevelpermissionsDelete[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsDelete-userlevelpermissions-delete'); // delete
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissions/add-userlevelpermissions-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissions/view-userlevelpermissions-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissions/edit-userlevelpermissions-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissions/delete-userlevelpermissions-delete-2'); // delete
        }
    );

    // userlevels
    $app->any('/UserlevelsList[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelsList-userlevels-list'); // list
    $app->any('/UserlevelsAdd[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelsAdd-userlevels-add'); // add
    $app->any('/UserlevelsView[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelsView-userlevels-view'); // view
    $app->any('/UserlevelsEdit[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelsEdit-userlevels-edit'); // edit
    $app->any('/UserlevelsDelete[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelsDelete-userlevels-delete'); // delete
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevels/view-userlevels-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevels/edit-userlevels-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevels/delete-userlevels-delete-2'); // delete
        }
    );

    // cetak_skk
    $app->any('/CetakSkk[/{params:.*}]', CetakSkkController::class)->add(PermissionMiddleware::class)->setName('CetakSkk-cetak_skk-custom'); // custom

    // m_jabatan
    $app->any('/MJabatanList[/{id}]', MJabatanController::class . ':list')->add(PermissionMiddleware::class)->setName('MJabatanList-m_jabatan-list'); // list
    $app->any('/MJabatanAdd[/{id}]', MJabatanController::class . ':add')->add(PermissionMiddleware::class)->setName('MJabatanAdd-m_jabatan-add'); // add
    $app->any('/MJabatanAddopt', MJabatanController::class . ':addopt')->add(PermissionMiddleware::class)->setName('MJabatanAddopt-m_jabatan-addopt'); // addopt
    $app->any('/MJabatanView[/{id}]', MJabatanController::class . ':view')->add(PermissionMiddleware::class)->setName('MJabatanView-m_jabatan-view'); // view
    $app->any('/MJabatanEdit[/{id}]', MJabatanController::class . ':edit')->add(PermissionMiddleware::class)->setName('MJabatanEdit-m_jabatan-edit'); // edit
    $app->any('/MJabatanDelete[/{id}]', MJabatanController::class . ':delete')->add(PermissionMiddleware::class)->setName('MJabatanDelete-m_jabatan-delete'); // delete
    $app->group(
        '/m_jabatan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MJabatanController::class . ':list')->add(PermissionMiddleware::class)->setName('m_jabatan/list-m_jabatan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MJabatanController::class . ':add')->add(PermissionMiddleware::class)->setName('m_jabatan/add-m_jabatan-add-2'); // add
            $group->any('/' . Config("ADDOPT_ACTION") . '', MJabatanController::class . ':addopt')->add(PermissionMiddleware::class)->setName('m_jabatan/addopt-m_jabatan-addopt-2'); // addopt
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MJabatanController::class . ':view')->add(PermissionMiddleware::class)->setName('m_jabatan/view-m_jabatan-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MJabatanController::class . ':edit')->add(PermissionMiddleware::class)->setName('m_jabatan/edit-m_jabatan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MJabatanController::class . ':delete')->add(PermissionMiddleware::class)->setName('m_jabatan/delete-m_jabatan-delete-2'); // delete
        }
    );

    // m_pangkat
    $app->any('/MPangkatList[/{id}]', MPangkatController::class . ':list')->add(PermissionMiddleware::class)->setName('MPangkatList-m_pangkat-list'); // list
    $app->any('/MPangkatAdd[/{id}]', MPangkatController::class . ':add')->add(PermissionMiddleware::class)->setName('MPangkatAdd-m_pangkat-add'); // add
    $app->any('/MPangkatAddopt', MPangkatController::class . ':addopt')->add(PermissionMiddleware::class)->setName('MPangkatAddopt-m_pangkat-addopt'); // addopt
    $app->any('/MPangkatView[/{id}]', MPangkatController::class . ':view')->add(PermissionMiddleware::class)->setName('MPangkatView-m_pangkat-view'); // view
    $app->any('/MPangkatEdit[/{id}]', MPangkatController::class . ':edit')->add(PermissionMiddleware::class)->setName('MPangkatEdit-m_pangkat-edit'); // edit
    $app->any('/MPangkatDelete[/{id}]', MPangkatController::class . ':delete')->add(PermissionMiddleware::class)->setName('MPangkatDelete-m_pangkat-delete'); // delete
    $app->group(
        '/m_pangkat',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MPangkatController::class . ':list')->add(PermissionMiddleware::class)->setName('m_pangkat/list-m_pangkat-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MPangkatController::class . ':add')->add(PermissionMiddleware::class)->setName('m_pangkat/add-m_pangkat-add-2'); // add
            $group->any('/' . Config("ADDOPT_ACTION") . '', MPangkatController::class . ':addopt')->add(PermissionMiddleware::class)->setName('m_pangkat/addopt-m_pangkat-addopt-2'); // addopt
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MPangkatController::class . ':view')->add(PermissionMiddleware::class)->setName('m_pangkat/view-m_pangkat-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MPangkatController::class . ':edit')->add(PermissionMiddleware::class)->setName('m_pangkat/edit-m_pangkat-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MPangkatController::class . ':delete')->add(PermissionMiddleware::class)->setName('m_pangkat/delete-m_pangkat-delete-2'); // delete
        }
    );

    // m_satuan_kerja
    $app->any('/MSatuanKerjaList[/{id}]', MSatuanKerjaController::class . ':list')->add(PermissionMiddleware::class)->setName('MSatuanKerjaList-m_satuan_kerja-list'); // list
    $app->any('/MSatuanKerjaAdd[/{id}]', MSatuanKerjaController::class . ':add')->add(PermissionMiddleware::class)->setName('MSatuanKerjaAdd-m_satuan_kerja-add'); // add
    $app->any('/MSatuanKerjaView[/{id}]', MSatuanKerjaController::class . ':view')->add(PermissionMiddleware::class)->setName('MSatuanKerjaView-m_satuan_kerja-view'); // view
    $app->any('/MSatuanKerjaEdit[/{id}]', MSatuanKerjaController::class . ':edit')->add(PermissionMiddleware::class)->setName('MSatuanKerjaEdit-m_satuan_kerja-edit'); // edit
    $app->any('/MSatuanKerjaDelete[/{id}]', MSatuanKerjaController::class . ':delete')->add(PermissionMiddleware::class)->setName('MSatuanKerjaDelete-m_satuan_kerja-delete'); // delete
    $app->group(
        '/m_satuan_kerja',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MSatuanKerjaController::class . ':list')->add(PermissionMiddleware::class)->setName('m_satuan_kerja/list-m_satuan_kerja-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MSatuanKerjaController::class . ':add')->add(PermissionMiddleware::class)->setName('m_satuan_kerja/add-m_satuan_kerja-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MSatuanKerjaController::class . ':view')->add(PermissionMiddleware::class)->setName('m_satuan_kerja/view-m_satuan_kerja-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MSatuanKerjaController::class . ':edit')->add(PermissionMiddleware::class)->setName('m_satuan_kerja/edit-m_satuan_kerja-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MSatuanKerjaController::class . ':delete')->add(PermissionMiddleware::class)->setName('m_satuan_kerja/delete-m_satuan_kerja-delete-2'); // delete
        }
    );

    // m_keperluan
    $app->any('/MKeperluanList[/{id}]', MKeperluanController::class . ':list')->add(PermissionMiddleware::class)->setName('MKeperluanList-m_keperluan-list'); // list
    $app->any('/MKeperluanAdd[/{id}]', MKeperluanController::class . ':add')->add(PermissionMiddleware::class)->setName('MKeperluanAdd-m_keperluan-add'); // add
    $app->any('/MKeperluanAddopt', MKeperluanController::class . ':addopt')->add(PermissionMiddleware::class)->setName('MKeperluanAddopt-m_keperluan-addopt'); // addopt
    $app->any('/MKeperluanView[/{id}]', MKeperluanController::class . ':view')->add(PermissionMiddleware::class)->setName('MKeperluanView-m_keperluan-view'); // view
    $app->any('/MKeperluanEdit[/{id}]', MKeperluanController::class . ':edit')->add(PermissionMiddleware::class)->setName('MKeperluanEdit-m_keperluan-edit'); // edit
    $app->any('/MKeperluanDelete[/{id}]', MKeperluanController::class . ':delete')->add(PermissionMiddleware::class)->setName('MKeperluanDelete-m_keperluan-delete'); // delete
    $app->group(
        '/m_keperluan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MKeperluanController::class . ':list')->add(PermissionMiddleware::class)->setName('m_keperluan/list-m_keperluan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MKeperluanController::class . ':add')->add(PermissionMiddleware::class)->setName('m_keperluan/add-m_keperluan-add-2'); // add
            $group->any('/' . Config("ADDOPT_ACTION") . '', MKeperluanController::class . ':addopt')->add(PermissionMiddleware::class)->setName('m_keperluan/addopt-m_keperluan-addopt-2'); // addopt
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MKeperluanController::class . ':view')->add(PermissionMiddleware::class)->setName('m_keperluan/view-m_keperluan-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MKeperluanController::class . ':edit')->add(PermissionMiddleware::class)->setName('m_keperluan/edit-m_keperluan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MKeperluanController::class . ':delete')->add(PermissionMiddleware::class)->setName('m_keperluan/delete-m_keperluan-delete-2'); // delete
        }
    );

    // v_sekretariat
    $app->any('/VSekretariatList[/{id_request}]', VSekretariatController::class . ':list')->add(PermissionMiddleware::class)->setName('VSekretariatList-v_sekretariat-list'); // list
    $app->any('/VSekretariatEdit[/{id_request}]', VSekretariatController::class . ':edit')->add(PermissionMiddleware::class)->setName('VSekretariatEdit-v_sekretariat-edit'); // edit
    $app->group(
        '/v_sekretariat',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_request}]', VSekretariatController::class . ':list')->add(PermissionMiddleware::class)->setName('v_sekretariat/list-v_sekretariat-list-2'); // list
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_request}]', VSekretariatController::class . ':edit')->add(PermissionMiddleware::class)->setName('v_sekretariat/edit-v_sekretariat-edit-2'); // edit
        }
    );

    // hukuman_disiplin
    $app->any('/HukumanDisiplinList[/{id}]', HukumanDisiplinController::class . ':list')->add(PermissionMiddleware::class)->setName('HukumanDisiplinList-hukuman_disiplin-list'); // list
    $app->any('/HukumanDisiplinAdd[/{id}]', HukumanDisiplinController::class . ':add')->add(PermissionMiddleware::class)->setName('HukumanDisiplinAdd-hukuman_disiplin-add'); // add
    $app->any('/HukumanDisiplinView[/{id}]', HukumanDisiplinController::class . ':view')->add(PermissionMiddleware::class)->setName('HukumanDisiplinView-hukuman_disiplin-view'); // view
    $app->any('/HukumanDisiplinEdit[/{id}]', HukumanDisiplinController::class . ':edit')->add(PermissionMiddleware::class)->setName('HukumanDisiplinEdit-hukuman_disiplin-edit'); // edit
    $app->any('/HukumanDisiplinDelete[/{id}]', HukumanDisiplinController::class . ':delete')->add(PermissionMiddleware::class)->setName('HukumanDisiplinDelete-hukuman_disiplin-delete'); // delete
    $app->group(
        '/hukuman_disiplin',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', HukumanDisiplinController::class . ':list')->add(PermissionMiddleware::class)->setName('hukuman_disiplin/list-hukuman_disiplin-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', HukumanDisiplinController::class . ':add')->add(PermissionMiddleware::class)->setName('hukuman_disiplin/add-hukuman_disiplin-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', HukumanDisiplinController::class . ':view')->add(PermissionMiddleware::class)->setName('hukuman_disiplin/view-hukuman_disiplin-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', HukumanDisiplinController::class . ':edit')->add(PermissionMiddleware::class)->setName('hukuman_disiplin/edit-hukuman_disiplin-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', HukumanDisiplinController::class . ':delete')->add(PermissionMiddleware::class)->setName('hukuman_disiplin/delete-hukuman_disiplin-delete-2'); // delete
        }
    );

    // banding
    $app->any('/BandingList[/{id}]', BandingController::class . ':list')->add(PermissionMiddleware::class)->setName('BandingList-banding-list'); // list
    $app->any('/BandingAdd[/{id}]', BandingController::class . ':add')->add(PermissionMiddleware::class)->setName('BandingAdd-banding-add'); // add
    $app->any('/BandingView[/{id}]', BandingController::class . ':view')->add(PermissionMiddleware::class)->setName('BandingView-banding-view'); // view
    $app->any('/BandingEdit[/{id}]', BandingController::class . ':edit')->add(PermissionMiddleware::class)->setName('BandingEdit-banding-edit'); // edit
    $app->any('/BandingDelete[/{id}]', BandingController::class . ':delete')->add(PermissionMiddleware::class)->setName('BandingDelete-banding-delete'); // delete
    $app->group(
        '/banding',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', BandingController::class . ':list')->add(PermissionMiddleware::class)->setName('banding/list-banding-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', BandingController::class . ':add')->add(PermissionMiddleware::class)->setName('banding/add-banding-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', BandingController::class . ':view')->add(PermissionMiddleware::class)->setName('banding/view-banding-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', BandingController::class . ':edit')->add(PermissionMiddleware::class)->setName('banding/edit-banding-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', BandingController::class . ':delete')->add(PermissionMiddleware::class)->setName('banding/delete-banding-delete-2'); // delete
        }
    );

    // inspeksi
    $app->any('/InspeksiList[/{id}]', InspeksiController::class . ':list')->add(PermissionMiddleware::class)->setName('InspeksiList-inspeksi-list'); // list
    $app->any('/InspeksiAdd[/{id}]', InspeksiController::class . ':add')->add(PermissionMiddleware::class)->setName('InspeksiAdd-inspeksi-add'); // add
    $app->any('/InspeksiView[/{id}]', InspeksiController::class . ':view')->add(PermissionMiddleware::class)->setName('InspeksiView-inspeksi-view'); // view
    $app->any('/InspeksiEdit[/{id}]', InspeksiController::class . ':edit')->add(PermissionMiddleware::class)->setName('InspeksiEdit-inspeksi-edit'); // edit
    $app->any('/InspeksiDelete[/{id}]', InspeksiController::class . ':delete')->add(PermissionMiddleware::class)->setName('InspeksiDelete-inspeksi-delete'); // delete
    $app->group(
        '/inspeksi',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', InspeksiController::class . ':list')->add(PermissionMiddleware::class)->setName('inspeksi/list-inspeksi-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', InspeksiController::class . ':add')->add(PermissionMiddleware::class)->setName('inspeksi/add-inspeksi-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', InspeksiController::class . ':view')->add(PermissionMiddleware::class)->setName('inspeksi/view-inspeksi-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', InspeksiController::class . ':edit')->add(PermissionMiddleware::class)->setName('inspeksi/edit-inspeksi-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', InspeksiController::class . ':delete')->add(PermissionMiddleware::class)->setName('inspeksi/delete-inspeksi-delete-2'); // delete
        }
    );

    // sidang_kode_perilaku
    $app->any('/SidangKodePerilakuList[/{id}]', SidangKodePerilakuController::class . ':list')->add(PermissionMiddleware::class)->setName('SidangKodePerilakuList-sidang_kode_perilaku-list'); // list
    $app->any('/SidangKodePerilakuAdd[/{id}]', SidangKodePerilakuController::class . ':add')->add(PermissionMiddleware::class)->setName('SidangKodePerilakuAdd-sidang_kode_perilaku-add'); // add
    $app->any('/SidangKodePerilakuView[/{id}]', SidangKodePerilakuController::class . ':view')->add(PermissionMiddleware::class)->setName('SidangKodePerilakuView-sidang_kode_perilaku-view'); // view
    $app->any('/SidangKodePerilakuEdit[/{id}]', SidangKodePerilakuController::class . ':edit')->add(PermissionMiddleware::class)->setName('SidangKodePerilakuEdit-sidang_kode_perilaku-edit'); // edit
    $app->any('/SidangKodePerilakuDelete[/{id}]', SidangKodePerilakuController::class . ':delete')->add(PermissionMiddleware::class)->setName('SidangKodePerilakuDelete-sidang_kode_perilaku-delete'); // delete
    $app->group(
        '/sidang_kode_perilaku',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SidangKodePerilakuController::class . ':list')->add(PermissionMiddleware::class)->setName('sidang_kode_perilaku/list-sidang_kode_perilaku-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SidangKodePerilakuController::class . ':add')->add(PermissionMiddleware::class)->setName('sidang_kode_perilaku/add-sidang_kode_perilaku-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SidangKodePerilakuController::class . ':view')->add(PermissionMiddleware::class)->setName('sidang_kode_perilaku/view-sidang_kode_perilaku-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SidangKodePerilakuController::class . ':edit')->add(PermissionMiddleware::class)->setName('sidang_kode_perilaku/edit-sidang_kode_perilaku-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SidangKodePerilakuController::class . ':delete')->add(PermissionMiddleware::class)->setName('sidang_kode_perilaku/delete-sidang_kode_perilaku-delete-2'); // delete
        }
    );

    // v_pemeriksa
    $app->any('/VPemeriksaList[/{id_request}]', VPemeriksaController::class . ':list')->add(PermissionMiddleware::class)->setName('VPemeriksaList-v_pemeriksa-list'); // list
    $app->any('/VPemeriksaEdit[/{id_request}]', VPemeriksaController::class . ':edit')->add(PermissionMiddleware::class)->setName('VPemeriksaEdit-v_pemeriksa-edit'); // edit
    $app->group(
        '/v_pemeriksa',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_request}]', VPemeriksaController::class . ':list')->add(PermissionMiddleware::class)->setName('v_pemeriksa/list-v_pemeriksa-list-2'); // list
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_request}]', VPemeriksaController::class . ':edit')->add(PermissionMiddleware::class)->setName('v_pemeriksa/edit-v_pemeriksa-edit-2'); // edit
        }
    );

    // v_aswas
    $app->any('/VAswasList[/{id_request}]', VAswasController::class . ':list')->add(PermissionMiddleware::class)->setName('VAswasList-v_aswas-list'); // list
    $app->any('/VAswasEdit[/{id_request}]', VAswasController::class . ':edit')->add(PermissionMiddleware::class)->setName('VAswasEdit-v_aswas-edit'); // edit
    $app->group(
        '/v_aswas',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_request}]', VAswasController::class . ':list')->add(PermissionMiddleware::class)->setName('v_aswas/list-v_aswas-list-2'); // list
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_request}]', VAswasController::class . ':edit')->add(PermissionMiddleware::class)->setName('v_aswas/edit-v_aswas-edit-2'); // edit
        }
    );

    // v_kirim_skk
    $app->any('/VKirimSkkList[/{id_request}]', VKirimSkkController::class . ':list')->add(PermissionMiddleware::class)->setName('VKirimSkkList-v_kirim_skk-list'); // list
    $app->any('/VKirimSkkEdit[/{id_request}]', VKirimSkkController::class . ':edit')->add(PermissionMiddleware::class)->setName('VKirimSkkEdit-v_kirim_skk-edit'); // edit
    $app->group(
        '/v_kirim_skk',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_request}]', VKirimSkkController::class . ':list')->add(PermissionMiddleware::class)->setName('v_kirim_skk/list-v_kirim_skk-list-2'); // list
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_request}]', VKirimSkkController::class . ':edit')->add(PermissionMiddleware::class)->setName('v_kirim_skk/edit-v_kirim_skk-edit-2'); // edit
        }
    );

    // riwayat_acc
    $app->any('/RiwayatAccList[/{id}]', RiwayatAccController::class . ':list')->add(PermissionMiddleware::class)->setName('RiwayatAccList-riwayat_acc-list'); // list
    $app->group(
        '/riwayat_acc',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', RiwayatAccController::class . ':list')->add(PermissionMiddleware::class)->setName('riwayat_acc/list-riwayat_acc-list-2'); // list
        }
    );

    // v_arsip_skk
    $app->any('/VArsipSkkList[/{id_request}]', VArsipSkkController::class . ':list')->add(PermissionMiddleware::class)->setName('VArsipSkkList-v_arsip_skk-list'); // list
    $app->any('/VArsipSkkView[/{id_request}]', VArsipSkkController::class . ':view')->add(PermissionMiddleware::class)->setName('VArsipSkkView-v_arsip_skk-view'); // view
    $app->group(
        '/v_arsip_skk',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_request}]', VArsipSkkController::class . ':list')->add(PermissionMiddleware::class)->setName('v_arsip_skk/list-v_arsip_skk-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_request}]', VArsipSkkController::class . ':view')->add(PermissionMiddleware::class)->setName('v_arsip_skk/view-v_arsip_skk-view-2'); // view
        }
    );

    // print_skk
    $app->any('/PrintSkk[/{params:.*}]', PrintSkkController::class)->add(PermissionMiddleware::class)->setName('PrintSkk-print_skk-custom'); // custom

    // dashboard2
    $app->any('/Dashboard2[/{params:.*}]', Dashboard2Controller::class)->add(PermissionMiddleware::class)->setName('Dashboard2-dashboard2-custom'); // custom

    // m_surat_keputusan
    $app->any('/MSuratKeputusanList[/{id}]', MSuratKeputusanController::class . ':list')->add(PermissionMiddleware::class)->setName('MSuratKeputusanList-m_surat_keputusan-list'); // list
    $app->any('/MSuratKeputusanAdd[/{id}]', MSuratKeputusanController::class . ':add')->add(PermissionMiddleware::class)->setName('MSuratKeputusanAdd-m_surat_keputusan-add'); // add
    $app->any('/MSuratKeputusanView[/{id}]', MSuratKeputusanController::class . ':view')->add(PermissionMiddleware::class)->setName('MSuratKeputusanView-m_surat_keputusan-view'); // view
    $app->any('/MSuratKeputusanEdit[/{id}]', MSuratKeputusanController::class . ':edit')->add(PermissionMiddleware::class)->setName('MSuratKeputusanEdit-m_surat_keputusan-edit'); // edit
    $app->any('/MSuratKeputusanDelete[/{id}]', MSuratKeputusanController::class . ':delete')->add(PermissionMiddleware::class)->setName('MSuratKeputusanDelete-m_surat_keputusan-delete'); // delete
    $app->group(
        '/m_surat_keputusan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MSuratKeputusanController::class . ':list')->add(PermissionMiddleware::class)->setName('m_surat_keputusan/list-m_surat_keputusan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MSuratKeputusanController::class . ':add')->add(PermissionMiddleware::class)->setName('m_surat_keputusan/add-m_surat_keputusan-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MSuratKeputusanController::class . ':view')->add(PermissionMiddleware::class)->setName('m_surat_keputusan/view-m_surat_keputusan-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MSuratKeputusanController::class . ':edit')->add(PermissionMiddleware::class)->setName('m_surat_keputusan/edit-m_surat_keputusan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MSuratKeputusanController::class . ':delete')->add(PermissionMiddleware::class)->setName('m_surat_keputusan/delete-m_surat_keputusan-delete-2'); // delete
        }
    );

    // konfigurasi
    $app->any('/KonfigurasiList[/{id}]', KonfigurasiController::class . ':list')->add(PermissionMiddleware::class)->setName('KonfigurasiList-konfigurasi-list'); // list
    $app->any('/KonfigurasiView[/{id}]', KonfigurasiController::class . ':view')->add(PermissionMiddleware::class)->setName('KonfigurasiView-konfigurasi-view'); // view
    $app->any('/KonfigurasiEdit[/{id}]', KonfigurasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('KonfigurasiEdit-konfigurasi-edit'); // edit
    $app->any('/KonfigurasiDelete[/{id}]', KonfigurasiController::class . ':delete')->add(PermissionMiddleware::class)->setName('KonfigurasiDelete-konfigurasi-delete'); // delete
    $app->group(
        '/konfigurasi',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KonfigurasiController::class . ':list')->add(PermissionMiddleware::class)->setName('konfigurasi/list-konfigurasi-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KonfigurasiController::class . ':view')->add(PermissionMiddleware::class)->setName('konfigurasi/view-konfigurasi-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KonfigurasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('konfigurasi/edit-konfigurasi-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KonfigurasiController::class . ':delete')->add(PermissionMiddleware::class)->setName('konfigurasi/delete-konfigurasi-delete-2'); // delete
        }
    );

    // v_kajati_konfigurasi
    $app->any('/VKajatiKonfigurasiList[/{id}]', VKajatiKonfigurasiController::class . ':list')->add(PermissionMiddleware::class)->setName('VKajatiKonfigurasiList-v_kajati_konfigurasi-list'); // list
    $app->any('/VKajatiKonfigurasiEdit[/{id}]', VKajatiKonfigurasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('VKajatiKonfigurasiEdit-v_kajati_konfigurasi-edit'); // edit
    $app->group(
        '/v_kajati_konfigurasi',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', VKajatiKonfigurasiController::class . ':list')->add(PermissionMiddleware::class)->setName('v_kajati_konfigurasi/list-v_kajati_konfigurasi-list-2'); // list
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', VKajatiKonfigurasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('v_kajati_konfigurasi/edit-v_kajati_konfigurasi-edit-2'); // edit
        }
    );

    // v_paraf_konfigurasi
    $app->any('/VParafKonfigurasiList[/{id}]', VParafKonfigurasiController::class . ':list')->add(PermissionMiddleware::class)->setName('VParafKonfigurasiList-v_paraf_konfigurasi-list'); // list
    $app->any('/VParafKonfigurasiEdit[/{id}]', VParafKonfigurasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('VParafKonfigurasiEdit-v_paraf_konfigurasi-edit'); // edit
    $app->group(
        '/v_paraf_konfigurasi',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', VParafKonfigurasiController::class . ':list')->add(PermissionMiddleware::class)->setName('v_paraf_konfigurasi/list-v_paraf_konfigurasi-list-2'); // list
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', VParafKonfigurasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('v_paraf_konfigurasi/edit-v_paraf_konfigurasi-edit-2'); // edit
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // change_password
    $app->any('/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // userpriv
    $app->any('/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
