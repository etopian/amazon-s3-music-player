# Amazon AWS S3 Music Player MisterDJ.org
-----

This is small database less application written in Slim 3 to replace Grooveshark now that it is dead. S3 costs .03 per gigabyte per month which means that 25000 songs stored there cost around $3.75 per month. And they will be there for the next decade. Yes we could add a lot of features and make this a full blown application written with a proper framework, but I don't have the money to fund that right now... maybe kickstart that thing later.

But here is what you need, you need a bucket with your music... As it stands it will dump all the content on a single page... So a few thousand thousand songs is fine (at least 4,000 is fine), tens of thousands might not be...

![Screenshot](https://raw.githubusercontent.com/etopian/amazon-s3-music-player/master/music.png)

## Features
- Playlist - Designed to play music uniterrupted.
- Responsive - Works with devices of all shapes and sizes
- Search - Search your list of music
- Play random tracks - Play random tracks from all your tracks, or from the search. Auto-playlist.
- Play history


## TODO
- Save the state of the player so it's the same when you return, either using a db or local cache.
- Use an audio library to allow fading out.
- Allow playlist to be reordered on mobile either using drag and drop or using arrows
- Some sort of IDv3 parsing. Right now it simply reads the file names and cleans them a bit. It's possible to use a javascript idv3 library, but special permissions have to be set via Amazon on each file object to allow this to work.

Drop this on a server that supports PHP 5.3+. 

Rename settings.example.json to settings.json and fill the keys.

If you have no APCU cache installed set APCU_CACHE to false. Password is the http password.

```
{
  "AWS_KEY": "",
  "AWS_SECRET": "",
  "PASSWORD": "",
  "BUCKET": "",
  "APCU_CACHE": true
}
```

Your bucket does not have to be public, in fact it is best if it stays private. This little script will generate secure URLs for your songs. Once you are done you can access it at:
```
http://mysite.com/index.php?pass={PASSWORD}
```

Using the password that you set above. This is mainly to not expose all your copyrighted music to the internet and get sued.
