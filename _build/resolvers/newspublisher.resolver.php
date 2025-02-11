<?php
/**
 * Resolver for NewsPublisher extra
 *
 * Copyright 2013-2025 Bob Ray <https://bobsguides.com>
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

$languages = array('en', 'fr', 'it', 'de', 'ru');

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
        } else {
            $modx->log(modX::LOG_LEVEL_INFO,
                'Set np_login_id System Setting');
        }


        /* Create lexicon entries for allow_modx_tags description */

        /** @var array $_lang */
        foreach ($languages as $language) {
            $file = MODX_CORE_PATH . 'components/newspublisher/lexicon/' . $language . '/' . 'permissions.inc.php';
            /* Next line has to be inside the loop */
            include($file);

            $value = $_lang['np_allow_modx_tags_desc'];

            $fields = array(
                'name' => 'np_allow_modx_tags_desc',
                'language' => $language,
            );
            $entry = $modx->getObject($prefix . 'modLexiconEntry', $fields);

            if (!$entry) {
                $entry = $modx->newObject('modLexiconEntry');
                $entry->set('name', 'np_allow_modx_tags_desc');
                $entry->set('language', $language);
                $entry->set('topic', 'permissions');
                $entry->set('namespace', 'core');
                $entry->set('value', $value);
                if ($entry->save()) {
                    $modx->log(modX::LOG_LEVEL_INFO, 'Set ' . $language .
                        ' lexicon strings for allow_modx_tags setting');
                } else {
                    $modx->log(modX::LOG_LEVEL_INFO, 'Could not set lexicon strings for allow_modx_tags setting');
                }
            }
        }
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        /* Remove lexicon entries for allow_modx_tags description */

        $modx->log(modX::LOG_LEVEL_INFO, "Attempting to remove Lexicon entries");

        foreach($languages as $language) {
            $fields = array(
                'name' => 'np_allow_modx_tags_desc',
                'language' => $language,
            );
            $entry = $modx->getObject($prefix . 'modLexiconEntry', $fields);

            if ($entry) {
                if ($entry->remove()) {
                    $modx->log(modX::LOG_LEVEL_INFO, 'Removed ' . $language .
                        ' lexicon strings for allow_modx_tags setting');
                } else {
                    $modx->log(modX::LOG_LEVEL_INFO, 'Could not remove ' .
                        $language . ' lexicon string for allow_modx_tags setting');
                }
            }
        }

        break;
}
return true;
