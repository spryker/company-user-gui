<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyUserGui;

use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyFacadeBridge;
use Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyUserFacadeBridge;
use Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCustomerFacadeBridge;
use Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableDeleteActionPluginInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\CompanyUserGui\CompanyUserGuiConfig getConfig()
 */
class CompanyUserGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_COMPANY_USER = 'FACADE_COMPANY_USER';

    /**
     * @var string
     */
    public const FACADE_COMPANY = 'FACADE_COMPANY';

    /**
     * @var string
     */
    public const FACADE_COMPANY_ROLE = 'FACADE_COMPANY_ROLE';

    /**
     * @var string
     */
    public const FACADE_CUSTOMER = 'FACADE_CUSTOMER';

    /**
     * @var string
     */
    public const PROPEL_QUERY_COMPANY_USER = 'PROPEL_QUERY_COMPANY_USER';

    /**
     * @var string
     */
    public const PLUGINS_COMPANY_USER_TABLE_CONFIG_EXPANDER = 'PLUGINS_COMPANY_USER_TABLE_CONFIG_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_COMPANY_USER_TABLE_PREPARE_DATA_EXPANDER = 'PLUGINS_COMPANY_USER_TABLE_PREPARE_DATA_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_COMPANY_USER_FORM_EXPANDER = 'PLUGINS_COMPANY_USER_FORM_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_COMPANY_USER_ATTACH_CUSTOMER_FORM_EXPANDER = 'PLUGINS_COMPANY_USER_ATTACH_CUSTOMER_FORM_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_COMPANY_USER_TABLE_ACTION_EXPANDER = 'PLUGINS_COMPANY_USER_TABLE_ACTION_EXPANDER';

    /**
     * @var string
     */
    public const PLUGIN_COMPANY_USER_TABLE_DELETE_ACTION = 'PLUGIN_COMPANY_USER_TABLE_DELETE_ACTION';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addCompanyUserFacade($container);
        $container = $this->addCompanyFacade($container);
        $container = $this->addCustomerFacade($container);
        $container = $this->addCompanyUserPropelQuery($container);
        $container = $this->addCompanyUserTableConfigExpanderPlugins($container);
        $container = $this->addCompanyUserTablePrepareDataExpanderPlugins($container);
        $container = $this->addCompanyUserFormExpanderPlugins($container);
        $container = $this->addCompanyUserAttachCustomerFormExpanderPlugins($container);
        $container = $this->addCompanyUserTableActionExpanderPlugins($container);
        $container = $this->addCompanyUserTableDeleteActionPlugin($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserFacade(Container $container): Container
    {
        $container->set(static::FACADE_COMPANY_USER, function (Container $container) {
            return new CompanyUserGuiToCompanyUserFacadeBridge(
                $container->getLocator()->companyUser()->facade(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyFacade(Container $container): Container
    {
        $container->set(static::FACADE_COMPANY, function (Container $container) {
            return new CompanyUserGuiToCompanyFacadeBridge(
                $container->getLocator()->company()->facade(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerFacade(Container $container): Container
    {
        $container->set(static::FACADE_CUSTOMER, function (Container $container) {
            return new CompanyUserGuiToCustomerFacadeBridge(
                $container->getLocator()->customer()->facade(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserFormExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_COMPANY_USER_FORM_EXPANDER, function (Container $container) {
            return $this->getCompanyUserFormExpanderPlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserPropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_COMPANY_USER, $container->factory(function () {
            return SpyCompanyUserQuery::create();
        }));

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserTableConfigExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_COMPANY_USER_TABLE_CONFIG_EXPANDER, function (Container $container) {
            return $this->getCompanyUserTableConfigExpanderPlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserAttachCustomerFormExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_COMPANY_USER_ATTACH_CUSTOMER_FORM_EXPANDER, function (Container $container) {
            return $this->getCompanyUserAttachCustomerFormExpanderPlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserTablePrepareDataExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_COMPANY_USER_TABLE_PREPARE_DATA_EXPANDER, function (Container $container) {
            return $this->getCompanyUserTablePrepareDataExpanderPlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserTableActionExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_COMPANY_USER_TABLE_ACTION_EXPANDER, function (Container $container) {
            return $this->getCompanyUserTableActionExpanderPlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserTableDeleteActionPlugin(Container $container): Container
    {
        $container->set(static::PLUGIN_COMPANY_USER_TABLE_DELETE_ACTION, function (Container $container) {
            return $this->getCompanyUserTableDeleteActionPlugin();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableConfigExpanderPluginInterface>
     */
    protected function getCompanyUserTableConfigExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTablePrepareDataExpanderPluginInterface>
     */
    protected function getCompanyUserTablePrepareDataExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserFormExpanderPluginInterface>
     */
    protected function getCompanyUserFormExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserAttachCustomerFormExpanderPluginInterface>
     */
    protected function getCompanyUserAttachCustomerFormExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableActionExpanderPluginInterface>
     */
    protected function getCompanyUserTableActionExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @return \Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableDeleteActionPluginInterface|null
     */
    protected function getCompanyUserTableDeleteActionPlugin(): ?CompanyUserTableDeleteActionPluginInterface
    {
        return null;
    }
}
