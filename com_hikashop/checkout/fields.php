<?php
/**
 * @package    HikaShop for Joomla!
 * @version    2.3.1
 * @author    hikashop.com
 * @copyright    (C) 2010-2014 HIKARI SOFTWARE. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php if (hikashop_level(2) && !empty($this->extraFields['order'])) {
    ?>
    <div class="row">
        <div id="hikashop_checkout_additional_info" class="hikashop_checkout_additional_info col-md-12 col-ld-12">
            <fieldset class="input">
                <legend><?php echo JText::_('ADDITIONAL_INFORMATION'); ?></legend>
                <?php
                if (!empty($this->extraFields['order'])) {
                    JRequest::setVar('hikashop_check_order', 1);
                    $this->setLayout('custom_fields');
                    $this->type = 'order';
                    echo $this->loadTemplate();
                }
                ?>
            </fieldset>
        </div>
    </div>
    <div style="clear:both"></div>
<?php } ?>