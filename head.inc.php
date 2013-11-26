<?php $jquery_themes = array(
			'black-tie', 'blitzer', 'cupertino', 'dark-hive', 'dot-luv', 'eggplant', 'excite-bike', 'flick', 'hot-sneaks', 'humanity', 'le-frog', 'mint-choc', 'overcast', 'pepper-grinder', 'redmond', 'smoothness', 'south-street', 'start', 'sunny', 'swanky-purse', 'trontastic', 'ui-darkness', 'ui-lightness', 'vader'
		);
			$jquery_theme_to_use = $jquery_themes[array_rand($jquery_themes)];
		?>

		<link rel="stylesheet" href="http://codeorigin.jquery.com/ui/1.10.3/themes/<?php echo $jquery_theme_to_use; ?>/jquery-ui.css" />
		<link rel="stylesheet" href="style.css" />

		<script src="http://codeorigin.jquery.com/jquery-2.0.3.min.js"></script>
		<script src="http://codeorigin.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
		<script src="event-handling.js"></script>
		<script src="scripts.js"></script>