<?php

require_once 'config/database.php';

spl_autoload_register(function ($class_name) {
    if (file_exists('models/' . $class_name . '.php')) {
        require_once 'models/' . $class_name . '.php';
    } else if (file_exists('controllers/' . $class_name . '.php')) {
        require_once 'controllers/' . $class_name . '.php';
    } else if (file_exists('core/' . $class_name . '.php')) {
        require_once 'core/' . $class_name . '.php';
    }
});

session_start();

$url = isset($_GET['url']) ? $_GET['url'] : 'index';

switch ($url) {
    case 'index':
        require_once 'views/index.php';
        break;
    case 'all-sach':
        require_once 'views/all-sach/index.php';
        break;
    case 'login':
        require_once 'views/login/login.php';
        break;
    case 'check_login':
        require_once 'views/login/check_login.php';
        break;
    case 'forgot-password':
        require_once 'views/login/forgot-password.php';
        break;
    case 'send_reset_email':
        require_once 'views/login/send_reset_email.php';
        break;
    case 'check-code':
        require_once 'views/login/check_code.php';
        break;
    case 'reset_password':
        require_once 'views/login/reset_password.php';
        break;
    case 'logout':
        require_once 'views/login/logout.php';
        break;
    case 'register':
        require_once 'views/register/register.php';
        break;
    case 'check_register':
        require_once 'views/register/check_register.php';
        break;
    case 'timkiem':
        require_once 'views/tim-kiem/search.php';
        break;
    case 'locsach':
        require_once 'views/loc-sach/filter.php';
        break;
    case 'chi-tiet-sach':
        require_once 'views/chi-tiet-sach/chi-tiet-sach.php';
        break;
    case 'profile':
        require_once 'views/profile/user.php';
        break;
    case 'profile/check-password':
        require_once 'views/profile/check-password.php';
        break;
    case 'profile/change-password':
        require_once 'views/profile/change-password.php';
        break;
    case 'profile/edit':
        require_once 'views/profile/edit.php';
        break;
    case 'profile/update':
        require_once 'views/profile/update.php';
        break;
    case 'the-thu-vien':
        require_once 'views/the-thu-vien/index.php';
        break;
    case 'the-thu-vien/giahan':
        require_once 'views/the-thu-vien/giahan.php';
        break;
    case 'the-thu-vien/dangky':
        require_once 'views/the-thu-vien/dangky_thethuvien.php';
        break;
    case 'the-thu-vien/dangky/store':
        require_once 'views/the-thu-vien/store.php';
        break;
    case 'the-thu-vien/active':
        require_once 'views/the-thu-vien/active.php';
        break;
    case 'the-thu-vien/check_active':
        require_once 'views/the-thu-vien/check_active.php';
        break;
    case 'dang-ky-muon':
        require_once 'views/dang-ky-muon/index.php';
        break;
    case 'dang-ky-muon/store':
        require_once 'views/dang-ky-muon/store.php';
        break;
    case 'phieu-muon':
        require_once 'views/phieu-muon/index.php';
        break;
    case 'phieu-muon/detail':
        require_once 'views/phieu-muon/detail.php';
        break;
    case 'phieu-muon/giahan':
        require_once 'views/phieu-muon/giahan.php';
        break;
    case 'phieu-muon/history':
        require_once 'views/phieu-muon/history.php';
        break;
    case 'yeu-thich-sach':
        require_once 'views/yeu-thich-sach/index.php';
        break;
    case 'yeu-thich-sach/store':
        require_once 'views/yeu-thich-sach/store.php';
        break;
    case 'yeu-thich-sach/delete':
        require_once 'views/yeu-thich-sach/delete.php';
        break;
    case 'danh-gia':
        require_once 'views/danh-gia/index.php';
        break;
    case 'danh-gia/store':
        require_once 'views/danh-gia/store.php';
        break;
    case 'binh-luan/store':
        require_once 'views/binh-luan/store.php';
        break;
    case 'cart':
        require_once 'views/cart/index.php';
        break;
    case 'cart/store':
        require_once 'views/cart/store.php';
        break;
    case 'cart/remove':
        require_once 'views/cart/remove.php';
        break;
    case 'cart/clear':
        require_once 'views/cart/clear.php';
        break;
    case 'cart/update_quantity':
        require_once 'views/cart/update_quantity.php';
        break;
    case 'cart/borrow':
        require_once 'views/cart/borrow.php';
        break;
    case 'offline':
        require_once 'offline.php';
        break;
// Admin
    case 'admin/dashboard':
        require_once 'views/admin/dashboard.php';
        break;
    case 'admin/quanlyphieumuon':
        require_once 'views/admin/phieu-muon/index.php';
        break;
    case 'admin/quanlyphieumuon/edit':
        require_once 'views/admin/phieu-muon/edit.php';
        break;
    case 'admin/quanlyphieumuon/update':
        require_once 'views/admin/phieu-muon/update.php';
        break;
    case 'admin/quanlyphieumuon/delete':
        require_once 'views/admin/phieu-muon/delete.php';
        break;
    case 'admin/quanlyphieumuon/return':
        require_once 'views/admin/phieu-muon/return.php';
        break;
    case 'admin/quanlyphieumuon/returnBrokenOrLost':
        require_once 'views/admin/phieu-muon/returnBrokenOrLost.php';
        break;
    case 'admin/quanlyphieumuon/returnBrokenOrLost/handle_return':
        require_once 'views/admin/phieu-muon/handle_return.php';
        break;
    case 'admin/quanlyxuphat':
        require_once 'views/admin/xu-phat/index.php';
        break;
    case 'admin/quanlyxuphat/print':
        require_once 'views/admin/xu-phat/print.php';
        break;
    case 'admin/quanlyxuphat/return':
        require_once 'views/admin/xu-phat/return.php';
        break;
    case 'admin/quanlyphieumuon/receive':
        require_once 'views/admin/phieu-muon/receive.php';
        break;
    case 'admin/quanlyphieumuon/print':
        require_once 'views/admin/phieu-muon/print.php';
        break;
    case 'admin/quanlydangkymuon':
        require_once 'views/admin/dang-ky-muon/index.php';
        break;
    case 'admin/quanlydangkymuon/store':
        require_once 'views/admin/dang-ky-muon/store.php';
        break;
    case 'admin/quanlydangkymuon/search':
        require_once 'views/admin/dang-ky-muon/search.php';
        break;
    case 'admin/quanlythethuvien':
        require_once 'views/admin/the-thu-vien/index.php';
        break;
    case 'admin/quanlythethuvien/store':
        require_once 'views/admin/the-thu-vien/store.php';
        break;
    case 'admin/quanlythethuvien/search':
        require_once 'views/admin/the-thu-vien/search.php';
        break;
    case 'admin/quanlythethuvien/quanlythe':
        require_once 'views/admin/the-thu-vien/quanlythe.php';
        break;
    case 'admin/quanlythethuvien/quanlythekhoa':
        require_once 'views/admin/the-thu-vien/quanlythekhoa.php';
        break;
    case 'admin/quanlythethuvien/mokhoathe':
        require_once 'views/admin/the-thu-vien/mokhoathe.php';
        break;
    case 'admin/quanlythethuvien/print':
        require_once 'views/admin/the-thu-vien/print.php';
        break;
    case 'admin/quanlythethuvien/sendCode':
        require_once 'views/admin/the-thu-vien/sendCode.php';
        break;
    case 'admin/quanlydocgia':
        require_once 'views/admin/doc-gia/index.php';
        break;
    case 'admin/quanlydocgia/add':
        require_once 'views/admin/doc-gia/add.php';
        break;
    case 'admin/quanlydocgia/store':
        require_once 'views/admin/doc-gia/store.php';
        break;
    case 'admin/quanlydocgia/edit':
        require_once 'views/admin/doc-gia/edit.php';
        break;
    case 'admin/quanlydocgia/update':
        require_once 'views/admin/doc-gia/update.php';
        break;
    case 'admin/quanlydocgia/delete':
        require_once 'views/admin/doc-gia/delete.php';
        break;
    case 'admin/quanlydocgia/search':
        require_once 'views/admin/doc-gia/search.php';
        break;
    case 'admin/quanlydocgia/import':
        require_once 'views/admin/doc-gia/import.php';
        break;
    case 'admin/quanlysach':
        require_once 'views/admin/sach/index.php';
        break;
    case 'admin/quanlysach/add':
        require_once 'views/admin/sach/add.php';
        break;
    case 'admin/quanlysach/store':
        require_once 'views/admin/sach/store.php';
        break;
    case 'admin/quanlysach/edit':
        require_once 'views/admin/sach/edit.php';
        break;
    case 'admin/quanlysach/update':
        require_once 'views/admin/sach/update.php';
        break;
    case 'admin/quanlysach/delete':
        require_once 'views/admin/sach/delete.php';
        break;
    case 'admin/quanlysach/search':
        require_once 'views/admin/sach/search.php';
        break;
    case 'admin/quanlyloaisach':
        require_once 'views/admin/loai-sach/index.php';
        break;
    case 'admin/quanlyloaisach/add':
        require_once 'views/admin/loai-sach/add.php';
        break;
    case 'admin/quanlyloaisach/store':
        require_once 'views/admin/loai-sach/store.php';
        break;
    case 'admin/quanlyloaisach/edit':
        require_once 'views/admin/loai-sach/edit.php';
        break;
    case 'admin/quanlyloaisach/update':
        require_once 'views/admin/loai-sach/update.php';
        break;
    case 'admin/quanlyloaisach/delete':
        require_once 'views/admin/loai-sach/delete.php';
        break;
    case 'admin/quanlytacgia':
        require_once 'views/admin/tacgia/index.php';
        break;
    case 'admin/quanlytacgia/add':
        require_once 'views/admin/tacgia/add.php';
        break;
    case 'admin/quanlytacgia/store':
        require_once 'views/admin/tacgia/store.php';
        break;
    case 'admin/quanlytacgia/edit':
        require_once 'views/admin/tacgia/edit.php';
        break;
    case 'admin/quanlytacgia/update':
        require_once 'views/admin/tacgia/update.php';
        break;
    case 'admin/quanlytacgia/delete':
        require_once 'views/admin/tacgia/delete.php';
        break;
    case 'admin/quanlytacgia/search':
        require_once 'views/admin/tacgia/search.php';
        break;
    case 'admin/quanlynhaxuatban':
        require_once 'views/admin/nha-xuat-ban/index.php';
        break;
    case 'admin/quanlynhaxuatban/add':
        require_once 'views/admin/nha-xuat-ban/add.php';
        break;
    case 'admin/quanlynhaxuatban/store':
        require_once 'views/admin/nha-xuat-ban/store.php';
        break;
    case 'admin/quanlynhaxuatban/edit':
        require_once 'views/admin/nha-xuat-ban/edit.php';
        break;
    case 'admin/quanlynhaxuatban/update':
        require_once 'views/admin/nha-xuat-ban/update.php';
        break;
    case 'admin/quanlynhaxuatban/delete':
        require_once 'views/admin/nha-xuat-ban/delete.php';
        break;
    case 'admin/quanlynhaxuatban/search':
        require_once 'views/admin/nha-xuat-ban/search.php';
        break;
    case 'admin/quanlydausach':
        require_once 'views/admin/dau-sach/index.php';
        break;
    case 'admin/quanlydausach/add':
        require_once 'views/admin/dau-sach/add.php';
        break;
    case 'admin/quanlydausach/store':
        require_once 'views/admin/dau-sach/store.php';
        break;
    case 'admin/quanlydausach/edit':
        require_once 'views/admin/dau-sach/edit.php';
        break;
    case 'admin/quanlydausach/update':
        require_once 'views/admin/dau-sach/update.php';
        break;
    case 'admin/quanlydausach/delete':
        require_once 'views/admin/dau-sach/delete.php';
        break;
    case 'admin/quanlydausach/search':
        require_once 'views/admin/dau-sach/search.php';
        break;
    case 'about':
        require_once 'views/layouts/about.php';
        break;
    case 'contact':
        require_once 'views/layouts/contact.php';
        break;
    case 'admin/quantrivien':
        require_once 'views/admin/quan-tri-vien/index.php';
        break;
    case 'admin/quantrivien/edit':
        require_once 'views/admin/quan-tri-vien/edit.php';
        break;
    case 'admin/quantrivien/update':
        require_once 'views/admin/quan-tri-vien/update.php';
        break;
    case 'admin/quantrivien/list':
        require_once 'views/admin/quan-tri-vien/list.php';
        break;
    case 'admin/quantrivien/add':
        require_once 'views/admin/quan-tri-vien/add.php';
        break;
    case 'admin/quantrivien/store':
        require_once 'views/admin/quan-tri-vien/store.php';
        break;
    case 'admin/quantrivien/delete':
        require_once 'views/admin/quan-tri-vien/delete.php';
        break;
    case 'admin/quantrivien/search':
        require_once 'views/admin/quan-tri-vien/search.php';
        break;
    case 'admin/quantrivien/change-password':
        require_once 'views/admin/quan-tri-vien/change-password.php';
        break;
    case 'admin/quantrivien/update-password':
        require_once 'views/admin/quan-tri-vien/update-password.php';
        break;
    case 'log':
        require_once 'views/view_log/view_error.php';
        break;
    default:
        require_once 'views/error/404.php';
        break;
}

?>
