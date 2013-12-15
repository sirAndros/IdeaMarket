<?php
/**
 * @version		plg_ot_mainmenu.php 0001 August 16 2012 OmegaTheme $
 * @package		OT Main Menu plug-in
 * @author		OmegaTheme http://omegatheme.com
 * @copyright	Copyright (c) 2012 OmegaTheme.com
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
 // no direct access
defined( '_JEXEC' ) or die();
jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.html.parameter' );

class plgSystemPlg_OT_MainMenu extends JPlugin {
	var $_params;
	var $_pluginPath;
	
	function __construct( &$subject ) {
		parent::__construct( $subject );
		$this->_plugin = JPluginHelper::getPlugin( 'system', 'plg_ot_mainmenu' );
		$this->_params = new JParameter( $this->_plugin->params );
		$this->_pluginPath = JPATH_PLUGINS.DS."system".DS."plg_ot_mainmenu".DS;
	}
	//Add main menu parameter
	function onContentPrepareForm($form, $data) {
		if ($form->getName()=='com_menus.item') {
			JForm::addFormPath($this->_pluginPath);
			$form->loadFile('parameters', false);
		}
	}
}
?>