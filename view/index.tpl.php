<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="<?= $base_url; ?>assets/base.css">

    <script src="<?= $base_url; ?>assets/jquery.min.js"></script>
    <script src="<?= $base_url; ?>assets/jquery-ui.min.js"></script>
    <script src="<?= $base_url; ?>assets/script.js"></script>

    <script src="<?= $base_url; ?>assets/jsmediatags.min.js"></script>
    <script src="<?= $base_url; ?>assets/vue.min.js"></script>    
    <link rel="stylesheet" href="<?= $base_url; ?>assets/style.css">
    <script type="text/javascript">
        var password = "<?= $password ?>";
        
        $(document).ready(function(){

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
                        var random_item_idx = Math.floor( (Math.random() * this.files.length) + 1 );
                        console.log(random_item_idx);
                        var file = this.files.splice( random_item_idx, 1 );
                        this.play(file[0]);
                    },                    
                    play_next_track: function(){
                        var file = this.playlist.shift();
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

                            /****************/
                            audio[0].pause();
                            audio[0].load();//suspends and restores all audio element
                            audio[0].play();

                            $('#audio-info').text(short_title);
                            $(audio[0]).unbind();


                            audio[0].onended = function () {
                                self.play_next_track();
                            };


                        }else{
                            self.add_to_playlist(file);
                        }                    
                    
                  },
                    
                  play: function(file){
                      key = file.key;
                      console.log(key);
                      var self = this; // create a closure to access component in the callback below
                      $.getJSON('/url?key=' + key + '&pass=' + password, function(url) {
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
                  $.getJSON('/load?pass=' + password, function(data) {
                      self.files = data;
                      //console.log(self.files);                  
                  }); 
                }
            });

        });

        
    </script>
</head>

<body>
<div id="main-container">
        
        <div id="nav">
            <div id="sidebar-fixed">
                <div id="player-container">
                    <div id="audio-info">
                        Please select a track to play. {{mytext}}
                    </div>

                    <audio id="player" controls>
                        <source id="mp3_src" src="" type="audio/mpeg">
                    </audio>
                    <div id="skip-btn" v-if="playlist.length == 0"><a v-on:click="play_random_track()" id="skip-link">Play Random Track</a></div>
                    <div id="skip-btn" v-if="playlist.length > 0"><a v-on:click="play_next_track()" id="skip-link">Play Next Track</a></div>
                </div>


                <div id="playlist">
                    <h3>Playlist</h3>
                    <ul id="items">
                        <li v-if="playlist.length == 0" id="empty-item">No items in the playlist.</li>
                        <li v-for="file in playlist">
                            <a class="audio-file" >{{file.title}}</a>
                        </li>                                
                    </ul>
                </div>
                <div id="playlist-history">
                    <h3>Playlist History</h3>
                    <ul id="history-items">
                        <li v-if="history.length == 0" id="empty-item">No items in your playlist history.</li>
                        <li v-for="file in history">
                            <a v-on:click="play(file)" class="audio-file" target="_blank">{{file.title}}</a>
                        </li>                             
                    </ul>
                </div>
            </div>

        </div>

    <div id="main" >
        <form id="search-form">
        <input v-model="search" class="search" placeholder="Search" />
        </form>
        <ul id="files" class="list">
            <li v-for="file in filteredFiles">
                <a v-on:click="play(file)" class="audio-file" target="_blank">{{file.title}}</a>
            </li>            
            

        </ul>
    </div>
</div>




</body>
</html>