    <?php

/*
|--------------------------------------------------------------------------
| Admin Routes
| Go to app\Helpers\PermissionHelper.php to config roles
|--------------------------------------------------------------------------
*/

## Deliveries routes
Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    Route::post('/push', 'DashboardController@push')->name('admin.notifications.push');
});

## Deliveries routes
Route::group(['prefix' => 'deliveries'], function () {
    Route::get('/', 'DeliveryController@index')->name('admin.deliveries');
    Route::post('/store', 'DeliveryController@store')->name('admin.deliveries.store');
    Route::get('/ajax/getInfoCustomer','DeliveryController@ajaxGetInforCustomer')->name('admin.deliveries.getInfoCustomer');
    Route::get('/edit','DeliveryController@edit')->name('admin.deliveries.edit');
    Route::post('/cancel/{status}','DeliveryController@cancel')->name('admin.deliveries.cancel');
    Route::post('/update/{status}','DeliveryController@update')->name('admin.deliveries.update');
    Route::get('/show','DeliveryController@show')->name('admin.deliveries.show');
    Route::get('/approve','DeliveryController@approveList')->name('admin.deliveries.approve');
});

## Orders routes
Route::group(['prefix' => 'orders'], function () {
    Route::get('/', 'OrderController@index')->name('admin.orders');
    Route::post('/approve', 'OrderController@approve')->name('admin.orders.approve');
    Route::post('/cancel_approve', 'OrderController@cancel_approve')->name('admin.orders.cancel_approve');
});

Route::group(['prefix'=>'products'], function(){
    Route::get('/','ProductController@index')->name('admin.products');
    Route::post('/store','ProductController@store')->name('admin.products.store');
    Route::post('/update','ProductController@update')->name('admin.products.update');
    Route::post('/delete/{id}','ProductController@delete')->name('admin.products.delete');
});
Route::get('/master_data', function () {
    return view('admin.masters_data.master_data');
});
Route::group(['prefix'=>'project'], function(){
    Route::get('/','ProjectController@index')->name('admin.projects.index');
    Route::post('/store','ProjectController@store')->name('admin.projects.store');
    Route::post('/update','ProjectController@update')->name('admin.projects.update');
    Route::post('/delete/{id}','ProjectController@delete')->name('admin.projects.delete');
});
Route::group(['prefix'=>'building'], function(){
    Route::get('/{project_code}','BuildingController@index')->name('admin.building.index');
    Route::post('/edit', 'BuildingController@edit_building')->name('admin.building.edit_building');
    Route::post('/deldete/{id}', 'BuildingController@delete_building')->name('admin.building.delete_building');
});
Route::group(['prefix'=>'customer'], function(){
    Route::get('/{project_code}/{building_code}/{room_no}', 'CustomerController@index')->name('admin.customer.index');
    Route::get('/show/{id}','CustomerController@show')->name('admin.customer.show');
    Route::post('/update_customer', 'CustomerController@update')->name('admin.customer.update_customer');
    Route::post('/delete/{id}','CustomerController@delete')->name('admin.customer.delete');
});
## Product inventories routes
Route::group(['prefix'=>'inventories'], function(){
    Route::get('/', 'InventoryController@index')->name('admin.inventories');
    Route::post('/create', 'InventoryController@create')->name('admin.inventories.create');
    Route::post('/delete/{id}', 'InventoryController@delete')->name('admin.inventories.delete');
});

## Staffs routes
Route::group(['prefix' => 'staffs'], function () {
    Route::get('/', 'StaffController@index');
    Route::post('/store', 'StaffController@store')->name('admin.staffs.store');
    Route::post('/update', 'StaffController@update')->name('admin.staffs.update');
    Route::post('/delete/{id}','StaffController@delete')->name('admin.staffs.delete');
});

## Salaries routes
Route::get('/salaries', function () {
    return view('admin.layouts.index');
});

## Notification
Route::group(['prefix' => 'notifications'], function(){
    Route::get('/', 'NotificationController@getJsonList')->name('admin.notifications.getJsonList');
    Route::post('/readNotification', 'NotificationController@readNotification')->name('admin.notifications.readNotification');
});

## Language
Route::group(['prefix' => 'lang'], function () {
    Route::get('/{filename}.js', 'LanguageController@getFileLang')->name('admin.lang.getFileLang');
});

## shipper routes
Route::group(['prefix' => 'shippers'], function () {
    Route::get('/', 'ShipperController@index')->name('admin.shippers');
    Route::post('/delivery/{id}', 'ShipperController@delivery')->name('admin.shippers.delivery');
});

## categories
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', 'CategoryController@index')->name('admin.categories');
    Route::post('/store', 'CategoryController@store')->name('admin.categories.store');
    Route::post('/update', 'CategoryController@update')->name('admin.categories.update');
    Route::post('/delete/{id}','CategoryController@delete')->name('admin.categories.delete');
});

## CRM
Route::group(['prefix' => 'crm'], function () {
    Route::get('/', 'CrmController@index')->name('admin.crm');
    Route::post('/update/{id}', 'CrmController@update')->name('admin.crm.update');
    Route::post('/create', 'CrmController@create')->name('admin.crm.create');
});