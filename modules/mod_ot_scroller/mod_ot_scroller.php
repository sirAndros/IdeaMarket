<?php
/**
 * @package 	OT Scroller for Joomla! 2.5
 * @version 	$Id: mod_ot_scroller.php - May 2012 00:00:00Z OmegaTheme
 * @author 	OmegaTheme Extensions (services@omegatheme.com) - http://omegatheme.com
 * @copyright Copyright(C) 2012 - OmegaTheme Extensions
 * @license 	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
**/
// no direct access
defined('_JEXEC') or die;

require_once (dirname(__FILE__).DS.'helper.php');

$doc = &JFactory::getDocument();
$doc->addStyleSheet(JURI::base().'/modules/mod_ot_scroller/css/layout.css');

$type = explode(',',trim($params->get('type')));

$folder	= modOTScrollerHelper::getFolder($params);
$images	= modOTScrollerHelper::getImages($params, $folder, $type);

$modwidth 		= $params->get('modwidth', 700);
$scrollheight 		= $params->get('scrollheight', 110);
$imgperframe		= $params->get('imgperframe', 1);

if (!count($images)) {
	echo JText::_( 'No images ');
	return;
}

require(JModuleHelper::getLayoutPath('mod_ot_scroller'));
?>
