<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>to_do_list</title>
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<form  method="post" action="index.php">
  		<label for="title">To do:</label><br>
  		<input type="text" id="title" name="title" value="" required><br>
  		<label for="description">Describe your to do:</label><br>
  		<input type="text" id="description" name="description" value=""><br>
  		<label for="due-date">Due date:</label><br>
  		<input type="date" id="due-date" name="due-date" value="" required><br></br>
  		<input type="submit" value="Add" name='Add'>
	</form> 
</body>
</html>

<?php
	use App\Controllers\ToDoController;
	require 'vendor/autoload.php';
  
	$toDo = new ToDoController();	
	if (isset($_POST['Add']))
	{
	  $toDo->create();
	}
	else if (isset($_POST['Delete']))
	{
		$toDo->delete();
	}
	else if (isset($_POST['State']))
	{
		$toDo->changeState();
	}
	$toDo->display();
?>