<?php

defined('_JEXEC') or die;

class JuridicoHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			'Processos',
			'index.php?option=com_juridico',
			// $vName == 'juridico'
		);

		JHtmlSidebar::addEntry(
			'Importação',
			'index.php?option=com_juridico&view=importacao',
			// $vName == 'importacao'
		);
	}
}
