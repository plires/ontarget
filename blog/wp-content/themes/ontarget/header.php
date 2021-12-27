<?php include(__DIR__ . '../../../../../includes/config.inc.php'); ?>

<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ontarget
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="app" class="site">

	<?php $current = 'blog'; ?>

	<!-- Msgs -->
	<?php include(__DIR__ . '../../../../../includes/msg.php'); ?>

	<!-- Errors -->
	<?php include(__DIR__ . '../../../../../includes/errors.php'); ?>

	<!-- Login -->
	<?php include(__DIR__ . '../../../../../includes/login.php'); ?>
	
	<!-- Nav -->
	<?php include(__DIR__ . '../../../../../includes/nav.php'); ?>

	<!-- Modal Perfil Usuario -->
    <?php include(__DIR__ . '../../../../../includes/modal-perfil.php'); ?>

    <!-- Modal Contactar a tu Team Leader -->
    <?php include(__DIR__ . '../../../../../includes/modal-contact-team-leader.php'); ?>

	
