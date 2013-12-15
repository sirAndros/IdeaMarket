<?php
/**
 * @package 	OT Scroller for Joomla! 2.5
 * @version 	$Id: helper.php - May 2012 00:00:00Z OmegaTheme
 * @author 	OmegaTheme Extensions (services@omegatheme.com) - http://omegatheme.com
 * @copyright Copyright(C) 2012 - OmegaTheme Extensions
 * @license 	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
**/
// no direct access
defined('_JEXEC') or die;

class modOTScrollerHelper
{
	function getImages(&$params, $folder, $type)
	{
		$files	= array();
		$images	= array();
		
		$dir = JPATH_BASE.DS.$folder;

		// check if directory exists
		if (is_dir($dir))
		{
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != '.' && $file != '..' && $file != 'CVS' && $file != 'index.html' && $file != 'Thumbs.db') {
						$files[] = $file;
					}
				}
			}
			closedir($handle);
			
			foreach($type as $tp){
				$tp=trim($tp);
				$i = 0;
				foreach ($files as $img){
					if (!is_dir($dir .DS. $img))
					{
						if (preg_match("#$tp#i", $img)) {
							$images[$i]->name 	= $img;
							$images[$i]->folder	= $folder;
							++$i;
						}
					}
				}
			}
			
		}

		return $images;
	}

	function getFolder(&$params)
	{
		$folder 	= $params->get( 'folder' );

		$LiveSite 	= JURI::base();

		// if folder includes livesite info, remove
		if ( JString::strpos($folder, $LiveSite) === 0 ) {
			$folder = str_replace( $LiveSite, '', $folder );
		}
		// if folder includes absolute path, remove
		if ( JString::strpos($folder, JPATH_SITE) === 0 ) {
			$folder= str_replace( JPATH_BASE, '', $folder );
		}
		$folder = str_replace('\\',DS,$folder);
		$folder = str_replace('/',DS,$folder);

		return $folder;
	}
}
?>