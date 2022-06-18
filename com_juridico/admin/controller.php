<?php

defined('_JEXEC') or die('Restricted access');

class JuridicoController extends JControllerLegacy
{
	
	protected $default_view = 'processos';

	public function display($cachable = false, $urlparams = array())
	{
		JLoader::register('JuridicoHelper', JPATH_ADMINISTRATOR . '/components/com_juridico/helpers/juridico.php');

		return parent::display();
	}
}
