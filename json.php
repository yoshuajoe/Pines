<?php
	if (isset($_POST['sql'])) {

		header('Content-Type: text/json; charset=utf-8');
		header('Content-Disposition: attachment; filename=filter.json');

		$output = fopen('php://output', 'w');

		//fputcsv($output, array('id', 'created_at', 'picture', 'source', 'screen_name', 'name', 'text', 'time_zone'));
		$con = mysqli_connect('127.0.0.1', 'root', '', 'datamining');
		$rows = mysqli_query($con, $_POST['sql']);
		while ($row = mysqli_fetch_assoc($rows)) {
		  fwrite($output,json_encode($row));
		}
		fclose($output);
		mysqli_close($con);
		exit();
	}
?>