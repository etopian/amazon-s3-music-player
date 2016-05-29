<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="//codeorigin.jquery.com/jquery-wp-content/themes/jquery/css/base.css?v=1">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="/assets/script.js"></script>
    <script src="/assets/list.min.js"></script>
    <script src="/assets/jsmediatags.min.js"></script>
    <link rel="stylesheet" href="/assets/style.css">

</head>
<body>
<div id="main-container">

        <div id="nav">
            <div id="sidebar-fixed">
                <div id="player-container">
                    <div id="audio-info">
                        Please select a track to play.
                    </div>

                    <audio id="player" controls>
                        <source id="mp3_src" src="" type="audio/mpeg">
                    </audio>
                    <div id="skip-btn"><a href="#" id="skip-link">Play Random Track</a></div>

                </div>


                <div id="playlist">
                    <h3>Playlist</h3>
                    <ul id="items">
                        <li id="empty-item">No items in the playlist.</li>
                    </ul>
                </div>
                <div id="playlist-history">
                    <h3>Playlist History</h3>
                    <ul id="history-items">
                        <li id="empty-item">No items in your playlist history.</li>
                    </ul>
                </div>
            </div>

        </div>

    <div id="main" >
        <form id="search-form">
        <input class="search" placeholder="Search" />
        </form>
        <ul id="files" class="list">
            <?php foreach($urls as $key => $url): ?>
            <li >
                <a class="audio-file" target="_blank" href="<?= $url?>">
                    <?= $key ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>




</body>
</html>