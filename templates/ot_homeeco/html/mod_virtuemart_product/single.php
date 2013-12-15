<?php // no direct access
defined ('_JEXEC') or die('Restricted access');
$i = 0;
$doc = &JFactory::getDocument();
//$pwidth = ' width' . floor (100 / $products_per_row);
$pwidth = 'width100';
?>
<div class="vmgroup<?php echo $module->id; ?>">
	<?php if ($headerText) { ?>
		<div class="vmheader"><?php echo $headerText ?></div>
	<?php } ?>
	<div class="ot-vmgroup vmgroup-i<?php echo $module->id; ?>" style="position: relative;">
		<?php if ($display_style == "div") { ?>
			<div class="ot-vmproduct ot-items">
				<?php foreach ($products as $product) { 
					$i++;
					if ($i == 1) {
						$first = ' first';
					} else {
						$first = '';
					}
					if($i == count($products)) {
						$last = ' last';
					} else {
						$last = '';
					}?>
					<div class="ot-item <?php echo $pwidth ?> <?php echo $first ?><?php echo $last ?>">
						<div class="spacer">
							<div class="ot-product-detail">
								<?php if (!empty($product->images[0])) {
									$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
								} else {
									$image = '';
								}
								//echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));?>
								<div class="product-image">
									<?php echo '<a class="modal" href="'.$product->images[0]->file_url.'" title="'.$product->product_name.'"><img src="'.$product->images[0]->file_url_thumb.'" alt="'.$product->product_name.'" /></a>';?>
								</div>
								<div class="product-detail">
									<?php $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
										$product->virtuemart_category_id); ?>
									<div class="product-name">
										<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>
									</div>
									<div class="clear"></div>
									<?php //Product short DESC ?>
									<div class="product-s-desc">
										<p class="product_s_desc">
											<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, 75, '...');?>
										</p>
									</div>
									<div class="clear"></div>
									<?php $maxrating = VmConfig::get('vm_maximum_rating_scale',5);
									$ratingModel = VmModel::getModel('ratings');
									$showRating = $ratingModel->showRating();
									if ($showRating) { ?>
										<div class="vote">
											<?php $rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
											if (empty($rating)) { ?>
												<span class="vote"><?php echo JText::_('COM_VIRTUEMART_UNRATED') ?></span>
											<?php } else {
												$ratingwidth = ( $rating->rating * 100 ) / $maxrating;//I don't use round as percetntage with works perfect, as for me
												?>
												<span class="vote">
													<span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . $rating->rating . '/' . $maxrating) ?>" class="vmicon ratingbox" style="display:inline-block;">
														<span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
														</span>
													</span>
												</span>
												<?php
											} ?>
										</div>
									<?php } ?>
									<div class="clear"></div>
									<div class="product-addtocart">
										<?php if ($show_price) { ?>
											<div class="product-price">
												<?php if (!empty($product->prices['salesPrice'])) { ?>
													<span class="PricesalesPrice"><?php echo $currency->createPriceDiv ('salesPrice', '', $product->prices, TRUE);?></span>
												<?php } ?>
											</div>
										<?php }
										if ($show_addtocart) {
											//echo mod_virtuemart_product::addtocart ($product);?>
											<?php /*<div class="product-addtocart-area">
												<form action="index.php" class="product" method="post">
													<span class="addtocart">
														<?php echo shopFunctionsF::getAddToCartButton ($product->orderable); ?>
													</span>
													<input type="hidden" value="1" name="quantity[]" class="quantity-input">
													<input type="hidden" value="<?php echo($product->product_name);?>" class="pname">
													<input type="hidden" value="com_virtuemart" name="option">
													<input type="hidden" value="cart" name="view">
													<noscript><input type="hidden" name="task" value="add" /></noscript>
													<input type="hidden" value="<?php echo($product->virtuemart_product_id);?>" name="virtuemart_product_id[]">
													<!--<input type="hidden" value="<?php echo($product->virtuemart_manufacturer_id); ?>" name="virtuemart_manufacturer_id[]" />-->
													<input type="hidden" value="<?php echo($product->virtuemart_category_id);?>" name="virtuemart_category_id[]">
												</form>
												<div class="clear"></div>
											</div>*/?>
											<?php echo JHTML::link($product->link, JText::_('COM_VIRTUEMART_PRODUCT_DETAILS'), array('title' => $product->product_name,'class' => 'product-details'));?>
										<?php }	?>
									</div>
									<div class="clear"></div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<!--<br style='clear:both;'/>-->
		<?php } else { ?>
			<?php if (strpos( $params->get ('moduleclass_sfx'), 'scroll')!==false){?>
			<div id="horiz_container_outer"><div id="horiz_container_inner"><div id="horiz_container">
			<?php } ?>
				<ul class="ot-vmproduct ot-items">
					<?php foreach ($products as $product) { 				
						$i++;
						if ($i == 1) {
							$first = ' first';
						} else {
							$first = '';
						}
						if($i == count($products)) {
							$last = ' last';
						} else {
							$last = '';
						}?>
						<li class="ot-item <?php echo $first ?><?php echo $last ?>" style="padding: 0px;">
							<div class="spacer">
								<div class="ot-product-detail">
									<?php
									if (!empty($product->images[0])) {
										$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
									} else {
										$image = '';
									}
									//echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));?>
									<div class="product-image">
										<div class="product-image-i">
											<?php echo '<a class="modal" href="'.$product->images[0]->file_url.'" title="'.$product->product_name.'"><img src="'.$product->images[0]->file_url_thumb.'" alt="'.$product->product_name.'" /></a>';?>
										</div>
										<?php if (!empty($product->prices['discountAmount'])&&!empty($product->prices['basePriceWithTax'])) { 
											$percent = ($product->prices['discountAmount'] / $product->prices['basePriceWithTax']) * 100; ?>
											<div class="product-discount">
												<span class="discount-per"><?php echo number_format($percent, 0); ?>%</span>
												<span><?php echo JText::_('TPL_OT_SALEOFF') ?></span>
											</div>
										<?php } ?>
									</div>
									<div class="product-detail">
										<?php $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
											$product->virtuemart_category_id); ?>
										<div class="product-name">
											<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>
										</div>
										<div class="clear"></div>
										<?php //Product short DESC ?>
										<div class="product-s-desc">
											<p class="product_s_desc">
												<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, 55, '...');?>
											</p>
										</div>
										<div class="clear"></div>
										<?php $maxrating = VmConfig::get('vm_maximum_rating_scale',5);
										$ratingModel = VmModel::getModel('ratings');
										$showRating = $ratingModel->showRating();
										if ($showRating) { ?>
											<div class="vote">
												<?php $rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
												if (empty($rating)) { ?>
													<span class="vote"><?php echo JText::_('COM_VIRTUEMART_UNRATED') ?></span>
												<?php } else {
													$ratingwidth = ( $rating->rating * 100 ) / $maxrating;//I don't use round as percetntage with works perfect, as for me
													?>
													<span class="vote">
														<span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . $rating->rating . '/' . $maxrating) ?>" class="vmicon ratingbox" style="display:inline-block;">
															<span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
															</span>
														</span>
													</span>
													<?php
												} ?>
											</div>
										<?php } ?>
										<div class="clear"></div>
										<div class="product-addtocart">
											<?php if ($show_price) { ?>
												<div class="product-price">
													<?php if (!empty($product->prices['salesPrice'])) { ?>
														<span class="PricesalesPrice"><?php echo $currency->createPriceDiv ('salesPrice', '', $product->prices, TRUE);?></span>
													<?php } ?>
												</div>
											<?php }
											if ($show_addtocart) {
												//echo mod_virtuemart_product::addtocart ($product);?>
												<?php echo JHTML::link($product->link, JText::_('COM_VIRTUEMART_PRODUCT_DETAILS'), array('title' => $product->product_name,'class' => 'product-details'));?>
											<?php }	?>
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</li>
					<?php } ?>
				</ul>
			<?php if (strpos( $params->get ('moduleclass_sfx'), 'scroll')!==false){?>
			</div></div></div>
			<div id="scrollbar">
				<div id="track">
					 <div id="dragBar"></div>
				</div>
			</div>
			<?php $doc->addScript('templates/ot_caraccessories/scripts/jquery.horizontal.scroll.js');
			$doc->addStyleSheet('templates/ot_caraccessories/css/jquery.horizontal.scroll.css');?>
			<script type="text/javascript" charset="utf-8">
			<!--
				jQuery(document).ready(function($){
					if ($('.scroll').length > 0){
						$(function(){
							$('#horiz_container_outer ul.ot-items li.ot-item').css('width', Math.floor($('.vmgroup<?php echo $module->id; ?>').width()/<?php echo $products_per_row; ?>) + 'px' );
							$('#horiz_container, #horiz_container_outer ul.ot-items').css('width', $('#horiz_container_outer ul.ot-items li.ot-item').width()*<?php echo (count($products)); ?> + 'px' );
							$('#horiz_container_outer, #scrollbar, #track').css('width', $('.vmgroup<?php echo $module->id; ?>').width() + 'px' );
							$('#horiz_container').css('height', $('#horiz_container_outer ul.ot-items').height() + 'px' );
							$('#horiz_container_outer').css('height', $('#horiz_container_inner').outerHeight(true) + 'px' );
							$('#horiz_container_outer').horizontalScroll();
						});
					}
				});		
			-->
			</script>
			<?php } ?>
		<?php }?>
	</div>
	<?php if ($footerText) : ?>
		<div class="vmfooter<?php echo $params->get ('moduleclass_sfx') ?>">
			<?php echo $footerText ?>
		</div>
		<?php endif; ?>
