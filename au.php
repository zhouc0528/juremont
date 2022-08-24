<?php
require_once('config.php');
?>

<!DOCTYPE HTML>
<html>

<head>
  <link rel="icon" href="/picture/icon.png">
  <title>Cost of Product Calculation - AU</title>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="/javascript/productcascading.js"></script>
  <script type="text/javascript" src="/javascript/displaycontrol.js"></script>
  <link rel="stylesheet" href="/css/au.css">
  <table>
    <tr>
      <td>
        <img src="/picture/logo-trans.png" style="width: 160px; height:75px;">
      </td>
      <td>
        <h1 style="font-family: 'Courier New', Courier, monospace;">
          &nbsp;&nbsp;
          Cost Calculator (Australia)
        </h1>
      </td>
    </tr>
  </table>
</head>

<body>
  <form action="result.php" method="post">

    <label>Supplier:</label>
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

    <!-- new features to be developed:
    display product information once selected.
    -->

    <label>Product Unit Purchase Price/ MT:</label>
    <input type="number" min="0.00" step="any" name="Product_Price"><br><br>

    <label>Purchase Currency:</label>
    <select id="currency" name="Currency">
      <option value="AUD">AUD</option>
      <option value="USD">USD</option>
      <option value="EUR">EUR</option>
      <option value="GBP">GBP</option>
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
    <input type="radio" name="Handling_Type" value="Chilled">Chilled &nbsp&nbsp&nbsp
    <input type="radio" name="Handling_Type" value="Frozen">Frozen
    <br><br>

<!--     <label>Product Handling Type:</label>
    <select id="handlingtype" name="Handling_Type">
      <option value="Ambient">Ambient</option>
      <option value="Chilled">Chilled</option>
      <option value="Frozen">Frozen</option>
    </select><br><br> -->

    <!-- Estimated Pallets Amount:<br> 
    <input type="number" name="Pallets" value = 20> (Pallets)<br><br> -->

    <label>Supplier Term:</label>
    <select id="supplierterm" name="Supplier_Term">
      <option value="FOB">FOB</option>
      <option value="CNF/CIF">CNF/CIF</option>
    </select><br><br>

    <!-- Hide departure port when supplier term is CNF/CIF -->
    <div id="seafreightcontrol">
      <label>Departure Port: </label>

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
      </select> <br>
      (Please choose Others if the departure port is not in the list or you need to use a manual rate)<br><br>

      <label>Sea Freight Spotrate:</label>
      <input id="spotrate" type="number" value="0" min="0.00" step="any" name="spotrate">
      <br>(Please Enter Sea Freight Quote <strong><em>ONLY</em></strong> When You Chose Others) <br><br>
    </div>

    <!-- Container Type:<br>
    <select id="containertype" name="Container_Type">
      <option value="20 DC">20' DC</option>
      <option value="40 DC">40' DC</option>
      <option value="20 RF">20' RF</option>
      <option value="40 RF">40' RF</option>
    </select><br><br> -->

    <label>Customer:</label>
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

    <label>Sale Currency:</label>
    <select id="salecurrency" name="SaleCurrency">
      <option value="AUD">AUD</option>
      <option value="USD">USD</option>
      <option value="EUR">EUR</option>
      <option value="GBP">GBP</option>
    </select><br><br>

    <label>Delivery From:</label>
    <select id="shippingfrom" name="Shipping_From">
      <option value="Our Warehouse">Our Warehouse</option>
      <option value="Direct FCL">Direct FCL</option>
    </select><br><br>

    <!-- new features to be developed:
    inter-state transport.
    -->

    <!-- Hide storage period when the shipping from id direct FCL -->
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