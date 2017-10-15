<!DOCTYPE html>
<html>
<head>
    <title>Music Player</title>
    <link rel="stylesheet" href="<?= $base_url; ?>assets/base.css">
    <script src="<?= $base_url; ?>assets/jquery.min.js"></script>
    <script src="<?= $base_url; ?>assets/jquery-ui.min.js"></script>
    <script src="<?= $base_url; ?>assets/jsmediatags.min.js"></script>
    <script src="<?= $base_url; ?>assets/vue.min.js"></script>
    <script src="<?= $base_url; ?>assets/Sortable.min.js"></script>
 
    <script src="<?= $base_url; ?>assets/vuedraggable.min.js"></script>
 
    <script src="<?= $base_url; ?>assets/script.js"></script>    
    <script src="<?= $base_url; ?>assets/howler.min.js"></script>        
    <link rel="stylesheet" href="<?= $base_url; ?>assets/style.css">


    <script type="text/javascript">
        var password = "<?= $password ?>";
        var baseurl = "<?= $base_url; ?>";
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
                        <draggable v-model="playlist" :options="{draggable:'.playlist-item'}">
                            <li v-for="(file,index) in playlist" class="playlist-item">
                                <a class="playlist-audio-file" >{{file.title}}</a><a v-on:click="remove_playlist(index)" class="remove">(x)</a>
                            </li>
                        </draggable>
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
        <div class="loader" v-if="files.length == 0">Loading</div>
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
