function sendReqApproval(elem){
    let locInParent = $(elem).parent().parent().parent().index();
    let currentTime = new Date();
    let timer = currentTime.toJSON();
    $.post("includes/handlers/ajax/sendReqApprovalJson.php",{songId:searchResult[locInParent]["songID"], userName:userLoggedIn, timer:timer}, 
           function(data){
            $(elem).text("REQUESTED");
            $(elem).css("background-color", "transparent");      
    });
}