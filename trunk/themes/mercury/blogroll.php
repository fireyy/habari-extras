<?php if ( ! empty( $blogs ) ) { ?>
	<section id="widget-blogroll" class="widget widget_comments">
		<h3><span><?php echo $blogroll_title; ?></span></h3>
		<ul>
		<?php
			foreach ( $blogs as $blog ) {
				?>
				<li class="vcard"><a href="<?php echo $blog->info->url; ?>" class="url" title="<?php echo $blog->content; ?>" rel="<?php echo $blog->info->relationship; ?> <?php echo $blog->xfn_relationships; ?>"><?php echo $blog->title; ?></a></li>
				<?php
			}
		?>
		</ul>
	</section>				
<?php } ?>
