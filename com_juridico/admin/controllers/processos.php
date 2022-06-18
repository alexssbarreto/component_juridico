<?php

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

class JuridicoControllerProcessos extends JControllerAdmin
{

    public function getModel($name = 'Processos', $prefix = 'JuridicoModel', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function publish()
    {
        $this->checkToken();

        $cid = $this->input->get('cid', array(), 'array');
        $data = array('publish' => 1, 'unpublish' => 0, 'archive' => 2, 'trash' => -2, 'report' => -3);
        $task = $this->getTask();
        $value = ArrayHelper::getValue($data, $task, 0, 'int');

        $model = $this->getModel();

        $model->publish($cid, $value);
        $this->setMessage(sprintf("%s processos atualizados com sucesso.", count($cid)));
        $this->setRedirect(\JRoute::_('index.php?option=com_juridico&view=processos', false));
    }
}
