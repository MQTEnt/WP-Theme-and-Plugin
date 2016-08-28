<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); /**/ ?>" />
        <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
        <div id="container">
              <header id="header">
                   <?php tmq_header(); ?>
              </header> <!-- End #header -->
              <div id="main-menu">
              	<?php tmq_menu('navbar'); ?>
              </div> <!-- End #main-menu -->