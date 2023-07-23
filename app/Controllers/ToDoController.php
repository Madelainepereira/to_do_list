<?php

namespace App\Controllers;
use Database\DatabaseConnection;
use Exception;

class ToDoController
{
	private const	SERVERNAME = "localhost";
	private const	USERNAME = "root";
	private const	PASSWORD = "";
	private const	DBNAME = "to_do_list";

	public function deleteControls($id)
	{
		$controls = "<form method='post'> 
						<button type='submit' name='Delete'>Delete</button>
						<input type='hidden' name='id' value=$id>
						<input type='hidden' name='delete' value='true'>
					</form>";
		return ($controls);
	}

	public function changeStateControls($id, $state)
	{
		$legend = "Mark as Done";

		if ($state == 1)
			$legend = "Mark as Pending";
		$controls = "<form method='post'> 
						<button type='submit' name='State'>$legend</button>
						<input type='hidden' name='id' value=$id>
						<input type='hidden' name='state' value=$state>
						<input type='hidden' name='delete' value='true'>
					</form>";
		return ($controls);
	}

	public function create()
	{
		$conn = new DatabaseConnection(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
		$conn -> connect();
		$title = $_REQUEST['title'];
		$description = $_REQUEST['description'];
		$dueDate = $_REQUEST['due-date'];
		
		$sql = "INSERT INTO to_do(title, description, due_date)
				VALUES ('$title', '$description', '$dueDate')";
		$results = $conn -> getConnection() -> exec($sql);
		try
		{
			if (!empty($results))
			{
				$statusCode = 200;
				$response = "To do registered successfully";
				return ([$statusCode, $response, $results]);
			}
		}
		catch(Exception $e)
		{
			echo ("An error occurred while creating the task");
		}
	}

	public function display()
	{
		$conn = new DatabaseConnection(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
		$conn -> connect();
		$sql = "SELECT id, title, description, due_date, state 
				FROM to_do";
		$statement = $conn -> getConnection() -> prepare($sql);
		$statement -> execute();
		$result = $statement -> fetchAll(\PDO::FETCH_ASSOC);
		$stateCheck = "";
		// print_r($result);
		try
		{
			if (!empty($result)) 
			{
				echo "<table>
						<tr>
							<th>to do</th>
							<th>description</th>
							<th>due date</th>
							<th>state</th>
						</tr>";
				// output data of each row
				foreach ($result as $row)
				{
					$stateCheck = "In progress";
					if ($row["state"] == 1)
						$stateCheck = "Done";
	       			echo 	
						"<tr><td>" 
							. $row["title"] . "</td><td>" 
							. $row["description"] . "</td><td>" 
							. $row["due_date"] . "</td><td>" 
							. $stateCheck . "</td><td>" 
							. $this->deleteControls($row["id"]) . "</td><td>"
							. $this->changeStateControls($row["id"], $row["state"]) .
						"</td></tr>";
				}
				echo "</table>";
			}
		} 
		catch(\PDOException $e) 
		{
			echo "Error: " . $e -> getMessage();
		}
	}

	public function delete()
	{
		$conn = new DatabaseConnection(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
		$conn -> connect();
		$id = $_REQUEST['id'];
		
		$sql = "DELETE FROM to_do WHERE id=$id";
		try
		{
			$conn -> getConnection() -> exec($sql);
			echo "to do deleted successfully";
		}
		catch(\PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function changeState()
	{
		$conn = new DatabaseConnection(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
		$conn -> connect();
		$id = $_REQUEST['id'];
		$state = $_REQUEST['state'];

		if ($state > 0)
			$new_state = 0;
		else
			$new_state = 1;
		$sql = "UPDATE to_do SET state=$new_state WHERE id=$id";
		try
		{
			$conn -> getConnection() -> exec($sql);
			echo "to do deleted successfully";
		}
		catch(\PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}
}

?>