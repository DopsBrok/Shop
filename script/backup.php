<?php
require __DIR__.'/../config.php';
$file=__DIR__.'/../backups/shop_'.date('Ymd_His').'.sql.gz';
$cmd="mysqldump -h".DB_HOST." -u".DB_USER." -p".DB_PASS.
      " " . DB_NAME . " | gzip > " . escapeshellarg($file);
system($cmd,$ret);
if($ret===0) echo "Backup created: $file";
else echo "Backup failed";
?>