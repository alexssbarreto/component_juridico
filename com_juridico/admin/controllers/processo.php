<?php

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

class JuridicoControllerProcesso extends JControllerAdmin
{

	private $processos = [];

	/**
	 * Process file import with process
	 */
	public function import()
	{
		$this->checkToken();

		try {
			$this->validateImport();
			$this->registerItem();

			$this->setMessage(sprintf("%s processos importados com sucesso.", count($this->processos)));
			return $this->setRedirect(\JRoute::_('index.php?option=com_juridico&view=importacao', false));
		} catch (Exception $e) {
			$this->setMessage($e->getMessage(), $e->getCode() == 0 ? 'Error' : 'Warning');
			return $this->setRedirect(\JRoute::_('index.php?option=com_juridico&view=importacao&layout=processamento', false));
		}
	}

	/**
	 * Open file CSV
	 */
	private function file()
	{
		if (count($this->processos)) {
			return;
		}

		$file = $_FILES['file'];

		if (!$file || $file['error'] != UPLOAD_ERR_OK) {
			throw new Exception('Obrigatório informar um documento no formato CSV, separado por `ponto e vírgula` (;).');
		}

		if (!$file || $file['type'] != 'text/csv') {
			return false;
		}

		$handler = fopen($file['tmp_name'], "r");

		$i = 0;
		while (($data = fgetcsv($handler, 0, ";")) !== FALSE) {
			if ($i != 0) {
				$data[0] = preg_replace( '/[^0-9]/', '', $data[0]);
				$data[0] = str_pad($data[0], 11, '0', STR_PAD_LEFT);
			}

			$this->processos[] = $data;
			$i++;
		}

		fclose($handler);

		unset($this->processos[0]);
	}

	/**
	 * Check all validates for import
	 */
	private function validateImport()
	{
		$this->file();

		if (!count($this->processos)) {
			throw new Exception('Nenhum registro a ser processado.', 400);
		}

		$this->validateTotalColumns();
		$this->validateItemColumns();
	}

	/**
	 * Register item process
	 */
	private function registerItem()
	{
		$model = $this->getModel();

		foreach ($this->processos as $processo) {
			$model->syncronize($processo);
		}
	}

	/**
	 * Validate count columns
	 */
	private function validateTotalColumns()
	{
		if (count($this->processos[1]) != 4) {
			throw new Exception('Colunas do arquivo inválido. O arquivo deve conter 4 colunas [CPF; PROCESSO; VALOR, ATIVO]');
		}
	}

	/**
	 * Validate item to column
	 */
	private function validateItemColumns()
	{
		$model = $this->getModel();

		unset($this->processos[0]);
		$errors = [];

		foreach ($this->processos as $key => $processo) {
			$index = $key + 1;

			if (empty($processo[0])) {
				$errors[] = sprintf("Linha: %s, coluna: CPF não preenchida.", $index);
			}
			if (empty($processo[1])) {
				$errors[] = sprintf("Linha: %s, coluna: PROCESSO não preenchida.", $index);
			}
			if (empty($processo[2])) {
				$errors[] = sprintf("Linha: %s, coluna: VALOR não preenchida.", $index);
			}
			if (!$model->hasUsuario($processo[0])) {
				$errors[] = sprintf("Linha: %s, coluna: CPF: %s não está cadastrado no site, veja com o Administrativo.", $index, $processo[0]);
			}
		}

		if (!empty($errors)) {
			$message = '<ul><li>';
			$message .= implode('</li><li>', $errors);
			$message .= '</li></ul>';

			throw new Exception($message, 400);
		}
	}

	public function getModel($name = 'Processos', $prefix = 'JuridicoModel', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }
}
