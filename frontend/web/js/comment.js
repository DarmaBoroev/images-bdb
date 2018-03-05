$("document").ready(function(){ 
        $("#new_comment").on("pjax:end", function() {
            $.pjax.reload({container:"#comments"});
            document.getElementById("commentform-text").value = "";
        });
});