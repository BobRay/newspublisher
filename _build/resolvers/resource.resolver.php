<?php
/**
* Resource resolver  for NewsPublisher extra.
* Sets template, parent, and (optionally) TV values
*
* Copyright 2013-2022 Bob Ray <https://bobsguides.com>
* Created on 12-20-2016
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
    function checkFields($required, $objectFields) {
        global $modx;
        $fields = explode(',', $required);
        foreach ($fields as $field) {
            if (! isset($objectFields[$field])) {
                $modx->log(modX::LOG_LEVEL_ERROR, '[Resource Resolver] Missing field: ' . $field);
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

$isMODX3Plus = $modx->getVersionData()['version'] >= 3;
if ($isMODX3Plus) {
    $classPrefix = 'MODX\Revolution\\';
} else {
    $classPrefix = '';
}

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        $intersects = array (
            0 =>  array (
              'pagetitle' => 'npElFinder',
              'parent' => 'NewsPublisher',
              'template' => 'npElFinderTemplate',
            ),
            1 =>  array (
              'pagetitle' => 'npElFinderConnector',
              'parent' => 'NewsPublisher',
              'template' => 'npElFinderTemplate',
            ),
        );

        if (is_array($intersects)) {
            foreach ($intersects as $k => $fields) {
                /* make sure we have all fields */
                if (! checkFields('pagetitle,parent,template', $fields)) {
                    continue;
                }
                $resource = $modx->getObject($classPrefix . 'modResource',
                    array('pagetitle' => $fields['pagetitle']));
                if (! $resource) {
                    continue;
                }

                /* Set class_key if MODX 3+ */
                if ($isMODX3Plus) {
                    $resource->set('class_key', 'MODX\Revolution\modDocument');
                }

                if ($fields['template'] == 'default') {
                    $resource->set('template', $modx->getOption('default_template'));
                } elseif (empty($fields['template'])) {
                    $resource->set('template', 0);
                } else {
                    $templateObj = $modx->getObject($classPrefix . 'modTemplate',
                        array('templatename' => $fields['template']));
                    if ($templateObj) {
                        $resource->set('template', $templateObj->get('id'));
                    } else {
                        $modx->log(modX::LOG_LEVEL_ERROR, '[Resource Resolver] Could not find template: ' . $fields['template']);
                    }
                }
                if (!empty($fields['parent'])) {
                    if ($fields['parent'] != 'default') {
                        $parentObj = $modx->getObject($classPrefix . 'modResource', array('pagetitle' => $fields['parent']));
                        if ($parentObj) {
                            $resource->set('parent', $parentObj->get('id'));
                        } else {
                            $modx->log(modX::LOG_LEVEL_ERROR, '[Resource Resolver] Could not find parent: ' . $fields['parent']);
                        }
                    }
                }

                if (isset($fields['tvValues'])) {
                    foreach($fields['tvValues'] as $tvName => $value) {
                        $resource->setTVValue($tvName, $value);
                    }

                }
                $resource->save();
            }

        }
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}


return true;