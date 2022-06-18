<?php

defined('_JEXEC') or die;

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "processos.cancel")
		{
			window.location.href = "/administrator/index.php?option=com_juridico"
		}

		if (task == "processo.import")
		{
			Joomla.submitform(task, document.getElementById("import-form"));
		}
	};
');
?>

<div class="row-fluid">
    <div class="span8">
        <div class="tree-holder">
            <div class="file" style="padding: 20px">
                <form enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_juridico&view=importacao'); ?>" method="POST" name="adminForm" id="import-form" class="form-validate">
                    <label><strong>Selecione o arquivo para processamento:</strong></label>
                    <input type="file" name="file" accept="text/csv" class="file" required>

                    <input type="hidden" name="task" value="" />
                    <input type="hidden" name="boxchecked" value="0" />
                    <?php echo JHtml::_('form.token'); ?>
                </form>
            </div>
        </div>
    </div>

    <div class="span4">
        <div class="alert page-header">
            <h4 class="card-title">Orientações</h4>

            <ul>
                <li>O arquivo deve estar no formato CSV, separado por (;);</li>
                <li>A sequência das colunas deve estar conforme o modelo abaixo;</li>
                <li>A coluna ativo serve para tornar público o processo para o filiado após a importação (0 para inativo; 1 para ativo).</li>
            </ul>

            <table class="table">
                <tr>
                    <th>CPF</th>
                    <th>AÇÃO</th>
                    <th>VALOR</th>
                    <th>ATIVO</th>
                </tr>
                <tr>
                    <td>11111111111</td>
                    <td>Processo</td>
                    <td>R$ 111,00</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>22222222222</td>
                    <td>Processo</td>
                    <td>R$ 222,00</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>33333333333</td>
                    <td>Processo</td>
                    <td>R$ 111,00</td>
                    <td>1</td>
                </tr>
            </table>
        </div>
    </div>
</div>