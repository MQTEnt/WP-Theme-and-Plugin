<?php
function tmq_plugin_activation() {

    //Khai báo plugin cần cài đặt
	$plugins = array(
		array(
			'name' => 'Redux Framework',
			'slug' => 'redux-framework',
			'required' => true /* Bắt buộc cài */
			)
		);
    //Thiết lập TGM
	$configs = array(
		'menu' => 'tp_plugin_install',
		'has_notice' => true, //Hiển thị thông báo cài đặt cho người dùng
		'dismissable' => false, //Không cho người dùng tắt thông báo 
		'is_automatic' => true //Tự động kích hoạt plugin sau khi cài
		);
	tgmpa($plugins, $configs);
}
add_action('tgmpa_register', 'tmq_plugin_activation'); //Hook
?>