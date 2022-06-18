<?php

defined('_JEXEC') or die('Restricted access');

class JuridicoTableProcesso extends JTable
{

	function __construct(&$db)
	{
		parent::__construct('#__processo', 'id', $db);
	}
}
