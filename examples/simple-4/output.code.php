<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Example: simple-3</title>
</head>
<body>
	<?php 
 if (isset($data[1])) { 
 ?>
		<span>List</span>
		<ul>
<!-- notice structure of first LI and two following LIs --><?php 
 foreach($data as $row): 
 ?><li>
				<span class="field1"><?php 
 print is_object($row)
						? $row->field1
						: $row['field1'] 
 ?></span>,
				<span class="field2"><?php 
 print is_object($row)
						? $row->field2
						: $row['field2'] 
 ?></span>,
				<span class="field3"><?php 
 print is_object($row)
						? $row->field3
						: $row['field3'] 
 ?></span>
			</li>
<?php 
 endforeach; 
 ?>
			
			
		</ul>
<?php 
 } 
 ?>
</body>
</html>
