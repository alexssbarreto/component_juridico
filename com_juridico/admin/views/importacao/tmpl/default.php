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
    <div class="span12">
        <div class="tree-holder">
            <div class="file" style="padding: 20px">
                <form enctype="multipart/form-data"
                      action="<?php echo JRoute::_('index.php?option=com_juridico&view=importacao'); ?>" method="POST"
                      name="adminForm" id="import-form" class="form-validate">
                    <label><strong>Selecione o arquivo para processamento:</strong></label>
                    <input type="file" name="file" accept="text/csv" class="file" required>

                    <input type="hidden" name="task" value=""/>
                    <input type="hidden" name="boxchecked" value="0"/>
                    <?php echo JHtml::_('form.token'); ?>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="alert page-header">
            <h4 class="card-title">Orientações</h4>

            <ul>
                <li>O arquivo deve estar no formato CSV, separado por (;);</li>
                <li>A sequência das colunas deve estar conforme o modelo abaixo;</li>
            </ul>

            <table class="table">
                <tr>
                    <th>CPF</th>
                    <th>NÚMERO DA AÇÃO</th>
                    <th>NOME DA AÇÃO</th>
                    <th>VALOR EXECUTADO</th>
                    <th>HONORÁRIOS</th>
                    <th>VALOR BENEFICIÁRIO</th>
                </tr>
                <tr>
                    <td>11111111111</td>
                    <td>0000000-00.0000.0.00.0000</td>
                    <td>LICENÇA PRÊMIO</td>
                    <td>R$ 000.000,00</td>
                    <td>R$ 000.000,00</td>
                    <td>R$ 000.000,00</td>
                </tr>
                <tr>
                    <td>22222222222</td>
                    <td>0000000-00.0000.0.00.0000</td>
                    <td>LICENÇA PRÊMIO</td>
                    <td>R$ 000.000,00</td>
                    <td>R$ 000.000,00</td>
                    <td>R$ 000.000,00</td>
                </tr>
                <tr>
                    <td>33333333333</td>
                    <td>0000000-00.0000.0.00.0000</td>
                    <td>LICENÇA PRÊMIO</td>
                    <td>R$ 000.000,00</td>
                    <td>R$ 000.000,00</td>
                    <td>R$ 000.000,00</td>
                </tr>
            </table>
        </div>
    </div>
</div>