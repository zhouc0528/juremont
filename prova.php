<!DOCTYPE HTML>
<html>

<head>
  <link rel="icon" href="/picture/icon.png">
  <title>Cost of Product Calculation - Prova</title>
  <link rel="stylesheet" href="/css/prova.css">
  <script src="/javascript/prova.js"></script>
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
    <input type="radio" name="freighttype" value="FCL" onchange="toggleFreightCost()">FCL Sea Freight CIF &nbsp&nbsp&nbsp
    <input type="radio" name="freighttype" value="LCL" onchange="toggleFreightCost()">LCL Sea Freight CIF &nbsp&nbsp&nbsp
    <input type="radio" name="freighttype" value="airfreight" onchange="toggleFreightCost()">Parcel Air Freight
    <br><br>

    <div id="freightCostSection">
      <label>Freight Cost (EURO):</label>
      <input type="number" name="freightcost" value="0"><br><br>
    </div>

    <label>Exchange Rate:</label>
    <input type="number" min="0.00" step="0.01" max="1.0" name="fxrate"><br><br>

    <label>Duty:</label>
    <select name="duty">
      <option value=0>0% (Thailand Origin)</option>
      <option value=5.0>5.0% (France Origin)</option>
    </select><br><br>

    <label>Customer Type:</label>
      <input type="radio" name="customertype" value="transfer" onchange="toggleNewBusiness()"> Transfer Business &nbsp&nbsp&nbsp
      <input type="radio" name="customertype" value="new" onchange="toggleNewBusiness()"> New Business<br><br>

    <label>Ship To:</label>
      <input type="radio" name="shipto" value="warehouse" onchange="toggleStorageWeeks()"> Warehouse &nbsp&nbsp&nbsp
      <input type="radio" name="shipto" value="customer" onchange="toggleStorageWeeks()"> Customer<br><br>

<!--<div id="customerLocationSection" style="display:none;">
      <label>Customer Location:</label>
      <input type="radio" name="customerlocation" value="metro"> Metro
      <input type="radio" name="customerlocation" value="rural"> Rural<br><br>
    </div> -->

    <div id="storageWeeksSection" style="display:none;">
      <label>Storage Weeks:</label>
      <input type="number" name="storageweeks" value="0"><br><br>
    </div>

<!--<label>Finance Costs:</label>
    <select name="finance">
      <option value=1.15>1.15</option>
      <option value=2.0>2.0</option>
      <option value=2.5>2.5</option>
      <option value=3.0>3.0</option>
    </select>&nbsp%<br><br> -->

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
