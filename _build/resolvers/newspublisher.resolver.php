<?php
/**
 * Resolver for NewsPublisher extra
 *
 * Copyright 2013-2022 Bob Ray <https://bobsguides.com>
 * Created on 02-25-2017
 *
 * NewsPublisher is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * NewsPublisher is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * NewsPublisher; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 * @package newspublisher
 * @subpackage build
 */

/* @var $object xPDOObject */
/* @var $modx modX */

/* @var array $options */

/** @var $transport modTransportPackage */

if ($transport) {
    $modx =& $transport->xpdo;
} else {
    $modx =& $object->xpdo;
}
$modx->log(modX::LOG_LEVEL_INFO, 'Running newspublisher resolver');
$prefix = $modx->getVersionData()['version'] >= 3
    ? 'MODX\Revolution\\'
    : '';

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    /** @noinspection PhpMissingBreakStatementInspection */
    case xPDOTransport::ACTION_UPGRADE:
        $cp = MODX_CORE_PATH;
        $files = array(
            $cp . 'components/newspublisher/controllers/filebrowser.class.php',
            $cp . 'components/newspublisher/filebrowser.class.php',
            $cp . 'components/newspublisher/templates/filebrowser-2.2.tpl',
            $cp . 'components/newspublisher/templates/filebrowser.tpl',
        );
        foreach ($files as $file) {
            @unlink($file);
        }
    /* Intentional fallthrough */
    case xPDOTransport::ACTION_INSTALL:

        /* Try to set np_login_id System Setting if it's empty */
        $modx->log(modX::LOG_LEVEL_INFO,
            'Attempting to set np_login_id System Setting');
        $success = true;

        $loginPage = $modx->getObject($prefix . 'modResource', array('alias' => 'login'));
        if (!$loginPage) {
            $loginPage = $modx->getObject($prefix . 'modResource', array('pagetitle' => "Login"));
        }
        /* Create login page if there isn't one */
        if (!$loginPage) {
            $loginPage = $modx->newObject($prefix . 'modResource');
            if ($loginPage) {
                $loginPage->set('pagetitle', 'Login');
                $loginPage->set('longtitle', 'Login');
                $loginPage->setContent('[[!Login]]');
                $loginPage->set('published', true);
                if ($loginPage->save()) {
                    $modx->log(modX::LOG_LEVEL_INFO, 'Created Login Page');

                    $setting = $modx->getObject($prefix . 'modSystemSetting', array('key' => 'np_login_id'));
                    if ($setting) {
                        $val = $setting->get('value');

                        $setting->set('value', $loginPage->get('id'));
                        if ($setting->save()) {
                            $modx->log(modX::LOG_LEVEL_INFO, 'Set np_login_id System Setting to ID of login page');
                        } else {
                            $success = false;
                            $modx->log(modX::LOG_LEVEL_INFO, 'Could not create Login Page');
                        }
                    } else {
                        $success = false;
                        $modx->log(modX::LOG_LEVEL_INFO, 'Could not find np_login_id SystemSetting');
                    }
                } else {
                    $success = false;
                    $modx->log(modX::LOG_LEVEL_INFO, 'Could not create Login Page');
                }
            }
        }
        if (!$success) {

            $modx->log(modX::LOG_LEVEL_ERROR,
                'Could not set np_login_id System Settings; Set it manually to the ID of the Login page');
        }

        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}
return true;