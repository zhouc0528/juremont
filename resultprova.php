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
    <table>
        <?php

        echo "<tr>" . "<td>" . "Product Name: " . "<td>" . $_POST['product'] ;

        echo "<tr>" . "<td>" . "Unit Price per KG: " . "<td>" . $_POST['unitprice']. " /KG";

        echo "<tr>" . "<td>" . "Shipment Quantity: " . "<td>" . $_POST['shipmentquantity']." KG";

        echo "<tr>" . "<td>" . "Freight Type: " . "<td>" . $_POST['freighttype']; 

        switch ($_POST['freighttype']) {
            case "LCL":
                $clearance = 500;
                $transport = 200;
                break;
            case "airfreight":
                $clearance = 430;
                $transport = 110;
                break;            
        };

        $freightcost = $_POST['freightcost'];

        echo "<tr>" . "<td>" . "Exchange Rate: " . "<td>" . $_POST['fxrate']; 
        $fxrate = $_POST['fxrate'];

        echo "<tr>" . "<td>" . "Duty: " . "<td>" . $_POST['duty'] . " %";
        $duty = $_POST['duty'] / 100;

        $finance = $_POST['finance'] / 100;

        echo "<tr>" . "<td>" . "Margin: " . "<td>" . $_POST['margin'] . " %";
        $margin = $_POST['margin'] / 100;

        echo "<tr>" . "<td>" . "<td>";
        echo "<tr>" . "<td style='border-bottom:2px dashed rgb(0, 0, 0)'>" . "<td style='border-bottom:2px dashed rgb(0, 0, 0)'>"; 
        echo "<tr>" . "<td>" . "<td>";

        $purchasecost = ($_POST['unitprice'] * $_POST['shipmentquantity'] + $_POST['freightcost'])/$fxrate;

        $totalcost = $purchasecost * (1+$duty+$finance) + $clearance + $transport;
        $profit = $totalcost/ (1-$margin) * $margin;
        $salepriceaud = ($totalcost + $profit)/ $_POST['shipmentquantity'];
        $salepriceeuro = $salepriceaud * $fxrate;

        echo "<tr>" . "<td>" . "Cost Total: ". "<td>". "AUD " . number_format($totalcost, 0);
        echo "<tr><td><strong>Juremont GP:</strong><td><strong>AUD "  . number_format($profit,0) . "</strong></td></tr>";
        echo "<tr>" . "<td>" . "Sell Price/ KG: ". "<td>"."AUD "  . number_format($salepriceaud,0);
        echo "<tr>" . "<td>" . "Sell Price/ KG: ". "<td>"."EURO "  . number_format($salepriceeuro,0);
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