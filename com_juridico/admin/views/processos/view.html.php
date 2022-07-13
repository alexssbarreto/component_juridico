<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Juridico View
 *
 * @since 0.0.1
 */
class JuridicoViewProcessos extends JViewLegacy
{

    /**
     * An array of items
     *
     * @var array
     */
    protected $items;

    /**
     * The pagination object
     *
     * @var JPagination
     */
    protected $pagination;

    /**
     * The model state
     *
     * @var object
     */
    protected $state;

    /**
     * Form object for search filters
     *
     * @var JForm
     */
    public $filterForm;

    /**
     * The active search filters
     *
     * @var array
     */
    public $activeFilters;

    /**
     * The sidebar markup
     *
     * @var string
     */
    protected $sidebar;

    /**
     * Display the Hello World view
     *
     * @param string $tpl
     *            The name of the template file to parse; automatically searches through the template paths.
     *            
     * @return void
     */
    function display($tpl = null)
    {
        JuridicoHelper::addSubmenu('juridico');

        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }

        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();

        return parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return void
     *
     * @since 1.6
     */
    protected function addToolbar()
    {
        JToolbarHelper::title('Processos Jurídicos', 'stack article');
        JToolbarHelper::publish('processos.publish', 'JTOOLBAR_PUBLISH', true);
        JToolbarHelper::unpublish('processos.unpublish', 'JTOOLBAR_UNPUBLISH', true);
    }
}
