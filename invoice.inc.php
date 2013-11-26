
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
			
			$dates = getDates(strtotime('first day of this month'), strtotime('last day of this month'), $dayOfWeek);
			foreach ($dates as $i => $date) {
				
				if(strpos($date, 'October 30')){
					$cost = 0;
				}
				echo invoice_item($date, $cost);
				$total += $cost;

				if($cost === 0) echo invoice_item_nocharge();

			}

			if($_REQUEST['fertilizer']) {
				echo invoice_item('Fertilization', 35);
				$total += 35;
			}

			echo invoice_item("Total DUE", $total);
			
		}

		function invoice_item_nocharge($date, $message='No lawn services were needed.') {
			return 
			"
			<tr class='nocharge-service'>
				<td colspan=2>$message</td>
			</tr>
			"; 
		}

		?>
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

		<div class="invoice-content-wrapper">
			<section class="invoice-to">
				<?php echo '<div>'.str_replace("\n", "</div><div>", $_REQUEST['customer']).'</div>'; ?>
				<!--
				<div>Gloria Orellana</div>
				<div>12014 Quiet Water Ct.</div>
				<div>Houston, Texas 77095</div>
				-->
			</section>


			<section class="invoice-items">
				<table class="invoice-items-table" title="Double-click an item to remove it from the list.">
<!--
					<tr class="new-line-item">
						<td><input type="text" class="new-line-item-name" /></td>
						<td><input type="number" class="new-line-item-price" /></td>
					</tr>
-->
					<?php

						MAKE_INVOICES($_REQUEST['price'], $_REQUEST['day']);

					?>

				</table>
			</section>


		</div>
	</body>