<?php
/**
 * @version		helper.php 0001 August 16 2012 OmegaTheme $
 * @package		OT Mega Menu module
 * @author		OmegaTheme http://omegatheme.com
 * @copyright	Copyright (c) 2012 OmegaTheme.com
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

class modOTmegaMenuHelper
{
	/**
	 * Get a list of the menu items.
	 *
	 * @param	JRegistry	$params	The module options.
	 *
	 * @return	array
	 * @since	1.5
	 */
	static function getItems(&$params)
	{
		$app = JFactory::getApplication();
		$menu = $app->getMenu();

		// If no active menu, use default
		$active = ($menu->getActive()) ? $menu->getActive() : $menu->getDefault();

		$user = JFactory::getUser();
		$levels = $user->getAuthorisedViewLevels();
		asort($levels);
		$key = 'menu_items'.$params.implode(',', $levels).'.'.$active->id;
		$cache = JFactory::getCache('mod_ot_megamenu', '');
		if (!($items = $cache->get($key)))
		{
			// Initialise variables.
			$list		= array();
			$modules	= array();
			$db			= JFactory::getDbo();

			// load the libraries
			jimport('joomla.application.module.helper');

			$path		= $active->tree;
			$start		= (int) $params->get('startLevel');
			$end		= (int) $params->get('endLevel');
			$showAll	= $params->get('showAllChildren');
			$items 		= $menu->getItems('menutype', $params->get('menutype'));
			
			$lastitem	= 0;
			// list all modules
			$modulesList = modOTmegaMenuHelper::createModulesList();

			if ($items) {
				foreach($items as $i => $item)
				{

					if (($start && $start > $item->level)
						|| ($end && $item->level > $end)
						|| (!$showAll && $item->level > 1 && !in_array($item->parent_id, $path))
						|| ($start > 1 && !in_array($item->tree[$start-2], $path))
					) {
						unset($items[$i]);
						continue;
					}

					$item->deeper = false;
					$item->shallower = false;
					$item->level_diff = 0;

					if (isset($items[$lastitem])) {
						$items[$lastitem]->deeper		= ($item->level > $items[$lastitem]->level);
						$items[$lastitem]->shallower	= ($item->level < $items[$lastitem]->level);
						$items[$lastitem]->level_diff	= ($items[$lastitem]->level - $item->level);
					}

					// Test if this is the last item
					$item->is_end = !isset($items[$i + 1]);

					$item->parent = (boolean) $menu->getItems('parent_id', (int) $item->id, true);

					$lastitem			= $i;
					$item->active		= false;
					$item->flink = $item->link;

					// Reverted back for CMS version 2.5.6
					switch ($item->type)
					{
						case 'separator':
							// No further action needed.
							continue;

						case 'url':
							if ((strpos($item->link, 'index.php?') === 0) && (strpos($item->link, 'Itemid=') === false)) {
								// If this is an internal Joomla link, ensure the Itemid is set.
								$item->flink = $item->link.'&Itemid='.$item->id;
							}
								$item->flink = JFilterOutput::ampReplace(htmlspecialchars($item->flink));
							break;

						case 'alias':
							// If this is an alias use the item id stored in the parameters to make the link.
							$item->flink = 'index.php?Itemid='.$item->params->get('aliasoptions');
							break;

						default:
							$router = JSite::getRouter();
							if ($router->getMode() == JROUTER_MODE_SEF) {
								$item->flink = 'index.php?Itemid='.$item->id;
							}
							else {
								$item->flink .= '&Itemid='.$item->id;
							}
							break;
					}

					if (strcasecmp(substr($item->flink, 0, 4), 'http') && (strpos($item->flink, 'index.php?') !== false)) {
						$item->flink = JRoute::_($item->flink, true, $item->params->get('secure'));
					}
					else {
						$item->flink = JRoute::_($item->flink);
					}
					
					//$item->title = htmlspecialchars($item->title);
					$item->anchor_css = htmlspecialchars($item->params->get('menu-anchor_css', ''));
					$item->anchor_title = htmlspecialchars($item->params->get('menu-anchor_title', ''));
					$item->menu_image = $item->params->get('menu_image', '') ? htmlspecialchars($item->params->get('menu_image', '')) : '';
					
					/*
					if (isset($items[$lastitem])) {
						$items[$lastitem]->deeper		= (($start?$start:1) > $items[$lastitem]->level);
						$items[$lastitem]->shallower	= (($start?$start:1) < $items[$lastitem]->level);
						$items[$lastitem]->level_diff	= ($items[$lastitem]->level - ($start?$start:1));
					}
					*/
					$item->ftitle = htmlspecialchars($item->title);
					$item->ftitle = JFilterOutput::ampReplace($item->ftitle);
					$parentItem = modOTmegaMenuHelper::getParentItem($item->parent_id, $items);

					// add classes
					//$item->classes = ' item'. $item->id;
					if (isset($active) && $active->id == $item->id) {
						$item->classes .= ' current';
					}
					//add active class
					if ( $item->type == 'alias' && is_array($path) && in_array($item->params->get('aliasoptions'), $path) || in_array($item->id, $path)) {
						$item->classes .= ' active';
						$item->active = true;
					}
					//add parent class
					if ( $item->deeper ) {
						$item->classes .= ' hasChild';
					}
						
					if ($item->parent) {
						if ($params->get('layout', 'default') != '') {
							$item->classes .= ' hasChild';
						}
					}
					//add first, last class to itemss
					$item->classes .= $item->is_end ? ' last-item' : '';
					$item->classes .= !isset($items[$i-1]) ? ' first-item' : '';
					
					/*
					//if (isset($items[$lastitem])) {
						$items[$lastitem]->classes .= $items[$lastitem]->shallower ? ' last-item' : '';
						$item->classes .= $items[$lastitem]->deeper ? ' first-item' : '';
						if (isset($items[$i+1]) AND $item->level - $items[$i+1]->level > 1) {
								$parentItem->classes .= ' last-item';
						}
					//}
					*/
						
					// submenu					
					if ( $item->params->get('create_column', 0)) {
						
						$item->column_width = $item->params->get('column_width', 200);
						
						//$parentItem->create_column = ' hasColumn';
						
						$item->title_column = ' title-column';
						
						$item->col = true;
						
						if (isset($parentItem->submenus_width)) {
							$parentItem->submenus_width = strval($parentItem->submenus_width) + strval($item->column_width);
						} else {
							$parentItem->submenus_width = strval($item->column_width);
						}
						
						//if (isset($items[$lastitem]) && $items[$lastitem]->deeper) {
						if (isset($items[$lastitem])) {
							$items[$lastitem]->columnWidth = $item->column_width;
						} else {
							$item->columnWidth = $item->column_width;
						}
					} else {
						$item->title_column = '';
						//$parentItem->create_column = ' notColumn';
					}
					
					// item description
					$item->description = $item->params->get('item_desc', '');
					if ($item->description) {
						$item->desc = $item->description;
					} else {
						$resultat = explode("||", $item->ftitle);
						if (isset($resultat[1])) {
							$item->desc = $resultat[1];
						} else {
							$item->desc = '';
						}
						$item->ftitle = $resultat[0];	
					}
					
					// load module
					$moduleID = $item->params->get('module_id', '');
					$style = 'rounded';
					if ($item->params->get('load_module', 0)) { 
						if (!isset($modules[$moduleID])) $modules[$moduleID] = modOTmegaMenuHelper::getModuleById($moduleID, $params, $modulesList, $style);
						$item->content = '<div class="submenu-loadModule">' . $modules[$moduleID] . '<div class="clr"></div></div>';
					} elseif (preg_match('/\[module_id=([0-9]+)\]/', $item->ftitle, $resultat)) { 
						$item->ftitle = preg_replace('/\[module_id=[0-9]+\]/', '', $item->ftitle); 
						$item->content = '<div class="submenu-loadModule">' . modOTmegaMenuHelper::getModuleById($resultat[1], $params, $modulesList, $style) . '<div class="clr"></div></div>';
					}
					
					//$item->itemClassSuffix
					$item->itemClassSuffix = htmlspecialchars($item->params->get('item_classSuffix'));
					if ($item->params->get('custom_item_color', 0)) {
						$item->itemTextColor = 'style="color:'.$item->params->get('item_color').'"';
					} else {
						$item->itemTextColor = '';
					}
				}
			}
			// give the correct deep infos for the last item
			if (isset($items[$lastitem])) {
				$items[$lastitem]->deeper		= (($start?$start:1) > $items[$lastitem]->level);
				$items[$lastitem]->shallower	= (($start?$start:1) < $items[$lastitem]->level);
				$items[$lastitem]->level_diff	= ($items[$lastitem]->level - ($start?$start:1));
			}

			$cache->store($items, $key);
		}
		return $items;
	}
	/**
	 * Get a the parent item object
	 */
	static function getParentItem($id, $items) {
        foreach ($items as $item) {
            if ($item->id == $id)
                return $item;
        }
    }

	/**
	 * Render the module
	 */
    static function getModuleById($moduleID, $params, $modulesList, $style) {
			
		$attribs['style'] = $style;
		
		if (in_array($moduleID, array_keys($modulesList))) {
			// get the title of the module
			$moduleTitle = $modulesList[$moduleID]->title;
			$moduleName = $modulesList[$moduleID]->module;
			
			// load the module
			if (JModuleHelper::isEnabled($moduleName)) {
				$module = JModuleHelper::getModule($moduleName, $moduleTitle);
				return JModuleHelper::renderModule($module);
			}
			
		} else {
			return 'Module ID='.$moduleID.'<br> does not exist !';
		}
    }

	/**
	 * Create the list of all modules published as Object
	 */
    static function createModulesList() {
        $db = JFactory::getDBO();
        $query = "
			SELECT *
			FROM #__modules
			WHERE published=1
			ORDER BY id
			;";
        $db->setQuery($query);
        $modulesList = $db->loadObjectList('id');
        return $modulesList;
    }
}
