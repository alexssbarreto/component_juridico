<?php

defined('_JEXEC') or die('Restricted access');

class JuridicoModelProcessos extends JModelList
{

    public function hasUsuario($username)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('*')->from($db->quoteName('#__users') . ' AS a');

        $search = $db->quote($db->escape(trim($username)));
        $query->where('a.username = ' . $search);

        $db->setQuery($query);

        return $db->loadObject();
    }

    protected function getListQuery()
    {
        $app = JFactory::getApplication();

        // Initialize variables.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Create the base select statement.
        $query->select('*')->from($db->quoteName('#__processo') . ' AS a');

        // Filter by search in title.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(a.cpf LIKE ' . $search . ' OR a.processo LIKE ' . $search . ' OR a.valor LIKE ' . $search . ' OR a.publicado_em LIKE ' . $search . ')');
            }
        }

        $orderDirn = $this->state->get('list.direction', 'desc');

        $orderCol = substr($app->input->get('list')['fullordering'], 0, - strlen($orderDirn));

        if (!$orderCol) {
            $orderCol = 'a.id';
        }

        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

        return $query;
    }

    public function publish(&$pks, $value = 1)
	{
	    $updateNulls = true;

		foreach ($pks as $i => $pk) {
		    $object = new stdClass();
		    
		    $object->id = $pk;
		    $object->ativo = $value;
		    
		    JFactory::getDbo()->updateObject('#__processo', $object, 'id', $updateNulls);
		}

		return true;
	}

    public function syncronize($data)
	{
		$valor = str_ireplace('.', '', $data[2]);
		$valor = str_ireplace(',', '.', $valor);
		$valor = str_ireplace('R$', '', $valor);

		$bind = [
			'cpf' => $data[0],
			'processo' => $data[1],
			'valor' => $valor,
			'publicado_em' => date("Y-m-d H-i-s"),
			'ativo' => empty($data['3']) ? 0 : 1
		];

        $isItem = $this->item($data[0]);

        if ($isItem) {
            $isItem->ativo = 0;
            $this->inative($isItem);
        }

		$table = $this->getTable();
		$table->bind($bind);
		$table->store();
	}

    public function item($cpf)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Create the base select statement.
        $query->select('*')->from($db->quoteName('#__processo') . ' AS a');
        $search = $db->quote($db->escape(trim($cpf), true));
        $query->where('a.cpf = ' . $search);

        $db->setQuery($query);

        return $db->loadObject();
    }

    public function inative($bind)
	{
		$table = $this->getTable();
		$table->bind($bind);
		$table->store();
	}

    public function getTable($name = 'Processo', $prefix = 'JuridicoTable', $options = array())
	{
		if (strpos(JPATH_COMPONENT, 'com_juridico') === false) {
			$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_juridico/tables');
		}

		return JTable::getInstance($name, $prefix, $options);
	}
}
