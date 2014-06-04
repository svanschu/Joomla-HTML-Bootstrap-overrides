<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_users/helpers/route.php';

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

?>
<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#loginModal">
    <?php echo JText::_('JLOGIN'); ?>
</button>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form"
      role="form">

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Login</h4>
                </div>
                <div class="modal-body">

                    <?php if ($params->get('pretext')) : ?>
                        <div class="pretext">
                            <p><?php echo $params->get('pretext'); ?></p>
                        </div>
                    <?php endif; ?>
                    <!--div id="form-login-username" class="control-group"-->
                    <div class="form-group">
                        <?php if (!$params->get('usetext')) : ?>
                            <span class="icon-user hasTooltip"
                                  title="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>"></span>
                            <label for="modlgn-username"
                                   class="element-invisible"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME'); ?></label>
                            <input id="modlgn-username" type="text" name="username" class="form-control"
                                   tabindex="0" size="18"
                                   placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>"/>
                        <?php else: ?>
                            <label
                                for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label>
                            <input id="modlgn-username" type="text" name="username" class="form-control"
                                   tabindex="0" size="18"
                                   placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>"/>
                        <?php endif; ?>
                    </div>
                    <!--/div-->
                    <!--div id="form-login-password" class="control-group"-->
                    <div class="form-group">
                        <?php if (!$params->get('usetext')) : ?>
                            <span class="icon-lock hasTooltip"
                                  title="<?php echo JText::_('JGLOBAL_PASSWORD') ?>"></span>
                            <label for="modlgn-passwd"
                                   class="element-invisible"><?php echo JText::_('JGLOBAL_PASSWORD'); ?>
                            </label>
                            <input id="modlgn-passwd" type="password" name="password" class="form-control"
                                   tabindex="0" size="18"
                                   placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>"/>
                        <?php else: ?>
                            <label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
                            <input id="modlgn-passwd" type="password" name="password" class="form-control"
                                   tabindex="0" size="18"
                                   placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>"/>
                        <?php endif; ?>
                    </div>
                    <!--/div-->
                    <?php if (count($twofactormethods) > 1): ?>
                        <!--div id="form-login-secretkey" class="control-group"-->
                        <div class="form-group">
                            <?php if (!$params->get('usetext')) : ?>
                                <span class="icon-star hasTooltip"
                                      title="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>"></span>
                                <label for="modlgn-secretkey"
                                       class="element-invisible"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?></label>
                                <input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey"
                                       class="input-small" tabindex="0" size="18"
                                       placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>"/>
                                <span class="btn width-auto hasTooltip"
                                      title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
							            <span class="icon-help"></span>
						            </span>
                            <?php else: ?>
                                <label
                                    for="modlgn-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY') ?></label>
                                <input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey"
                                       class="input-small" tabindex="0" size="18"
                                       placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>"/>
                                <span class="btn width-auto hasTooltip"
                                      title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
						                <span class="icon-help"></span>
                                    </span>
                            <?php
                            endif; ?>

                        </div>
                        <!--/div-->
                    <?php endif; ?>
                    <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                        <!--div id="form-login-remember" class="control-group checkbox"-->
                        <div class="form-group checkbox">
                            <label for="modlgn-remember"
                                   class="control-label">
                                <input id="modlgn-remember" type="checkbox" name="remember" class="inputbox"
                                       value="yes"/> <?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?>
                            </label>
                        </div>
                        <!--/div-->
                    <?php endif; ?>
                    <div class="modal-footer">
                        <?php
                        $usersConfig = JComponentHelper::getParams('com_users'); ?>
                        <?php if ($usersConfig->get('allowUserRegistration')) : ?>
                            <a class="btn btn-default btn-xs"
                               href="<?php echo JRoute::_('index.php?option=com_users&view=registration&Itemid=' . UsersHelperRoute::getRegistrationRoute()); ?>">
                                <?php echo JText::_('MOD_LOGIN_REGISTER'); ?> <span
                                    class="icon-arrow-right"></span></a>
                        <?php endif; ?>
                        <a class="btn btn-default btn-xs"
                           href="<?php echo JRoute::_('index.php?option=com_users&view=remind&Itemid=' . UsersHelperRoute::getRemindRoute()); ?>">
                            <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
                        <a class="btn btn-default btn-xs"
                           href="<?php echo JRoute::_('index.php?option=com_users&view=reset&Itemid=' . UsersHelperRoute::getResetRoute()); ?>">
                            <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>

                        <div id="form-login-submit" class="control-group">
                            <div class="controls">
                                <button type="submit" tabindex="0" name="Submit"
                                        class="btn btn-primary"><?php echo JText::_('JLOGIN') ?></button>
                            </div>
                        </div>
                        <input type="hidden" name="option" value="com_users"/>
                        <input type="hidden" name="task" value="user.login"/>
                        <input type="hidden" name="return" value="<?php echo $return; ?>"/>
                        <?php echo JHtml::_('form.token'); ?>
                    </div>
                    <?php if ($params->get('posttext')) : ?>
                        <div class="posttext">
                            <p><?php echo $params->get('posttext'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</form>
