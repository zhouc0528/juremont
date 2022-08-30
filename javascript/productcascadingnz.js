$(document).ready(function() {
    $("#itemgroup").on("change", function() {
      var ItmsGrpCod = $(this).val();
      if (ItmsGrpCod) {
        $.ajax({
          url: "/functions/productcascadingnz.php",
          type: "POST",
          cache: false,
          data: {
            ItmsGrpCod: ItmsGrpCod
          },
          success: function(data) {
            $("#product").html(data);
          }
        });
      } else {
        $('#product').html('<option value="">--- Select Item Group First ---</option>');
      }
    });
  });
