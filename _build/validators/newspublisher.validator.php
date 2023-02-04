<?php
/**
 * Validator for NewsPublisher extra
 *
 * Copyright 2013-2022 Bob Ray <https://bobsguides.com>
 * Created on 02-03-2023
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
/** @var modTransportPackage $transport */


if ($transport) {
    $modx =& $transport->xpdo;
} else {
    $modx =& $object->xpdo;
}

$prefix = $modx->getVersionData()['version'] >= 3
    ? 'MODX\Revolution\\'
    : '';

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        /* Create NewPublisher page if necessary */
        /** @var modResource $npPage */
        $npPage = $modx->getObject($prefix . 'modResource',
            array('alias' => 'newspublisher'));

        if (empty($npPage)) {
            /* Create NP page */
            $modx->log(modX::LOG_LEVEL_INFO, 'Attempting to create NewsPublisher Resource');

$npPageContent = <<<EOT
[[!NewsPublisher?
    &show=`pagetitle,longtitle,published,hidemenu,content`
]]
EOT;

            $npPage = $modx->newObject($prefix . 'modResource');
            $fields = array(
                'pagetitle' => 'NewsPublisher',
                'alias' => 'newspublisher',
                'longtitle', 'NewsPublisher',
                'content' => $npPageContent,
                'description' => 'NewsPublisher Form',
                'published' => '1',
                'template' => $modx->getOption('default_template', null),
            );

            if ($npPage) {
                $npPage->fromArray($fields, '', true, true);
                if ($npPage->save()) {
                    $modx->log(modX::LOG_LEVEL_INFO, 'Created NewsPublisher page');
                } else {
                    $modx->log(modX::LOG_LEVEL_ERROR, '
                    Could not Save NewsPublisher page');
                }
            }
        }
        break;
    case xPDOTransport::ACTION_UPGRADE:
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return true;