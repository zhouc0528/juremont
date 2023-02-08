<?php      
    include('functions/config.php');  
    $username = $_POST['username'];  
    $password = $_POST['password'];  
    
        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $username = mysqli_real_escape_string($conn, $username);  
        $password = mysqli_real_escape_string($conn, $password);  
      
        $sql = "select * from User where Username = '$username' and Password = '$password'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){  
            echo "Login successful";  
        }  
        else{  
            echo "Invalid username or password";  
        }     
?>  