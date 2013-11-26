<html>
	<head>	
		<?php require_once('head.inc.php'); ?>

	<title><?php echo $_REQUEST['customer']; ?></title>
	</head>

		<form method="POST" action="invoice.php" target="_BLANK">

			Put in the amount you charge this client for each visit:
			$<input type="number" name="price" min="0" value="27.00" max="9999" step="1" size="4" 
		    title="Enter the price that this customer gets charged for each service visit." />
		<br/>
			Check this box to add a $35.00 charge for fertilization.
			<input type="checkbox" name="fertilizer" />
		<br/><br/>
			Select which day-of-the-week that you visit this client.
			<select name="day"><option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option selected="selected" value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option><option value="Friday">Friday</option><option value="Saturday">Saturday</option><option value="Sunday">Sunday</option></select>
		<br/><br/>
		<!--	<label id="calendar-option" for="calendar-option">Select specific days to invoice on a calendar</label>
			<input type="checkbox" name="advanced-date" id="calendar-option"/>
		-->
		<br/>
			Enter the customer's information (this will appear in the Bill To section of the invoice.)
		<br/>
			<textarea cols=60 rows=10 name="customer"></textarea>

			<br/></br>
			<input type="submit" value="Make Invoice"/>
		</form>

</html>