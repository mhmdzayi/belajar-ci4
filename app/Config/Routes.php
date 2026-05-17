 
 
<?php 
 
use CodeIgniter\Router\RouteCollection; 
 
/** @var RouteCollection $routes */ 
 
// Route default (halaman beranda)  
$routes->get('/', 'Beranda::index'); 
 
// Route halaman tentang  
$routes->get('tentang', 'Beranda::tentang');

// Route halaman buku
$routes->get('buku', 'Buku::index');

// Route halaman profil
$routes->get('profil', 'Profil::index');

// Route halaman galeri
$routes->get('galeri', 'Galeri::index');

// Route controller Demo 
$routes->get('demo', 'Demo::index'); 

// Route CRUD Buku 
$routes->get('buku',                'Buku::index'); 
$routes->get('buku/tambah',         'Buku::tambah'); 
$routes->post('buku/simpan',        'Buku::simpan'); 
$routes->get('buku/detail/(:num)',  'Buku::detail/$1'); 
$routes->get('buku/edit/(:num)',    'Buku::edit/$1'); 
$routes->post('buku/update/(:num)', 'Buku::update/$1'); 
$routes->get('buku/hapus/(:num)',   'Buku::hapus/$1'); 
$routes->get('buku/ekspor',         'Buku::ekspor');

$routes->get('akademik', 'Akademik::index');
$routes->get('akademik/matkul', 'Akademik::matkul');
$routes->get('akademik/nilai/(:any)', 'Akademik::nilai/$1'); // (:any) untuk menerima NIM