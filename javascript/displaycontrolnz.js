$(document).ready(function(){
    $('#shippingfrom').change(
        function () {
            var shippingfrom = $('option:selected', this).text();
            if (shippingfrom == "Our Warehouse") {
                $('#storagecontrol').css("display","block");
            } else if (shippingfrom == "Direct FCL") {
                $('#storagecontrol').css("display","none");
            }
        });
 });  

 $(document).ready(function(){
    $('#currency').change(
        function () {
            var currency = $('option:selected', this).text();
            if (currency == "NZD") {
                $('#fxcontrol').css("display","none");
            } else $('#fxcontrol').css("display","block");
            
        });
 });