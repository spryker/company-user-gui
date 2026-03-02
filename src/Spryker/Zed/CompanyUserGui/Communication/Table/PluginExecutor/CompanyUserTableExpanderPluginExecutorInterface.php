<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyUserGui\Communication\Table\PluginExecutor;

use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

interface CompanyUserTableExpanderPluginExecutorInterface
{
    public function executeConfigExpanderPlugins(TableConfiguration $config): TableConfiguration;

    /**
     * @param array<array> $companyUserDataTableRows
     *
     * @return array<array>
     */
    public function executeBulkDataExpanderPlugins(array $companyUserDataTableRows): array;
}
