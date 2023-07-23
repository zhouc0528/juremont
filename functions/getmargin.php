<?php
require_once('config.php');
$ItmsGrpCod = $_POST['item_group'];
$sql = "SELECT Margin FROM ItemGroup WHERE ItmsGrpCod = '$ItmsGrpCod'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['Margin'];
} else {
    echo "0";
}
?>
