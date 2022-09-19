<!DOCTYPE HTML>
<html>

<head>
    <link rel="icon" href="/picture/icon.png">
    <title>Result Page</title>
    <link rel="stylesheet" href="/css/resultstyle.css">
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
        require_once('functions/config.php');

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

        /* #container size and quantity per PO is pre-defined in the itemgroup table
        $containersize_sql = "SELECT ContainerSize FROM ItemGroup WHERE ItmsGrpCod ='$itemgroup'";
        $containersize_result = $conn->query($containersize_sql);
        $containersize_row = $containersize_result->fetch_assoc();
        $containersize = $containersize_row["ContainerSize"];

        $weightpercontainer_sql = "SELECT WeightperContainer FROM ItemGroup WHERE ItmsGrpCod ='$itemgroup'";
        $weightpercontainer_result = $conn->query($weightpercontainer_sql);
        $weightpercontainer_row = $weightpercontainer_result->fetch_assoc();
        $weightpercontainer = $weightpercontainer_row["WeightperContainer"]; */

        $weightpercontainer = $_POST['QuantityperShipment'];
        $containersize = $_POST['Container_Size'];

        $product = $_POST['Product'];
        $product_sql = "SELECT * FROM Product WHERE ItemNo ='$product'";
        $product_result = $conn->query($product_sql);
        $product_row = $product_result->fetch_assoc();
        echo "<tr>" . "<td>" . "Product: " . "<td>" . $product_row["ItemDescription"] . '   (' . $product_row['ItemNo'] . ')';

        echo "<tr>" . "<td>" . "Product Unit Purchase Price: " . "<td>" . $_POST['Product_Price'] . " /MT";

        echo "<tr>" . "<td>" . "Purchase Currency: " . "<td>" . $_POST['Currency'];

        echo "<tr>" . "<td>" . "Exchange Rate: " . "<td>" . $_POST['FX_Rate'];

        echo "<tr>" . "<td>" . "Total Contract Quantity: " . "<td>" . $_POST['Quantity'] . " MT"; //The quantity is only for display, which is the quantity of whole contract

        echo "<tr>" . "<td>" . "Weight per Shipment: " . "<td>" .$weightpercontainer. " MT";

        echo "<tr>" . "<td>" . "Container Size: " . "<td>" .$containersize. " ft";

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

        /* ---------------------------------------------------------------------- 
    related cost summary
    */

        echo "<tr>" . "<td>" . "Related Cost Summary:";
        echo "<tr>" . "<td>";

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
        // echo "<tr>" . "<td>" . "Container Type: " . "<td>" . $containertype;

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

        echo "<tr>" . "<td>" . "Sea Freight: " . "<td>" . "AUD ". number_format($seafreightrate,2);


        /* $seafreightdecimal = number_format($seafreightrate,2);
    echo "seafreight: ".$seafreightdecimal;
    echo "<tr>"."<td>"; */

        $landedcost = 2500; //change landed cost here.
        echo "<tr>" . "<td>" . "Landed Cost: " . "<td>" . "AUD ". $landedcost;

        /*currently duty is not considered*/
        $whschargeperorder = 3.97 * 2; //inwards + outwards admin fee
        $whschargeperpallet = 3.67 + 2.61 + 1.06 + 0.84 + 3.63 + 3.43 + 3.63 + 2.61;

        #devanning charge by container type: 20' $340.40, 40' $473.59 
        #ambient storage = 3.25, temp controlled storage = 4.90 per pallet
        /*currently only using flat full truck load rate for metro delivery*/

        $storagetype = $containersize . " " . $_POST['Handling_Type'];
        // echo "<tr>" . "<td>" . "Storage Type: " . "<td>" . $storagetype;

        switch ($storagetype) {
            case "20 Ambient":
                $devanning = 359.12;
                $pallets = 20;
                $storagecharge = 3.43;
                $transportcharge = 485.20;
                break;
            case "20 Chilled":
                $devanning = 359.12;
                $pallets = 20;
                $storagecharge = 5.17;
                $transportcharge = 650.00;
                break;
            case "40 Ambient":
                $devanning = 499.64;
                $pallets = 40;
                $storagecharge = 3.43;
                $transportcharge = 759.60;
                break;
            case "40 Chilled":
                $devanning = 499.64;;
                $pallets = 40;
                $storagecharge = 5.17;
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

        $margin = $_POST['Margin'] / 100;

        $fuellevy = 0.35; //change fuel levy here.

        #calculate total cost by shipping from and supplier term:
        /*change the coding of this nested switch: by different conditions, set a new variable the value of the original variable * 0 or 1,
    eg. if the supplier term is CNF/CIF, the $seafreightactual = $seafreightdecimal * 0.
    */

    $warehouseinwards = $whschargeperorder + ($whschargeperpallet * $pallets)+ $devanning;
    $totalstoragecharge = $storagecharge * $_POST['Storage'] * $pallets;
    
        switch ($_POST['Shipping_From']) {
            case "Our Warehouse":

                switch ($_POST['Supplier_Term']) {
                    case "FOB":
                        $totalcharge = (130 * $weightpercontainer) + ($_POST['Product_Price'] * $weightpercontainer * (1 + $_POST['Duty'] / 100 + $finance) / $_POST['FX_Rate']) +
                            $seafreightrate + $landedcost + $warehouseinwards + $totalstoragecharge + ($transportcharge * (1 + $fuellevy));

                        
                        // echo "<tr>" . "<td>" . "Devanning: " . "<td>" . "AUD " . $devanning;
                        echo "<tr>" . "<td>" . "Warehouse Inwards Charge: " . "<td>" . "AUD " . $warehouseinwards;
                        // echo "<tr>" . "<td>" . "Pallets Amount: " . "<td>" . "AUD " . $pallets;
                        echo "<tr>" . "<td>" . "Storage Charge: " . "<td>"  . "AUD ". $totalstoragecharge;
                        echo "<tr>" . "<td>" . "Transport Charge: " . "<td>" . "AUD " . $transportcharge;
                        echo "<tr>" . "<td>" . "Fuel Levy: " . "<td>" . $fuellevy*100 . " %";
                        echo "<tr>" . "<td>" . "Overheads: " . "<td>" . "AUD 130" ;
                        break;
                    case "CNF/CIF":
                        $totalcharge = (130 * $weightpercontainer) + ($_POST['Product_Price'] * $weightpercontainer * (1 + $_POST['Duty'] / 100 + $finance) / $_POST['FX_Rate']) +
                            $landedcost + $warehouseinwards + $totalstoragecharge + ($transportcharge * (1 + $fuellevy));

                        echo "<tr>" . "<td>" . "Warehouse Inwards Charge: " . "<td>" . "AUD " . $warehouseinwards;
                        // echo "<tr>" . "<td>" . "Devanning: " . "<td>"  . "AUD ". $devanning;
                        // echo "<tr>" . "<td>" . "Pallets Amount: " . "<td>"  . "AUD ". $pallets;
                        echo "<tr>" . "<td>" . "Storage Charge: " . "<td>" . "AUD " . $totalstoragecharge;
                        echo "<tr>" . "<td>" . "Transport Charge: " . "<td>" . "AUD " . $transportcharge;
                        echo "<tr>" . "<td>" . "Fuel Levy: " . "<td>" . $fuellevy*100 . " %";
                        echo "<tr>" . "<td>" . "Overheads: " . "<td>" . "AUD 130" ;
                        break;
                };
                break;

            case "Direct FCL":
                switch ($_POST['Supplier_Term']) {
                    case "FOB":
                        $totalcharge = (100 * $weightpercontainer) + ($_POST['Product_Price'] * $weightpercontainer * (1 + $_POST['Duty'] / 100 + $finance) / $_POST['FX_Rate']) + $seafreightrate + $landedcost;
                        echo "<tr>" . "<td>" . "Overheads: " . "<td>" . "AUD 100" ;
                        break;
                    case "CNF/CIF":
                        $totalcharge = (100 * $weightpercontainer) + ($_POST['Product_Price'] * $weightpercontainer * (1 + $_POST['Duty'] / 100 + $finance) / $_POST['FX_Rate']) + $landedcost;
                        echo "<tr>" . "<td>" . "Overheads: " . "<td>" . "AUD 100" ;
                        break;
                };
                break;
        }




        // echo "<tr>" . "<td>" . "Total Charge: " . "<td>"  . $totalcharge;
        echo "<tr>" . "<td>" . "<td>";
        echo "<tr>" . "<td style='border-bottom:2px dashed rgb(250, 232, 200)'>" . "<td style='border-bottom:2px dashed rgb(250, 232, 200)'>";

        /* we buy in Euro, sell in AUD
        we buy in AUD, sell in AUD
        we buy in USD, sell in AUD or USD
        we buy GBP, sell in GBP or AUD 

        This is a easy way but not comprehensive to calculate the total cost related to currency:*/

        #calculation result starts here
        switch ($_POST['SaleCurrency'] == $_POST['Currency']) {
            case true:
                $costofproduct = $totalcharge / $weightpercontainer * $_POST['FX_Rate'];
                $marginvalue = ($totalcharge / $weightpercontainer / (1 - $margin) * $_POST['FX_Rate']) * $margin;
                $saleprice = ($totalcharge / $weightpercontainer / (1 - $margin) * $_POST['FX_Rate']);
                break;

            case false:
                $costofproduct = ($totalcharge / $weightpercontainer);
                $marginvalue = ($totalcharge / $weightpercontainer / (1 - $margin)) * $margin;
                $saleprice = ($totalcharge / $weightpercontainer / (1 - $margin));
                break;
        }
        echo "<tr>" . "<td>" . "Total Product Cost/ MT: ". "<td>". $_POST['SaleCurrency'] . " " . number_format($costofproduct, 0);
        echo "<tr>" . "<td>" . "Expected Margin/ MT: "."<td>".$_POST['SaleCurrency'] . " "  . number_format($marginvalue,0);
        echo "<tr>" . "<td>" . "Recommended Sale Price/ MT: ". "<td>".$_POST['SaleCurrency'] . " "  . number_format($saleprice,0);
        ?>
    </table>

    <button onClick="window.print()">Print</button>
</body>

<footer style="margin-top: 40px;">
    <table>
        <tr>
            <td>
                &copy; Copyright
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