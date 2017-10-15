$(window).on('beforeunload', function () {
        return 'Are you sure you want to leave? Music will stop playing if you do that.';
});



$(document).ready(function(){

    $( "#items" ).on( "click",".remove", function() {
        $(this).parent().remove();
        playlist_check_empty();
        return false;
    });
    
 

    var mainapp = new Vue({
        el: '#main-container',
        data: {
          seen: true,
          mytext: "Text",
          files: [],
          playlist: [],
          history: [],
          search: ''
        },
        methods: {
            play_random_track: function(){
                //find random track to play
                var random_item_idx = Math.floor( (Math.random() * this.filteredFiles.length) + 1 );
                console.log(random_item_idx);
                var file = this.filteredFiles.splice( random_item_idx, 1 )[0];
                this.play(file);
            },
            remove_playlist: function(index){
                this.playlist.splice( index, 1 )[0];
            },
            play_next_track: function(){
                var file = this.playlist.shift();
                if(typeof file == 'undefined'){
                    this.play_random_track();
                }
                console.log(file);
                $("#mp3_src").attr("src", "");
                this.play(file);

            },
            add_to_playlist(file) {
                this.playlist.push(file);
            },
            add_to_playlist_history(file) {
                this.history.unshift(file);
            },                    
            change: function(url, file){
                var audio =    $("#player");
                var title = file.title;
                var self = this;
                if($("#mp3_src").attr("src").length === 0 || audio[0].ended ) {
                    
                   

                    this.add_to_playlist_history(file);

                    short_title = title.split('\/').pop().replace('.mp3', '');
                    $("#mp3_src").attr("src", url);
                    window.document.title = title;
                    //(function titleScroller(text) {
                    //    document.title = text;
                    //    console.log(text);
                    //    setTimeout(function () {
                    //        titleScroller(text.substr(1) + text.substr(0, 1));
                    //    }, 200);
                    //}(title));                       

                    /****************/
                    audio[0].pause();
                    audio[0].load();//suspends and restores all audio element
                    audio[0].play();

                    $('#audio-info').text(short_title);
                    $(audio[0]).unbind();


                    audio[0].onended = function () {
                        self.play_next_track();
                        window.document.title = "";

                    };


                }else{
                    self.add_to_playlist(file);
                }                    

          },

          play: function(file){
              key = file.key;
              console.log(key);
              var self = this; // create a closure to access component in the callback below
              $.getJSON(baseurl + 'url?key=' + key + '&pass=' + password, function(url) {
                  //self.files = data;
                  console.log(url);
                  self.change(url, file);
              //console.log(self.files);                  
              });      
          }  
        },
        computed: {
          filteredFiles() {
            return this.files.filter(item => {
               return item.title.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            });
          }
        },          

        mounted:  function () {

          var self = this; // create a closure to access component in the callback below
          $.getJSON( baseurl + 'load?pass=' + password, function(data) {
              self.files = data;
              //console.log(self.files);                  
          }); 
        }
    });

});
