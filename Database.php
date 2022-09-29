
$username = "";
$email = "";
$errors = array();

$servername = "jhtstoveke.be.mysql";
$username = "jhtstoveke_beimslab";
$password = "IMSLab5R48B66L";
$dbname = "jhtstoveke_beimslab";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
