<?php @chdir('/public_html/organicfoodfanatics.com/cronjobs/'); ?>
<?php include_once 'cronjobs.php'; ?>
<?php

// /usr/bin/GET http://organicfoodfanatics.com/cronjobs/cache.php >/dev/null 2>&1

$cdir = scandir(BASE_DIR . 'cache');
foreach ($cdir as $key => $_cached_file_name) {
    if (!in_array($_cached_file_name, array(".", ".."))) {
        if (!is_dir($dir . DS . $_cached_file_name)) {

            if (file_exists(BASE_DIR . 'cache/' . $_cached_file_name)) {

                if (filemtime(BASE_DIR . 'cache/' . $_cached_file_name) < (time() - CACHING_EXPIRATION_TIME)) {
                    unlink(BASE_DIR . 'cache/' . $_cached_file_name);
                }
            }
        }
    }
}
?>