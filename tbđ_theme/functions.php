<?php
/*
@ Khai báo hằng giá trị
  @ THEME_URL = Lấy đường dẫn tới thư mục theme
  @ CORE = Lấy đường dẫn tới thư mục core
*/
define( 'THEME_URL', get_stylesheet_directory() );
define ( 'CORE', THEME_URL . "/core" );
/*
@ Nhúng file /core/init.php
*/
require_once( CORE . "/init.php" );

/*
@ Thiết lập chiều rộng nội dung
*/
if(!isset($content_width)){
  $content_width = 620;
}

/*
@ KHAI BÁO CHỨC NĂNG CỦA THEME
*/
if(!function_exists('tmq_theme_setup')){
  function tmq_theme_setup() {
    /*@ Thiết lập textdomain */
    $language_folder = THEME_URL . '/languages';
    load_theme_textdomain( 'tmq', $language_folder );

    /*@ Thêm chức năng format cho phần viết post */
    add_theme_support( 'post-formats',['image', 'link']);

    /*@ Thêm chức năng thumbnails cho phần viết post */
    add_theme_support( 'post-thumbnails' );

    /*@ Thêm custom background */
    $default_background = array(
      'default-color' => '#e8e8e8'
    );
    add_theme_support( 'custom-background', $default_background ); //Đăng kí Background (Phần Appearance/Background/Colors)

    /*@ Thêm lựa chọn menu (cho phần Theme locations) */
    register_nav_menu( 'navbar', __('Thiết bị điện: Navbar (Menu chính)', 'tmq') ); //Đăng kí Menus (Phần Appeareance/Menus có thể dùng được)

    /*@ Tạo sidebar */
    $left_sidebar = array(
      'name' => __('Thiết bị điện: Left Sidebar', 'tmq'),
      'id' => 'left-sidebar',
      'description' => __('Thiết bị điện: Left sidebar'),
      'class' => 'left-sidebar',
      'before_title' => '<h3 class="widgettitle">',
      'after_title' => '</h3>'
    );
    register_sidebar( $left_sidebar ); //Đăng kí left-sidebar cho Widget (Hiển thị phần Apprearance/Widgets)

    $right_sidebar = array(
      'name' => __('Thiết bị điện: Right Sidebar', 'tmq'),
      'id' => 'right-sidebar',
      'description' => __('Thiết bị điện: Right sidebar'),
      'class' => 'right-sidebar',
      'before_title' => '<h3 class="widgettitle">',
      'after_title' => '</h3>'
    );
    register_sidebar( $right_sidebar ); //Đăng kí right-sidebar cho Widget
  }
  add_action('init', 'tmq_theme_setup'); //Hook
}

/* TEMPLATE FUNCTIONS */

/*
@ Hiển thị header
*/
if (!function_exists('tmq_header')){
  function tmq_header(){
    global $tmq_options; //Biến để lấy giá trị trong theme option
    if( $tmq_options['logo-on'] == 0 ): //Nếu không cài đặt logo thì hiển thị chữ
     printf( '<p id="none-logo"><a href="%1$s" title="%2$s">%3$s</a></p>',
        get_bloginfo('url'),
        get_bloginfo('description'),
        get_bloginfo('sitename') );
    ?>
    <?php else: ?>
    <div id="logo">
      <img src="<?php echo $tmq_options['logo-image']['url']; ?>"/>
    </div> <!-- End #logo -->
    <?php endif; ?>
    <div id="site-title"><h2><?php bloginfo('title'); ?></h2></div>
    <div id="site-description"><p><?php bloginfo('description'); ?></p></div>
    <?php
  }
}

/*
@ Hàm hiển thị Thumbnail (Featured Image) -->
*/
if(!function_exists('tmq_thumbnail')){
  function tmq_thumbnail($size){
          //Chỉ hiển thị thumbnail cho những post đủ điều kiện sau:
          if(!is_single() && has_post_thumbnail() && !post_password_required() || has_post_format('image')): ?>
            <div class="product-thumbnail">
              <?php the_post_thumbnail($size); //Tham số dựa trên kích cỡ các thumnail tại Settings/Media?>
            </div>
          <?php endif; ?>
  <?php }
}

/*
@ Hàm hiển thị Bài viết sản phẩm theo Category
*/
if(!function_exists('tmq_main_content')){
  function tmq_main_content(){
    $cats = get_categories(); //Get tất cả các Category
    //Loop categries
    foreach ($cats as $cat){
      $cat_id= $cat->term_id; //Lấy ID của Category
      echo "<div class='category'>";
      echo "<h2>".$cat->name." &raquo;&raquo;</h2>"; //Tạo tiêu đề
      echo "<div class='products'>";
      query_posts("cat=$cat_id&posts_per_page=3"); //Tạo custom query (chỉ lấy 3 bài viết trên mỗi category)
      //Start loop
      if (have_posts()): 
        while (have_posts()): the_post();
          echo "<div class='product'>";
          tmq_thumbnail('thumbnail'); //Hiển thị thumbnail cho mỗi sản phẩm
          echo '<p class="name-product">'.get_the_title().'</p>';
          echo '<p class="view-detail"><a href="'.get_permalink().'">Xem chi tiết</a></p>';
          echo '</div> <!-- End .product -->';
        endwhile;
      endif; 
      echo '</div> <!-- End .products -->';
      echo '</div> <!-- End .category -->';
    }
  }
}

/*
@ Thiết hiển thị giao diện Menu (Navbar)
*/
if(!function_exists('tmq_menu')){
  function tmq_menu($slug) {
    $menu = array(
      'theme_location' => $slug,
      'container' => 'nav',
      'container_class' => $slug,
    );
    wp_nav_menu($menu); //Hiển thị menu (navbar)
  }
}

/*
@ Hiển thị banner
*/
if(!function_exists('tmq_banner')){
  function tmq_banner(){
    global $tmq_options;
    if( $tmq_options['banner-on'] == 1 ):
      echo '<img src="'.$tmq_options['banner-image']['url'].'" alt="">';
    endif;
  }
}

/*** Nhúng file style.css ***/
function tmq_style(){
  //style.css
  wp_register_style('main-style', get_template_directory_uri().'/style.css', 'all'); //Đăng kí file css
  wp_enqueue_style('main-style'); //Đưa vào danh sách những file css

  //reset.css
  wp_register_style('reset-style', get_template_directory_uri().'/reset.css', 'all');
  wp_enqueue_style('reset-style');
}
add_action('wp_enqueue_scripts', 'tmq_style'); //Hook gọi hàm nhúng file css ở trên
