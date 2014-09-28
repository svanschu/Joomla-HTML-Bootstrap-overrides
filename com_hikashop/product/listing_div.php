<?php
/**
 * @package	HikaShop for Joomla!
 * @version	2.3.0
 * @author	hikashop.com
 * @copyright	(C) 2010-2014 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php
$mainDivName=$this->params->get('main_div_name');
$carouselEffect=$this->params->get('carousel_effect');
$enableCarousel=$this->params->get('enable_carousel');

$textCenterd=$this->params->get('text_center');
$this->align="left";
if($textCenterd){
	$this->align="center";
}
$height=$this->params->get('image_height');
$width=$this->params->get('image_width');
$this->borderClass="";

if($this->params->get('border_visible',1) == 1){
	$this->borderClass="hikashop_subcontainer_border";
}
if($this->params->get('border_visible',1) == 2){
	$this->borderClass="thumbnail";
}
if(empty($width) && empty($height)){
	$width=$this->image->main_thumbnail_x;
	$height=$this->image->main_thumbnail_y;
}
if(!empty($this->rows)){
	$row = reset($this->rows);
	$this->image->checkSize($width,$height,$row);
	$this->newSizes= new stdClass();
	$this->newSizes->height=$height;
	$this->newSizes->width=$width;
	$this->image->main_thumbnail_y=$height;
	$this->image->main_thumbnail_x=$width;
}

if((!empty($this->rows) || !$this->module || JRequest::getVar('hikashop_front_end_main',0)) && $this->pageInfo->elements->total){
	$pagination = $this->config->get('pagination','bottom');
	if(in_array($pagination,array('top','both')) && $this->params->get('show_limit') && $this->pageInfo->elements->total){
		$this->pagination->form = '_top';
?>
	<form action="<?php echo hikashop_currentURL(); ?>" method="post" name="adminForm_<?php echo $this->params->get('main_div_name').$this->category_selected;?>_top">
		<div class="hikashop_products_pagination hikashop_products_pagination_top">
		<?php echo $this->pagination->getListFooter($this->params->get('limit')); ?>
		<!--span class="hikashop_results_counter"><?php //echo $this->pagination->getResultsCounter(); ?></span-->
		</div>
		<input type="hidden" name="filter_order_<?php echo $this->params->get('main_div_name').$this->category_selected;?>" value="<?php echo $this->pageInfo->filter->order->value; ?>" />
		<input type="hidden" name="filter_order_Dir_<?php echo $this->params->get('main_div_name').$this->category_selected;?>" value="<?php echo $this->pageInfo->filter->order->dir; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
<?php
	}
?>
	<div class="hikashop_products">
<?php

	if(!empty($this->rows)){

		if ($this->config->get('show_quantity_field')>=2) {
?>
		<form action="<?php echo hikashop_completeLink('product&task=updatecart'); ?>" method="post" name="hikashop_product_form_<?php echo $this->params->get('main_div_name'); ?>" enctype="multipart/form-data">
<?php
		}
		if($enableCarousel){
			$this->setLayout('carousel');
			echo $this->loadTemplate();
		}
		else
		{
			$columns = (int)$this->params->get('columns');
			if(empty($columns) || $columns<1) $columns = 1;
			$width = (int)(100/$columns)-1;
			$current_column = 1;
			$current_row = 1;

			if(HIKASHOP_RESPONSIVE) {
				switch($columns) {
					case 12:
					case 6:
					case 4:
					case 3:
					case 2:
					case 1:
						$row_fluid = 12;
						$span = $row_fluid / $columns;
						break;
					case 10:
					case 8:
					case 7:
						$row_fluid = $columns;
						$span = 1;
						break;
					case 5:
						$row_fluid = 10;
						$span = 2;
						break;
					case 9: // special case
						$row_fluid = 10;
						$span = 1;
						break;
				}
				if($row_fluid == 12)
					echo '<div class="row"><div class="thumbnails">'; //<ul class="thumbnails">
				else
					echo '<div class="row'/*.$row_fluid*/.'"><div class="thumbnails">'; //<ul class="thumbnails">
			}

			foreach($this->rows as $row){
				if(!HIKASHOP_RESPONSIVE) {
?>
			<div class="hikashop_product hikashop_product_column_<?php echo $current_column; ?> hikashop_product_row_<?php echo $current_row; ?>" style="width:<?php echo $width;?>%;">
				<div class="hikashop_container">
					<div class="hikashop_subcontainer <?php echo $this->borderClass; ?>">
<?php
				} else {
                    /*<li class="col-md-<?php echo $span; ?> hikashop_product hikashop_product_column_<?php echo $current_column; ?> hikashop_product_row_<?php echo $current_row; ?>">*/
?>
			<div class="col-md-<?php echo $span; ?> hikashop_product_column_<?php echo $current_column; ?> hikashop_product_row_<?php echo $current_row; ?>">
				<div class="hikashop_container">
					<div class="hikashop_subcontainer <?php echo $this->borderClass; ?>">
<?php
				}

				$this->row =& $row;
				$this->setLayout('listing_'.$this->params->get('div_item_layout_type'));
				echo $this->loadTemplate();

				if(!HIKASHOP_RESPONSIVE) {
?>
					</div>
				</div>
			</div>
<?php
				} else {
?>
					</div>
				</div>
			</div><!--/li-->
<?php
				}
				if($current_column>=$columns){
					$current_row++;
					if(!HIKASHOP_RESPONSIVE) {
?>
			<div style="clear:both"></div>
<?php
					}
					$current_column=0;
				}
				$current_column++;
			}

			if(HIKASHOP_RESPONSIVE) {
				echo '</div></div>'; //</ul></div>
			}
		}