</div>
<?php if (strpos( $params->get ('moduleclass_sfx'), 'slide')!==false){?>
	<?php $doc->addScript('templates/ot_caraccessories/scripts/jquery.cycle.all.js');?>
	<script type="text/javascript" charset="utf-8">
	<!--
		var j = jQuery.noConflict();
		if (j('.slide .vmgroup<?php echo $module->id; ?>').length > 0){
			j(function(){
				var slideshow = j('.slide .vmgroup<?php echo $module->id; ?> .ot-items')
				.after('<div id="ot-slidenav<?php echo $module->id; ?>" class="ot-slidenav">')
				.cycle({ 
					fx:     'scrollHorz',
					speed:  '300', 
					timeout: 4000/*,
					pager:  '#ot-slidenav<?php echo $module->id; ?>'*/
				});
				j('#ot-slidenav<?php echo $module->id; ?>').prepend('<span id="otnext<?php echo $module->id; ?>" class="ot-next">&nbsp;</span>');
				// j('#ot-slidenav<?php echo $module->id; ?>').prepend('<span id="pauseButton<?php echo $module->id; ?>" class="ot-pause">&nbsp;</span>');
				j('#ot-slidenav<?php echo $module->id; ?>').prepend('<span id="otprev<?php echo $module->id; ?>" class="ot-prev">&nbsp;</span>');
				// j('#pauseButton<?php echo $module->id; ?>').click(function() {
					// var obj = j(this);
					// if (obj.hasClass('ot-pause')) {
						// obj.removeClass('ot-pause').addClass('ot-play');
						// slideshow.cycle('pause');
					// } else if (obj.hasClass('ot-play')) {
						// obj.removeClass('ot-play').addClass('ot-pause');
						// slideshow.cycle('resume');
					// }
				// });
				j('#otnext<?php echo $module->id; ?>').click(function() {
					slideshow.cycle('next');
				});
				j('#otprev<?php echo $module->id; ?>').click(function() {
					slideshow.cycle('prev');
				});
				// add style
				j('#ot-slidenav<?php echo $module->id; ?>').css({
					'position': 'absolute',
					'top': '-30px',
					'right': '0px'
				});
			});
		}
	-->
	</script>
<?php } ?>

<div class="clear"></div>