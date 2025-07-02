/*$(".delete-icon").on("click", function (event) {
    $("#confirm-delete").data("href", $(this).data("href"));
});
$(".modal-body .text-center button").on("click", function (event) {
    var $button = $(event.target);
    if ($button[0].id == "confirm-delete") {
        $("#deletemodal").modal("hide");
        $.ajax({
            url: $(this).data("href"),
            type: "DELETE",
            dataType: "JSON",
            data: { _token: $(this).data("token") },
            success: function (data) {
                location.reload();
            },
        });
    }
});*/

function open_deletemodal(url) {
    $("#delete-hidden").val(url);
    $("#deletemodal").modal("show");
}

$(".modal-delete .text-center button").on("click", function (event) {
    var $button = $(event.target);
    var u = $("#delete-hidden").val();
    if ($button[0].id == "confirm-delete") {
        $.ajax({
            url: u,
            type: "DELETE",
            dataType: "JSON",
            data: { _token: $(this).data("token") },
            success: function (data) {},
        });

        // table.ajax.url(url).load();
        $("#deletemodal").modal("hide");
        location.reload();
    } else $("#delete-hidden").val("");
});
