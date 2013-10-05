<?php
$version='v4_65_0_r179';
$frameworkName='mkframework_'.$version;
$zipName=$frameworkName.'.zip';

print 'http://mkdevs.com/data/down/'.$frameworkName;
$zip=file_get_contents('http://mkdevs.com/data/down/'.$frameworkName);

file_put_contents('mkframework.zip',$zip);


$zip = new ZipArchive;
if ($zip->open('mkframework.zip') === TRUE) {
    $zip->extractTo('vendor/');
    $zip->close();
    
    rename('vendor/'.$frameworkName,'vendor/mkframework');
    
    echo 'ok';
} else {
    echo 'failed';
}

