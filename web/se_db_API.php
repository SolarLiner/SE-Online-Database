<?php
// DB Credentials (local)
// User : db_user
// Psswd: d2rGZrbmHbVK2unE
$server = "localhost";
$database = "se_db";
$user     = "root";
$password = "";
//
// DB Credentials (server)
// User : 
// Psswd:
//$server = "";
//$database = "";
//$user     = "";
//$password = "";

$mysqli = new mysqli($server, $user, $password, $database);

if(isset($_POST['MODE']))
{
	if($_POST['MODE'] == "SET") // Data pushing
	{
		$name = $_POST['NAME'];
		$locname = $_POST['LOCNAME'];
		$pioneername = $_POST['PIONEERNAME'];
		$parent = $_POST['PARENT'];
		$date = isset($_POST['DATE']) ? $_POST['DATE'] : date("Y.m.d H:i:s.u");
		$descr = $_POST['DESCR'];

		if($stmt=$mysqli->prepare("INSERT INTO objects(Name, LocName, PioneerName, Parent, Date, Descr, ObjectID) VALUES (?, ?, ?, ?, ?, ?, NULL)"))
		{
			$stmt->bind_param("ssssis",
								$name,
								$locname,
								$pioneername,
								$parent,
								$date,
								$descr);
			$stmt->execute();
			$stmt->close();
			
			echo "200 OK";
		}
		else
		{
			echo nl2br("400 BAD REQUEST\n\n" . $mysqli->error);
		}
	}
	else if($_POST['MODE'] == 'GET')
	{
		if(!isset($_POST['ID']))
		{
			if($stmt=$mysqli->query("SELECT * FROM objects"))
			{
				while($stmt->fetch_assoc())
				{
					echo json_encode($row);
				}
			}
			else
			{
				echo "400 BAD REQUEST<br/><br/>" . $mysqli->error;
			}
		}
		else
		{
			if($stmt=$mysqli->prepare("SELECT * FROM objects WHERE ObjectID = ?"))
			{
				$stmt->bind_param("s", $_POST['ID']);
				$stmt->execute();
				$stmt->store_result();
				$row = array();
				$stmt->bind_result($row['Name'], $row['LocName'], $row['PioneerName'], $row['Parent'], $row['Date'], $row['Descr'], $row['ObjectID']);
				$stmt->fetch();
				
				echo json_encode($row);
			}
			else
			{
				echo "400 BAD REQUEST<br/><br/>" . $mysqli->error;
			}
		}
	}
	else
	{
		if($stmt=$mysqli->prepare("SELECT * FROM objects WHERE ObjectID = ?"))
		{
			$stmt->bind_param("s", $_POST['ID']);
			$stmt->execute();
			$stmt->store_result();
			$row = array();
			$stmt->bind_result($row['Name'], $row['LocName'], $row['PioneerName'], $row['Parent'], $row['Date'], $row['Descr'], $row['ObjectID']);
			$stmt->fetch(); ?>
PObject
{
	LocName "<?php echo $row['LocName']; ?>"
	Name 	"<?php echo $row['Name']; ?>"
	Parent	"<?php echo $row['Parent']; ?>"
	Pioneer	"<?php echo $row['PioneerName']; ?>"
	Date	"<?php echo date("Y.m.d H:i:s", $row['Date']); ?>"
	<?php
	if($row['Descr'] != null || $row['Descr'] != "")
	{
		?>
	Descr	"<?php echo $row['Descr']; ?>"
	<?php
	}
		}
		else
		{
			echo "400 BAD REQUEST<br/><br/>" . $mysqli->error;
		}
	}
}
else if(isset($_GET['ID']))
{
	if($stmt=$mysqli->prepare("SELECT * FROM objects WHERE ObjectID = ?"))
	{
		$stmt->bind_param("s", $_GET['ID']);
		$stmt->execute();
		$stmt->store_result();
		$row = array();
		$stmt->bind_result($row['Name'], $row['LocName'], $row['PioneerName'], $row['Parent'], $row['Date'], $row['Descr'], $row['ObjectID']);
		$stmt->fetch(); ?>
PObject
{
	LocName "<?php echo $row['LocName']; ?>"
	Name 	"<?php echo $row['Name']; ?>"
	Parent	"<?php echo $row['Parent']; ?>"
	Pioneer	"<?php echo $row['PioneerName']; ?>"
	Date	"<?php echo date("Y.m.d H:i:s", strtotime($row['Date'])); ?>"
<?php
	if($row['Descr'] != null || $row['Descr'] != "")
	{ ?>
	Descr	"<?php echo $row['Descr']; ?>"
<?php
	} ?>
} <?php
	}
	else
	{
		echo "400 BAD REQUEST<br/><br/>" . $mysqli->error;
	}
}
?>
