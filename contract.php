<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="/picture/icon.png">
    <title>Contract Page</title>
    <link rel="stylesheet" href="/css/contract.css">
</head>
<body>
    <table>
        <tr>
            <td>
                <img src="/picture/logo-trans.png" style="width: 160px; height: 75px;">
            </td>
            <td>
                <h1 style="font-family: 'Courier New', Courier, monospace;">Contract Page</h1>
            </td>
        </tr>
    </table>

    <div class="form-container">
        <form action="result.php" method="post">
            <label for="Product">Product:</label>
            <input type="text" name="Product" value="<?php echo $_POST['Product']; ?>" readonly><br>

            <label for="Product_Price">Product Unit Purchase Price/MT:</label>
            <input type="text" name="Product_Price" value="<?php echo $_POST['Product_Price']; ?>" readonly> <br>

            <label for="Currency">Purchase Currency:</label>
            <input type="text" name="Currency" value="<?php echo $_POST['Currency']; ?>" readonly><br>

            <label for="Quantity">Total Contract Quantity:</label>
            <input type="text" name="Quantity" value="<?php echo $_POST['Quantity']; ?>" readonly> (MT)<br>

            <label for="Container_Size">Container Size:</label>
            <input type="text" name="Container_Size" value="<?php echo $_POST['Container_Size']; ?>" readonly> ft<br>

            <label for="Handling_Type">Product Handling Type:</label>
            <input type="text" name="Handling_Type" value="<?php echo $_POST['Handling_Type']; ?>" readonly><br>

            <label for="Supplier_Term">Supplier Term:</label>
            <input type="text" name="Supplier_Term" value="<?php echo $_POST['Supplier_Term']; ?>" readonly><br>

            <label for="SaleCurrency">Sale Currency:</label>
            <input type="text" name="SaleCurrency" value="<?php echo $_POST['SaleCurrency']; ?>" readonly><br>
        </form>
    </div>

    <button onClick="window.print()">Save as PDF</button>

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
</body>
</html>
