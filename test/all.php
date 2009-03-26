<?php
error_reporting(E_ALL|E_STRICT);
set_include_path(dirname(dirname(__FILE__)).PATH_SEPARATOR.'src'.PATH_SEPARATOR.get_include_path());

require_once 'lime.php';


$h = new lime_harness(new lime_output_color());
$dir = new DirectoryIterator(dirname(__FILE__));
while ($dir->valid()) {
    if ($dir->isFile() && $dir->getFilename() !== 'all.php') {
        $h->register($dir->getPathname());
    }
    $dir->next();
}
$h->run();
