<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('dieuxe', 'DieuXeController@getDieuXe')->name('getDieuXe');
// Route::get('l', 'LoginController@getLogin')->name('getLogin');

Route::get('/', 'LoginController@index');
Route::get('/login', 'LoginController@getLogin');
Route::post('/login', 'LoginController@login');
Route::get('/autoPullOperatingPool/{token}', 'DieuXeController@autoPullOperatingPool')->name('autoPullOperatingPool');


//autoPullOperatingPool

Route::get('/logout', 'LoginController@getLogout')->name('getLogout');

Route::group(['middleware' => 'login'], function () {
    //Group route Dieuxe
    Route::get('/operating/create', function () {
        return view('DieuXe.index');
    })->name('operating-create');
    Route::get('/operating/create1', 'DieuXeController@getOperating')->name('getOperating');
    Route::get('/operating/create3', 'DieuXeController@getDieuXe')->name('getDieuXe');
    Route::post('/creatOperating', 'DieuXeController@creatOperating')->name('creatOperating');
    Route::post('/getSuggestOperatingByHotKey', 'DieuXeController@getSuggestOperatingByHotKey')->name('getSuggestOperatingByHotKey');
    Route::get('/editOperating/{id}', 'DieuXeController@getEditOperating')->name('getEditOperating');
    // Route::get('/operating/detail/{id}/{page}', function ($id, $page) {
    //     return view('DieuXe.edit', compact('id', 'page'));
    // })->name('operating-edit');
    Route::get('/operating/detail/{id}', function ($id) {
        $arrParameters = explode("-",$id);
        $id = $arrParameters[0];
        $page = $arrParameters[1];
        return view('DieuXe.edit', compact('id', 'page'));
    })->name('operating-edit');
    Route::post('/postEditOperating', 'DieuXeController@postEditOperating')->name('postEditOperating');
    Route::get('/operating/delete/{id}', 'DieuXeController@getDeleteOperating')->name('getDeleteOperating');
    Route::get('excel', 'DieuXeController@exampleExportExcel')->name('excel');
    Route::get('/print', function () {
        return view('DieuXe.print');
    })->name('print');
    Route::post('/operating/getLastestGoods', 'DieuXeController@getLastestGoods')->name('getLastestGoods');
    Route::post('/operating/getLastestCarInfoByPlace', 'DieuXeController@getLastestCarInfoByPlace')->name('getLastestCarInfoByPlace');
    Route::post('/operating/getDriverInfoForOperating', 'DieuXeController@getDriverInfoForOperating')->name('getDriverInfoForOperating');
    Route::post('/pullOperatingPool', 'DieuXeController@pullOperatingPool')->name('pullOperatingPool');
    //getLastestCarInfoByPlace
    //operating/getLastestGoods
    Route::post('/getListPrint', 'DieuXeController@getListPrint')->name('getListPrint');
    Route::get('completeOperating', 'DieuXeController@completeOperating')->name('completeOperating');
    Route::get('completeOneOperating', 'DieuXeController@completeOneOperating')->name('completeOneOperating');

    Route::get('/operating/search', 'DieuXeController@search')->name('operatingsearch');
    Route::get('/operating/{pagi?}', 'DieuXeController@getShowdieuxe')->name('operating');
    Route::get('operating2', 'DieuXeController@getShowdieuxe2');

	// Operating Pool
    // Route::post('/getListPrintPool', 'DieuXePoolController@getListPrintPool')->name('getListPrintPool');
    // Route::get('/operatingPool/search', 'DieuXePoolController@searchPool')->name('operatingsearchPool');
    // Route::get('operatingPool', 'DieuXePoolController@getShowdieuxePool')->name('operatingPool');
    // Route::get('operatingPool2', 'DieuXePoolController@getShowdieuxePool2');
    // Route::get('/printPool', function () {
    //     return view('DieuXePool.print');
    // })->name('print');
    // Route::get('excelPool', 'DieuXePoolController@exampleExportExcelPool')->name('excel');
    // Route::get('/operatingPool/detail/{id}', function ($id) {
    //     return view('DieuXePool.edit', compact('id'));
    // })->name('operating-edit');
    // Route::post('/postEditOperatingPool', 'DieuXePoolController@postEditOperatingPool')->name('postEditOperatingPool');
    // Route::get('/editOperatingPool/{id}', 'DieuXePoolController@getEditOperatingPool')->name('getEditOperatingPool');
    // Route::post('/operatingPool/getLastestGoods', 'DieuXePoolController@getLastestGoods')->name('getLastestGoods');
    // Route::post('/operatingPool/getDriverInfoForOperating', 'DieuXePoolController@getDriverInfoForOperating')->name('getDriverInfoForOperating');
	// Operating Pool
    Route::get('/permission', function () {
        return view('errors');
    });
    //Group route xe
    Route::get('/xe', 'carController@getcar');
    Route::get('/delete/xe/{id}', 'carController@del');
    Route::get('/xe/create', 'carController@createItem');
    Route::post('/xe/create', 'carController@postcreateItem');
    Route::get('/xe/detail/{id}', 'carController@itemDetail');
    Route::post('/xe/detail/{id}', 'carController@update');
    Route::get('/xe/search', 'carController@search');
    Route::get('/xe/getCarData', 'carController@getCarData')->name('getCarData');
    //group route noigiao
    Route::get('/noigiao', 'noigiaoController@getNoiGiao');
    Route::get('/noigiao/create', 'noigiaoController@createNoiGiao');
    Route::get('/noigiao/{id}/edit', 'noigiaoController@editNoiGiao');
    Route::get('/noigiao/delete/{id}', 'noigiaoController@deleteNoiGiao');
    Route::post('/noigiao/update/{id}', 'noigiaoController@updateNoiGiao');
    Route::post('/noigiao/create', 'noigiaoController@postcreateNoiGiao');
    Route::get('/noigiao/search', 'noigiaoController@searchNoiGiao');
    //group route noinhan
    Route::get('/noinhan', 'noinhanController@getNoiNhan');
    Route::get('/noinhan/create', 'noinhanController@createNoiNhan');
    Route::get('/noinhan/{id}/edit', 'noinhanController@editNoiNhan');
    Route::get('/noinhan/delete/{id}', 'noinhanController@deleteNoiNhan');
    Route::post('/noinhan/update/{id}', 'noinhanController@updateNoiNhan');
    Route::post('/noinhan/create', 'noinhanController@postcreateNoiNhan');
    Route::get('/noinhan/search', 'noinhanController@searchNoiNhan');

    //group route hang hoa
    Route::get('/hanghoa', 'goodsController@getgoods');
    Route::get('/hanghoa/delete/{id}', 'goodsController@del');
    Route::get('/hanghoa/create', 'goodsController@createItem');
    Route::post('/hanghoa/create', 'goodsController@postcreateItem');
    Route::get('/hanghoa/{id}/edit', 'goodsController@itemDetail');
    Route::post('/hanghoa/detail/{id}', 'goodsController@update');
    Route::get('/hanghoa/search', 'goodsController@search');
    Route::get('/hanghoa2', 'goodsController@getgoods2');
    //group route xitbon
    Route::get('/xitbon', 'cleartankController@getcleartank');
    Route::post('/delete/xitbon', 'cleartankController@del');
    Route::get('/xitbon/create', 'cleartankController@createItem');
    Route::post('/xitbon/create', 'cleartankController@postcreateItem');
    Route::get('/xitbon/detail/{id}', 'cleartankController@itemDetail');
    Route::post('/xitbon/detail', 'cleartankController@update');
    Route::get('/xitbon/search', 'cleartankController@search');
    //group route loaidungcu
    Route::get('/loaidungcu', 'toolcategoryController@index')->name('LoaiDungCu');
    Route::get('/loaidungcu/them', 'toolcategoryController@CreateGet')->name('ThemLoaiDungCu');
    Route::post('/loaidungcu/them', 'toolcategoryController@CreatePost')->name('PostThemLoaiDungCu');
    Route::get('/loaidungcu/sua/{id}', 'toolcategoryController@EditGet')->name('SuaLoaiDungCu');
    Route::post('/loaidungcu/sua/{id}', 'toolcategoryController@EditPost')->name('PostSuaLoaiDungCu');
    Route::post('/loaidungcu/xoa', 'toolcategoryController@DeleteLoaiDungCu')->name('DeleteLoaiDungCu');
    Route::post('/loaidungcu/searchloai', 'toolcategoryController@Search')->name('SearchLoai');
    //froup route dung cu
    Route::get('/dungcu', 'toolController@index')->name('DungCu');
    Route::get('/dungcu/them', 'toolController@CreateGet')->name('ThemDungCu');
    Route::post('/dungcu/them', 'toolController@CreatePost')->name('PostThemDungCu');
    Route::get('/dungcu/sua/{id}', 'toolController@EditGet')->name('SuaDungCu');
    Route::post('/dungcu/sua/{id}', 'toolController@EditPost')->name('PostSuaDungCu');
    Route::post('/dungcu/xoa', 'toolController@DeleteDungCu')->name('DeleteDungCu');
    Route::post('/dungcu/searchdc', 'toolController@Search')->name('SearchDC');
    //group route loai xe
    Route::get('/loaixe', 'cartypeController@getcartype');
    Route::post('/delete/loaixe', 'cartypeController@del');
    Route::get('/loaixe/create', 'cartypeController@createItem');
    Route::post('/loaixe/create', 'cartypeController@postcreateItem');
    Route::get('/loaixe/detail/{id}', 'cartypeController@itemDetail');
    Route::post('/loaixe/detail/{id}', 'cartypeController@update');
    Route::get('/loaixe/search', 'cartypeController@search');
    //group route romooc
    Route::get('/romooc', 'trailerController@gettrailer');
    Route::get('/delete/romooc/{id}', 'trailerController@del');
    Route::get('/romooc/create', 'trailerController@createItem');
    Route::post('/romooc/create', 'trailerController@postcreateItem');
    Route::get('/romooc/detail/{id}', 'trailerController@itemDetail');
    Route::post('/romooc/detail/{id}', 'trailerController@update');
    Route::get('/romooc/search', 'trailerController@search');
    Route::get('/romooc/getData', 'trailerController@getData');
    //group route loai romooc
    Route::get('/loairomooc', 'TypetrailerController@gettrailer');
    Route::post('/delete/loairomooc', 'TypetrailerController@del');
    Route::get('/loairomooc/create', 'TypetrailerController@createItem');
    Route::post('/loairomooc/create', 'TypetrailerController@postcreateItem');
    Route::get('/loairomooc/detail/{id}', 'TypetrailerController@itemDetail');
    Route::post('/loairomooc/detail/{id}', 'TypetrailerController@update');
    Route::get('/loairomooc/search', 'TypetrailerController@search');
    //group route user crud
    // Route::prefix('user')->group(function () {
    //     Route::get('/detail/{id}', 'userController@itemDetail');
    //     Route::get('/search', 'userController@search');
    //     Route::get('/create', 'userController@createItem');
    //     Route::get('/', 'userController@getuser')->name('getalluser');
    // });
    // Route::get('delete/user/{id}', 'userController@del');
    // Route::post('/createuser', 'userController@createuser');
    // Route::post('/updateuser/{id}', 'userController@updateuser');

    // group route user
    Route::get('user', function(){
        return view('User.show');
    });
    Route::get('/user/getUser','userQuocHuyController@getUser');
    Route::get('/user/search','userQuocHuyController@getSearch');
    Route::get('/user/delete/{id}','userQuocHuyController@getDelete');
    Route::get('/user/edit/{id}',function($id){
        return view('User.detail',compact('id'));
    });
    Route::get('/user/getedit/{id}','userQuocHuyController@getEdit');
    Route::post('/user/postedit/{id}','userQuocHuyController@postEdit');
    Route::get('/user/insert', function(){
        return view('User.detail');
    });
    Route::post('/user/postinsert','userQuocHuyController@postInsert');



    // map api

    Route::get('/map', 'MapController@index');
    Route::get('/locationEnd', 'MapController@create');
    Route::get('/locationEndManyCar/{id}', 'MapController@createManyCar');
    Route::get('/History', 'MapController@HistoryCar');
    Route::get('/getInfo', 'MapController@getInfo');
    Route::get('/getInfo1', 'MapController@getInfo1');
    Route::post('/mapxe', 'MapController@getInfo2');
    Route::get('/mapxe', function () {
        return view('api.mapmove');
    });

    //end map api
    Route::get('/maintenance/car_id','MaintenanceController@getCar');
    Route::get('/maintenance/getCardata','MaintenanceController@getCarData');


    // BÁO BẢO DƯỠNG
    Route::get('/maintenance', 'MaintenanceController@getMaintenance')->name('showM');
    Route::post('/delete/maintenance', 'MaintenanceController@del')->name('MDel');
    Route::get('/maintenance/create', 'MaintenanceController@createItem')->name('MAdd');
    Route::post('/maintenance/create', 'MaintenanceController@postcreateItem')->name('MAdd');
    Route::get('/maintenance/detail/{id}', 'MaintenanceController@itemDetail')->name('Mdetail');
    Route::post('/maintenance/detail/{id}', 'MaintenanceController@update')->name('Mdetail');
    Route::get('/maintenance/search', 'MaintenanceController@search')->name('MSearch');
    Route::get('/maintenance/print', 'MaintenanceController@Print')->name('printM');
    Route::get('/maintenance/create/{id}', 'MaintenanceController@Sum')->name('MSum');
    Route::get('/maintenance/itemDetail/{id}', 'MaintenanceController@Detailmaintenance')->name('Mitem');
    Route::get('/maintenance/createItemDeail/{id}', 'MaintenanceController@CreateItemDeltail')->name('Mcreatedetail');
    Route::post('/maintenance/createItemDeail/{id}', 'MaintenanceController@PostItemDeltail')->name('Mcreatedetail');
    Route::post('/maintenance/createItemDeail/{id}', 'MaintenanceController@PostItemDeltail')->name('Mcreatedetail');
    Route::post('/Deail/delete', 'MaintenanceController@DeltailDel');
    Route::get('/Deail/edit/{id}', 'MaintenanceController@DeltailEdit');
    Route::post('/Deail/edit', 'MaintenanceController@DeltailEdit1');
    Route::get('/Deail1/edit/{id}', 'MaintenanceController@Deltail1Edit');
    Route::post('/Deail1/edit', 'MaintenanceController@Deltail1Edit1');

    // BÁO HIỂM XE 
    Route::get('/insurance', 'InsuranceController@getInsurance')->name('showInsu');
    Route::post('/delete/insurance', 'InsuranceController@del')->name('InsuDel');
    Route::get('/insurance/create', 'InsuranceController@createItem')->name('InsuAdd');
    Route::post('/insurance/create', 'InsuranceController@postcreateItem')->name('InsuAdd');
    Route::get('/insurance/detail/{id}', 'InsuranceController@itemDetail')->name('Insudetail');
    Route::post('/insurance/detail/{id}', 'InsuranceController@update')->name('Insudetail');
    Route::get('/insurance/search', 'InsuranceController@search')->name('InsuSearch');
    Route::get('/insurance/print', 'InsuranceController@Print')->name('printInsu');
    Route::get('/insurance/create/{id}', 'InsuranceController@Sum')->name('bhSum');

    // CHỨNG NHẬN PCCC
    Route::get('/fire-certificate', 'FireCertificateController@getCN')->name('showF');
    Route::post('/delete/fire-certificate', 'FireCertificateController@del')->name('FDel');
    Route::get('/fire-certificate/create', 'FireCertificateController@createItem')->name('FAdd');
    Route::post('/fire-certificate/create', 'FireCertificateController@postcreateItem')->name('FAdd');
    Route::get('/fire-certificate/detail/{id}', 'FireCertificateController@itemDetail')->name('Fdetail');
    Route::post('/fire-certificate/detail/{id}', 'FireCertificateController@update')->name('Fdetail');
    Route::get('/fire-certificate/search', 'FireCertificateController@search')->name('FSearch');
    Route::get('/fire-certificate/print', 'FireCertificateController@Print')->name('printF');
    Route::get('/fire-certificate/create/{id}', 'FireCertificateController@Sum')->name('FSum');


    // KIỂM ĐỊNH 
    Route::get('/verify', 'VerifyController@getKD')->name('showV');
    Route::post('/delete/verify', 'VerifyController@del')->name('VDel');
    Route::get('/verify/create', 'VerifyController@createItem')->name('VAdd');
    Route::post('/verify/create', 'VerifyController@postcreateItem')->name('VAdd');
    Route::get('/verify/detail/{id}', 'VerifyController@itemDetail')->name('Vdetail');
    Route::post('/verify/detail/{id}', 'VerifyController@update')->name('Vdetail');
    Route::get('/verify/search', 'VerifyController@search')->name('VSearch');
    Route::get('/verify/print', 'VerifyController@Print')->name('printV');
    Route::get('/verify/create/{id}', 'VerifyController@Sum')->name('kdSum');

    // THAY NHỚT 
    Route::get('/oil', 'OilController@getO')->name('showO');
    Route::post('/delete/oil', 'OilController@del')->name('ODel');
    Route::get('/oil/create', 'OilController@createItem')->name('OAdd');
    Route::post('/oil/create', 'OilController@postcreateItem')->name('OAdd');
    Route::get('/oil/detail/{id}', 'OilController@itemDetail')->name('Odetail');
    Route::post('/oil/detail/{id}', 'OilController@update')->name('Odetail');
    Route::get('/oil/search', 'OilController@search')->name('OSearch');
    Route::get('/oil/print', 'OilController@Print')->name('printO');
    Route::get('/oil/create/{id}', 'OilController@Sum')->name('kdSum');

    // THAY VỎ
    Route::get('/tires', 'TiresController@getTires')->name('showTires');
    Route::post('/delete/tires', 'TiresController@del')->name('TiresDel');
    Route::get('/tires/create', 'TiresController@createItem')->name('TiresAdd');
    Route::post('/tires/create', 'TiresController@postcreateItem')->name('TiresAdd');
    Route::get('/tires/detail/{id}', 'TiresController@itemDetail')->name('Tiresdetail');
    Route::post('/tires/detail/{id}', 'TiresController@update')->name('Tiresdetail');
    Route::get('/tires/search', 'TiresController@search')->name('TiresSearch');
    Route::get('/tires/print', 'TiresController@Print')->name('printTires');
    Route::get('/tires/create/{id}', 'TiresController@Sum')->name('kdSum');
    
    // TỔNG BẢO TRÌ

    Route::get('sumMaintenance','SumMainController@getshow')->name('showSum');
    Route::get('/sumMaintenance/viewItemdetail/{id}','SumMainController@itemDetail');
    Route::get('/sumMaintenance/search', 'SumMainController@search')->name('searchsum');

    //partner
    Route::prefix('partner')->group(function () {
        Route::get('/', 'partnerController@show');
        Route::get('/delete/{id}', 'partnerController@delete');
        Route::get('/search', 'partnerController@searchPartner');

        Route::get('/{id}/edit', 'partnerController@editPartner');
        Route::post('/update', 'partnerController@updatePartner');

        Route::get('/create', 'partnerController@getCreate');
        Route::post('/create', 'partnerController@postCreate');
        Route::get('/getData', 'partnerController@getData');
    });
    //end partner
    //driver

    // Route::get('/driver', 'DriverController@index');
    //enddriver

    //assistant
    Route::get('/assistant-driver', 'AssistantController@index')->name('AddAssistant');
    Route::get('/assistant-driver/add', 'AssistantController@AddAssistantGet')->name('AddAssistantGet');
    Route::post('/assistant-driver/add', 'AssistantController@AddAssistantPost')->name('AddAssistantPost');
    Route::post('/assistant-driver/delete', 'AssistantController@DeleteAssistantPost')->name('DeleteAssistant');
    Route::get('/assistant-driver/edit/{id}', 'AssistantController@EditAssistantGet')->name('EditAssistantGet');
    Route::post('/assistant-driver/edit/{id}', 'AssistantController@EditAssistantPost')->name('EditAssistantPost');
    //endassistant
    // Driver Start
    Route::prefix('driver')->group(function () {
       /* Route::get('/', function () {
            return view('Driver.index');
        });*/
        //Route::get('getDriver', 'DriverController@getDriver')->name('getDriver');
        Route::get('/', 'DriverController@getDriver')->name('getDriver');
        Route::get('/getListcense', 'DriverController@getlisLicense')->name('getlisLicense');
        Route::get('/searchDriver', 'DriverController@search')->name('searchDriver');
        /*Route::get('/searchDriver', function () {
            return view('Driver.index');;
        });*/
        
        Route::get('/delete/{id}', 'DriverController@deleteDriver')->name('deleteDriver');
        Route::get('/search', 'DriverController@search')->name('search');
        Route::get('/create', function () {
            return view('Driver.create');
        });
        Route::post('/postCreateDriver', 'DriverController@createDriver')->name('createDriver');
        //    Route::get('/edit', function () {
        //     return view('Driver.edit');
        // });
        Route::get('/detail/{id}', function ($id) {
            return view('Driver.edit', compact('id'));
        });
        Route::get('/edit/{id}', 'DriverController@getEditDriver')->name('getEditDriver');
        Route::post('/edit', 'DriverController@postEditDriver')->name('postEditDriver');
        Route::get('getCreate', 'DriverController@getCreate')->name('getCreate');
    });
    //Driver End

    //Phân quyền
    Route::get('/privileges','privilegesController@show');
    Route::get('/privileges/edit/{id}','privilegesController@getEdit');
    Route::post('/privileges/edit','privilegesController@postEdit');
    Route::post('/privileges/delete','privilegesController@delete');

    //Phụ tùng
    Route::get('/accessary','accessaryController@index');
    Route::get('/accessary/edit/{id}','accessaryController@getEdit');
    Route::post('/accessary/edit','accessaryController@postEdit');
    Route::post('/accessary/delete','accessaryController@delete');
    Route::get('/accessary/search','accessaryController@search');
    Route::get('/accessary/outStockSearch','accessaryController@searchOutStock');
    Route::get('/accessary/create',function(){
        return view('Accessary.create');
    });
    Route::post('/accessary/create','accessaryController@create');
    Route::post('/accessary/delete','accessaryController@delete');
    
    //Nhập phụ tùng
    Route::get('/importAccessary','ieAccessaryController@indexImport');
    Route::get('/importAccessary/search','ieAccessaryController@searchImport');

    Route::get('/importAccessary/edit/{id}','ieAccessaryController@getEditImport');
    Route::post('/importAccessary/edit','ieAccessaryController@postEditImport');

    Route::get('/importAccessary/create','ieAccessaryController@getCreateImport');
    Route::post('/importAccessary/create','ieAccessaryController@postCreateImport');

    Route::post('/importAccessary/delete','ieAccessaryController@deleteImport');
    Route::get('/importAccessary/report','ieAccessaryController@reportImport');

    //Xuất phụ tùng
    Route::get('/exportAccessary','ieAccessaryController@indexExport');
    Route::get('/exportAccessary/search','ieAccessaryController@searchExport');

    Route::get('/exportAccessary/edit/{id}','ieAccessaryController@getEditExport');
    Route::post('/exportAccessary/edit','ieAccessaryController@postEditExport');

    Route::get('/exportAccessary/create','ieAccessaryController@getCreateExport');
    Route::post('/exportAccessary/create','ieAccessaryController@postCreateExport');

    Route::post('/exportAccessary/delete','ieAccessaryController@deleteExport');
    Route::get('/exportAccessary/report','ieAccessaryController@reportExport');
    Route::get('/exportAccessary/print',function(){
        return view('exportAccessary.print-single');
    });

    //Báo cáo tồn phụ tùng
    Route::get('/remainReport','ieAccessaryController@indexReport');
    Route::get('/remainReport/report','ieAccessaryController@remainReport');

	//Driver End
    
    //Người phụ trách
    Route::get('/curator', 'curatorController@index')->name('AddCurator');
    Route::get('/curator/add', 'curatorController@AddCuratorGet')->name('AddCuratorGet');
    Route::post('/curator/add', 'curatorController@AddCuratorPost')->name('AddCuratorPost');
    Route::post('/curator/delete', 'curatorController@DeleteCuratorPost')->name('DeleteCurator');
    Route::get('/curator/edit/{id}', 'curatorController@EditCuratorGet')->name('EditCuratorGet');
    Route::post('/curator/edit/{id}', 'curatorController@EditCuratorPost')->name('EditCuratorPost');

	// Lệnh tổng tổng hợp
	Route::get('/accountant','AccountantController@index');
	Route::get('/accountant/search','AccountantController@index');


	// Lệnh tổng tổng hợp
    Route::get('/accountant','AccountantController@index');
    Route::get('/operatingPool','AccountantController@all');
});
Route::get('/hash', function () {
    print_r(Hash::make('123456'));
});