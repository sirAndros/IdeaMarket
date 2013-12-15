<?php
/**
 * @version		mod_ot_megamenu.php 0001 August 16 2012 OmegaTheme $
 * @package		OT Mega Menu module
 * @author		OmegaTheme.com, http://omegatheme.com
 * @copyright	Copyright (c) 2012 OmegaTheme.com
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
jimport('joomla.filesystem.file');

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
$items	= modOTmegaMenuHelper::getItems($params);

// if no item in the menu then exit
if (!count($items) OR !$items) return false;

$document = JFactory::getDocument();
$document->addScript(JURI::root().'/modules/mod_ot_megamenu/js/jsOTmegaMenu.js');
$document->addStyleSheet(JURI::root().'/modules/mod_ot_megamenu/css/cssOTmegaMenu.css');

$app	= JFactory::getApplication();
$menu	= $app->getMenu();
$active	= $menu->getActive();
$active_id = isset($active) ? $active->id : $menu->getDefault()->id;
$path	= isset($active) ? $active->tree : array();
$showAll	= $params->get('showAllChildren');
$class_sfx	= htmlspecialchars($params->get('class_sfx'));

// get the language direction
$langdirection = $document->getDirection();

if(count($items)) {
	require JModuleHelper::getLayoutPath('mod_ot_megamenu', $params->get('layout', 'default'));
}
