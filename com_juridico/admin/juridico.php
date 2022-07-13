<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_juridico
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

$controller = JControllerLegacy::getInstance('Juridico');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();