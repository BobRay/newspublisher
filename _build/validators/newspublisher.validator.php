<?php
/**
 * Validator for NewsPublisher extra
 *
 * Copyright 2013-2022 Bob Ray <https://bobsguides.com>
 * Created on 07-01-2022
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

if ($object->xpdo) {
    $modx =& $object->xpdo;
    $prefix = $modx->getVersionData()['version'] >= 3
        ?'MODX\Revolution\\'
        : '';
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx->log(modX::LOG_LEVEL_INFO, 'Creating NewsPublisherTemplate');
            $templateId = createNewsPublisherTemplate($modx, $prefix);
            $modx->log(modX::LOG_LEVEL_INFO, 'Creating NewsPublisher Resource');
            $id = createNewsPublisherResource($modx,$templateId, $prefix);
            $modx->log(modX::LOG_LEVEL_INFO, 'NP ID: ' . $id);
            break;
        case xPDOTransport::ACTION_UPGRADE:
            /* Nothing here. Validator is only for new installs */
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            $template = $modx->getObject($prefix . 'modTemplate', array('templatename' => 'NewsPublisherTemplate'));
            if ($template) {
               if ($template->remove()) {
                    $modx->log(modX::LOG_LEVEL_INFO, 'Removed NewsPublisher Template');
               }
            }

            $doc = $modx->getObject($prefix . 'modResource', array('pagetitle' => 'NewsPublisher'));
            if ($doc) {
                /* Don't remove to avoid losing children */
                $modx->log(modX::LOG_LEVEL_ERROR, 'NewsPublisher Resource must be removed manually');

            }
            break;
    }
    return true;
}

function createNewsPublisherTemplate($modx, $prefix) {
    $template = $modx->getObject($prefix . 'modTemplate',
        array('templatename'=> 'NewsPublisherTemplate'));
    if ( !$template) {
        $template = $modx->newObject($prefix. 'modTemplate');
        $template->fromArray(array(
            'property_preprocess' => false,
            'templatename' => 'NewsPublisherTemplate',
            'description' => 'NewsPublisher Template',
            'icon' => '',
            'template_type' => 0,
            'properties' =>
                array(),
        ), '', true, true);
        $template->setContent('
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family:Georgia, sans-serif;">

<head>
[[!Canonical]]
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>[[++site_name]] - [[*pagetitle]]</title>
<base href="[[!++site_url]]" /> 
<!-- <link rel="stylesheet" href="path/to/your/css/file" type="text/css" /> -->

</head>
<body>
    
<div class="newspublisher">
[[*content]]
</div>

</body>
</html>
');
    $template->save();
    }
    $template = $modx->getObject($prefix . 'modTemplate',
        array('TemplateName' => 'NewsPublisherTemplate'));

    return $template->get('id');
}

function createNewsPublisherResource($modx, $templateId, $prefix) {
    $resource = $modx->getObject($prefix . 'modResource', array('pagetitle' => 'NewsPublisher'));
    if (! $resource) {
        $resource = $modx->newObject($prefix . 'modResource');

        $resource->fromArray(array(
            'contentType' => 'text/html',
            'pagetitle' => 'NewsPublisher',
            'longtitle' => '',
            'description' => 'Page to hold NewsPublisher snippet tag',
            'alias' => 'newspublisher',
            'alias_visible' => true,
            'published' => true,
            'introtext' => '',
            'richtext' => false,
            'template' => $templateId,
            'searchable' => true,
            'cacheable' => true,
            'createdby' => 1,
            'editedby' => 1,
            'deleted' => false,
            'deletedon' => 0,
            'deletedby' => 0,
            'menutitle' => '',
            'hidemenu' => false,
            'context_key' => $modx->getOption('default_context'),
            'content_type' => 1,
            'hide_children_in_tree' => 0,
            'show_in_tree' => 1,
            'properties' => NULL,
        ), '', true, true);

        $resource->setContent('[[!NewsPublisher?
    &show=`pagetitle,longtitle,introtext,alias,pub_date,unpub_date,hidemenu,published,content`
    &initrte=`1`
    &initelfinder=`1`
    &rtsummary=`1`
    &rtcontent=`1`

]]');
       if (!$resource->save()) {
           $modx->log(modX::LOG_LEVEL_ERROR, 'Could not save NewsPublisherResource');
       };

    }
    $r = $modx->getObject($prefix . 'modResource',
        array('pagetitle' => 'NewsPublisher'));
    if (!$r) {
        $modx->log(modX::LOG_LEVEL_INFO, 'Could not get NP Resource');
        return 0;
    } else {
        return $r->get('id');
    }
} // end of createNewsPublisherResource function

