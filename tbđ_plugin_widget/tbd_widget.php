<?php
/*
Plugin Name: TBĐ Widget
Description: TBĐ
Author: TMQ
Text Domain: black-studio-tinymce-widget
Domain Path: /languages
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class
 *
 * @package Black_Studio_TinyMCE_Widget
 * @since 2.0.0
 */

if ( ! class_exists( 'Black_Studio_TinyMCE_Plugin' ) ) {

	final class Black_Studio_TinyMCE_Plugin {

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 2.0.0
		 */
		public static $version = '2.2.11';

		/**
		 * The single instance of the plugin class
		 *
		 * @var object
		 * @since 2.0.0
		 */
		protected static $_instance = null;

		/**
		 * Instance of admin class
		 *
		 * @var object
		 * @since 2.0.0
		 */
		protected static $admin = null;

		/**
		 * Instance of admin pointer class
		 *
		 * @var object
		 * @since 2.1.0
		 */
		protected static $admin_pointer = null;

		/**
		 * Instance of compatibility class
		 *
		 * @var object
		 * @since 2.0.0
		 */
		protected static $compatibility = null;

		/**
		 * Instance of the text filters class
		 *
		 * @var object
		 * @since 2.0.0
		 */
		protected static $text_filters = null;

		/**
		 * Return the main plugin instance
		 *
		 * @return object
		 * @since 2.0.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Return the instance of the admin class
		 *
		 * @return object
		 * @since 2.0.0
		 */
		public static function admin() {
			return self::$admin;
		}

		/**
		 * Return the instance of the admin pointer class
		 *
		 * @return object
		 * @since 2.1.0
		 */
		public static function admin_pointer() {
			return self::$admin_pointer;
		}

		/**
		 * Return the instance of the compatibility class
		 *
		 * @return object
		 * @since 2.0.0
		 */
		public static function compatibility() {
			return self::$compatibility;
		}

		/**
		 * Return the instance of the text filters class
		 *
		 * @return object
		 * @since 2.0.0
		 */
		public static function text_filters() {
			return self::$text_filters;
		}

		/**
		 * Get plugin version
		 *
		 * @return string
		 * @since 2.0.0
		 */
		public static function get_version() {
			return self::$version;
		}

		/**
		 * Get plugin basename
		 *
		 * @uses plugin_basename()
		 *
		 * @return string
		 * @since 2.0.0
		 */
		public static function get_basename() {
			return plugin_basename( __FILE__ );
		}

		/**
		 * Class constructor
		 *
		 * @uses add_action()
		 * @uses add_filter()
		 * @uses get_option()
		 * @uses get_bloginfo()
		 *
		 * @global object $wp_embed
		 * @since 2.0.0
		 */
		protected function __construct() {
			// Include required files
			include_once( plugin_dir_path( __FILE__ ) . 'includes/class-widget.php' );
			// Include and instantiate admin class on admin pages
			if ( is_admin() ) {
				include_once( plugin_dir_path( __FILE__ ) . 'includes/class-admin.php' );
				self::$admin = Black_Studio_TinyMCE_Admin::instance();
				include_once( plugin_dir_path( __FILE__ ) . 'includes/class-admin-pointer.php' );
				self::$admin_pointer = Black_Studio_TinyMCE_Admin_Pointer::instance();
			}
			// Include and instantiate text filter class on frontend pages
			else {
				include_once( plugin_dir_path( __FILE__ ) . 'includes/class-text-filters.php' );
				self::$text_filters = Black_Studio_TinyMCE_Text_Filters::instance();
			}
			// Register action and filter hooks
			add_action( 'plugins_loaded', array( $this, 'load_compatibility' ), 50 );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		}

		/**
		 * Prevent the class from being cloned
		 *
		 * @return void
		 * @since 2.0.0
		 */
		protected function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; uh?' ), '2.0' );
		}

		/**
		 * Load compatibility class
		 *
		 * @uses apply_filters()
		 * @uses get_bloginfo()
		 * @uses plugin_dir_path()
		 *
		 * @return void
		 * @since 2.0.0
		 */
		public function load_compatibility() {
			// Compatibility load flag (for both deprecated functions and code for compatibility with other plugins)
			$load_compatibility = apply_filters( 'black_studio_tinymce_load_compatibility', true );
			if ( $load_compatibility ) {
				include_once( plugin_dir_path( __FILE__ ) . 'includes/class-compatibility.php' );
				self::$compatibility = Black_Studio_TinyMCE_Compatibility::instance();
			}
		}

		/**
		 * Widget initialization
		 *
		 * @uses is_blog_installed()
		 * @uses register_widget()
		 *
		 * @return null|void
		 * @since 2.0.0
		 */
		public function widgets_init() {
			if ( ! is_blog_installed() ) {
				return;
			}
			register_widget( 'WP_Widget_Black_Studio_TinyMCE' );
		}

		/**
		 * Check if a widget is a Black Studio Tinyme Widget instance
		 *
		 * @param object $widget
		 * @return boolean
		 * @since 2.0.0
		 */
		public function check_widget( $widget ) {
			return 'object' == gettype( $widget ) && ( 'WP_Widget_Black_Studio_TinyMCE' == get_class( $widget ) || is_subclass_of( $widget , 'WP_Widget_Black_Studio_TinyMCE' ) );
		}

	} // END class Black_Studio_TinyMCE_Plugin

} // END class_exists check


