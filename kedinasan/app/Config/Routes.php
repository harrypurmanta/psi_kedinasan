<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->get('login', '\App\Controllers\Login::index');
$routes->get('login/checklogin', '\App\Controllers\Login::checklogin');
$routes->post('login/checklogin', '\App\Controllers\Login::checklogin');
$routes->post('login/logout', '\App\Controllers\Login::logout');
$routes->get('login/logout', '\App\Controllers\Login::logout');
$routes->get('login/register', '\App\Controllers\Login::register');
$routes->post('login/register', '\App\Controllers\Login::register');
$routes->get('login/simpanregister', '\App\Controllers\Login::simpanregister');
$routes->post('login/simpanregister', '\App\Controllers\Login::simpanregister');

$routes->get('home', '\App\Controllers\Home::index');
$routes->get('passhand/petunjuksoal', '\App\Controllers\Passhand::petunjuksoal');
$routes->post('passhand/petunjuksoal', '\App\Controllers\Passhand::petunjuksoal');
$routes->get('passhand/startujian', '\App\Controllers\Passhand::startujian');
$routes->post('passhand/startujian', '\App\Controllers\Passhand::startujian');
$routes->get('passhand/showresult', '\App\Controllers\Passhand::showresult');
$routes->post('passhand/showresult', '\App\Controllers\Passhand::showresult');

$routes->get('sikapkerja/petunjuksoal', '\App\Controllers\Sikapkerja::petunjuksoal');
$routes->post('sikapkerja/petunjuksoal', '\App\Controllers\Sikapkerja::petunjuksoal');
$routes->get('sikapkerja/startujian', '\App\Controllers\Sikapkerja::startujian');
$routes->post('sikapkerja/startujian', '\App\Controllers\Sikapkerja::startujian');

$routes->get('admin', '\App\Controllers\Admin\Dashboard::index');
$routes->get('admin/soal', '\App\Controllers\Admin\Soal::index');
$routes->get('admin/soallatihan', '\App\Controllers\Admin\Soallatihan::index');
$routes->get('admin/jawaban', '\App\Controllers\Admin\Jawaban::index');
$routes->get('admin/jawabanlatihan', '\App\Controllers\Admin\Jawabanlatihan::index');
$routes->get('admin/users', '\App\Controllers\Admin\Users::index');
$routes->get('admin/users/resetmateri/(:segment)', '\App\Controllers\Admin\Users::resetmateri/$1');
$routes->get('admin/users/tambahuser', '\App\Controllers\Admin\Users::tambahuser');
$routes->post('admin/users/tambahuser', '\App\Controllers\Admin\Users::tambahuser');
$routes->get('admin/users/edituser', '\App\Controllers\Admin\Users::edituser');
$routes->post('admin/users/edituser', '\App\Controllers\Admin\Users::edituser');
$routes->get('admin/users/simpanuser', '\App\Controllers\Admin\Users::simpanuser');
$routes->post('admin/users/simpanuser', '\App\Controllers\Admin\Users::simpanuser');
$routes->get('admin/users/updateuser', '\App\Controllers\Admin\Users::updateuser');
$routes->post('admin/users/updateuser', '\App\Controllers\Admin\Users::updateuser');
$routes->get('admin/users/hapususer', '\App\Controllers\Admin\Users::hapususer');
$routes->post('admin/users/hapususer', '\App\Controllers\Admin\Users::hapususer');
$routes->get('admin/users/hasilexcel/(:num)/(:num)', '\App\Controllers\Admin\Users::hasilexcel/$1/$2');
$routes->post('admin/users/hasilexcel/(:num)/(:num)', '\App\Controllers\Admin\Users::hasilexcel/$1/$2');
$routes->get('admin/users/hasilpdf/(:num)/(:num)', '\App\Controllers\Admin\Users::hasilpdf/$1/$2');
$routes->post('admin/users/hasilpdf/(:num)/(:num)', '\App\Controllers\Admin\Users::hasilpdf/$1/$2');
$routes->get('admin/users/hasilweb/(:num)/(:num)', '\App\Controllers\Admin\Users::hasilweb/$1/$2');
$routes->post('admin/users/hasilweb/(:num)/(:num)', '\App\Controllers\Admin\Users::hasilweb/$1/$2');
$routes->get('admin/users/hasillatihan/(:num)/(:num)', '\App\Controllers\Admin\Users::hasillatihan/$1/$2');
$routes->post('admin/users/hasillatihan/(:num)/(:num)', '\App\Controllers\Admin\Users::hasillatihan/$1/$2');
$routes->get('admin/users/hasilused/(:num)/(:num)/(:num)', '\App\Controllers\Admin\Users::hasilused/$1/$2/$3');
$routes->post('admin/users/hasilused/(:num)/(:num)/(:num)', '\App\Controllers\Admin\Users::hasilused/$1/$2/$3');
$routes->get('admin/hasil/(:num)', '\App\Controllers\Admin\Hasil::index/$1');
$routes->post('admin/hasil/(:num)', '\App\Controllers\Admin\Hasil::index/$1');
$routes->get('admin/hasil/latihanmateri/(:num)/(:num)', '\App\Controllers\Admin\Hasil::latihanmateri/$1/$2');
$routes->post('admin/hasil/latihanmateri/(:num)/(:num)', '\App\Controllers\Admin\Hasil::latihanmateri/$1/$2');
$routes->get('admin/hasil/hasillatihanmateri/(:num)/(:num)/(:num)', '\App\Controllers\Admin\Hasil::hasillatihanmateri/$1/$2/$3');
$routes->post('admin/hasil/hasillatihanmateri/(:num)/(:num)/(:num)', '\App\Controllers\Admin\Hasil::hasillatihanmateri/$1/$2/$3');


