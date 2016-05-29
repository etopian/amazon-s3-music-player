function add_to_playlist_history(url, title){
    var currentdate = new Date();
    var time = currentdate.getHours() +':'+ currentdate.getMinutes() +':'+ currentdate.getSeconds() ;
    short_title = time + ' ' + title.split('\/').pop().replace('.mp3', '').substr(0, 30) + '...';
    $('ul#history-items').prepend('<li><a title="' + title + '" href="' + url + '">' + short_title + '</a></li>');

}

function change(li_element, url, title) {
    var audio = $("#player");

    if($("#mp3_src").attr("src").length == 0 || audio[0].ended) {
        //find a random item from the files and play that
        if (typeof url == 'undefined'){
            var random_item = Math.floor( (Math.random() * $('#files li').length) + 1 );

            url = $( "ul#files li:nth-child(" + random_item + ") a" ).attr('href');
            title = $( "ul#files li:nth-child(" + random_item + ") a" ).text();
        }

        add_to_playlist_history(url, title);

        short_title = title.split('\/').pop().replace('.mp3', '');
        $("#mp3_src").attr("src", url);

        /****************/
        audio[0].pause();
        audio[0].load();//suspends and restores all audio element
        audio[0].play();



        $('#audio-info').text(short_title);
        $(audio[0]).unbind();


        audio[0].onended = function () {
            var li_item = $('#playlist ul li').first();
            var new_url =   $('#playlist ul li a').first().attr('href');
            var new_title = $('#playlist ul li a').first().text();
            change(li_item, new_url, new_title);
        };
    }else{
        short_title = title.split('\/').pop().replace('.mp3', '');
        $('#playlist ul').append('<li><a title="' + title + '" href="' + url + '">' + short_title + '</a> <a class="remove">(x)</a></li>');
    }
}




$(document).ready(function(){
    $('.audio-file').click(function(){
        var url = $(this).attr('href');
        var title = $(this).text();
        var li_element = $(this).parent();
        change(li_element, url, title);
        return false;
    });

    var options = {
        valueNames: ['audio-file']
    };

    var hackerList = new List('main', options);

    $( "#playlist ul" ).sortable();
    $( "#playlist ul" ).disableSelection();

    $( ".list, #playlist ul" ).sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();

});
