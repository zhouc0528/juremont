<!DOCTYPE HTML>
<html>

<head>
    <link rel="icon" href="/picture/icon.png">
    <title>Result Page</title>
    <link rel="stylesheet" href="/css/resultstylenz.css">
    <table>
        <tr>
            <td>
                <img src="/picture/logo-trans.png" style="width: 160px; height:75px;">
            </td>
            <td>
                <h1 style="font-family: 'Courier New', Courier, monospace;">
                    &nbsp;Input Summary and Result
                </h1>
            </td>
        </tr>
    </table>
</head>

<body>
    <table>
        <?php
        require_once('functions/confignz.php');

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

        $product = $_POST['Product'];
        $product_sql = "SELECT * FROM Product WHERE ItemNo ='$product'";
        $product_result = $conn->query($product_sql);
        $product_row = $product_result->fetch_assoc();
        echo "<tr>" . "<td>" . "Product: " . "<td>" . $product_row["ItemDescription"] . '   (' . $product_row['ItemNo'] . ')';

        echo "<tr>" . "<td>" . "Product Unit Purchase Price: " . "<td>" . $_POST['Product_Price'] . " /MT";

        echo "<tr>" . "<td>" . "Purchase Currency: " . "<td>" . $_POST['Currency'];

        echo "<tr>" . "<td>" . "Exchange Rate: " . "<td>" . $_POST['FX_Rate'];

        echo "<tr>" . "<td>" . "Total Contract Quantity: " . "<td>" . $_POST['Quantity'] . " MT"; //The quantity is only for display, which is the quantity of whole contract

        $weightpercontainer = $_POST['QuantityperShipment'];

        echo "<tr>" . "<td>" . "Weight per Shipment: " . "<td>" .$weightpercontainer. " MT";

        $containersize = $_POST['Container_Size'];

        echo "<tr>" . "<td>" . "Container Size: " . "<td>" .$containersize. " ft";

        echo "<tr>" . "<td>" . "Duty: " . "<td>" . $_POST['Duty'] . " %";

        #change finance percentage here:
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

        $customer = $_POST['Customer'];
        $customer_sql = "SELECT BPName FROM BP WHERE BPCode ='$customer'";
        $customer_result = $conn->query($customer_sql);
        $customer_row = $customer_result->fetch_assoc();
        echo "<tr>" . "<td>" . "Customer: " . "<td>" . $customer_row["BPName"];

        echo "<tr>" . "<td>" . "Delivery From: " . "<td>" . $_POST['Shipping_From'];

        echo "<tr>" . "<td>" . "Storage Period: " . "<td>" . $_POST['Storage'];
        echo "<tr>" . "<td>" . "<td>";
        echo "<tr>" . "<td style='border-bottom:2px dashed rgb(250, 232, 200)'>" . "<td style='border-bottom:2px dashed rgb(250, 232, 200)'>";

        /*related cost summary*/

        echo "<tr>" . "<td>" . "Related Cost Summary:";
        echo "<tr>" . "<td>";

        switch ($_POST['Supplier']) {
            case 'Juremont Pty Ltd-NZD':
                $landedcost = 7500 + (600*(1+0.25)+6.430+382.210+3.910*22+5.500*3+4.230+3.910*22)*1.07;//average store 2-3 weeks in AU, item cost = current inventory cost
                break;
            default:
                $landedcost = 1600;
                break;
        }
        
        //$landedcost = 1500; change landed cost here.
        echo "<tr>" . "<td>" . "Landed Cost: " . "<td>" . "NZD ". $landedcost;

        $whschargeperorder = 8.15+5.31; //inwards + outwards admin fee
        $whschargeperpallet = 6.14+3.23+2.85+2.29+3.4+3.23+7.9;

        $storagetype = $containersize . " " . $_POST['Handling_Type'];

        switch ($storagetype) {
            case "20 Ambient":
                $devanning = 300;
                $pallets = 20;
                $storagecharge = 4.52;
                $transportcharge = 250;
                break;
            case "20 Chilled":
                $devanning = 300;
                $pallets = 20;
                $storagecharge = 4.52;
                $transportcharge = 250;
                break;
            case "40 Ambient":
                $devanning = 550;
                $pallets = 40;
                $storagecharge = 4.52;
                $transportcharge = 365;
                break;
            case "40 Chilled":
                $devanning = 550;
                $pallets = 40;
                $storagecharge = 4.52;
                $transportcharge = 365;
                break;
        };

        $margin = $_POST['Margin'] / 100;

        $fuellevy = 0.25; //change fuel levy here.

    $warehouseinwards = $whschargeperorder + ($whschargeperpallet * $pallets)+ $devanning;
    $totalstoragecharge = $storagecharge * $_POST['Storage'] * $pallets;
  
        switch ($_POST['Shipping_From']) {
            case "Our Warehouse":
                        $totalcharge = (130 * $weightpercontainer) + ($_POST['Product_Price'] * $weightpercontainer * (1 + $_POST['Duty'] / 100 + $finance) / $_POST['FX_Rate']) +
                            $landedcost + $warehouseinwards + $totalstoragecharge + ($transportcharge * (1 + $fuellevy));

                        echo "<tr>" . "<td>" . "Warehouse Inwards Charge: " . "<td>" . "NZD " . $warehouseinwards;
                        echo "<tr>" . "<td>" . "Storage Charge: " . "<td>" . "NZD " . $totalstoragecharge;
                        echo "<tr>" . "<td>" . "Transport Charge: " . "<td>" . "NZD " . $transportcharge;
                        echo "<tr>" . "<td>" . "Fuel Levy: " . "<td>" . $fuellevy*100 . " %";
                        echo "<tr>" . "<td>" . "Overheads: " . "<td>" . "NZD 130" ;
                        break;

            case "Direct FCL":
                        $totalcharge = (100 * $weightpercontainer) + ($_POST['Product_Price'] * $weightpercontainer * (1 + $_POST['Duty'] / 100 + $finance) / $_POST['FX_Rate']) + $landedcost;
                        echo "<tr>" . "<td>" . "Overheads: " . "<td>" . "NZD 100" ;
                        break;
        }


        echo "<tr>" . "<td>" . "<td>";
        echo "<tr>" . "<td style='border-bottom:2px dashed rgb(250, 232, 200)'>" . "<td style='border-bottom:2px dashed rgb(250, 232, 200)'>";

        #calculation result starts here
        $costofproduct = ($totalcharge / $weightpercontainer);
        $marginvalue = ($totalcharge / $weightpercontainer / (1 - $margin)) * $margin;
        $saleprice = ($totalcharge / $weightpercontainer / (1 - $margin));

        echo "<tr>" . "<td>" . "Total Product Cost/ MT: ". "<td>". "NZD " . " " . number_format($costofproduct, 0);
        echo "<tr>" . "<td>" . "Expected Margin/ MT: "."<td>". "NZD " . " "  . number_format($marginvalue,0);
        echo "<tr>" . "<td>" . "Recommended Sale Price/ MT: ". "<td>"."NZD " . " "  . number_format($saleprice,0);
        ?>
    </table>

    <button onClick="window.print()">Print</button>
</body>

<footer style="margin-top: 40px;">
    <table>
        <tr>
            <td>
                &copy; Copyright 2022 -
                <script>
                    document.write(new Date().getFullYear())
                </script>: Juremont Pty Ltd<br>
            </td>

            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Support:
                <a href="mailto:accounts@jure.com.au" style="color: white;">Juremont Finance Team</a>
            </td>
        </tr>
    </table>
</footer>

</html>