$routes->get('jawaban/showjawaban', '\App\Controllers\Admin\Jawaban::showjawaban');
$routes->post('jawaban/showjawaban', '\App\Controllers\Admin\Jawaban::showjawaban');
$routes->get('jawaban/editjawaban', '\App\Controllers\Admin\Jawaban::editjawaban');
$routes->post('jawaban/editjawaban', '\App\Controllers\Admin\Jawaban::editjawaban');
$routes->get('jawaban/hapusjawaban', '\App\Controllers\Admin\Jawaban::hapusjawaban');
$routes->post('jawaban/hapusjawaban', '\App\Controllers\Admin\Jawaban::hapusjawaban');
$routes->get('jawaban/updatejawaban', '\App\Controllers\Admin\Jawaban::updatejawaban');
$routes->post('jawaban/updatejawaban', '\App\Controllers\Admin\Jawaban::updatejawaban');
$routes->get('jawaban/tambahjawaban', '\App\Controllers\Admin\Jawaban::tambahjawaban');
$routes->post('jawaban/tambahjawaban', '\App\Controllers\Admin\Jawaban::tambahjawaban');
$routes->get('jawaban/simpanjawaban', '\App\Controllers\Admin\Jawaban::simpanjawaban');
$routes->post('jawaban/simpanjawaban', '\App\Controllers\Admin\Jawaban::simpanjawaban');



$routes->get('soal/tambahsoal', '\App\Controllers\Admin\Soal::tambahsoal');
$routes->post('soal/tambahsoal', '\App\Controllers\Admin\Soal::tambahsoal');
$routes->get('soal/simpansoal', '\App\Controllers\Admin\Soal::simpansoal');
$routes->post('soal/simpansoal', '\App\Controllers\Admin\Soal::simpansoal');
$routes->get('soal/editsoal', '\App\Controllers\Admin\Soal::editsoal');
$routes->post('soal/editsoal', '\App\Controllers\Admin\Soal::editsoal');
$routes->get('soal/updatesoal', '\App\Controllers\Admin\Soal::updatesoal');
$routes->post('soal/updatesoal', '\App\Controllers\Admin\Soal::updatesoal');
$routes->get('soal/hapussoal', '\App\Controllers\Admin\Soal::hapussoal');
$routes->post('soal/hapussoal', '\App\Controllers\Admin\Soal::hapussoal');
$routes->get('soal/showjawaban', '\App\Controllers\Admin\Soal::showjawaban');
$routes->post('soal/showjawaban', '\App\Controllers\Admin\Soal::showjawaban');
$routes->get('soal/simpanjawaban', '\App\Controllers\Admin\Soal::simpanjawaban');
$routes->post('soal/simpanjawaban', '\App\Controllers\Admin\Soal::simpanjawaban');
$routes->get('soal/deletejawaban', '\App\Controllers\Admin\Soal::deletejawaban');
$routes->post('soal/deletejawaban', '\App\Controllers\Admin\Soal::deletejawaban');
$routes->get('soal/showsoal', '\App\Controllers\Admin\Soal::showsoal');
$routes->post('soal/showsoal', '\App\Controllers\Admin\Soal::showsoal');
$routes->get('soal/tambahsoallatihan', '\App\Controllers\Admin\Soal::tambahsoallatihan');
$routes->post('soal/tambahsoallatihan', '\App\Controllers\Admin\Soal::tambahsoallatihan');
$routes->get('soal/simpansoallatihan', '\App\Controllers\Admin\Soal::simpansoallatihan');
$routes->post('soal/simpansoallatihan', '\App\Controllers\Admin\Soal::simpansoallatihan');
$routes->get('soal/updatestatus', '\App\Controllers\Admin\Soal::updatestatus');
$routes->post('soal/updatestatus', '\App\Controllers\Admin\Soal::updatestatus');

