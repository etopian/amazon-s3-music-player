# Amazon AWS S3 Music Player MisterDJ.org
-----

This is small database less application written in Slim 3 to replace Grooveshark now that it is dead. S3 costs .03 per gigabyte per month which means that 25000 songs stored there cost around $3.75 per month. And they will be there for the next decade. Yes we could add a lot of features and make this a full blown application written with a proper framework, but I don't have the money to fund that right now... maybe kickstart that thing later.

But here is what you need, you need a bucket with your music... As it stands it will dump all the content on a single page... So up to a thousand songs is fine, a few thousand might not be...

![Screenshot](https://raw.githubusercontent.com/etopian/amazon-s3-music-player/master/s3-music-player.png)

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
