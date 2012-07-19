<?php
/**
 * NewsPublisher Build Script
 *
 * Copyright 2011-2012 Bob Ray

 *
 * NewsPublisher is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * NewsPublisher is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * NewsPublisher; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package newspublisher
 */
/**
 * Build NewsPublisher Package
 *
 * Description: Build script for NewsPublisher package
 * @package newspublisher
 * @subpackage build
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

define('MODX_BASE_URL','http://localhost/addons/');
define('MODX_MANAGER_URL','http://localhost/addons/manager/');
define('MODX_ASSETS_URL','http://localhost/addons/assets/');
define('MODX_CONNECTORS_URL','http://localhost/addons/connectors/');

/* define sources */
$root = dirname(dirname(__FILE__)) . '/';
$sources= array (
    'root' => $root,
    'build' => $root . '_build/',
    'source_core' => $root . 'core/components/newspublisher',
    'source_assets' => $root . 'assets/components/newspublisher',
    'data' => $root . '_build/data/',
    'docs' => $root . 'core/components/newspublisher/docs/',
    'resolvers' => $root . '_build/resolvers/',
);
unset($root);

/* instantiate MODx */
require_once $sources['build'].'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modx->setLogLevel(xPDO::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

/* set package info */
define('PKG_NAME','newspublisher');
define('PKG_VERSION','1.4.1');
define('PKG_RELEASE','rc');

/* load builder */
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace('newspublisher',false,true,'{core_path}components/newspublisher/');

/* create snippet objects */

/* create category */
/* @var $category modCategory */
$category= $modx->newObject('modCategory');
$category->set('id',1);
$category->set('category','NewsPublisher');

/* add snippets */
$modx->log(modX::LOG_LEVEL_INFO,'Adding in snippets.');
$snippets = include $sources['data'].'transport.snippets.php';
if (is_array($snippets)) {
    $category->addMany($snippets);
} else { $modx->log(modX::LOG_LEVEL_FATAL,'Adding snippets failed.'); }

/* add chunks  */
$modx->log(modX::LOG_LEVEL_INFO,'Adding in chunks.');
$chunks = include $sources['data'].'transport.chunks.php';
if (is_array($chunks)) {
    $category->addMany($chunks);
} else { $modx->log(modX::LOG_LEVEL_FATAL,'Adding chunks failed.'); }

/* create category vehicle */
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Snippets' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        'Chunks' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
    )
);
$vehicle = $builder->createVehicle($category,$attr);
$vehicle->resolve('file',array(
        'source' => $sources['source_core'],
        'target' => "return MODX_CORE_PATH . 'components/';",
    ));
    $vehicle->resolve('file',array(
        'source' => $sources['source_assets'],
        'target' => "return MODX_ASSETS_PATH . 'components/';",
    ));

$builder->putVehicle($vehicle);

/* Add filebrowser action */
$modx->log(modX::LOG_LEVEL_INFO,'Adding filebrowser action.');
$browserAction = include $sources['data'].'transport.browseraction.php';
$vehicle= $builder->createVehicle($browserAction,array (
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => array ('namespace','controller'),
));
$builder->putVehicle($vehicle);

/* NewsPublisher access policy template */
$modx->log(modX::LOG_LEVEL_INFO,'Adding access policy template.');
$template = include $sources['data'].'transport.accesspolicytemplate.php';
$vehicle= $builder->createVehicle($template,array (
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'name',
));
$vehicle->resolve('php',array(
    'source' => $sources['resolvers'] . 'accesspolicytemplate.resolver.php',
));
$builder->putVehicle($vehicle);

/* NewsPublisher access policy */
$modx->log(modX::LOG_LEVEL_INFO,'Adding access policy.');
$policy = include $sources['data'].'transport.accesspolicy.php';
$vehicle= $builder->createVehicle($policy,array (
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'name',
));
$vehicle->resolve('php',array(
    'source' => $sources['resolvers'] . 'accesspolicy.resolver.php',
));

$vehicle->resolve('php',array(
    'source' => $sources['resolvers'] . 'filemove.resolver.php',
));

$builder->putVehicle($vehicle);

unset($vehicle,$template,$policy,$browserAction);


/* now pack in the license file, readme.txt and setup options */
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['source_core'] . '/docs/license.txt'),
    'readme' => file_get_contents($sources['source_core'] . '/docs/readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
));

/* zip up the package */
$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(xPDO::LOG_LEVEL_INFO, "Package Built.");
$modx->log(xPDO::LOG_LEVEL_INFO, "Execution time: {$totalTime}");
exit();
