<?php

defined('_JEXEC') or die('Restricted access');

class JuridicoModelProcesso extends JModelList
{

	public function getList()
    {
        $user  = JFactory::getUser();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('*')->from($db->quoteName('#__processo') . ' AS a');

        $search = $db->quote($db->escape(trim($user->username)));
        $query->where('a.cpf = ' . $search);
        $query->where('a.ativo = 1');
        $query->order('a.publicado_em DESC');

        $db->setQuery($query);

        return $db->loadObjectList();
    }
}