$(window).on("load",function(){

    $("#attack").on("click",function(){
        $("#attack").css("background-color","#888");
        var textAreaValue = "";
        for (var i=1; i < $(".bind").length + 1; ++i) {
            var selecter = "#s" + String(i);
            textAreaValue += $(selecter).val(); 
        }
        var data = JSON.stringify({html:textAreaValue});
        $.ajax({
            type: "POST",
            url:  "forceajax.php",
            data: data,
            success: function(jsonData){
               var responce = JSON.parse(JSON.stringify(jsonData));
               console.log(responce); 
               $("#attack").css("background-color","#fff");
            }
        });
    });

    $("#steal").on("click",function(){
        var textAreaValue = $("#u1").val(); 
        var data = JSON.stringify({html:'<!-- '+textAreaValue+' -->'});
        $.ajax({
            type: "POST",
            url:  "seurlnavajax.php",
            data: data,
            success: function(jsonData){
                var responce = JSON.parse(JSON.stringify(jsonData));
                for (var i=0; i < responce.length; ++i) {
                    var navUrl = "<a class=\"nu\" href="+responce[i]+" target=\"_blank\">"+responce[i]+"</a>\n";
                    $("#senu").append(navUrl);
                }
            }
        });
    });
});
