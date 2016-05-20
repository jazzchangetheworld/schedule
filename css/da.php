<?php 
/* Пример запроса
	$result=mysql_query("SELECT * FROM table_name")
*/


function genTable($result){
	echo "<div class='table'>";
	while ($line=mysql_fetch_assoc($result)) {
		echo "<div class=table_row>";
		foreach ($line as $key => $value) {
			if ($key=="id")
				echo "<div class='cell hidden'>$value</div>";
			else echo "<div class='cell'>$value</div>";	
		}
	}
	
}
?>