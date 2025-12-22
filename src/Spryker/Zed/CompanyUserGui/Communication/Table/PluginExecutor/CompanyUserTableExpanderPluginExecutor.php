<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyUserGui\Communication\Table\PluginExecutor;

use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class CompanyUserTableExpanderPluginExecutor implements CompanyUserTableExpanderPluginExecutorInterface
{
    /**
     * @var array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableConfigExpanderPluginInterface>
     */
    protected $companyUserTableConfigExpanderPlugins;

    /**
     * @var array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTablePrepareDataExpanderPluginInterface>
     */
    protected $companyUserTablePrepareDataExpanderPlugins;

    /**
     * @param array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableConfigExpanderPluginInterface> $companyUserTableConfigExpanderPlugins
     * @param array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTablePrepareDataExpanderPluginInterface> $companyUserTablePrepareDataExpanderPlugins
     * @param array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableBulkDataExpanderPluginInterface> $companyUserTableBulkDataExpanderPlugins
     */
    public function __construct(
        array $companyUserTableConfigExpanderPlugins,
        array $companyUserTablePrepareDataExpanderPlugins,
        protected array $companyUserTableBulkDataExpanderPlugins
    ) {
        $this->companyUserTableConfigExpanderPlugins = $companyUserTableConfigExpanderPlugins;
        $this->companyUserTablePrepareDataExpanderPlugins = $companyUserTablePrepareDataExpanderPlugins;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    public function executeConfigExpanderPlugins(TableConfiguration $config): TableConfiguration
    {
        foreach ($this->companyUserTableConfigExpanderPlugins as $companyUserTableConfigExpanderPlugin) {
            $config = $companyUserTableConfigExpanderPlugin->expandConfig($config);
        }

        return $config;
    }

    /**
     * @param array<array> $companyUserDataTableRows
     *
     * @return array<array>
     */
    public function executeBulkDataExpanderPlugins(array $companyUserDataTableRows): array
    {
        foreach ($companyUserDataTableRows as &$companyUserDataTableRow) {
            $companyUserDataTableRow = $this->executePrepareDataExpanderPlugins($companyUserDataTableRow);
        }

        foreach ($this->companyUserTableBulkDataExpanderPlugins as $companyUserTableBulkDataExpanderPlugin) {
            $companyUserDataTableRows = $companyUserTableBulkDataExpanderPlugin->expandData($companyUserDataTableRows);
        }

        return $companyUserDataTableRows;
    }

    /**
     * @param array $companyUserDataItem
     *
     * @return array
     */
    protected function executePrepareDataExpanderPlugins(array $companyUserDataItem): array
    {
        foreach ($this->companyUserTablePrepareDataExpanderPlugins as $companyUserTablePrepareDataExpanderPlugin) {
            $companyUserDataItem = $companyUserTablePrepareDataExpanderPlugin->expandDataItem($companyUserDataItem);
        }

        return $companyUserDataItem;
    }
}
