<!DOCTYPE HTML>
<html>

<head>
    <link rel="icon" href="/picture/icon.png">
    <title>Result Page</title>
    <link rel="stylesheet" href="/css/resultstyleprova.css">
    <table>
        <tr>
            <td>
                <img src="/picture/logo-trans.png" style="width: 160px; height:75px;">
            </td>
            <td>
                <h1 style="font-family: 'Courier New', Courier, monospace;">
                    &nbsp;Recommended Sale Price
                </h1>
            </td>
        </tr>
    </table>
</head>

<body>
    <table class="bordered-table">
        <?php

        echo "<tr>" . "<td>" . "Product Name: " . "<td>" . $_POST['product'];

        echo "<tr>" . "<td>" . "Unit Price per KG: " . "<td>" . number_format($_POST['unitprice'],2). " /KG";

        echo "<tr>" . "<td>" . "Shipment Quantity: " . "<td>" . $_POST['shipmentquantity']." KG";

        switch ($_POST['freighttype']) {
            case "FCL":
                $clearance = 2900;
                break;
            case "LCL":
                $clearance = 1000;
                break;
            case "airfreight":
                $clearance = 740;
                break;            
        };

        echo "<tr>" . "<td>" . "Clearance/Direct Delivery: " . "<td>" . number_format($clearance,2);

        $freightcost = $_POST['freighttype'] === 'airfreight' ? $_POST['freightcost'] : 0;

        echo "<tr>" . "<td>" . "Additional Air Freight: " . "<td>" . number_format($freightcost,2);

        echo "<tr>" . "<td>" . "Exchange Rate: " . "<td>" . $_POST['fxrate']; 
        $fxrate = $_POST['fxrate'];

        echo "<tr>" . "<td>" . "Duty: " . "<td>" . $_POST['duty'] . " %";
        $duty = $_POST['duty'] / 100;

        $additionalCost = $_POST['customertype'] === 'new' ? 0.07 * $_POST['unitprice'] * $_POST['shipmentquantity']/$fxrate : 0;

        echo "<tr>" . "<td>" . "New Business Additional Cost: " . "<td>" . number_format($additionalCost,2);

        switch ($_POST['shipto']) {
            case 'warehouse':
                switch ($_POST['freighttype']) {
                    case 'FCL':
                        $warehousehandling = 400 + 7.94 + 430; // including devanning, admin fee, inwards + outwards
                        $transportcharge = 1700; // using $85 per pallet rate to calculate transport, including fuel levy, no matter rural area or inter-state
                        $storagecharge = 7 * $_POST['storageweeks']*22;
                        break;
                    case 'LCL': 
                        $warehousehandling = 7.94 + (20 + 21) * $_POST['pallets']; 
                        $transportcharge = 85 * $_POST['pallets']; // using $85 per pallet rate to calculate transport, including fuel levy, no matter rural area or inter-state
                        $storagecharge = 7 * $_POST['storageweeks'] * $_POST['pallets'];
                        break;
                    default:
                        $warehousehandling = 0;
                        $transportcharge = 0;
                }
                $finance = 0.01 + (0.002 * $_POST['storageweeks']);
                break;
            default:
                $warehousehandling = 0;
                $transportcharge = 0;
                $storagecharge = 0;
                $finance = 0.01;
                //$transport = ($_POST['customerlocation'] === 'metro') ? 600 : 800;
        }

        echo "<tr>" . "<td>" . "Warehouse Handling: " . "<td>" . number_format($warehousehandling,2);
        echo "<tr>" . "<td>" . "Transport Charge: " . "<td>" . number_format($transportcharge,2);
        echo "<tr>" . "<td>" . "Storage Charge: " . "<td>" . number_format($storagecharge,2);

        $margin = $_POST['margin'] / 100;
        $costofproduct = ($_POST['unitprice'] * $_POST['shipmentquantity'] + $freightcost)/$fxrate;
        $totalcost = $costofproduct * (1+$duty+$finance) + $clearance + $transportcharge + $additionalCost + $wharftowarehouse + $warehousehandling + $storagecharge;
        echo "<tr>" . "<td>" . "Finance: " . "<td>" . number_format($costofproduct * $finance,2);
             

        echo "<tr>" . "<td>" . "Margin: " . "<td>" . $_POST['margin'] . " %";

        echo "<tr class='dashed-line'><td colspan='2'></td></tr>";

        $profit = $totalcost / (1 - $margin) * $margin;
        $salepriceaud = ($totalcost + $profit) / $_POST['shipmentquantity'];
        $salepriceeuro = $salepriceaud * $fxrate;

        echo "<tr>" . "<td>" . "Cost Total: ". "<td>". "AUD " . number_format($totalcost, 0);
        echo "<tr><td><strong>Juremont GP:</strong><td><strong>AUD "  . number_format($profit,0) . "</strong></td></tr>";
        echo "<tr>" . "<td>" . "Sell Price/ KG: ". "<td>"."AUD "  . number_format($salepriceaud,2);
        echo "<tr>" . "<td>" . "Sell Price/ KG: ". "<td>"."EURO "  . number_format($salepriceeuro,2);
        ?>
    </table>

    <button onClick="window.print()">Print</button>
    <p></p>

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
