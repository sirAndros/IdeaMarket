<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6246 2012-07-09 19:00:20Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

//Custom tabs
jimport('joomla.html.pane');
$pane =& JPane::getInstance('tabs');
$i = 1;

// addon for joomla modal Box
JHTML::_('behavior.modal');
// JHTML::_('behavior.tooltip');
$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component');
$document = JFactory::getDocument();
$document->addScriptDeclaration("
	jQuery(document).ready(function($) {
		$('a.ask-a-question').click( function(){
			$.facebox({
				iframe: '" . $url . "',
				rev: 'iframe|550|550'
			});
			return false ;
		});
	/*	$('.additional-images a').mouseover(function() {
			var himg = this.href ;
			var extension=himg.substring(himg.lastIndexOf('.')+1);
			if (extension =='png' || extension =='jpg' || extension =='gif') {
				$('.main-image img').attr('src',himg );
			}
			console.log(extension)
		});*/
	});
");
/* Let's see if we found the product */
if (empty($this->product)) {
    echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
    echo '<br /><br />  ' . $this->continue_link_html;
    return;
}
//var_dump($this->product);
?>
<?php 
//$document->addScript('templates/ot_homeeco/html/com_virtuemart/simple_thumbs.js');
$document->addScript('templates/ot_homeeco/scripts/jquery.carousel.min.js');
?>
<script type="text/javascript">
var $j = jQuery.noConflict();
$j(function(){
	// $j("div.additional-images-i").carousel({ 
		// direction: "horizontal",
		// dispItems: 3,
		// loop: true,
		// animSpeed: "slow"});
	$j("div.main-image").carousel({ 
		direction: "horizontal",
		dispItems: 1,
		loop: true,
		animSpeed: "slow"});
	$j("div.related-products").carousel({ 
		direction: "horizontal",
		dispItems: <?php echo(VmConfig::get ( 'categories_per_row', 3 )); ?>,
		loop: true,
		animSpeed: "slow"});
	$itemwidth = $j(".product-related-products").width();
	$j(".product-related-products .product").css('width', Math.floor($itemwidth/<?php echo(VmConfig::get ( 'categories_per_row', 3 )); ?>) + 'px');
	$j(".product-related-products .carousel-wrap").css('width', $itemwidth);
});
</script>
<div class="productdetails-view">

    <?php
    // Product Navigation
    if (VmConfig::get('product_navigation', 1)) {
	?>
        <div class="product-neighbours">
	    <?php
	    if (!empty($this->product->neighbours ['previous'][0])) {
		$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
		echo JHTML::_('link', $prev_link, $this->product->neighbours ['previous'][0]
			['product_name'], array('class' => 'previous-page'));
	    }
	    if (!empty($this->product->neighbours ['next'][0])) {
		$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
		echo JHTML::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array('class' => 'next-page'));
	    }
	    ?>
    	<div class="clear"></div>
        </div>
    <?php } // Product Navigation END
    ?>

	<?php // Back To Category Button
	if ($this->product->virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id);
		$categoryName = $this->product->category_name ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart');
		$categoryName = jtext::_('COM_VIRTUEMART_SHOP_HOME') ;
	}
	?>
	<?php /* <div class="back-to-category">
    	<a href="<?php echo $catURL ?>" class="product-details" title="<?php echo $categoryName ?>"><?php echo JText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
	</div> */ ?>

    <?php // Product Title   ?>
    <?php /*<h1><?php echo $this->product->product_name ?></h1>*/?>
    <?php // Product Title END   ?>

    <?php // afterDisplayTitle Event
    echo $this->product->event->afterDisplayTitle ?>

    <?php
    // Product Edit Link
    echo $this->edit_link;
    // Product Edit Link END
    ?>
	<?php
	// PDF - Print - Email Icon
	if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_button_enable')) {
	?>
		<div class="icons">
		<?php
		//$link = (JVM_VERSION===1) ? 'index2.php' : 'index.php';
		$link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
		$MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

		if (VmConfig::get('pdf_icon', 1) == '1') {
		echo $this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_button_enable', false);
		}
		echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon');
		echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend');
		?>
		<div class="clear"></div>
		</div>
	<?php } // PDF - Print - Email Icon END
	?>

    <?php
    // Product Short Description
    //if (!empty($this->product->product_s_desc)) {
	?>
        <!--<div class="product-short-description">-->
	    <?php
	    /** @todo Test if content plugins modify the product description */
	    //echo nl2br($this->product->product_s_desc);
	    ?>
        <!--</div>-->
	<?php
    //} // Product Short Description END


    if (!empty($this->product->customfieldsSorted['ontop'])) {
	$this->position = 'ontop';
	echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>
    <div class="product-preview">
		<div class="product-images-details">
		<?php
			echo $this->loadTemplate('images');
		?>
		</div>
		<div class="product-details">
			<div class="product-name">
				<h3><?php echo $this->product->product_name ?></h3>
			</div>
			<?php // Category of the Product
			if ($this->product->virtuemart_category_id) {
				echo '<div class="product-category">'.JText::_('COM_VIRTUEMART_CATEGORY') .': <a href="'. $catURL.'">'.$categoryName.'</a></div>';
			}
			?>
			<?php // Manufacturer of the Product
			if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
				echo $this->loadTemplate('manufacturer');
			}
			?>
			<div class="product-sku">
				<?php echo JText::_('COM_VIRTUEMART_PRODUCT_SKU') .': '. $this->product->product_sku; ?>
			</div>
			<div class="spacer-buy-area">
				<?php // Product Price
				if ($this->show_prices and (empty($this->product->images[0]) or $this->product->images[0]->file_is_downloadable == 0)) { ?>
					<?php echo $this->loadTemplate('showprices');?>
				<?php } ?>
				<?php
				// Add To Cart Button
				// if (!empty($this->product->prices) and !empty($this->product->images[0]) and $this->product->images[0]->file_is_downloadable==0 ) {
				if (!VmConfig::get('use_as_catalog', 0) and !empty($this->product->prices)) {?>
					<?php echo $this->loadTemplate('addtocart');?>
				<?php }  // Add To Cart Button END ?>
				<?php
				// TODO in Multi-Vendor not needed at the moment and just would lead to confusion
				/* $link = JRoute::_('index2.php?option=com_virtuemart&view=virtuemart&task=vendorinfo&virtuemart_vendor_id='.$this->product->virtuemart_vendor_id);
				  $text = JText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL');
				  echo '<span class="bold">'. JText::_('COM_VIRTUEMART_PRODUCT_DETAILS_VENDOR_LBL'). '</span>'; ?><a class="modal" href="<?php echo $link ?>"><?php echo $text ?></a><br />
				 */
				?>
				<?php
				if (is_array($this->productDisplayShipments)) {
					foreach ($this->productDisplayShipments as $productDisplayShipment) {
						echo $productDisplayShipment . '<br />';
					}
				}
				if (is_array($this->productDisplayPayments)) {
					foreach ($this->productDisplayPayments as $productDisplayPayment) {
						echo $productDisplayPayment . '<br />';
					}
				} ?>
				<div class="clear"></div>
				<?php
				// Ask a question about this product
				if (VmConfig::get('ask_question', 1) == '1') {
					?>
					<div class="ask-a-question">
						<a class="ask-a-question" href="<?php echo $url ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
						<!--<a class="ask-a-question modal" rel="{handler: 'iframe', size: {x: 700, y: 550}}" href="<?php echo $url ?>"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>-->
					</div>
				<?php }
				?>
				<?php
				// Manufacturer of the Product
				if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
					echo $this->loadTemplate('manufacturer');
				}
				?>

				<div class="availability">
					<?php echo JText::_('COM_VIRTUEMART_PRODUCT_AVAILABILITY').': '; ?>
					<?php
					// Availability Image
					$stockhandle = VmConfig::get('stockhandle', 'none');
					if (($this->product->product_in_stock - $this->product->product_ordered) < 1) {
						if ($stockhandle == 'risetime' and VmConfig::get('rised_availability') and empty($this->product->product_availability)) {
						?>
							<?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability'))) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability', '7d.gif'), VmConfig::get('rised_availability', '7d.gif'), array('class' => 'availability')) : VmConfig::get('rised_availability'); ?>
						<?php
						} else if (!empty($this->product->product_availability)) {
						?>
							<?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability)) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability, $this->product->product_availability, array('class' => 'availability')) : $this->product->product_availability; ?>
						<?php
						}
					}
					?>
				</div>
			</div>
			<?php // Product Short Description ?>
			<div class="product-short-description">
				<?php if (!empty($this->product->product_s_desc)) { ?>
					<?php /** @todo Test if content plugins modify the product description */
					echo $this->product->product_s_desc; ?>
				<?php } ?>
			</div>
			<?php // Product Short Description END ?>
			<div class="social-button">
				<!-- Facebook Button -->
				<div class="itemFacebookButton floatleft">
					<div id="fb-root"></div>
					<script type="text/javascript">
						(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) {return;}
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/en_US/all.js#appId=177111755694317&xfbml=1";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));
					</script>
					<div class="fb-like" data-send="false" data-width="260" data-show-faces="true" layout="button_count"></div>
				</div>
				<!-- Twitter Button -->
				<div class="itemTwitterButton floatleft">
					<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal"><?php echo JText::_('TPL_OT_TWEET'); ?></a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
				</div>
				<!-- Google +1 Button -->
				<div class="itemGooglePlusOneButton floatleft">	
					<g:plusone annotation="bubble" width="120" size="medium"></g:plusone>
					<script type="text/javascript">
					  (function() {
						window.___gcfg = {lang: 'en'}; // Define button default language here
						var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
						po.src = 'https://apis.google.com/js/plusone.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
				</div>
			</div>
		</div>
		<div class="clear"></div>
    </div>
	<?php if (!empty($this->product->customfieldsSorted['top'])) { ?>
		<div class="floatleft width100">
		<?php $this->position='top';
		$custom_title = null;
		foreach ($this->product->customfieldsSorted[$this->position] as $field) {
			if ($field->display) {
				if ($field->custom_title != $custom_title) { ?>
					<div class="customfield customfield<?php echo $field->virtuemart_custom_id; ?>">
						<div class="customfield-i">
							<h3><?php echo JText::_($field->custom_title); ?></h3>
							<div class="customfield-content">
								<?php echo JText::_($field->custom_title).': '.$field->display;?>
							</div>
						</div>
					</div>
				<?php }
				$custom_title = $field->custom_title;
			}
		}?>
		</div>
	<?php } // Product custom_fields END?>

	<?php // event onContentBeforeDisplay
	echo $this->product->event->beforeDisplayContent; ?>

	<div class="otcustom-tabs">
		<?php
		echo $pane->startPane('otcustom-title-tabs');
		// Product Description
		if (!empty($this->product->product_desc)) { ?>
			<?php //Title Product DESC
				echo $pane->startPanel(JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE'), 'otcustom-title-tab-'.$i++); ?>
			<div id="product-description-details-page" class="product-description">
				<?php /** @todo Test if content plugins modify the product description */ ?>
				<!--<span class="title"><?php //echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?></span>-->
				<?php echo $this->product->product_desc; ?>
			</div>
		<?php
		} // Product Description END
		
		//Product Review
		echo $pane->startPanel(JText::_('COM_VIRTUEMART_REVIEWS'), 'otcustom-title-tab-'.$i++);
		echo $this->loadTemplate('reviews');
		//Product Review END
		echo $pane->endPane(); ?>	
	</div>

	<?php if (!empty($this->product->customfieldsSorted['normal'])) {
		$this->position = 'normal';
		echo $this->loadTemplate('customfields');
	} // Product custom_fields END
	
	// Product Packaging
	$product_packaging = '';
	if ($this->product->packaging || $this->product->box) { ?>
		<div class="product-packaging">
			<?php if ($this->product->packaging) {
				$product_packaging .= JText::_('COM_VIRTUEMART_PRODUCT_PACKAGING1') . $this->product->packaging;
				if ($this->product->box)
					$product_packaging .= '<br />';
			}
			if ($this->product->box)
				$product_packaging .= JText::_('COM_VIRTUEMART_PRODUCT_PACKAGING2') . $this->product->box;
			echo str_replace("{unit}", $this->product->product_unit ? $this->product->product_unit : JText::_('COM_VIRTUEMART_PRODUCT_FORM_UNIT_DEFAULT'), $product_packaging); ?>
		</div>
	<?php } // Product Packaging END
	?>

	<?php
	// Product Files
	// foreach ($this->product->images as $fkey => $file) {
	// Todo add downloadable files again
	// if( $file->filesize > 0.5) $filesize_display = ' ('. number_format($file->filesize, 2,',','.')." MB)";
	// else $filesize_display = ' ('. number_format($file->filesize*1024, 2,',','.')." KB)";

	/* Show pdf in a new Window, other file types will be offered as download */
	// $target = stristr($file->file_mimetype, "pdf") ? "_blank" : "_self";
	// $link = JRoute::_('index.php?view=productdetails&task=getfile&virtuemart_media_id='.$file->virtuemart_media_id.'&virtuemart_product_id='.$this->product->virtuemart_product_id);
	// echo JHTMl::_('link', $link, $file->file_title.$filesize_display, array('target' => $target));
	// }
	if (!empty($this->product->customfieldsRelatedProducts)) {
	echo $this->loadTemplate('relatedproducts');
	} // Product customfieldsRelatedProducts END

	if (!empty($this->product->customfieldsRelatedCategories)) {
	echo $this->loadTemplate('relatedcategories');
	} // Product customfieldsRelatedCategories END
	// Show child categories
	if (VmConfig::get('showCategory', 1)) {
	echo $this->loadTemplate('showcategory');
	}
	if (!empty($this->product->customfieldsSorted['onbot'])) {
		$this->position='onbot';
		echo $this->loadTemplate('customfields');
	} // Product Custom ontop end
	?>
	<?php // onContentAfterDisplay event
	echo $this->product->event->afterDisplayContent; ?>
	
	<?php jimport( 'joomla.application.module.helper' );
	$modules = JModuleHelper::getModules( 'vm-inner' );
	if ($modules){ ?>
		<div class="ot-vm-inner floatleft width100">
			<div class="ot-vm-inner-i">
				<?php foreach ($modules as $module){
					$params = new JRegistry;
					$params->loadString($module->params);?>
					<div class="otModule module<?php echo $params->get('moduleclass_sfx'); ?>">
						<div class="otModule-i">
							<?php if ($module->showtitle=="1"){?>
							<h3>
								<span class="title-module"><?php echo $module->title;?></span>
							</h3>
							<?php } ?>
							<div class="otModuleContent-i clearfix">
								<?php echo JModuleHelper::renderModule($module);?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>
