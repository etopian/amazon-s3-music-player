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
                <div id="audio-info">

                </div>

                <audio id="player" controls>

                    <source id="mp3_src" src="" type="audio/mpeg">

                </audio>

                <div id="playlist">
                    <h3>Playlist</h3>
                    <ul id="items">
                    </ul>
                </div>
                <div id="playlist-history">
                    <h3>Playlist History</h3>
                    <ul id="history-items">
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