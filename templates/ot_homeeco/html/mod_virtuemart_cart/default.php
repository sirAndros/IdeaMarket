<?php // no direct access
defined('_JEXEC') or die('Restricted access');

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

<!-- Virtuemart 2 Ajax Card -->
<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?>" id="vmCartModule<?php echo $module->id; ?>">
<?php
if ($show_product_list) {
	?>
	<div id="hiddencontainer" style=" display: none; ">
		<div class="container">
			<?php if ($show_price) { ?>
			  <div class="prices" style="float: right;"></div>
			<?php } ?>
			<div class="product_row">
				<span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span>
			</div>

			<div class="product_attributes"></div>
		</div>
	</div>
	<div class="total_products">
		<?php if ( $data->totalProduct ) echo $data->totalProductTxt; ?>
		<?php //echo ($data->totalProduct . JText::_('TPL_OT_PRODUCTS')); ?>
	</div>
	<div class="vm_cart_products">
		<div class="container">
			<?php foreach ($data->products as $product)
			{
				if ($show_price) { ?>
					  <div class="prices" style="float: right;"><?php echo  $product['prices'] ?></div>
					<?php } ?>
				<div class="product_row">
					<span class="quantity"><?php echo  $product['quantity'] ?></span>&nbsp;x&nbsp;<span class="product_name"><?php echo  $product['product_name'] ?></span>
				</div>
				<?php if ( !empty($product['product_attributes']) ) { ?>
					<div class="product_attributes"><?php echo  $product['product_attributes'] ?></div>

				<?php }
			}
			?>
		</div>
	</div>
	<div class="total">
		<?php //if ($data->totalProduct) echo  $data->billTotal; ?>
		<?php echo  $data->billTotal; ?>
	</div>
	<div class="show_cart">
		<?php /*if ($data->totalProduct) { 
			echo  $data->cart_show;
		} else { ?>
			<div class="empty_product">
			<?php echo JText::_('TPL_OT_MOD_VIRTUEMART_CARD_EMPTY') ?>
			</div>
		<?php }*/ ?>
		<?php //echo '<a href="'.JRoute::_("index.php?option=com_virtuemart&view=cart".$taskRoute,$useXHTML,$useSSL).'">'.$linkName.'</a>';
		echo  $data->cart_show;?>
	</div>
<?php } else { ?>
	<div class="ot-total_products">
		<span class="total_products"><?php echo $data->totalProductTxt; ?></span>
		<span class="show_cart">
		<?php //if ($data->totalProduct) { ?>
			<?php echo '<a href="'.JRoute::_("index.php?option=com_virtuemart&view=cart".$taskRoute,$useXHTML,$useSSL).'">'.$linkName.'</a>';?>
			
		<?php //} ?>
		</span>
	</div>
<?php } ?>

<div style="clear:both;"></div>

<noscript>
<?php echo JText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
</noscript>
</div>

