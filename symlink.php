<?php
	
$targetFolder = __DIR__.'/../absen/storage/app/public';
$linkFolder = __DIR__.'/storage';
symlink($targetFolder,$linkFolder);


echo 'success'
?>