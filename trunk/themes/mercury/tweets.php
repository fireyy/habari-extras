<!-- This file can be copied and modified in a theme directory -->

<ul id="twitterbox">
	<?php foreach ($tweets as $tweet) : ?>
	<li class="tweet_username"><a href="http://twitter.com/<?php echo urlencode( Options::get( 'twitter__username' )); ?>" title="Follow me at Twitter!"><?php echo urlencode( Options::get( 'twitter__username' )); ?></a></li>
	<li class="tweet_text"><?php echo $tweet->text; ?></li>
	<?php endforeach; ?>
</ul>