# Amazon AWS s3 Music Player

This is a quick and dirty script that I wrote to replace my need for Grooveshark now that it is dead. S3 costs .03 per gigabyte per month which means that 25000 songs stored there cost around $3.75 per month. And they will be there for the next decade. Yes we could add a lot of features and make this a full blown application written with a proper framework, but I don't have the money to fund that right now... maybe kickstart that thing later.


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
