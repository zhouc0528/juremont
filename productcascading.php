<?php
require_once('config.php');
$ItmsGrpCod = $_POST['ItmsGrpCod'];
$sql = "SELECT * FROM Product WHERE ItemGroup = {$ItmsGrpCod} and Active = 'Y' order by ItemDescription";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['ItemNo'] . '">' . $row['ItemDescription'] . '</option>';
}

?>