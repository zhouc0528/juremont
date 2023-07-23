function fetchMargin() {
    var selectedGroup = document.getElementById("itemgroup").value;
    if (selectedGroup === "") {
        document.getElementById("marginInput").value = "";
        return;
    }

    $.ajax({
        type: "POST",
        url: "/functions/getmargin.php",
        data: { item_group: selectedGroup },
        success: function (response) {
            document.getElementById("marginInput").value = response;
        },
        error: function (error) {
            console.error("Error fetching margin: " + error);
        }
    });
}