?>
			<div style="clear:both"></div>
<?php
		if ($this->config->get('show_quantity_field')>=2) {
			$this->ajax = 'if(hikashopCheckChangeForm(\'item\',\'hikashop_product_form_'.$this->params->get('main_div_name').'\')){ return hikashopModifyQuantity(\'\',field,1,\'hikashop_product_form_'.$this->params->get('main_div_name').'\'); } return false;';
			$this->row = new stdClass();
			$this->row->prices = array($this->row);
			$this->row->product_quantity = -1;
			$this->row->product_min_per_order = 0;
			$this->row->product_max_per_order = -1;
			$this->row->product_sale_start = 0;
			$this->row->product_sale_end = 0;
			$this->row->prices = array('filler');
			$this->setLayout('quantity');
			echo $this->loadTemplate();
			if(!empty($this->ajax) && $this->config->get('redirect_url_after_add_cart','stay_if_cart')=='ask_user'){
?>
			<input type="hidden" name="popup" value="1"/>
<?php
			}
?>
			<input type="hidden" name="hikashop_cart_type_0" id="hikashop_cart_type_0" value="cart"/>
			<input type="hidden" name="add" value="1"/>
			<input type="hidden" name="ctrl" value="product"/>
			<input type="hidden" name="task" value="updatecart"/>
			<input type="hidden" name="return_url" value="<?php echo urlencode(base64_encode(urldecode($this->redirect_url)));?>"/>
		</form>
<?php
		}
	}
?>
	</div>
	<?php if(in_array($pagination,array('bottom','both')) && $this->params->get('show_limit') && $this->pageInfo->elements->total){ $this->pagination->form = '_bottom'; ?>
	<form action="<?php echo hikashop_currentURL(); ?>" method="post" name="adminForm_<?php echo $this->params->get('main_div_name').$this->category_selected;?>_bottom">
		<div class="hikashop_products_pagination hikashop_products_pagination_bottom">
		<?php echo $this->pagination->getListFooter($this->params->get('limit')); ?>
		<span class="hikashop_results_counter"><?php echo $this->pagination->getResultsCounter(); ?></span>
		</div>
		<input type="hidden" name="filter_order_<?php echo $this->params->get('main_div_name').$this->category_selected;?>" value="<?php echo $this->pageInfo->filter->order->value; ?>" />
		<input type="hidden" name="filter_order_Dir_<?php echo $this->params->get('main_div_name').$this->category_selected;?>" value="<?php echo $this->pageInfo->filter->order->dir; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
<?php }
}
?>