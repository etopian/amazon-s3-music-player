$(window).on('beforeunload', function () {
        return 'Are you sure you want to leave? Music will stop playing if you do that.';
});


function save_playlist(){
    
}

function save_history(){

}






$(document).ready(function(){




    $( "#items" ).on( "click",".remove", function() {
        $(this).parent().remove();
        playlist_check_empty();
        return false;
    });


});
