<?php
defined('_JEXEC') or die('Restricted Access');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));

$saveOrder = $listOrder == 'a.ordering';

if ($saveOrder) {
    JHtml::_('sortablelist.sortable', 'processoList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>

<form action="<?php echo JRoute::_('index.php?option=com_juridico'); ?>" method="post" name="adminForm" id="adminForm">
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>

    <div id="j-main-container" class="span10">
        <?php
            // Search tools bar
            echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
        ?>

        <div class="clearfix"></div>

        <?php if (empty($this->items)) : ?>
            <div class="alert alert-no-items">
                <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
            </div>
        <?php else : ?>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="1%" class="center">
                            <?php echo JHtml::_('grid.checkall'); ?>
						</th>
                        <th width="1%" class="nowrap center hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'Id', 'a.id', $listDirn, $listOrder); ?>
                        </th>
                        <th width="25%"><?php echo JHtml::_('searchtools.sort', 'CPF', 'a.cpf', 'a.cpf', null); ?></th>
                        <th><?php echo JHtml::_('searchtools.sort', 'Ação', 'a.processo', $listDirn, $listOrder); ?></th>
                        <th><?php echo JHtml::_('searchtools.sort', 'Valor', 'a.valor', $listDirn, $listOrder); ?></th>
                        <th width="20%"><?php echo JHtml::_('searchtools.sort', 'Publicado em', 'a.publicado_em', $listDirn, $listOrder); ?></th>
                        <th width="5%"><?php echo JHtml::_('searchtools.sort', 'Ativo', 'a.ativo', $listDirn, $listOrder); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($this->items)) : ?>
                        <?php foreach ($this->items as $i => $row) : ?>
                            <tr>
                                <td class="center">
                                    <?php echo JHtml::_('grid.id', $i, $row->id); ?>
                                </td>
                                <td><?php echo $row->id; ?></td>
                                <td><?php echo $row->cpf; ?></td>
                                <td><?php echo $row->processo; ?></td>
                                <td><?php echo 'R$ ' . number_format($row->valor,2,",","."); ?></td>
                                <td align="center"><?php echo JHtml::_('date', $row->publicado_em, JText::_('DATE_FORMAT_LC4')); ?></td>
                                <td align="center">
                                    <?php if ($row->ativo): ?>
                                    <span class="badge badge-info">Sim</span>
                                    <?php else: ?>
                                        <span class="badge">Não</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>

        <?php endif; ?>
    </div>
</form>