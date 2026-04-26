 
<?php 
 
use CodeIgniter\Router\RouteCollection; 
 
/** 
 * @var RouteCollection $routes 
 */ 
 
// Route default (halaman beranda) 
$routes->get('/', 'Beranda::index'); 
 
// Route halaman tentang 
$routes->get('tentang', 'Beranda::tentang'); 
 
// Route dengan parameter numerik 
$routes->get('pengguna/(:num)', 'Beranda::pengguna/$1'); 
 
// Route halaman waktu 
$routes->get('waktu', 'Beranda::waktu'); 
  
// Route GET — untuk menampilkan halaman 
$routes->get('/', 'Home::index'); 
$routes->get('tentang', 'Home::tentang'); 
$routes->get('produk', 'Produk::index'); 
  
// Route dengan parameter — (:num) hanya terima angka, (:any) terima apapun 
$routes->get('produk/detail/(:num)', 'Produk::detail/$1'); 
$routes->get('produk/kategori/(:any)', 'Produk::kategori/$1'); 
  
// Route POST — untuk menerima data form 
$routes->post('produk/simpan', 'Produk::simpan'); 
  
// Route PUT dan DELETE — untuk REST API 
$routes->put('api/produk/(:num)', 'Api\Produk::update/$1'); 
$routes->delete('api/produk/(:num)', 'Api\Produk::hapus/$1'); 
  
// Route group — prefix yang sama 
$routes->group('admin', function($routes) { 
    $routes->get('dashboard', 'Admin\Dashboard::index'); 
    $routes->get('pengguna', 'Admin\Pengguna::index'); 
}); 
// Menghasilkan: /admin/dashboard dan /admin/pengguna 
  
// Route dengan filter 
$routes->get('profil', 'Akun::profil', ['filter' => 'auth']); 
  
// Named route — route yang diberi nama untuk kemudahan referensi 
$routes->get('login', 'Auth::login', ['as' => 'halaman_login']); 