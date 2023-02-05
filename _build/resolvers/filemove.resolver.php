<?php
/**
 * NewsPublisher filemove resolver script
 * Copyright 2013-2023 Bob Ray <https://bobsguides.com>
 *
 * @package newspublisher
 */

/* @var $modx modX */
/* @var $policy modAccessPolicy */
/* @var $options array */
/* @var $object array */
/* @var $template modAccessPolicyTemplate */

/** @var $transport modTransportPackage */

if ($transport) {
    $modx =& $transport->xpdo;
} else {
    $modx =& $object->xpdo;
}
$modx->log(modX::LOG_LEVEL_INFO, 'Running filemove resolver');
$success = true;

if (!function_exists("rrmdir")) {
    function rrmdir($dir) {
        if (is_dir($dir)) {
             $objects = scandir($dir);
             foreach ($objects as $object) {
               if ($object != "." && $object != "..") {
                 if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
               }
             }
             reset($objects);
             rmdir($dir);
        }
    }
}
switch($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        break;

    case xPDOTransport::ACTION_UPGRADE:
        $dir = MODX_CORE_PATH . 'components/newspublisher/classes';
        if (is_dir($dir)) {
            $modx->log(xPDO::LOG_LEVEL_INFO,'Removing obsolete class files');
            rrmdir($dir);
        }
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return $success;
