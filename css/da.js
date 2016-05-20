/*$name_table - название таблицы 
$id-ид таблицы 
$cap - массив название столбцов 
$Result - sql запрос 
$sql_row_name - массив запрашиваемых столбцов из БД*/ 
function genTable($name_table,$cap,$Result,$sql_row_name,$id) { 
$str = ''; 
$str .= '<table id="'.$id.'" border="1"> 
<caption>'.$name_table.'</caption><tr> 
<th class="hidden"></th>'; 

for($i = 0; $i < count($cap); $i++){ 
$str .= '<th>'.$cap[$i].'</th>'; 
}; 

while($row = $Result->fetch_assoc()) { 

$str .= '<tr>'; 
$str .= '<td><input type="checkbox" id='.$row['id_cabinet'].'/></td>' ; 

for ($i=0; $i < count($sql_row_name); $i++) { 
if ($sql_row_name[$i] == $sql_row_name[0]) { 

$str .= '<td class="hidden">'.$row[''.$sql_row_name[$i].''].'</td>'; 

} else $str .= '<td>'.$row[$sql_row_name[$i]].'</td>'; 
} 
$str .= '</tr>'; 
} 
$str .= '</table>'; 

return $str; 
}