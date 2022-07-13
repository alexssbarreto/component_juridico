<?php
defined('_JEXEC') or die('Restricted Access');
?>

<div class="span12">
    <h1>Meus Processos</h1>
    <h4 style="color: #9E9E9E"><?php echo $this->name ?></h4>
</div>

<div class="span12">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nº da Ação</th>
                <th>Nome da Ação</th>
                <th>Valor Executado</th>
                <th>Honorários 7%</th>
                <th>Valor Beneficiário</th>
                <th width="20%">Publicado em</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($this->items)) : ?>
                <?php foreach ($this->items as $i => $row) : ?>
                    <tr>
                        <td><?php echo $row->numero_acao; ?></td>
                        <td><?php echo $row->nome_acao; ?></td>
                        <td><?php echo 'R$ ' . number_format($row->valor_executado,2,",","."); ?></td>
                        <td><?php echo 'R$ ' . number_format($row->valor_honorario,2,",","."); ?></td>
                        <td><?php echo 'R$ ' . number_format($row->valor_beneficiario,2,",","."); ?></td>
                        <td><?php echo JHtml::_('date', $row->publicado_em, JText::_('DATE_FORMAT_LC4')); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhum processo</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>