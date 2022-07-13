<?php

defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT.'/models/processo.php');

class JuridicoViewJuridico extends JViewLegacy
{

    function display($tpl = null)
    {
        $this->name = JFactory::getUser()->name;
		$model = new JuridicoModelProcesso();

        $this->items = $model->getList();

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));

            return false;
        }

        // Display the template
        parent::display($tpl);
    }
}