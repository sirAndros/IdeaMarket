<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_images.php 6188 2012-06-29 09:38:30Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Product Main Image
if (!empty($this->product->images[0])) {
    ?>
    <div id="large_image_holder" class="main-image">
		<ul id="large_images">
			<?php //echo $this->product->images[0]->displayMediaFull('class="medium-image" id="medium-image"', false, "class='modal'", true); ?>
			<?php foreach($this->product->images as $image) { ?>
				<li><a class="modal" href="<?php echo JURI::root().$image->file_url; ?>"><img src="<?php echo JURI::root().$image->file_url_thumb; ?>" alt="thumb" /></a></li>
			<?php } ?>
		</ul>
    </div>
<?php } // Product Main Image END ?>

<?php
// Showing The Additional Images
/*if (!empty($this->product->images)) {
    ?>
    <div class="additional-images">
		<div class="additional-images-i">
			<ul id="thumb_holder">
			<?php
			// List all Images
			if (count($this->product->images) > 0) {
				foreach ($this->product->images as $image) {
					//echo '<div class="floatleft">' . $image->displayMediaThumb('class="product-image"', true, 'class="modal"', true, true) . '</div>'; //'class="modal"'
					echo '<li><a href="javascript:void(0);"><img src="'.JURI::root().$image->file_url_thumb.'" alt="thumb" /></a></li>';
				}
			} ?>
			</ul>
		</div>
        <div class="clear"></div>
    </div>
<?php
}*/ // Showing The Additional Images END ?>