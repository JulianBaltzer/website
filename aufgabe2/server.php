<?php
	
    function error($str) 
    {
        //return header( 'Location: startseite.html' ) ;
    }
    function success($str) 
    {
       //return header( 'Location: wam_brinker_s.html' ) ;
    }



// Verbindung mit DB
$db = mysqli_connect("localhost","root","", "jbaltzer");

if (mysqli_connect_errno()) 
{
	printf(error("Verbindung fehlgeschlagen: " . mysqli_connect_error()));
	exit();
} 
//----------------

// Usecases abfragen
if ($_POST['usecase'] == "result") 
{	
			//$result = mysql_query("SELECT * FROM noten");
			
			
			$sql = "SELECT * FROM noten";
			$result = mysqli_query($db, $sql); // First parameter is just return of "mysqli_connect()" function
			echo "<br>";
			echo "<table border='1'>";
			echo "<td>Vorname</td>";
			echo "<td>Nachname</td>";
			echo "<td>Note</td>";
			while ($row = mysqli_fetch_assoc($result)) { // Important line !!! Check summary get row on array ..
				echo "<tr>";
				foreach ($row as $field => $value) { // I you want you can right this line like this: foreach($row as $value) {
					echo "<td>" . $value . "</td>"; // I just did not use "htmlspecialchars()" function. 
				}
				echo "</tr>";
			}
			echo "</table>";
			
			$query = "SELECT avg(note) as avg FROM noten"; 
			$query = mysqli_query($db, $query);
			$avg = mysqli_fetch_assoc($query);
			echo "<br>";
			echo("Durchschnitt:");
			echo($avg['avg']. "<br>");
			
				echo("<a href='index.html'><button>Zurück</button></a>");
}
else if ($_POST['usecase'] == "save"){

	$vorname = mysqli_real_escape_string($db, $_POST["vorname"]);
	$nachname = mysqli_real_escape_string($db, $_POST["nachname"]);
	$note = mysqli_real_escape_string($db, $_POST["note"]);

	$query = "INSERT INTO noten(vorname,nachname,note) VALUES ('$vorname','$nachname','$note')";
	if (!$res = mysqli_query($db, $query)) 
	{
		echo "schmutz";
		printf(error("Fehler: ".mysqli_error($db)));
		mysqli_close($db);
		exit();
	}
	
	return header( 'Location: index.html' ) ;
}
?>