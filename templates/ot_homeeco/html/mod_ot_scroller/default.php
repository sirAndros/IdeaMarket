<?php
/**
 * @package 	OT Scroller module for Joomla! 2.5
 * @version 	$Id: default.php - May 2012 00:00:00Z OmegaTheme
 * @author 	OmegaTheme Extensions (services@omegatheme.com) - http://omegatheme.com
 * @copyright Copyright(C) 2012 - OmegaTheme Extensions
 * @license 	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
**/
// no direct access
defined('_JEXEC') or die; ?>
<?php
	if($params->get('Loadjquery',1)==1){
		$document = &JFactory::getDocument();
		$document->addScript( 'modules/mod_ot_scroller/js/jquery.js' );
	}
?>

<script src="modules/mod_ot_scroller/js/jquery.tools.min.js" type="text/javascript" language="javascript"></script>

<div class="scroll_wrapper scroll-<?php echo $module->id; ?>">
	<div class="scroll_wrapper_i">
		<!-- "previous page" action -->
		<a class="prev browse left"></a>
		<div class="scrollable" style="width: <?php echo $modwidth;?>; height: <?php echo $scrollheight;?>;">
		   <div class="items">
			<?php foreach($images as $image) : ?>
				<div class="img" >
					<?php 
						$image->folder	= str_replace( '\\', '/', $image->folder );
						//$img = JHTML::_('image', $image->folder.'/'.$image->name, $image->name, array('width' => $image->width, 'height' => $image->height));
						$img = JHTML::_('image', $image->folder.'/'.$image->name, $image->name);
						echo $img;
					?>
				</div>
			<?php endforeach;?>
		      </div>
		</div>
		<!-- "next page" action -->
		<a class="next browse right"></a>
	</div>
</div>

<script type="text/javascript">
<!--
	var k = jQuery.noConflict();
	k(document).ready(function(){
		var heightAction = k(".scroll-<?php echo $module->id; ?> a.browse").height();
		var heightScroller = k("div.scroll-<?php echo $module->id; ?>").height();
		k(".scroll-<?php echo $module->id; ?> a.browse").css({
			'top': (heightScroller - heightAction)/2 + 'px'
			//'top': (heightScroller + heightAction)/4*3 + 'px'
		});
		//var widthAction = k("a.browse").width();
		//k("div.scrollable").css({
		//	'width': <?php echo intval($modwidth); ?> - widthAction*4 + 'px'
		//});
	});
	
	k(function() {
		k(".scroll-<?php echo $module->id; ?> .scrollable").scrollable({
			size:'<?php echo $imgperframe?>',
			loop:true
		}).autoscroll(5000);
	});
-->
</script>
