<?php
/**
 * @version		default.php 0001 August 16 2012 OmegaTheme $
 * @package		OT Mega Menu module
 * @author		OmegaTheme http://omegatheme.com
 * @copyright	Copyright (c) 2012 OmegaTheme.com
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die();

?>

<div class="ot-megaMenu" id="ot-megaMenu">
	<div class="ot-megaMenu-i">
		<ul class="menu<?php echo $params->get('moduleclass_sfx'); ?> ot-menu">
<?php

$zIndex = 9999;
	
foreach ($items as $i => &$item) {
	
	//check column is list or not
	if ($item->params->get('load_module', 0) OR $item->menu_image) {
		$item->submenuList = ' notList';
	} else {
		$item->submenuList = '';
	}
	
	//set styles for the columns
	if(isset($item->col)) {
		$columnStyles = isset($item->columnWidth) ? ' style="width:' . $item->columnWidth . 'px;float:left; z-index:'. $zIndex .';"' : ' style="width:' . $item->column_width . 'px;float:left; z-index:'. $zIndex .';"';
	} else if ($item->params->get('column_width', 0)) {
		$columnStyles = ' style="width: ' . $item->params->get('column_width') . 'px; float:left; z-index:'. $zIndex .';"';
	} else {
		$columnStyles = ' style="float:left; z-index:'. $zIndex .';"';
	}
	
	//create column
	//if ((isset($item->col) AND ($item->level > 1) AND !isset($item->submenus_width) AND (isset($items[$i-1]) AND !$items[$i-1]->deeper))) {
	// if ((isset($item->col) AND ($item->level > 1) AND (isset($items[$i-1]) AND !$items[$i-1]->deeper))) {
        // echo '</ul></div><div class="submenu-column" ' . $columnStyles . '><ul class="ot-menu">';
    // }
	
	if ((isset($item->col) AND ($item->level > 1))) {		
		if  (isset($items[$i-1]) AND !$items[$i-1]->deeper){
        echo '</ul></div>';
			$col = '';
		} else {
			$col = ' first-column';
		}
		echo '<div class="submenu-column'.$col.'" ' . $columnStyles . '><ul class="ot-menu">';
    }
	
    if (isset($item->content) AND $item->content) {
		echo '<li class="ot-item'.' level' . $item->level .' '. $item->submenuList .' '.$item->classes .' '.$item->anchor_css .'">' . $item->content;
		$item->ftitle = '';
    } 
		
    if ($item->ftitle != "") {
		$title = $item->anchor_title ? ' title="'.$item->anchor_title.'"' : '';
		$description = $item->desc ? '<br /><span class="item-desc">' . $item->desc . '</span>' : '';
		
		// item is image
		if ($item->menu_image) {
			$item->params->get('menu_text', 1 ) ?
			$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->ftitle.'"/><span>'. $item->ftitle . $description .'</span>' :
			$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->ftitle.'" />';
		} else {	
			$linktype = '<span class="ot-item '. $item->title_column .'">'.$item->ftitle.$description.'</span>';
		}
		
		echo '<li class="ot-item'.' level' . $item->level .' '. $item->submenuList .' '.$item->itemClassSuffix .' '.$item->classes .' '.$item->anchor_css .'">';
		
        switch ($item->type) :
            default:
                echo '<a class="ot-item level' . $item->level .' ' . $item->anchor_css . ' '. $item->title_column .'" href="' . $item->flink . '" title="' . $item->title . '" '.$item->itemTextColor.'>' . $linktype . '</a>';
                break;
            case 'separator':
                echo '<h3 class="separator"><span class="separator level' . $item->level .' ' . $item->anchor_css . '" '.$item->itemTextColor.'>' . $linktype . '</span></h3>';
                break;
            case 'url':
            case 'component':
                switch ($item->browserNav) :
                    default:
                    case 0:
                        echo '<a class="ot-item level' . $item->level .' ' . $item->anchor_css . ' '. $item->title_column .'" href="' . $item->flink . '" title="'. $item->title . '" '.$item->itemTextColor.'>' . $linktype . '</a>';
                        break;
                    case 1:
                        // _blank
                        echo '<a class="ot-item level' . $item->level .' ' . $item->anchor_css . ' '. $item->title_column .'" href="' . $item->flink . '" target="_blank" title="' . $item->title . '" '.$item->itemTextColor.'>' . $linktype . '</a>';
                        break;
                    case 2:
                        // window.open
                        echo '<a class="ot-item level' . $item->level .' ' . $item->anchor_css . ' '. $item->title_column .'" href="' . $item->flink . '&tmpl=component" onclick="window.open(this.href,\'targetWindow\',\'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes\');return false;" title="'. $item->title . '" '.$item->itemTextColor.'>' . $linktype . '</a>';
                        break;
                endswitch;
                break;
        endswitch;
    }

    if ($item->deeper) {
		// set style for the submenus
        if (isset($item->submenus_width)) {
            $item->styles = 'style="width:' . $item->submenus_width . 'px;"';
			$item->create_column = 'hasColumn';
        } else {
            $item->styles = "";
			$item->create_column = 'notColumn';
        }
		
		// echo "\n\t<div class=\"submenu-wrap submenu-wrap-level$item->level $item->create_column\" " . $item->styles . "><div class=\"submenu-wrap-i\"><div class=\"submenu-leftbg\"></div><div class=\"submenu-rightbg\"></div><div class=\"submenu-wrap-ii\"><div class=\"submenu-column first-column\" " . $columnStyles . ">\n\t<ul class=\"ot-menu\">";
        echo "\n\t<div class=\"submenu-wrap submenu-wrap-level$item->level $item->create_column\" " . $item->styles . "><div class=\"submenu-wrap-i\"><div class=\"submenu-leftbg\"></div><div class=\"submenu-rightbg\"></div><div class=\"submenu-wrap-ii\">";
	
    }
	
    // The next item is shallower.
    elseif ($item->shallower) {
        echo "\n\t</li>";
        echo str_repeat("\n\t</ul>\n\t</div></div></div></div>\n\t</li>", $item->level_diff);
    }
    // the item is the last.
    elseif ($item->is_end) {
        echo str_repeat("</li>\n\t</ul>\n\t</div></div></div></div></div>", $item->level_diff);
        echo "</li>";
    }
    // The next item is on the same level.
    else {
		echo "\n\t\t</li>\n";
    }

    $zIndex--;
}
?>
		</ul>
	</div>
</div>
