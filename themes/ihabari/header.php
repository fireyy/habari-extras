<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html" />
<title><?php if($request->display_entry && isset($post)) { echo "{$post->title} - "; } ?><?php Options::out( 'title' ) ?></title>
<meta id="viewport" name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="apple-touch-fullscreen" content="yes" />
<link rel="apple-touch-icon" href="/icon.png"/>
<meta name="generator" content="Habari" />

<link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php $theme->feed_alternate(); ?>" />
<link rel="edit" type="application/atom+xml" title="Atom Publishing Protocol" href="<?php URL::out( 'atompub_servicedocument' ); ?>" />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php URL::out( 'rsd' ); ?>" />

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $theme->get_url(); ?>/style.css" />

<?php $theme->header(); ?>
</head>

<body class="home">
<div id="page">
	<div id="header">

	<h1><a href="<?php Site::out_url( 'habari' ); ?>"><?php Options::out( 'title' ); ?></a></h1>
	<p class="description"><?php Options::out( 'tagline' ); ?></p>

	<ul class="menu">
		<li <?php if($request->display_home) { ?>
	class="current_page_item"<?php } ?>><a href="<?php Site::out_url( 'habari' ); ?>" title="<?php Options::out( 'title' ); ?>"><?php echo $home_tab; ?></a></li>
<?php
// Menu tabs
foreach ( $pages as $tab ) {
?>
		<li<?php if(isset($post) && $post->slug == $tab->slug) { ?>
	class="current_page_item"<?php } ?>><a href="<?php echo $tab->permalink; ?>" title="<?php echo $tab->title; ?>"><?php echo $tab->title; ?></a></li>
<?php
}
if ( $user instanceof User ) { ?>
		<li class="admintab"><a href="<?php Site::out_url( 'admin' ); ?>" title="<?php _e('Admin area'); ?>"><?php _e('Admin'); ?></a></li>
<?php } ?>
	</ul>

	</div>

	<hr>
<!-- /header -->

