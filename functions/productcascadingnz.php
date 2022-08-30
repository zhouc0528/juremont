<?php
require_once('confignz.php');
$ItmsGrpCod = $_POST['ItmsGrpCod'];
$sql = "SELECT * FROM Product WHERE ItemGroup = {$ItmsGrpCod} and Active = 'Y' order by ItemDescription";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['ItemNo'] . '">' . $row['ItemDescription'] .'   ('. $row['ItemNo'] . ')' . '</option>';
}

?>