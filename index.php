<?php
require_once('config.php');
?>

<!DOCTYPE HTML>
<html>

<head>
  <link rel="icon" href="/picture/icon.png">
  <title>Cost of Product Calculation</title>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="/javascript/productcascading.js"></script>  
  <script type="text/javascript" src="/javascript/displaycontrol.js"></script>
  <link rel="stylesheet" href="/css/stylesheet.css">
  <img src="/picture/logo.jpg">
</head>

<body style="background-color:rgb(198, 115, 104);">
  <form action="result.php" method="post">

    Supplier:<br>
    <select id="supplier" name="Supplier">
      <option value="">--- Select Supplier ---</option>
      <?php
      $sql = "SELECT * from BP b  where b.BPCode  like 'S%' or b.BPCode  like 'F%' Order by b.BPName";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row["BPCode"]}'>{$row['BPName']}</option>";
      }
      ?>
    </select> <br><br>

    Item Group:<br>
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

    Product:<br>
    <select id="product" name="Product">
      <option value="">--- Select Product ---</option>
    </select><br><br>

    <!-- new features to be developed:
    display product information once selected.
    -->

    Product Unit Purchase Price/ MT:<br>
    <input type="number" min="0.00" step="any" name="Product_Price"><br><br>

    Purchase Currency:<br>
    <select id="currency" name="Currency">
      <option value="AUD">AUD</option>
      <option value="USD">USD</option>
      <option value="EUR">EUR</option>
      <option value="GBP">GBP</option>
    </select><br><br>

    <div id="fxcontrol" style="display: none;">
    Exchange Rate:<br> 
    <input type="number" min="0.00" step="0.01" name="FX_Rate" value="1.00"><br><br></div>

    Total Contract Quantity:<br> 
    <input type="number" min="0.00" step="any" name="Quantity"> (MT)<br><br> 

    Duty:<br>
    <select id="duty" name="Duty">
      <option value="0">0%</option>
      <option value="4">4%</option>
      <option value="5">5%</option>
    </select><br><br>

    Product Handling Type:<br>
    <select id="handlingtype" name="Handling_Type">
      <option value="Ambient">Ambient</option>
      <option value="Chilled">Chilled</option>
      <option value="Frozen">Frozen</option>
    </select><br><br>

    <!-- Estimated Pallets Amount:<br> 
    <input type="number" name="Pallets" value = 20> (Pallets)<br><br> -->

    Supplier Term:<br>
    <select id="supplierterm" name="Supplier_Term">
      <option value="FOB">FOB</option>
      <option value="CNF/CIF">CNF/CIF</option>
    </select><br><br>

    <!-- Hide departure port when supplier term is CNF/CIF -->
    <div id="seafreightcontrol">
    Departure Port: <br>
    (Please choose Others if the departure port is not in the list or you need to use a manual rate)<br> 
    <select id="dport" name="Departure_Port">
      <option value="">--- Select Departure Port ---</option>
      <?php
      $sql = "SELECT distinct PortofLoading, Country from SeaFreight";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row["PortofLoading"]}'>{$row['PortofLoading']}.{$row['Country']}</option>";
      }
      ?>
      <option value="Others">Others</option>
    </select> <br><br>

    Please Enter Sea Freight Quote If You Chose Others: <br>
    <input type="number" value="0" min="0.00" step="any" name="spotrate">
    <br><br></div>

    <!-- Container Type:<br>
    <select id="containertype" name="Container_Type">
      <option value="20 DC">20' DC</option>
      <option value="40 DC">40' DC</option>
      <option value="20 RF">20' RF</option>
      <option value="40 RF">40' RF</option>
    </select><br><br> -->

    Container Size: <br>
    <input type="radio" name="Container_Size" value="20">20 ft &nbsp&nbsp&nbsp
    <input type="radio" name="Container_Size" value="40">40 ft
    <br><br>

    Customer:<br>
    <select id="customer" name="Customer">
      <option value="">--- Select Customer ---</option>
      <?php
      $sql = "SELECT * from BP b  where b.BPCode  like 'C%' Order by b.BPName";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row["BPCode"]}'>{$row['BPName']}</option>";
      }
      ?>
    </select><br><br>

    Delivery From:<br>
    <select id="shippingfrom" name="Shipping_From">
      <option value="Our Warehouse">Our Warehouse</option>
      <option value="Direct FCL">Direct FCL</option>
    </select><br><br>

    <!-- new features to be developed:
    inter-state transport.
    -->

    <!-- Hide storage period when the shipping from id direct FCL -->
    <div id="storagecontrol">
    Product Storage Period: <br>
    <input type="number" name="Storage" value = 0> (Weeks)<br>
    </div>

    <br>
    Margin: <br>
    <input type="number" min="0" step="0.1" name="Margin">&nbsp%<br><br>

    <br><br><br>
    <input type="submit" value="Calculate" id="calculate">
  </form>
</body>

</html>

