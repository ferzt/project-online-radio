function setEditMode() {
    $("#songSelect").css("width", "calc(100% - 220px)");
}

$("form").submit(function (event) {
    var formData = {
      playlistName: $("#plname").val(),
        public:$("#public").is(":checked"),
        username:userLoggedIn,
    };

    $.ajax({
      type: "POST",
      url: "includes/handlers/create-playlist-handler.php",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {

        let plInfo = data;
        openPage("playlist-edit.php?id=" + plInfo.playlistId + "&userId=" + plInfo.userId + "&mode=edit");
    });

    event.preventDefault();
});

function closeSearch() {
    $("#songSelect").css("width","0"); 
}