$routes->get('soallatihan/tambahsoallatihan', '\App\Controllers\Admin\Soallatihan::tambahsoallatihan');
$routes->post('soallatihan/tambahsoallatihan', '\App\Controllers\Admin\Soallatihan::tambahsoallatihan');
$routes->get('soallatihan/simpansoal', '\App\Controllers\Admin\Soallatihan::simpansoal');
$routes->post('soallatihan/simpansoal', '\App\Controllers\Admin\Soallatihan::simpansoaL');
$routes->get('soallatihan/showsoal', '\App\Controllers\Admin\Soallatihan::showsoal');
$routes->post('soallatihan/showsoal', '\App\Controllers\Admin\Soallatihan::showsoal');
$routes->get('soallatihan/editsoal', '\App\Controllers\Admin\Soallatihan::editsoal');
$routes->post('soallatihan/editsoal', '\App\Controllers\Admin\Soallatihan::editsoal');
$routes->get('soallatihan/updatesoal', '\App\Controllers\Admin\Soallatihan::updatesoal');
$routes->post('soallatihan/updatesoal', '\App\Controllers\Admin\Soallatihan::updatesoal');
$routes->get('soallatihan/hapussoal', '\App\Controllers\Admin\Soallatihan::hapussoal');
$routes->post('soallatihan/hapussoal', '\App\Controllers\Admin\Soallatihan::hapussoal');

$routes->get('jawabanlatihan/showjawaban', '\App\Controllers\Admin\Jawabanlatihan::showjawaban');
$routes->post('jawabanlatihan/showjawaban', '\App\Controllers\Admin\Jawabanlatihan::showjawaban');
$routes->get('jawabanlatihan/editjawaban', '\App\Controllers\Admin\Jawabanlatihan::editjawaban');
$routes->post('jawabanlatihan/editjawaban', '\App\Controllers\Admin\Jawabanlatihan::editjawaban');
$routes->get('jawabanlatihan/hapusjawaban', '\App\Controllers\Admin\Jawabanlatihan::hapusjawaban');
$routes->post('jawabanlatihan/hapusjawaban', '\App\Controllers\Admin\Jawabanlatihan::hapusjawaban');
$routes->get('jawabanlatihan/updatejawaban', '\App\Controllers\Admin\Jawabanlatihan::updatejawaban');
$routes->post('jawabanlatihan/updatejawaban', '\App\Controllers\Admin\Jawabanlatihan::updatejawaban');
$routes->get('jawabanlatihan/tambahjawaban', '\App\Controllers\Admin\Jawabanlatihan::tambahjawaban');
$routes->post('jawabanlatihan/tambahjawaban', '\App\Controllers\Admin\Jawabanlatihan::tambahjawaban');
$routes->get('jawabanlatihan/simpanjawaban', '\App\Controllers\Admin\Jawabanlatihan::simpanjawaban');
$routes->post('jawabanlatihan/simpanjawaban', '\App\Controllers\Admin\Jawabanlatihan::simpanjawaban');


$routes->get('materi', '\App\Controllers\Materi::index');
$routes->get('latihan', '\App\Controllers\Latihan::index');
$routes->get('latihan/petunjuksoal', '\App\Controllers\Latihan::petunjuksoal');
$routes->post('latihan/petunjuksoal', '\App\Controllers\Latihan::petunjuksoal');
$routes->get('latihan/startlatihan', '\App\Controllers\Latihan::startlatihan');
$routes->post('latihan/startlatihan', '\App\Controllers\Latihan::startlatihan');
$routes->get('latihan/showresult', '\App\Controllers\Latihan::showresult');
$routes->post('latihan/showresult', '\App\Controllers\Latihan::showresult');
$routes->get('latihan/showsk_grp', '\App\Controllers\Latihan::showsk_grp');
$routes->post('latihan/showsk_grp', '\App\Controllers\Latihan::showsk_grp');

$routes->get('tryout/ujian/(:segment)/(:segment)', 'Tryout::ujian/$1/$2');
$routes->get('tryout/sikapkerja/(:segment)/(:segment)', 'Tryout::sikapkerja/$1/$2');
// $routes->get('tryout/hasiltryout/(:segment)', 'Tryout::hasiltryout/$1');
$routes->get('tryout/hasiltryout/(:segment)', '\App\Controllers\Tryout::hasiltryout/$1');


// $routes->group('admin', function($routes) {
//     $routes->post('upsert-gambar-sk', 'Soalsikapkerjalatihan::upsertGambarSk');
// });
// $routes->post('upsert-gambar-sk', 'Soalsikapkerjalatihan::upsertGambarSk');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
