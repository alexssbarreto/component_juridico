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
                $subquery = sprintf('(a.cpf LIKE %s OR a.nome_acao LIKE %s OR a.valor_beneficiario LIKE %s OR a.publicado_em LIKE %s OR a.numero_acao LIKE %s OR a.valor_executado LIKE %s OR a.valor_honorario LIKE %s)',
                    $search, $search, $search, $search, $search, $search, $search);

                $query->where($subquery);
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
        $valorExecutado = str_ireplace('.', '', $data[3]);
        $valorExecutado = str_ireplace(',', '.', $valorExecutado);
        $valorExecutado = str_ireplace('R$', '', $valorExecutado);

        $valorHonorario = str_ireplace('.', '', $data[4]);
        $valorHonorario = str_ireplace(',', '.', $valorHonorario);
        $valorHonorario = str_ireplace('R$', '', $valorHonorario);

		$valorBeneficiario = str_ireplace('.', '', $data[5]);
		$valorBeneficiario = str_ireplace(',', '.', $valorBeneficiario);
		$valorBeneficiario = str_ireplace('R$', '', $valorBeneficiario);

		$bind = [
			'cpf' => $data[0],
            'numero_acao' => $data[1],
            'nome_acao' => $data[2],
			'valor_executado' => $valorExecutado,
            'valor_honorario' => $valorHonorario,
            'valor_beneficiario' => $valorBeneficiario,
			'publicado_em' => date("Y-m-d H-i-s"),
			'ativo' => empty($data['6']) ? 0 : 1
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
