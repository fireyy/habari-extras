<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8" />
 <title><?php if($request->display_entry && isset($post)) { echo "{$post->title} - "; } ?><?php Options::out( 'title' ) ?></title>
 <meta name="generator" content="Habari" />
 <link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php $theme->feed_alternate(); ?>" />
 <link rel="edit" type="application/atom+xml" title="Atom Publishing Protocol" href="<?php URL::out( 'atompub_servicedocument' ); ?>" />
 <link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php URL::out( 'rsd' ); ?>" />
 <link rel="Shortcut Icon" href="/favicon.ico" />
 <link rel="stylesheet" type="text/css" href="<?php Site::out_url( 'theme' ); ?>/style.css" />
<!--[if IE]>
<script src="<?php Site::out_url( 'theme' ); ?>/html5.js"></script>
<![endif]-->
 <?php $theme->header(); ?>
 <!-- Special thanks to Diagona Icons by Yusuke,they are really nice. -->
</head>
<body>
<div id="wrapper">
	<header id="header">
		<h1 id="blog-title"><span><a href="<?php Site::out_url( 'habari' ); ?>"><?php Options::out( 'title' ); ?></a></span></h1>
		<p id="blog-description"><?php Options::out( 'tagline' ); ?></p>
		<nav id="menu">
		<ul>
			<li class="page_item<?php if ($request->display_home || $request->display_entries || $request->display_entry) echo " current_page_item"; ?>"><a href="<?php Site::out_url( 'habari' ); ?>" title="<?php Options::out( 'title' ); ?>"><span>Blog</span></a></li>
			<?php
				foreach ( $pages as $tab ) {
				?>
			<li id="page_item_<?php echo $tab->id; ?>" class="page_item<?php if(isset($post) && $post->slug == $tab->slug) echo " current_page_item"; ?>"><a href="<?php echo $tab->permalink; ?>" title="<?php echo $tab->title; ?>"><span><?php echo $tab->title; ?></span></a></li>
				<?php } ?>
		</ul>
		</nav>
		<?php //if ( Plugins::is_loaded('Twitter') ) $theme->twitter(); ?>
		<?php if ( Plugins::is_loaded('TwitterLitte') ) $theme->twitterlitte(); ?>
		<div id="misc">
			<a id="sitefeed" href="<?php $theme->feed_alternate(); ?>" title="订阅更新"><span>订阅更新</span></a>
			<a id="fav-label" title="Bookmark on Delicious" href="http://delicious.com/post?url=<?php Site::out_url( 'habari' ); ?>&amp;title=<?php Options::out( 'title' ) ?>, <?php Options::out( 'tagline' ); ?>" target="_blank">收藏</a>
			<?php $theme->display ('searchform' ); ?>
		</div>
	</header>	
	<div id="posts">