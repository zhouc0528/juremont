<?php
require_once('functions/confignz.php');
?>

<!DOCTYPE HTML>
<html>

<head>
  <link rel="icon" href="/picture/icon.png">
  <title>Cost of Product Calculation - NZ</title>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="/javascript/productcascadingnz.js"></script>
  <script type="text/javascript" src="/javascript/displaycontrolnz.js"></script>
  <link rel="stylesheet" href="/css/nz.css">
  <table>
    <tr>
      <td>
        <img src="/picture/logo-trans.png" style="width: 160px; height:75px;">
      </td>
      <td>
        <h1 style="font-family: 'Courier New', Courier, monospace;">
          &nbsp;&nbsp;
          Cost Calculator (New Zealand)

          NZ is not completed, please ignore.
        </h1>
      </td>
    </tr>
  </table>
</head>

<body>
<form action="resultnz.php" method="post">

<label>Supplier:</label>
<select id="supplier" name="Supplier">
  <option value="">--- Select Supplier ---</option>
  <?php
  $sql = "SELECT * from BP b  where BPType = 'S' and b.InUse = 1 Order by b.BPName"; 
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row["BPCode"]}'>{$row['BPName']}</option>";
  }
  ?>
</select> <br><br>

<label>Item Group:</label>
<select id="itemgroup" name="Item_Group">
  <option value="">--- Select Item Group ---</option>
  <?php
  $sql = "SELECT * FROM ItemGroup order by ItmsGrpNam";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row["ItmsGrpCod"]}'>{$row['ItmsGrpNam']}</option>";
  }
  ?>
</select><br>

<label>Product:</label>
<select id="product" name="Product">
  <option value="">--- Select Product ---</option>
</select><br><br>

<label>Product Unit Purchase Price/ MT:</label>
<input type="number" min="0.00" step="any" name="Product_Price"><br><br>

<label>Purchase Currency:</label>
<select id="currency" name="Currency">
  <option value="NZD">NZD</option>
  <option value="USD">USD</option>
</select><br><br>

<div id="fxcontrol" style="display: none;">
  <label>Exchange Rate:</label>
  <input type="number" min="0.00" step="0.01" name="FX_Rate" value="1.00"><br><br>
</div>

<label>Total Contract Quantity:</label>
<input type="number" min="0.00" step="any" name="Quantity"> (MT)<br><br>

<label>Weight per Shipment:</label>
<input type="number" min="0.00" step="any" name="QuantityperShipment"> (MT)<br><br>

<label>Container Size: </label>
<input type="radio" name="Container_Size" value="20">20 ft &nbsp&nbsp&nbsp
<input type="radio" name="Container_Size" value="40">40 ft
<br><br>

<label>Duty:</label>
<select id="duty" name="Duty">
  <option value="0">0%</option>
  <option value="4">4%</option>
  <option value="5">5%</option>
</select><br><br>

<label>Product Handling Type: </label>
<input type="radio" name="Handling_Type" value="Ambient">Ambient &nbsp&nbsp&nbsp
<input type="radio" name="Handling_Type" value="Chilled">Chilled
<br><br>

<label>Customer:</label>
<select id="customer" name="Customer">
  <option value="">--- Select Customer ---</option>
  <?php
  $sql = "SELECT * from BP b  where b.BPType  = 'C' and InUse = 1 Order by b.BPName";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row["BPCode"]}'>{$row['BPName']}</option>";
  }
  ?>
</select><br><br>

<label>Delivery From:</label>
<select id="shippingfrom" name="Shipping_From">
  <option value="Our Warehouse">Our Warehouse</option>
  <option value="Direct FCL">Direct FCL</option>
</select><br><br>

<div id="storagecontrol">
  <label>Product Storage Period: </label>
  <input type="number" name="Storage" value=0> (Weeks)<br>
</div>

<br>
<label>Margin:</label>
<input type="number" min="0" step="0.1" name="Margin">&nbsp%<br><br><br>

<input type="submit" value="Calculate" id="calculate">
</form>
</body>

<footer style="margin-top: 30px;">
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