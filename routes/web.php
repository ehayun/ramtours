<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
 */

Route::get('/clear-cache', function () {
    //dd('test');
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/admin', 'admin\AdminController@index')->name('admin');
Route::get('/admin/profile', 'admin\AdminController@profile')->name('admin.profile');
Route::PUT('/admin/updateprofile/{id}', 'admin\AdminController@updateprofile')->name('admin.updateprofile');
Route::get('/admin/changepwd', 'admin\AdminController@change_pwd')->name('admin.change password');
Route::put('/admin/save_change_pwd', 'admin\AdminController@save_change_pwd');
Auth::routes();
Route::get('/admin/setting', 'admin\SettingController@index')->name('setting.index');
Route::get('/admin/setting/language_setting', 'admin\SettingController@language_setting')->name('setting.language setting');
Route::put('/admin/setting/language_setting', 'admin\SettingController@save_language_setting');
Route::get('/admin/setting/currency_rate', 'admin\SettingController@currency_rate')->name('setting.currency rate');
Route::put('/admin/setting/currency_rate', 'admin\SettingController@save_currency_rate');
Route::get('/admin/setting/homepage', 'admin\SettingController@homepage_settings')->name('homepage');
Route::get('/admin/setting/homepage/create', 'admin\SettingController@create_homepage_settings')->name('homepage.create');
Route::post('/admin/setting/homepage', 'admin\SettingController@save_homepage_settings')->name('homepage');
Route::get('/admin/setting/homepage/{id}/edit', 'admin\SettingController@edit_homepage_setting')->name('homepage.edit');
Route::put('/admin/setting/homepage/{id}', 'admin\SettingController@update_homepage_setting')->name('homepage');
Route::delete('/admin/setting/homepage/{id}', 'admin\SettingController@homepage_setting_destroy');
Route::get('/admin/setting/homepage_meta', 'admin\SettingController@create_homepage_meta_settings');
Route::post('/admin/setting/homepage_meta', 'admin\SettingController@save_homepage_meta_settings');
Route::get('/admin/setting/notification', 'admin\SettingController@notification')->name('setting.notification');
Route::put('/admin/setting/notification', 'admin\SettingController@save_notification');

Route::get('admin/location/{loc_id}/package-setting/{pkg_type}/page_content', 'admin\LocationController@add_loc_page_content')->name('location');
Route::post('admin/location/{loc_id}/package-setting/{pkg_type}/page_content', 'admin\LocationController@save_loc_page_content')->name('location');

Route::get('admin/location/{loc_id}/package-setting/{pkg_type}', 'admin\LocationController@loc_pkg_setting')->name('location');
Route::get('admin/location/{loc_id}/package-setting/{pkg_type}/create', 'admin\LocationController@loc_pkg_setting_create')->name('location');
Route::post('admin/location/{loc_id}/package-setting/{pkg_type}', 'admin\LocationController@store_loc_pkg_setting');
Route::get('admin/package-setting/{pkg_type}/edit/{set_id}', 'admin\LocationController@loc_pkg_setting_edit')->name('location');
Route::put('admin/package-setting/{pkg_type}/update/{set_id}', 'admin\LocationController@update_loc_pkg_setting');
Route::delete('admin/package-setting/{set_id}', 'admin\LocationController@delete_pkg_setting');
Route::get('admin/location/hotelmeta/{id}', 'admin\LocationController@add_location_hotel_meta_data');
Route::put('admin/location/hotelmeta/{id}', 'admin\LocationController@save_location_hotel_meta_data');
Route::get('admin/location/flightmeta/{id}', 'admin\LocationController@add_location_flight_meta_data');
Route::put('admin/location/flightmeta/{id}', 'admin\LocationController@save_location_flight_meta_data');
Route::get('admin/location/packagemeta/{id}', 'admin\LocationController@add_location_package_meta_data');
Route::put('admin/location/packagemeta/{id}', 'admin\LocationController@save_location_package_meta_data');
Route::resource('admin/location', 'admin\LocationController');
Route::get('admin/airline/trash', 'admin\AirlineController@trash_airline');
Route::patch('admin/airline/restore', 'admin\AirlineController@restore_trash_airline');
Route::delete('admin/airline/destroy/{id}', 'admin\AirlineController@force_delete_airline');
Route::delete('admin/airline/destroy', 'admin\AirlineController@force_delete_all');
Route::patch('admin/airline/restore/{id}', 'admin\AirlineController@restore_single_airline');
Route::resource('admin/airline', 'admin\AirlineController');
Route::get('admin/flight/trash', 'admin\FlightController@trash_flight');
Route::patch('admin/flight/restore/{id}', 'admin\FlightController@restore_single_flight');
Route::patch('admin/flight/restore', 'admin\FlightController@restore_trash_flight');
Route::delete('admin/flight/destroy/{id}', 'admin\FlightController@force_delete_flight');
Route::delete('admin/flight/destroy', 'admin\FlightController@force_delete_all');
Route::resource('admin/flight', 'admin\FlightController');
Route::get('admin/flight-schedule/trash', 'admin\Flight_ScheduleController@trash_flight_sche');
Route::patch('admin/flight-schedule/restore/{id}', 'admin\Flight_ScheduleController@restore_single_flight_sche');
Route::patch('admin/flight-schedule/restore', 'admin\Flight_ScheduleController@restore_trash_flight_sche');
Route::delete('admin/flight-schedule/destroy/{id}', 'admin\Flight_ScheduleController@force_delete_flight_sche');
Route::delete('admin/flight-schedule/destroy', 'admin\Flight_ScheduleController@force_delete_all_sche');
Route::get('admin/flight-schedule-meta/{id}', 'admin\Flight_ScheduleController@add_flight_sche_meta_data');
Route::put('admin/flight-schedule-meta/{id}', 'admin\Flight_ScheduleController@save_flight_sche_meta_data');
Route::get('admin/flight-schedule-alert/{id}', 'admin\Flight_ScheduleController@flight_schedule_alert');
Route::put('admin/flight-schedule-alert/{id}', 'admin\Flight_ScheduleController@store_flight_schedule_alert');
Route::resource('admin/flight-schedule', 'admin\Flight_ScheduleController');
Route::get('admin/hotel/trash', 'admin\HotelController@trash_hotel');
Route::patch('admin/hotel/restore/{id}', 'admin\HotelController@restore_single_hotel');
Route::patch('admin/hotel/restore', 'admin\HotelController@restore_trash_hotel');
Route::delete('admin/hotel/destroy/{id}', 'admin\HotelController@force_delete_hotel');
Route::delete('admin/hotel/destroy', 'admin\HotelController@force_delete_all');
Route::get('admin/hotel-meta/{id}', 'admin\HotelController@add_hotel_meta_data');
Route::put('admin/hotel-meta/{id}', 'admin\HotelController@save_hotel_meta_data');
Route::resource('admin/hotel', 'admin\HotelController');
Route::get('admin/hotel/{id}/edit_image', 'admin\HotelController@edit_image')->name('hotel.edit image');
Route::put('admin/edit_hotel_image/{id}/', 'admin\HotelController@update_image');
Route::delete('admin/hotel/delete_image/{id}/', 'admin\HotelController@destroy_image');

Route::get('admin/room/{room_id}/room_prices', 'admin\RoomController@room_prices')->name('room');
Route::get('admin/room/{room_id}/room_prices/create', 'admin\RoomController@room_price_create')->name('room');
Route::post('admin/room/{room_id}/room_prices', 'admin\RoomController@room_price_store');
Route::get('admin/room_prices/{price_id}/edit', 'admin\RoomController@room_price_edit')->name('room');
Route::put('admin/room_prices/{price_id}', 'admin\RoomController@room_price_update');
Route::delete('admin/room_prices/{price_id}', 'admin\RoomController@room_price_delete');
Route::get('admin/room/{room_id}/room_stock', 'admin\RoomController@room_stock')->name('room');
Route::get('admin/room/{room_id}/room_stock/create', 'admin\RoomController@room_stock_create')->name('room');
Route::post('admin/room/{room_id}/room_stock', 'admin\RoomController@room_stock_store');
Route::get('admin/room_stock/{room_stock_id}/edit', 'admin\RoomController@room_stock_edit')->name('room');
Route::put('admin/room_stock/{room_stock_id}', 'admin\RoomController@room_stock_update');
Route::delete('admin/room_stock/{room_stock_id}', 'admin\RoomController@room_stock_delete');

Route::get('admin/room/gallery/{id}', 'admin\RoomController@gallery');
Route::put('admin/room/add_image/{id}', 'admin\RoomController@add_image');
Route::get('admin/room/{id}/edit_image', 'admin\RoomController@edit_image');
Route::put('admin/room/edit_room_image/{id}', 'admin\RoomController@update_image');
Route::delete('admin/room/gallery/{id}', 'admin\RoomController@delete_image');
Route::get('admin/room/trash', 'admin\RoomController@trash_room');
Route::patch('admin/room/restore/{id}', 'admin\RoomController@restore_single_room');
Route::patch('admin/room/restore', 'admin\RoomController@restore_trash_room');
Route::delete('admin/room/destroy/{id}', 'admin\RoomController@force_delete_room');
Route::delete('admin/room/destroy', 'admin\RoomController@force_delete_all');
Route::get('admin/room-alert/{id}', 'admin\RoomController@room_alert');
Route::put('admin/room-alert/{id}', 'admin\RoomController@store_room_alert');
Route::resource('admin/room', 'admin\RoomController');
Route::get('admin/package/trash', 'admin\PackageController@trash_package');
Route::patch('admin/package/restore/{id}', 'admin\PackageController@restore_single_package');
Route::patch('admin/package/restore', 'admin\PackageController@restore_trash_package');
Route::delete('admin/package/destroy/{id}', 'admin\PackageController@force_delete_package');
Route::delete('admin/package/destroy', 'admin\PackageController@force_delete_all');
Route::get('admin/package-meta/{id}', 'admin\PackageController@add_pkg_meta_data');
Route::put('admin/package-meta/{id}', 'admin\PackageController@save_pkg_meta_data');
Route::get('admin/package/package-page-placeholders', 'admin\PackageController@package_page_placeholders');
Route::put('admin/package/package-page-placeholders', 'admin\PackageController@save_package_page_placeholders');
Route::resource('admin/package', 'admin\PackageController');

Route::get('admin/car/{car_id}/car_prices', 'admin\CarController@car_prices');
Route::get('admin/car/{car_id}/car_prices/create', 'admin\CarController@car_price_create');
Route::post('admin/car/{car_id}/car_prices', 'admin\CarController@car_price_store');
Route::get('admin/car_prices/{price_id}/edit', 'admin\CarController@car_price_edit');
Route::put('admin/car_prices/{price_id}', 'admin\CarController@car_price_update');
Route::delete('admin/car_prices/{price_id}', 'admin\CarController@car_price_delete');
Route::get('admin/car/trash', 'admin\CarController@trash_car');
Route::patch('admin/car/restore', 'admin\CarController@restore_trash_car');
Route::patch('admin/car/restore/{id}', 'admin\CarController@restore_single_car');
Route::delete('admin/car/destroy/{id}', 'admin\CarController@force_delete_car');
Route::delete('admin/car/destroy', 'admin\CarController@force_delete_all');
Route::resource('admin/car', 'admin\CarController');
Route::resource('admin/car-features', 'admin\Car_featuresController');
Route::get('admin/car-suplier/trash', 'admin\Car_suplierController@trash_car_suplier');
Route::patch('admin/car-suplier/restore/{id}', 'admin\Car_suplierController@restore_single_car_suplier');
Route::patch('admin/car-suplier/restore', 'admin\Car_suplierController@restore_trash_car_suplier');
Route::delete('admin/car-suplier/destroy/{id}', 'admin\Car_suplierController@force_delete_car_suplier');
Route::delete('admin/car-suplier/destroy', 'admin\Car_suplierController@force_delete_all');
Route::resource('admin/car-suplier', 'admin\Car_suplierController');
Route::get('admin/card/trash', 'admin\CardController@trash_card');
Route::delete('admin/card/destroy/{id}', 'admin\CardController@force_delete_card');
Route::patch('admin/card/restore/{id}', 'admin\CardController@restore_single_card');
Route::patch('admin/card/restore', 'admin\CardController@restore_trash_card');
Route::delete('admin/card/destroy', 'admin\CardController@force_delete_all');
Route::get('admin/card/{id}/page', 'admin\CardController@page');
Route::put('admin/card/{id}/page', 'admin\CardController@save_page');
Route::resource('admin/card', 'admin\CardController');

Route::resource('admin/attraction', 'admin\AttractionController');
Route::resource('admin/package-person', 'admin\PkgPersonController');
Route::resource('admin/hotel-type', 'admin\HotelTypeController');
Route::resource('admin/room-type', 'admin\RoomTypeController');
Route::resource('admin/hotel-amenities', 'admin\HotelAmenitiesController');
Route::resource('admin/hotel-features', 'admin\HotelFeaturesController');
Route::resource('admin/review', 'admin\HotelReviewController');
Route::resource('admin/testimonial', 'admin\TestimonialController');
Route::get('admin/hotel/gallery/{id}', 'admin\HotelController@gallery');
Route::put('admin/hotel/add_image/{id}', 'admin\HotelController@add_image');
Route::post('/get_flight_from_airline', 'admin\AirlineController@get_flight_from_airline');
Route::post('/get_hotel_room', 'admin\HotelController@get_hotel_room');
Route::post('/get_flight_sche_from_airline', 'admin\AirlineController@get_flight_sche_from_airline');
Route::post('/get_car_from_flight_sche_id', 'admin\CarController@get_car_from_flight_sche_id');
Route::post('/get_hotel_from_loc_id', 'admin\HotelController@get_hotel_from_loc');

Route::post('/get_car_from_loc', 'admin\CarController@get_car_from_loc');
Route::get('/admin/gallery', 'admin\GalleryController@create');
Route::put('/admin/gallery', 'admin\GalleryController@store');
Route::get('/admin/gallery/{id}/edit_image', 'admin\GalleryController@edit_image');
Route::put('/admin/gallery/{id}', 'admin\GalleryController@update_image');
Route::delete('/admin/gallery/{id}', 'admin\GalleryController@delete_image');
Route::get('admin/page-meta/{id}', 'admin\PageController@add_page_meta_data');
Route::put('admin/page-meta/{id}', 'admin\PageController@save_page_meta_data');
Route::resource('admin/page', 'admin\PageController');
Route::get('/admin/pagelink/{page_id}', 'admin\PageController@page_links');
Route::get('/admin/pagelink/{page_id}/create', 'admin\PageController@create_link');
Route::post('/admin/pagelink/{page_id}', 'admin\PageController@store_link');
Route::get('/admin/pagelink/{pagelink_id}/edit', 'admin\PageController@edit_link');
Route::put('/admin/pagelink/{page_id}/edit/{pagelink_id}', 'admin\PageController@update_link');
Route::delete('/admin/pagelink/{page_id}', 'admin\PageController@destroy_link');

//order details route
Route::get('/admin/orders-detail', 'admin\OrderController@index')->name('all orders');
Route::get('/admin/orders-detail/{id}/edit', 'admin\OrderController@edit')->name('edit orders');
Route::put('/admin/orders-detail/{id}', 'admin\OrderController@update');
Route::delete('/admin/orders-detail/{id}', 'admin\OrderController@destroy');

//mobile site route
if (rami_checking_is_mobile() == 1) {
    Route::get('/', 'mobile\MobileHomeController@home');
    Route::get('/package/{id}', 'mobile\MobileHomeController@package_detail');
    Route::get('/fly-travel-packages', 'mobile\MobileHomeController@fly_travel_packages');
    Route::get('/fly-travel-package/{id}', 'mobile\MobileHomeController@fly_travel_packages_detail');
    Route::get('/flights/{loc_id}', 'mobile\MobileHomeController@flights');
    Route::get('/search-flights', 'mobile\MobileHomeController@serach_flights');
    Route::get('/flight-detail/{id}', 'mobile\MobileHomeController@flight_detail');
    Route::get('/package-category/{id}', 'mobile\MobileHomeController@loc_vacation_packages');
    Route::get('/search-vacation-packages', 'mobile\MobileHomeController@search_vacation_packages');
    Route::get('/loc-accommodation/{loc_id}', 'mobile\MobileHomeController@accommodation');
    Route::get('/search-accommodation/', 'mobile\MobileHomeController@search_accommodation');
    Route::get('/accommodation/{id}', 'mobile\MobileHomeController@accommodation_detail');
    Route::get('/accommodation-detail/{id}', 'mobile\MobileHomeController@accommodation_detail');
    Route::get('/testimonials', 'mobile\MobileHomeController@testimonials');
    Route::get('/contact', 'mobile\MobileHomeController@contact');
    Route::post('/send_contact', 'mobile\MobileHomeController@send_contact');
    Route::POST('/search', 'mobile\MobileHomeController@search_accommodation_hotel_code');
    Route::post('/submit-contact', 'mobile\MobileHomeController@submit_contact');

} else {
    //home route//main site
    Route::get('/', 'front\HomeController@index');
    Route::get('/flightsProfit', 'front\HomeController@flightsProfit')->name('flight_profit');
    Route::get('/package/{id}', 'front\HomeController@package');
    Route::get('/package-category/{id}', 'front\HomeController@loc_vacation_packages');
    Route::get('/search-vacation-packages', 'front\HomeController@search_vacation_packages');
    Route::get('/flight-detail/{id}', 'front\HomeController@flight_detail');
    Route::get('/flights/{loc_id}', 'front\HomeController@flights');
    Route::get('/search-flights', 'front\HomeController@serach_flights');
    Route::get('/fly-travel-packages', 'front\HomeController@fly_travel_packages');
    Route::get('/fly-travel-package/{id}', 'front\HomeController@fly_travel_packages_detail');
    Route::get('/loc-accommodation/{loc_id}', 'front\HomeController@accommodation');
    Route::get('/search-accommodation/', 'front\HomeController@search_accommodation');
    Route::get('/accommodation/{id}', 'front\HomeController@accommodation_detail');
    Route::get('/accommodation-detail/{id}', 'front\HomeController@accommodation_detail');
    Route::POST('/search', 'front\HomeController@search_accommodation_hotel_code');
    Route::get('/contact', 'front\HomeController@contact');
    Route::post('/submit-contact', 'front\HomeController@submit_contact');
    Route::get('/testimonials', 'front\HomeController@testimonial');
}

Route::post('/submit-testimonial', 'front\HomeController@submit_testimonial');
Route::get('/order-passengers', 'front\HomeController@order_passengers');
Route::get('/tourist-info', 'front\HomeController@tourist_info');
Route::post('/submit-contact-page', 'front\HomeController@submit_contact_page');
// Route::get('/loc-accommodation/{loc_id}', 'front\HomeController@accommodation');
// Route::get('/search-accommodation/', 'front\HomeController@search_accommodation');
// Route::POST('/search', 'front\HomeController@search_accommodation_hotel_code');
Route::get('/blackforest-cards', 'front\HomeController@blackforest_cards');
Route::get('/היער-השחור-מידע', 'front\HomeController@blackforest_info');
Route::get('/setup_package', 'front\HomeController@setup_package');
Route::get('/data-security', 'front\HomeController@data_security');
Route::get('/sites-policy', 'front\HomeController@sites_policy');
Route::get('/about', 'front\HomeController@about');
Route::get('/ram-travel-destination', 'front\HomeController@ram_travel_destination');
Route::get('/hiking-trails', 'front\HomeController@hikingtrails');

//cart and payment
Route::post('/cart-setup', 'secure\CartController@setup_cart');
Route::post('/verify-cart', 'secure\CartController@verify_cart');
Route::get('/order-passengers', 'secure\CheckoutController@order_passengers');
Route::post('/order-passengers', 'secure\CheckoutController@save_order_passengers');
Route::get('/payment/process', 'secure\paymentController@payment');
Route::get('payment-success', 'secure\CheckoutController@payment_success')->name('payment_success');
Route::get('/payment-fail', 'secure\CheckoutController@payment_fail')->name('payment_fail');
Route::get('/payment-notok', 'secure\paymentController@payment_notOk')->name('payment_notok');
Route::get('/payment-cancel', 'secure\paymentController@payment_notOk')->name('payment_cancel');
Route::get('/payment/verify', 'secure\paymentController@payment_verify')->name('payment_verify');

//testing_only
// Route::get('stock','secure\paymentController@stock');
// Route::get('testing_sto','secure\paymentController@testing_pdf');

//automation_route
Route::get('auto/location_flight_count', 'automation\AutomationController@location_flight_count');
Route::get('auto/location_fch_count', 'automation\AutomationController@location_fch_count');
Route::get('auto/location_fc_count', 'automation\AutomationController@location_fc_count');
Route::get('auto/location_hotel_count', 'automation\AutomationController@location_hotel_count');
Route::get('auto/import_pages', 'automation\AutomationController@import_pages');
Route::get('auto/copy_links', 'automation\AutomationController@copy_links');
Route::get('auto/setup_all_package_cost', 'automation\AutomationController@setup_all_package_cost');
Route::get('auto/update_pack_profit', 'automation\AutomationController@update_pack_profit');

//Ajax Controller
Route::post('/load_more', 'ajax\AjaxController@ajax_for_load_more');
Route::post('/package_load_more', 'ajax\AjaxController@ajax_for_package_load_more');
Route::post('/flight_load_more', 'ajax\AjaxController@ajax_for_flight_load_more');
Route::post('/hotel_load_more', 'ajax\AjaxController@ajax_for_hotel_load_more');
Route::post('/packages-location-dates', 'ajax\AjaxController@ajax_for_packages_location_dates');
Route::post('/flights-src-desti-dates', 'ajax\AjaxController@ajax_for_flights_src_desti_dates');
Route::post('/submit-contact-form', 'ajax\AjaxController@ajax_for_submit_contact_form');


Route::get('/wp-content/uploads/{order}', 'secure\paymentController@notAllow');

Route::get('/{slug}', 'front\HomeController@static_page');