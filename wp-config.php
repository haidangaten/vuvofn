<?php
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung 
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt, 
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */
define('DB_NAME', 'vuvofn');

/** Username của database */
define('DB_USER', 'root');

/** Mật khẩu của database */
define('DB_PASSWORD', '');

/** Hostname của database */
define('DB_HOST', 'localhost');

/** Database charset sử dụng để tạo bảng database. */
define('DB_CHARSET', 'utf8mb4');

/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', '');

/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '.{h15>VUgwQApIklj r+5}4W,|XmQ0(8cZEPD(Tdq=[:)&wDSUNX<^uos>4FeQGN');
define('SECURE_AUTH_KEY',  '6YR<Hg?0>|NPmvaWRd`TWJA&Qt=xX,=|| U0ahvHKx>*cnq`ho/@Mbmx$&Cy|t.X');
define('LOGGED_IN_KEY',    'bZwMkHXswm%&*xqdh]_tfg?*DPp2Xq1hZqrP4AG6sj0s4OiQYYQMiSzl#q3kdc^a');
define('NONCE_KEY',        'g;r2uNDt0= H1fVyp>tIbjK]ICb7JZ_h0/,Py%:svAl>Q~g9e!o<5PyVrOIU+v^~');
define('AUTH_SALT',        '{V;p:R4j64&=iLdFJAzG?T)-PtXhO>rSm%Kvk-@t+<kki=PC+8{ /_rmGc=ILd{%');
define('SECURE_AUTH_SALT', '<af%Kj:rwu0z]qY<(Y|+b;Jsd({V(p_Tjt?{]RJ-.TMn- 2~Nr xdlVFjnRi/w]{');
define('LOGGED_IN_SALT',   '@!fob /5Xc6zH=0m[8,`j_G^bS/gfE3.U:XXJ+gM{QN4A[ujqsr_jo=lTB*`co9E');
define('NONCE_SALT',       '/S|7CV.E-qjMfR-(}5YyI[E-v2[Io>6x3Bk5DIohV[wS9D{Bl1%kft=GJ.t1Y{1 ');

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix  = 'wp_';

/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
error_reporting(0); ini_set('display_errors',0);

/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
