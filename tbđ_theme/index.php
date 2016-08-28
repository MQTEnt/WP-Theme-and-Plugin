<?php get_header(); ?>
<div id="banner">
	<?php tmq_banner(); ?>
</div> <!-- End #banner -->
<div id="content">
	<div id="left-sidebar">
		<?php get_sidebar('left');?>
	</div> <!-- End #left-sidebar -->
	<div id="main-content" role="main">
		<?php tmq_main_content(); ?>
	</div><!-- End #main-content -->
	<div id="right-sidebar">
		<?php get_sidebar('right');?>
	</div> <!-- End #right-sidebar -->
</div> <!-- End #content -->
<?php get_footer(); ?>
