<?php 
	if(is_active_sidebar('left-sidebar')): //Kiểm tra sidebar có widget hay không (theo ID của sidebar)
		dynamic_sidebar('left-sidebar'); //Gọi sidebar (theo ID) đã được tạo ở functions.php
	else:
		_e('This is left sidebar, you have to add some widgets', 'tmq'); //Nếu sidebar không có widget thì hiện thông báo để người dùng thêm widget vào sidebar
	endif;
?>