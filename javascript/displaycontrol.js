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
    $('#supplierterm').change(
        function () {
            var supplierterm = $('option:selected', this).text();
            if (supplierterm == "FOB") {
                $('#seafreightcontrol').css("display","block");
            } else if (supplierterm == "CNF/CIF") {
                $('#seafreightcontrol').css("display","none");
            }
        });
 });  

 $(document).ready(function(){
    $('#currency').change(
        function () {
            var currency = $('option:selected', this).text();
            if (currency == "AUD") {
                $('#fxcontrol').css("display","none");
            } else $('#fxcontrol').css("display","block");
            
        });
 });


$(document).ready(function(){
    $('#supplier').change(
        function () {
        var supplier = $('option:selected', this).text(); 
        if (supplier == "Barry Callebaut Australia Pty Ltd") {
            $('#dutycontrol').css("display","none");
            $('#suppliertermcontrol').css("display","none");
            $('#seafreightcontrol').css("display","none");
        } else {
            $('#dutycontrol').css("display","block");
            $('#suppliertermcontrol').css("display","block");
            $('#seafreightcontrol').css("display","block");
        }
    });
});


