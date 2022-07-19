<!DOCTYPE HTML>
<html>

<head>
    <link rel="icon" href="/picture/icon.png">
    <title>Result Page</title>
    <link rel="stylesheet" href="/css/resultstyle.css">
    <h1 style="font-family: 'Courier New', Courier, monospace;">
        Here is Your Input Summary:
    </h1>
</head>

<body>
    <table>
        <?php
        require_once('config.php');

        $supplier = $_POST['Supplier'];
        $supplier_sql = "SELECT BPName FROM BP WHERE BPCode ='$supplier'";
        $supplier_result = $conn->query($supplier_sql);
        $supplier_row = $supplier_result->fetch_assoc();
        echo "<tr>" . "<td>" . "Supplier: " . "<td>" . $supplier_row["BPName"];

        $itemgroup = $_POST['Item_Group'];
        $itemgroup_sql = "SELECT ItmsGrpNam FROM ItemGroup WHERE ItmsGrpCod ='$itemgroup'";
        $itemgroup_result = $conn->query($itemgroup_sql);
        $itemgroup_row = $itemgroup_result->fetch_assoc();
        echo "<tr>" . "<td>" . "Item Group: " . "<td>" . $itemgroup_row["ItmsGrpNam"];

        #container size and quantity per PO is pre-defined in the itemgroup table
        $containersize_sql = "SELECT ContainerSize FROM ItemGroup WHERE ItmsGrpCod ='$itemgroup'";
        $containersize_result = $conn->query($containersize_sql);
        $containersize_row = $containersize_result->fetch_assoc();
        $containersize = $containersize_row["ContainerSize"];

        $weightpercontainer_sql = "SELECT WeightperContainer FROM ItemGroup WHERE ItmsGrpCod ='$itemgroup'";
        $weightpercontainer_result = $conn->query($weightpercontainer_sql);
        $weightpercontainer_row = $weightpercontainer_result->fetch_assoc();
        $weightpercontainer = $weightpercontainer_row["WeightperContainer"];

        /*     echo "<tr>" . "<td>" . "Weight per Container: " . "<td>" .$weightpercontainer; */

        /*     echo "<tr>" . "<td>" . "Container Size: " . "<td>" .$containersize; */

        $product = $_POST['Product'];
        $product_sql = "SELECT ItemDescription FROM Product WHERE ItemNo ='$product'";
        $product_result = $conn->query($product_sql);
        $product_row = $product_result->fetch_assoc();
        echo "<tr>" . "<td>" . "Product: " . "<td>" . $product_row["ItemDescription"];

        echo "<tr>" . "<td>" . "Product Unit Purchase Price: " . "<td>" . $_POST['Product_Price'] . " /MT";

        echo "<tr>" . "<td>" . "Purchase Currency: " . "<td>" . $_POST['Currency'];

        echo "<tr>" . "<td>" . "Exchange Rate: " . "<td>" . $_POST['FX_Rate'];

        echo "<tr>" . "<td>" . "Total Contract Quantity: " . "<td>" . $_POST['Quantity'] . " MT"; //The quantity is only for display, which is the quantity of whole contract

        echo "<tr>" . "<td>" . "Duty: " . "<td>" . $_POST['Duty'] . " %";

        //change finance percentage here:
        switch (true) {
            case $_POST['Storage'] <= 4:
                $finance = 0.015;
                break;

            case $_POST['Storage'] <= 8:
                $finance = 0.02;
                break;

            default:
                $finance = 0.025;
                break;
        }

        echo "<tr>" . "<td>" . "Finance: " . "<td>" . ($finance * 100) . "%";

        echo "<tr>" . "<td>" . "Product Handling Type: " . "<td>" . $_POST['Handling_Type'];

        // echo "<tr>"."<td>"."Estimated Pallets Amount: "."<td>".$_POST['Pallets']." Pallets";

        echo "<tr>" . "<td>" . "Supplier Term: " . "<td>" . $_POST['Supplier_Term'];

        echo "<tr>" . "<td>" . "Departure Port: " . "<td>" . $_POST['Departure_Port'];

        $customer = $_POST['Customer'];
        $customer_sql = "SELECT BPName FROM BP WHERE BPCode ='$customer'";
        $customer_result = $conn->query($customer_sql);
        $customer_row = $customer_result->fetch_assoc();
        echo "<tr>" . "<td>" . "Customer: " . "<td>" . $customer_row["BPName"];

        echo "<tr>" . "<td>" . "Delivery From: " . "<td>" . $_POST['Shipping_From'];

        echo "<tr>" . "<td>" . "Storage Period: " . "<td>" . $_POST['Storage'];
        echo "<tr>" . "<td>" . "<td>";
        echo "<tr>" . "<td style='border-bottom:2px dashed rgb(250, 232, 200)'>" . "<td style='border-bottom:2px dashed rgb(250, 232, 200)'>";


        echo "<tr>" . "<td>" . "This section is for testing (will delete): ";
        echo "<tr>" . "<td>";

        $fuellevy = 0.35; //change fuel levy here.

        #convert product handling type to container type
        switch ($_POST['Handling_Type']) {
            case "Ambient":
                $ctype = "DC";
                break;
            case "Chilled":
                $ctype = "RF";
                break;
            case "Frozen":
                $ctype = "RF";
                break;
        };

        #calculate sea freight based on container type and departure port.
        $dport = $_POST['Departure_Port'];
        $containertype = $containersize . " " . $ctype;
        echo $containertype;
        echo "<tr>" . "<td>";
        $seafreight_sql = "SELECT Rate FROM SeaFreight WHERE PortofLoading ='$dport' and ContainerType ='$containertype'";
        $seafreight_result = $conn->query($seafreight_sql);
        $seafreight_row = $seafreight_result->fetch_assoc();

        switch ($dport) {
            case "Others";
                $seafreightrate = $_POST['spotrate'] / 0.7;
                break;
            default:
                $seafreightrate = $seafreight_row["Rate"] / 0.7;
        };

        echo "<tr>" . "<td>" . "Sea Freight: " . "<td>" . $seafreightrate;
        echo "<tr>" . "<td>";

        /* $seafreightdecimal = number_format($seafreightrate,2);
    echo "seafreight: ".$seafreightdecimal;
    echo "<tr>"."<td>"; */

        $landedcost = 2500; //change landed cost here.

        /*currently duty is not considered*/
        $whschargeperorder = 3.76 * 2; //inwards + outwards admin fee
        $whschargeperpallet = 3.44 + 3.48 + 1.00 + 0.80 + 3.48 + 3.44;

        #devanning charge by container type: 20' $340.40, 40' $473.59 
        #ambient storage = 3.25, temp controlled storage = 4.90 per pallet
        /*currently only using flat full truck load rate for metro delivery*/

        $storagetype = $containersize . " " . $_POST['Handling_Type'];
        echo $storagetype;
        echo "<tr>" . "<td>";

        switch ($storagetype) {
            case "20 Ambient":
                $devanning = 340.40;
                $pallets = 20;
                $storagecharge = 3.25;
                $transportcharge = 460.00;
                break;
            case "20 Chilled":
                $devanning = 340.40;
                $pallets = 20;
                $storagecharge = 4.90;
                $transportcharge = 650.00;
                break;
            case "40 Ambient":
                $devanning = 473.59;
                $pallets = 40;
                $storagecharge = 3.25;
                $transportcharge = 720.00;
                break;
            case "40 Chilled":
                $devanning = 473.59;
                $pallets = 40;
                $storagecharge = 4.90;
                $transportcharge = 900.00;
                break;
            case "20 Frozen":
                $devanning = 450.00;
                $pallets = 20;
                $storagecharge = 5.00;
                $transportcharge = 600;
                break;
            case "40 Frozen":
                $devanning = 700.00;
                $pallets = 40;
                $storagecharge = 5.00;
                $transportcharge = 1200;
                break;
        };
        echo "devanning:" . $devanning;
        echo "<tr>" . "<td>";
        echo "pallets amount: " . $pallets;
        echo "<tr>" . "<td>";
        echo "storage charge: " . $storagecharge;
        echo "<tr>" . "<td>";
        echo "transport charge: " . $transportcharge;
        echo "<tr>" . "<td>";

        $margin = $_POST['Margin'] / 100;

        #calculate total cost by shipping from and supplier term:
        /*change the coding of this nested switch: by different conditions, set a new variable the value of the original variable * 0 or 1,
    eg. if the supplier term is CNF/CIF, the $seafreightactual = $seafreightdecimal * 0.
    */

        switch ($_POST['Shipping_From']) {
            case "Our Warehouse":

                switch ($_POST['Supplier_Term']) {
                    case "FOB":
                        $totalcharge = ($_POST['Product_Price'] * $weightpercontainer * (1 + $_POST['Duty'] / 100 + $finance) / $_POST['FX_Rate']) +
                            $seafreightrate + $landedcost + $whschargeperorder + ($whschargeperpallet * $pallets) +
                            $devanning + ($storagecharge * $_POST['Storage'] * $pallets) + ($transportcharge * (1 + $fuellevy));
                        break;
                    case "CNF/CIF":
                        $totalcharge = ($_POST['Product_Price'] * $weightpercontainer * (1 + $_POST['Duty'] / 100 + $finance) / $_POST['FX_Rate']) +
                            $landedcost + $whschargeperorder + ($whschargeperpallet * $pallets) +
                            $devanning + ($storagecharge * $_POST['Storage'] * $pallets) + ($transportcharge * (1 + $fuellevy));
                        break;
                };
                break;

            case "Direct FCL":
                switch ($_POST['Supplier_Term']) {
                    case "FOB":
                        $totalcharge = ($_POST['Product_Price'] * $weightpercontainer * (1 + $_POST['Duty'] / 100 + $finance) / $_POST['FX_Rate']) + $seafreightrate + $landedcost;
                        break;
                    case "CNF/CIF":
                        $totalcharge = ($_POST['Product_Price'] * $weightpercontainer * (1 + $_POST['Duty'] / 100 + $finance) / $_POST['FX_Rate']) + $landedcost;
                        break;
                };
                break;
        }




        echo "total charge: " . $totalcharge;
        echo "<tr>" . "<td>" . "<td>";
        echo "<tr>" . "<td style='border-bottom:2px dashed rgb(250, 232, 200)'>" . "<td style='border-bottom:2px dashed rgb(250, 232, 200)'>";
        echo "<tr>" . "<td>" . "Total Product Cost/ MT: ";
        echo "<td>";
        $costofproduct = number_format(($totalcharge / $weightpercontainer), 0);
        echo "AUD$ " . $costofproduct;
        echo "<tr>" . "<td>" . "Expected Margin/ MT: ";
        echo "<td>";
        echo "AUD$ " . number_format(($totalcharge / $weightpercontainer / (1 - $margin)) * $margin, 0);
        echo "<tr>" . "<td>" . "Recommended Sale Price/ MT: ";
        echo "<td>";
        $saleprice = number_format(($totalcharge / $weightpercontainer / (1 - $margin)), 0);
        echo "AUD$ " . $saleprice;
        echo "<tr>" . "<td>";
        echo "<tr>" . "<td>";
        echo "<tr>" . "<td>";
        ?>
    </table>
</body>

<footer>
    <table>
        <tr>
            <td>
                &copy; Copyright 
                <script>
                    document.write(new Date().getFullYear())
                </script>: Juremont Pty Ltd<br>
                &nbsp;&nbsp;&nbsp;&nbsp;Support:
                <a href="mailto:accounts@jure.com.au">Juremont Finance Team</a>
            </td>

            <td>
                <img src="/picture/logo.jpg" style="width: 400px; height:75px; margin-left:20px">
            </td>
        </tr>
    </table>
</footer>

</html>