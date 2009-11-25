<!-- To customize this template, copy it to your currently active theme directory and edit it -->
<div id="twitterbox">
	<ul>
	<?php
		if (is_array($tweets)) {
			printf('<li class="tweet_username"><a href="%s">' . _t('Read more…', $this->class_name) . '</a></li>', $tweets[0]->user->profile_url);
			foreach ($tweets as $tweet) {
				echo '<li class="tweet_text">'.$tweet->text.'</li>';
			}
		}
		else { // Exceptions
			echo '<li class="twitter-error">' . $tweets . '</li>';
		}
	?>
	</ul>
</div>