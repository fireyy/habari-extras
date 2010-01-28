<!-- To customize this template, copy it to your currently active theme directory and edit it -->
<section id="widget-twitterbox" class="widget">
	<ul>
	<?php
		if (is_array($tweets)) {
			foreach ($tweets as $tweet) {
				echo '<li class="tweet_text">';
				printf('<a href="%s" class="tweet_username" title="Follow me on Twitter!">' . _t('Read more', $this->class_name) . '</a>', $tweets[0]->user->profile_url);
				echo $tweet->text.'</li>';
			}
		}
		else { // Exceptions
			echo '<li class="twitter-error">';
			printf('<a href="%s" class="tweet_username" title="Follow me on Twitter!">' . _t('Read more', $this->class_name) . '</a>', $tweets[0]->user->profile_url);
			echo  $tweets . '</li>';
		}
	?>
	</ul>
</section>