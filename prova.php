<!DOCTYPE HTML>
<html>

<head>
  <link rel="icon" href="/picture/icon.png">
  <title>Cost of Product Calculation - Prova</title>
  <link rel="stylesheet" href="/css/prova.css">
  <table>
    <tr>
      <td>
        <img src="/picture/logo-trans.png" style="width: 160px; height:75px;">
      </td>
      <td>
        <h1 style="font-family: 'Courier New', Courier, monospace;">
          &nbsp;&nbsp;
          Prova Pricing Model 2024
        </h1>
      </td>
    </tr>
  </table>
</head>

<body>
  <form action="resultprova.php" method="post">

  <label>Product Name:</label>
    <input type="text" name="product"><br><br>

    <label>Unit Price (EURO):</label>
    <input type="number" min="0.00" step="0.01" name="unitprice">&nbsp/KG<br><br>

    <label>Shipment Quantity:</label>
    <input type="number" name="shipmentquantity"> KG<br><br>

    <label>Freight Type: </label>
    <input type="radio" name="freighttype" value="LCL">LCL Sea Freight &nbsp&nbsp&nbsp
    <input type="radio" name="freighttype" value="airfreight">Parcel Air Freight
    <br><br>

    <label>Freight Cost (EURO):</label>
    <input type="number" name="freightcost"><br><br>

    <label>Exchange Rate:</label>
      <input type="number" min="0.00" step="0.01" max="1.0" name="fxrate"><br><br>

    <label>Duty:</label>
    <select name="duty">
      <option value=0>0</option>
      <option value=5.0>5.0</option>
    </select>&nbsp%<br><br>

    <label>Finance Costs:</label>
    <select name="finance">
      <option value=1.5>1.5</option>
      <option value=2.0>2.0</option>
      <option value=2.5>2.5</option>
      <option value=3.0>3.0</option>
    </select>&nbsp%<br><br>

    <!--
    <label>Wharf to Warehouse:</label>
    <input type="number" name="wharftowarehouse"><br><br>

    <label>Warehouse Handling:</label>
    <input type="number" name="warehousehandling"><br><br>

    <label>Storage:</label>
    <input type="number" name="storage"><br><br>
    -->

    <label>Target Margin Percentage:</label>
    <input type="number" min="0" step="0.1" name="margin">&nbsp%<br><br>
    <br>

    <input type="submit" value="Calculate" id="calculate">
  </form>
</body>

<footer style="margin-top: 30px;">
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