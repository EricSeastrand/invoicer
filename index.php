<html>
	<head>
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

<?php 
		function getOrdinalSuffix($number) {		
			$ends = array('th','st','nd','rd','th','th','th','th','th','th');
			if (($number %100) >= 11 && ($number%100) <= 13)
			   $abbreviation = 'th';
			else
			   $abbreviation = $ends[$number % 10];
			return $abbreviation;
		}

		function formatDate($dateObject=true) {
			if($dateObject === true) $dateObject = time();
			$extn = getOrdinalSuffix(strftime('%e', $dateObject));

			return strftime("%A, %B %e<sup>$extn</sup> %Y", $dateObject);
		}

		function invoice_item($description, $cost) {
			$cost = sprintf("%.2f",$cost);
			return 
			"
			<tr>
				<td>$description</td>
				<td>$". $cost ."</td>
			</tr>
			";
		}


		function getDates($start_date, $end_date, $days){
			if(!is_array($days) ) $days = explode(',', $days);
			// parse the $start_date and $end_date string values	

			while( $start_date <= $end_date ){

				$dow=strftime('%A', $start_date);
				// assumes $days is array containing strings  - Saturday, Monday...
				if( in_array($dow, $days) )
					$results[]= formatDate($start_date);
				
				// incrememnt by 1 day
				
				$start_date+=86400;
				
			}

			return $results;
		}

		function MAKE_INVOICES($cost="25.00", $dayOfWeek) {
			$total = 0;
			
			$dates = getDates(strtotime('first day of next month'), strtotime('last day of next month'), $dayOfWeek);
			foreach ($dates as $i => $date) {
				echo invoice_item($date, $cost);
				$total += $cost;
			}

			echo invoice_item("Total DUE", $total);
			
		}

		?>
	<title><?php echo $_REQUEST['customer']; ?></title>
	</head>
	<body class="invoice-body">
			<div class="invoice-created"> <?php echo formatDate(); ?>  </div>

		<div class="the-word-invoice">INVOICE</div>

		<section class="invoice-header">
			<h1>Cut-N-Edge</h1>
			<h2>Lawn Maintenance</h2>
			<h2>Residential &amp; Commercial</h2>
		</section>


		<section class="invoice-from">
			<h2>James Madden</h2>
			
			<div class="street-address">
				<h3>11659 Jones Rd. #221</h3>
				<h3>Houston, TX 77070</h3>
			</div>

			<div class="phone-numbers">
				<dt>Office</dt>
					<dd><span class="area-code">(281)</span>477-0497</dd>     
				<dt>Cell</dt>
					<dd><span class="area-code">(281)</span>253-8128</dd>
			</div>


		</section>



		<section class="invoice-items">
			<table>
				
				<?php 


				if(!isset($_REQUEST['day']))
					echo '<font color="red">You must specify a day like <a href="?day=Monday&price='.$_REQUEST['price'].'">?day=Monday</a></font>'; 
				
				if(!isset($_REQUEST['price']))
					echo '<font color="red">You must specify a price like <a href="?price=25&day='.$_REQUEST['day'].'">?price=25.00</a></font>'; 


					MAKE_INVOICES($_REQUEST['price'], $_REQUEST['day']);

				?>


			</table>
		</section>


		<section class="invoice-to">
			<?php echo '<div>'.str_replace("\n", "</div><div>", $_REQUEST['customer']).'</div>'; ?>
			<!--
			<div>Gloria Orellana</div>
			<div>12014 Quiet Water Ct.</div>
			<div>Houston, Texas 77095</div>
			-->
		</section>
	</body>
</html>