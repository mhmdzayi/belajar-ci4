 
 
<?php 
 
use CodeIgniter\Router\RouteCollection; 
 
/** @var RouteCollection $routes */ 
 
// Route default (halaman beranda)  
$routes->get('/', 'Beranda::index'); 
 
// Route halaman tentang  
$routes->get('tentang', 'Beranda::tentang');

// Route halaman profil
$routes->get('profil', 'Profil::index');

// Route controller Demo 
$routes->get('demo', 'Demo::index'); 

$routes->get('akademik', 'Akademik::index');
$routes->get('akademik/matkul', 'Akademik::matkul');
$routes->get('akademik/nilai/(:any)', 'Akademik::nilai/$1'); // (:any) untuk menerima NIM