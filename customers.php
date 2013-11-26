<form method="POST" action="index.php" target="_BLANK">

	Cost per visit:
	$<input type="number" name="price" min="0" value="25.00" max="9999" step="0.01" size="4" 
    title="Enter the price that this customer gets charged for each service visit." />
<br/>
	<select name="day"><option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option><option value="Friday">Friday</option><option value="Saturday">Saturday</option><option value="Sunday" selected="">Sunday</option></select>
<br/>
	<label id="calendar-option" for="calendar-option">Select specific days to invoice on a calendar</label>
	<input type="checkbox" name="advanced-date" id="calendar-option"/>
<br/>
	Enter the customer's information (this will appear in the Bill To section of the invoice.)
<br/>
	<textarea cols=60 rows=10 name="customer"></textarea>

	<br/></br>
	<input type="submit" value="Make Invoice"/>
</form>

