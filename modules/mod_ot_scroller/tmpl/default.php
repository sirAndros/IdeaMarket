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
<script type="text/javascript" language="javascript">var k = jQuery.noConflict();</script>
<script src="modules/mod_ot_scroller/js/jquery.tools.min.js" type="text/javascript" language="javascript"></script>

<div class="scroll_wrapper" style="width: <?php echo $modwidth;?>">
	<div class="scroll_wrapper_i">
		<!-- "previous page" action -->
		<a id="next-prev-button" class="prev browse left"></a>
		<div id="ot-scrollable" class="scrollable" style="height: <?php echo $scrollheight;?>">
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
	k(document).ready(function(){
		var heightAction = k("a.browse").height();
		var heightScroller = k("div.scroll_wrapper").height();
		k("a.browse").css({
			'top': (heightScroller - heightAction)/2 + 'px'
		});
		var widthAction = k("a.browse").width();
		k("div.scrollable").css({
			'width': <?php echo intval($modwidth); ?> - widthAction*4 + 'px'
		});
	});
	
	k(function() {
		k(".scrollable").scrollable({
			size:'<?php echo $imgperframe?>',
			loop:true
		}).autoscroll(5000);
	});
-->
</script>
