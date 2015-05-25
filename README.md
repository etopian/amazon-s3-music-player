# amazon-s3-music-player

![Screenshot](https://raw.githubusercontent.com/etopian/amazon-s3-music-player/master/s3-music-player.png)

Drop this on a server that supports PHP 5.3+. Edit the file and set the variables at the very top:

```
$settings['AWS_KEY']="";
$settings['AWS_SECRET']="";
$settings['PASSWORD']="";
$settings['BUCKET']="";
```

Your bucket does not have to be public, in fact it is best if it stays private. This little script will generate secure URLs for your songs. Once you are done you can access it at:
```
http://mysite.com/index.php?pass={PASSWORD}
```

Using the password that you set above. This is mainly to not expose all your copyrighted music to the internet and get sued.
