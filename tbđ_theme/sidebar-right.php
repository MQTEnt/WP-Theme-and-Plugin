<?php 
	if(is_active_sidebar('right-sidebar')): //Kiểm tra sidebar có widget hay không (theo ID của sidebar)
		dynamic_sidebar('right-sidebar'); //Gọi sidebar (theo ID) đã được tạo ở functions.php
	else:
		_e('This is right sidebar, you have to add some widgets', 'tmq'); //Nếu sidebar không có widget thì hiện thông báo để người dùng thêm widget vào sidebar
	endif;
?>