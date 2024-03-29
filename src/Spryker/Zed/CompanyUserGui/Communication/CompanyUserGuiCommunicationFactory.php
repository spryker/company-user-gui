<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyUserGui\Communication;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\CompanyUserGui\Communication\ButtonCreator\CompanyUserGuiButtonCreator;
use Spryker\Zed\CompanyUserGui\Communication\ButtonCreator\CompanyUserGuiButtonCreatorInterface;
use Spryker\Zed\CompanyUserGui\Communication\Form\CompanyUserEditForm;
use Spryker\Zed\CompanyUserGui\Communication\Form\CompanyUserForm;
use Spryker\Zed\CompanyUserGui\Communication\Form\CustomerCompanyAttachForm;
use Spryker\Zed\CompanyUserGui\Communication\Form\DataProvider\CompanyUserFormDataProvider;
use Spryker\Zed\CompanyUserGui\Communication\Form\DataProvider\CustomerCompanyAttachFormDataProvider;
use Spryker\Zed\CompanyUserGui\Communication\Form\DeleteCompanyUserForm;
use Spryker\Zed\CompanyUserGui\Communication\Form\DisableCompanyUserForm;
use Spryker\Zed\CompanyUserGui\Communication\Form\EnableCompanyUserForm;
use Spryker\Zed\CompanyUserGui\Communication\Table\CompanyUserTable;
use Spryker\Zed\CompanyUserGui\Communication\Table\PluginExecutor\CompanyUserTableExpanderPluginExecutor;
use Spryker\Zed\CompanyUserGui\Communication\Table\PluginExecutor\CompanyUserTableExpanderPluginExecutorInterface;
use Spryker\Zed\CompanyUserGui\CompanyUserGuiDependencyProvider;
use Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyFacadeInterface;
use Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyUserFacadeInterface;
use Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCustomerFacadeInterface;
use Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableDeleteActionPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Spryker\Zed\CompanyUserGui\CompanyUserGuiConfig getConfig()
 */
class CompanyUserGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer|null $data
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getCompanyUserForm(?CompanyUserTransfer $data = null, array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(CompanyUserForm::class, $data, $options);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer|null $data
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getCompanyUserEditForm(?CompanyUserTransfer $data = null, array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(CompanyUserEditForm::class, $data, $options);
    }

    /**
     * @return \Spryker\Zed\CompanyUserGui\Communication\Form\DataProvider\CompanyUserFormDataProvider
     */
    public function createCompanyUserFormDataProvider(): CompanyUserFormDataProvider
    {
        return new CompanyUserFormDataProvider(
            $this->getCompanyUserFacade(),
            $this->getCompanyFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\CompanyUserGui\Communication\ButtonCreator\CompanyUserGuiButtonCreatorInterface
     */
    public function createCompanyUserGuiButtonCreator(): CompanyUserGuiButtonCreatorInterface
    {
        return new CompanyUserGuiButtonCreator();
    }

    /**
     * @return \Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyUserFacadeInterface
     */
    public function getCompanyUserFacade(): CompanyUserGuiToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserGuiDependencyProvider::FACADE_COMPANY_USER);
    }

    /**
     * @return \Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyFacadeInterface
     */
    public function getCompanyFacade(): CompanyUserGuiToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserGuiDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \Spryker\Zed\CompanyUserGui\Communication\Form\DataProvider\CustomerCompanyAttachFormDataProvider
     */
    public function createCustomerCompanyAttachFormDataProvider(): CustomerCompanyAttachFormDataProvider
    {
        return new CustomerCompanyAttachFormDataProvider(
            $this->getCompanyUserFacade(),
            $this->getCompanyFacade(),
            $this->getCustomerFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCustomerFacadeInterface
     */
    public function getCustomerFacade(): CompanyUserGuiToCustomerFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserGuiDependencyProvider::FACADE_CUSTOMER);
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserFormExpanderPluginInterface>
     */
    public function getCompanyUserFormPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUserGuiDependencyProvider::PLUGINS_COMPANY_USER_FORM_EXPANDER);
    }

    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserPropelQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CompanyUserGuiDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }

    /**
     * @return \Spryker\Zed\CompanyUserGui\Communication\Table\PluginExecutor\CompanyUserTableExpanderPluginExecutorInterface
     */
    public function createCompanyUserTableExpanderPluginExecutor(): CompanyUserTableExpanderPluginExecutorInterface
    {
        return new CompanyUserTableExpanderPluginExecutor(
            $this->getCompanyUserTableConfigExpanderPlugins(),
            $this->getCompanyUserTablePrepareDataExpanderPlugins(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer|null $data
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getCustomerCompanyAttachForm(?CompanyUserTransfer $data = null, array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(CustomerCompanyAttachForm::class, $data, $options);
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserAttachCustomerFormExpanderPluginInterface>
     */
    public function getCompanyUserAttachCustomerFormExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUserGuiDependencyProvider::PLUGINS_COMPANY_USER_ATTACH_CUSTOMER_FORM_EXPANDER);
    }

    /**
     * @return \Spryker\Zed\CompanyUserGui\Communication\Table\CompanyUserTable
     */
    public function createCompanyUserTable(): CompanyUserTable
    {
        return new CompanyUserTable(
            $this->getCompanyUserPropelQuery(),
            $this->createCompanyUserTableExpanderPluginExecutor(),
            $this->getCompanyUserTableActionExpanderPlugins(),
            $this->getCompanyUserTableDeleteActionPlugin(),
        );
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createEnableCompanyUserForm(): FormInterface
    {
        return $this->getFormFactory()->create(EnableCompanyUserForm::class);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createDisableCompanyUserForm(): FormInterface
    {
        return $this->getFormFactory()->create(DisableCompanyUserForm::class);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createDeleteCompanyUserForm(): FormInterface
    {
        return $this->getFormFactory()->create(DeleteCompanyUserForm::class);
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableConfigExpanderPluginInterface>
     */
    public function getCompanyUserTableConfigExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUserGuiDependencyProvider::PLUGINS_COMPANY_USER_TABLE_CONFIG_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTablePrepareDataExpanderPluginInterface>
     */
    public function getCompanyUserTablePrepareDataExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUserGuiDependencyProvider::PLUGINS_COMPANY_USER_TABLE_PREPARE_DATA_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableActionExpanderPluginInterface>
     */
    public function getCompanyUserTableActionExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUserGuiDependencyProvider::PLUGINS_COMPANY_USER_TABLE_ACTION_EXPANDER);
    }

    /**
     * @return \Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableDeleteActionPluginInterface|null
     */
    public function getCompanyUserTableDeleteActionPlugin(): ?CompanyUserTableDeleteActionPluginInterface
    {
        return $this->getProvidedDependency(CompanyUserGuiDependencyProvider::PLUGIN_COMPANY_USER_TABLE_DELETE_ACTION);
    }
}
