<?php
/**
 * Category resolver  for NewsPublisher extra.
 * Sets Category Parent
 *
 * Copyright 2013-2022 Bob Ray <https://bobsguides.com>
 * Created on 02-06-2017
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
/* @var $parentObj modResource */
/* @var $templateObj modTemplate */

/* @var array $options */

if (!function_exists('checkFields')) {
    function checkFields($modx, $required, $objectFields) {
        $fields = explode(',', $required);
        foreach ($fields as $field) {
            if (!isset($objectFields[$field])) {
                $modx->log(modX::LOG_LEVEL_ERROR, '[Category Resolver] Missing field: ' . $field);
                return false;
            }
        }
        return true;
    }
}

/** @var $transport modTransportPackage */

if ($transport) {
    $modx =& $transport->xpdo;
} else {
    $modx =& $object->xpdo;
}

$classPrefix = $modx->getVersionData()['version'] >= 3
        ? 'MODX\Revolution\\'
        : '';


switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        $intersects = array (
                'NewsPublisher' =>  array (
                  'category' => 'NewsPublisher',
                  'parent' => '',
                ),
                'npElFinder' =>  array (
                  'category' => 'npElFinder',
                  'parent' => 'NewsPublisher',
                ),
                'npTinyMCE' =>  array (
                  'category' => 'npTinyMCE',
                  'parent' => 'NewsPublisher',
                ),
            );

        if (is_array($intersects)) {
            foreach ($intersects as $k => $fields) {
                /* make sure we have all fields */
                if (!checkFields($modx, 'category,parent', $fields)) {
                    continue;
                }
                $categoryObj = $modx->getObject($classPrefix . 'modCategory', array('category' => $fields['category']));
                if (!$categoryObj) {
                    continue;
                }
                $parentObj = $modx->getObject($classPrefix . 'modCategory', array('category' => $fields['parent']));
                    if ($parentObj) {
                        $categoryObj->set('parent', $parentObj->get('id'));
                    }
                $categoryObj->save();
            }
        }
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}


return true;