if ( ! function_exists( 'bstw' ) ) {

	/**
	 * Return the main instance to prevent the need to use globals
	 *
	 * @return object
	 * @since 2.0.0
	 */
	function bstw() {
		return Black_Studio_TinyMCE_Plugin::instance();
	}

	/* Create the main instance */
	bstw();

} // END function_exists bstw check
else {

	/* Check for multiple plugin instances */
	if ( ! function_exists( 'bstw_multiple_notice' ) ) {

		/**
		 * Show admin notice when multiple instances of the plugin are detected
		 *
		 * @return void
		 * @since 2.1.0
		 */
		function bstw_multiple_notice() {
			global $pagenow;
			if ( 'widgets.php' == $pagenow ) {
				echo '<div class="error">';
				/* translators: error message shown when multiple instance of the plugin are detected */
				echo '<p>' . esc_html( __( 'ERROR: Multiple instances of the Black Studio TinyMCE Widget plugin were detected. Please activate only one instance at a time.', 'black-studio-tinymce-widget' ) ) . '</p>';
				echo '</div>';
			}
		}
		add_action( 'admin_notices', 'bstw_multiple_notice' );

	} // END function_exists bstw_multiple_notice check

} // END else function_exists bstw check


/*** Thiết bị điện Widget ***/
add_action('widgets_init', 'create_tbd_widget');
function create_tbd_widget(){
	register_widget('tbd_widget_hotrotructuyen');
	register_widget('tbd_widget_danhmucsanpham');
}

/*
 * Tạo class tbd_widget_hotrotructuyen
 */
