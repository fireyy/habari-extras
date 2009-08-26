
<!-- footer -->
<div class="clear"></div>
</div>

<hr>

<p id="footer">
<small><?php Options::out('title'); _e(' is powered by'); ?> <a href="http://www.habariproject.org/" title="Habari">Habari</a></small>
</p>

<?php $theme->footer(); ?>

<?php
/* In order to see DB profiling information:
1. Insert this line in your config file: define( 'DEBUG', TRUE );
2.Uncomment the followng line
*/
// include 'db_profiling.php';
?>
</body>
</html>
<!-- /footer -->
