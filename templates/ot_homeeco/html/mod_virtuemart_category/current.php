<?php // no direct access
defined('_JEXEC') or die('Restricted access');
//JHTML::stylesheet ( 'menucss.css', 'modules/mod_virtuemart_category/css/', false );
$ID = str_replace('.', '_', substr(microtime(true), -8, 8));
?>

<ul class="VMmenu menu <?php echo $class_sfx ?>" id="<?php echo "VMmenu".$ID ?>" >
<?php $i = 0; ?>
<?php foreach ($categories as $category) {
		 $active_menu = 'VmClose';
		$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
		$cattext = $category->category_name;
		//if ($active_category_id == $category->virtuemart_category_id) $active_menu = 'class="active"';
		if (in_array( $category->virtuemart_category_id, $parentCategories)) $active_menu = 'VmOpen';
		if ($i==0) $active_menu = $active_menu . " first";
		if ($i==(count($categories)-1)) $active_menu = $active_menu . " last";
		$i++;
		?>

<li class="<?php echo $active_menu ?>">
	<div >
		<?php echo JHTML::link($caturl, $cattext);
		if ($category->childs) {
			?>
			<!--<span class="VmArrowdown"> </span>-->
			<?php
		}
		?>
	</div>
<?php if ($active_menu=='class="VmOpen"') {


	?>
	<ul class="menu<?php echo $class_sfx; ?>">
	<?php
		foreach ($category->childs as $child) {

			$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$child->virtuemart_category_id);
			$cattext = $child->category_name;
			?>

			<li>
				<div ><?php echo JHTML::link($caturl, $cattext); ?></div>
			</li>
			<?php
		}
		?>
	</ul>
	<?php
}
?>
</li>
<?php
	} ?>
</ul>
