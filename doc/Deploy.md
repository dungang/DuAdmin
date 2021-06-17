# 发布

如果你的 web 服务器是 Apache，你需要增加一个包含如下内容的 .htaccess 文件到你的 web 目录 (或者 public_html 根据实际情况而定，是你的 index.php 文件所在的目录)。

```
Options +FollowSymLinks
IndexIgnore */*

RewriteEngine on

# if a directory or a file exists, use it directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# otherwise forward it to index.php
RewriteRule . index.php
```