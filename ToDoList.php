<!DOCTYPE PHP>
<html>
<head>
	<title>To Do List</title>
	<meta charset="UTF-8">
	<style>
		h2{
			background-color:green;
			color:white;
			opacity:0.8;
			position:absolute;
		}
		div.div_1{
			padding-left:40px;
			background-color:lightblue;
		}
		div.div_2{
			background-color:lightgray;
		}
		.addBtn:hover {
			background-color: #sbbb;
		}
		ul li{
			cursor: pointer;
			list-style-type: none;
		}
		ul li:hover {
			background: #ddd;
		}
		.cancelBtn{
			color:red;
			cursor: pointer;
		}
		.submitBtn{
			margin-left:40px;
		}
		.updateBtn{
			margin-left:10px;
		}
		
	</style>
</head>
<body>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "test";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT Event, Status FROM ToDoList_Table";
	$result = $conn->query($sql);
	$rowcount = mysqli_num_rows($result);
?>
	<div class="div_1">
	<h2>To Do List</h2><br><br><br><br>
	<form action="ToDoList.php" method="get">
	<input type="text" id="myInput" placeholder="Add Text Here">
	<button onclick="AddMyList()" class="addBtn">Add</button>
	</div><hr>
	<div class="div_2">
	<ul id="myUL">
<?php
	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
		/* echo "id: " . $row["ListNumber"]. " - Name: " . $row["Event"] . "<br>"; */
		$eventId = $row["Event"];
		if($row["Status"] == 0){
			echo "<li><span style='color:black'><input type='checkbox' id=checkboxId name='checkboxId[]' value='$eventId'>" . $row["Event"] . "</span>&emsp;<button class='cancelBtn'>x</button></li><br>";
		}
		else{
			echo "<li><span style='color:black'><input type='checkbox' id=checkboxId name='checkboxId[]' value='$eventId' checked>" . $row["Event"] . "</span>&emsp;<button class='cancelBtn'>x</button></li><br>";
		}
	  }
	} else {
	  echo "There are no event at this time..";
	}
	$conn->close();
?>
	</ul>
	<input type="submit" class="submitBtn" value="Show">
	<button class="updateBtn">Update</button>
	</form>
	</div>
	<?php
		if(empty($_GET['checkboxId']) == true){
			echo "";
		}
		else{
			echo "<br/><h3>Your To Do List is:</h3>";
			$name = $_GET['checkboxId'];
			foreach($name as $event){
				echo "- ".$event."<br/>";
			}
		}
	?>
	
	<script>
		function AddMyList(){
			var li = document.createElement("LI");
			var inputValue = document.getElementById("myInput");
			var cancel = document.createElement("button");
			cancel.innerHTML = "x";
			cancel.style.color = 'red';
			li.innerHTML += "<input type='checkbox' type='checkbox' id='checkboxId' name='checkboxId[]' value=inputValue.value>";
			li.innerHTML += inputValue.value+'&emsp;';
			li.appendChild(cancel);
			inputValue.value = "";
			if(inputValue == ''){
				alert("Your input is null!");
			}
			else{
			document.getElementById("myUL").appendChild(li);
			}
		}
		
		function UpdateFunction(){
		"<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "test";

			// Create connection
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			// Check connection
			if (!$conn) {
			  die("Connection failed: " . mysqli_connect_error());
			}

			$sql = "UPDATE ToDoList_Table SET lastname='Doe' WHERE id=2";

			if (mysqli_query($conn, $sql)) {
			  echo "Record updated successfully";
			} else {
			  echo "Error updating record: " . mysqli_error($conn);
			}

			mysqli_close($conn);
		?>"
		}
	</script>
</body>
</html>