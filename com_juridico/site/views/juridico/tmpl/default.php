<?php
defined('_JEXEC') or die('Restricted Access');
?>

<style>
    @media
    only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {

        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr { border: 1px solid #ccc; }

        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
            text-align: right;
        }

        td:before {
            /* Now like a table header */
            position: absolute;
            text-align: left;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }

        /*
        Label the data
        */
        td:nth-of-type(1):before { content: "Nº da Ação"; }
        td:nth-of-type(2):before { content: "Nome da Ação"; }
        td:nth-of-type(3):before { content: "Valor executado"; }
        td:nth-of-type(4):before { content: "Honorário 7%"; }
        td:nth-of-type(5):before { content: "Valor Beneficiário"; }
</style>

<div class="span12">
    <h1>Meus Cálculos</h1>
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
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($this->items)) : ?>
            <?php foreach ($this->items as $i => $row) : ?>
                <tr>
                    <td><?php echo $row->numero_acao; ?></td>
                    <td><?php echo $row->nome_acao; ?></td>
                    <td><?php echo 'R$ ' . number_format($row->valor_executado, 2, ",", "."); ?></td>
                    <td><?php echo 'R$ ' . number_format($row->valor_honorario, 2, ",", "."); ?></td>
                    <td><?php echo 'R$ ' . number_format($row->valor_beneficiario, 2, ",", "."); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Não há cálculos disponíveis.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>