class tbd_widget_hotrotructuyen extends WP_Widget {
	/*
	 * Thiết lập widget: đặt tên, base ID
	 */
	function __construct() {
		parent::__construct (
	      	'tbd_widget_hotrotructuyen', // ID của widget
	      	'Thiết bị điện: Hỗ trợ trực tuyến', // Tên của widget
	      	['description' => 'Hiển thị thông tin liên lạc hỗ trợ trực tuyến']
      	);
	}
	/*
	 * Tạo form option cho widget
	 */
	function form( $instance ) {
		parent::form( $instance );
 
        //Biến tạo các giá trị mặc định trong form
        $default = array(
                'hotline' => 'Số đường dây nóng',
                'yahoo'	  => 'Địa chỉ Yahoo',
                'email'   => 'Địa chỉ email'
        );
 
        //Gộp các giá trị trong mảng $default vào biến $instance để nó trở thành các giá trị mặc định
        $instance = wp_parse_args( (array) $instance, $default);
 
        //Tạo biến riêng cho giá trị mặc định trong mảng $default
        $hotline = esc_attr( $instance['hotline'] );
 		$yahoo = esc_attr( $instance['yahoo'] );
 		$email = esc_attr( $instance['email'] );
        //Hiển thị form trong option của widget
        echo 'Nhập tiêu đề <input class="widefat" type="text" name="'.$this->get_field_name('hotline').'" value="'.$hotline.'"/>';
        echo 'Nhập tiêu đề <input class="widefat" type="text" name="'.$this->get_field_name('yahoo').'" value="'.$yahoo.'"/>';
        echo 'Nhập tiêu đề <input class="widefat" type="text" name="'.$this->get_field_name('email').'" value="'.$email.'"/>';
	}
	/*
	 * Save widget form
	 */
	function update( $new_instance, $old_instance ) {
		parent::update( $new_instance, $old_instance );
        $instance = $old_instance;
        $instance['hotline'] = strip_tags($new_instance['hotline']);
        $instance['yahoo'] = strip_tags($new_instance['yahoo']);
        $instance['email'] = strip_tags($new_instance['email']);
        return $instance;
	}
	/*
	 * Show widget
	 */
	function widget( $args, $instance ) {
		echo "<div class='sidebar-container'>";
		echo "<h2 class=''>Hỗ trợ trực tuyến </h2>";
		echo "<div class='sidebar-content contact'>";
		echo "<img src='".get_template_directory_uri()."/img/support-phone.png' alt=''>";
		echo '<p ><span>Hotline:</span> <br>'.$instance['hotline'].'</p>';
		echo '<p ><span>Yahoo:</span> <br>'.$instance['yahoo'].'</p>';
		echo '<p ><span>Email:</span> <br>'.$instance['email'].'</p>';
		echo '</div> <!-- End .sidebar-content -->';
		echo '</div> <!-- End .sidebar-container -->';
	}
}


/*
 * Tạo class tbd_widget_danhmucsanpham
 */
class tbd_widget_danhmucsanpham extends WP_Widget {
	/*
	 * Thiết lập widget: đặt tên, base ID
	 */
	function __construct() {
		parent::__construct (
	      	'tbd_widget_danhmucsanpham', // ID của widget
	      	'Thiết bị điện: Danh mục sản phâm', // Tên của widget
	      	['description' => 'Hiển thị danh mục sản phẩm']
      	);
	}
	/*
	 * Tạo form option cho widget
	 */
	function form( $instance ) {
		parent::form( $instance );
        $default = array(
                'title' => 'Tiêu đề',
        );
 
        //Gộp các giá trị trong mảng $default vào biến $instance để nó trở thành các giá trị mặc định
        $instance = wp_parse_args( (array) $instance, $default);
 
        //Tạo biến riêng cho giá trị mặc định trong mảng $default
        $title = esc_attr( $instance['title'] );
        //Hiển thị form trong option của widget
        echo 'Nhập tiêu đề <input class="widefat" type="text" name="'.$this->get_field_name('title').'" value="'.$title.'"/>';
	}
	/*
	 * Save widget form
	 */
	function update( $new_instance, $old_instance ) {
		parent::update( $new_instance, $old_instance );
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
	}
	/*
	 * Show widget
	 */
	function widget( $args, $instance ) {
		echo "<div class='sidebar-container'>";
		echo "<h2 class=''>".$instance['title']."</h2>";
		echo "<div class='sidebar-content list'>";
		$cats = get_categories(); //Get tất cả các Category
    	//Loop categries
		foreach ($cats as $cat){
		    $cat_id= $cat->term_id; //Lấy ID của Category
		    echo "<h4>".$cat->name."</h4>"; //Tạo tiêu đề
		    query_posts("cat=$cat_id&posts_per_page=3"); //Tạo custom query (chỉ lấy 3 bài viết trên mỗi category)
      		//Start loop
     		if (have_posts()): 
      			while (have_posts()): the_post();
          		echo '<p><a href="'.get_the_permalink().'">'.get_the_title().'</a></p>';
          		endwhile;
          	endif;
		}
		echo '</div> <!-- End .sidebar-content -->';
		echo '</div> <!-- End .sidebar-container -->';
	}
}