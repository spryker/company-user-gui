<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyUserGui\Communication\Form;

use DateTime;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @see \Spryker\Zed\Customer\Communication\CustomerForm original customer form
 *
 * @method \Spryker\Zed\CompanyUserGui\Communication\CompanyUserGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\CompanyUserGui\CompanyUserGuiConfig getConfig()
 */
class CompanyUserCustomerForm extends AbstractType
{
    /**
     * @var string
     */
    public const OPTION_SALUTATION_CHOICES = 'salutation_choices';

    /**
     * @var string
     */
    public const OPTION_GENDER_CHOICES = 'gender_choices';

    /**
     * @var string
     */
    public const FIELD_EMAIL = 'email';

    /**
     * @var string
     */
    public const FIELD_SALUTATION = 'salutation';

    /**
     * @var string
     */
    public const FIELD_FIRST_NAME = 'first_name';

    /**
     * @var string
     */
    public const FIELD_LAST_NAME = 'last_name';

    /**
     * @var string
     */
    public const FIELD_GENDER = 'gender';

    /**
     * @var string
     */
    public const FIELD_SEND_PASSWORD_TOKEN = 'send_password_token';

    /**
     * @var string
     */
    public const FIELD_ID_CUSTOMER = 'id_customer';

    /**
     * @var string
     */
    public const FIELD_COMPANY = 'company';

    /**
     * @var string
     */
    public const FIELD_PHONE = 'phone';

    /**
     * @var string
     */
    public const FIELD_DATE_OF_BIRTH = 'date_of_birth';

    /**
     * @var string
     */
    protected const PATTERN_FIRST_NAME = '/^[^:\/<>]+$/';

    /**
     * @var string
     */
    protected const PATTERN_LAST_NAME = '/^[^:\/<>]+$/';

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'customer';
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined(static::OPTION_SALUTATION_CHOICES);
        $resolver->setDefined(static::OPTION_GENDER_CHOICES);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this
            ->addIdCustomerField($builder)
            ->addEmailField($builder)
            ->addSalutationField($builder, $options[static::OPTION_SALUTATION_CHOICES])
            ->addFirstNameField($builder)
            ->addLastNameField($builder)
            ->addGenderField($builder, $options[static::OPTION_GENDER_CHOICES])
            ->addSendPasswordField($builder)
            ->addDateOfBirthField($builder)
            ->addPhoneField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdCustomerField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_ID_CUSTOMER, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addEmailField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_EMAIL, EmailType::class, [
            'label' => 'Email',
            'constraints' => $this->createEmailConstraints(),
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return $this
     */
    protected function addSalutationField(FormBuilderInterface $builder, array $choices)
    {
        $builder->add(static::FIELD_SALUTATION, ChoiceType::class, [
            'label' => 'Salutation',
            'placeholder' => 'Select one',
            'choices' => $choices,
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addFirstNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_FIRST_NAME, TextType::class, [
            'label' => 'First Name',
            'constraints' => [
                $this->createNotBlankConstraint(),
                $this->createLengthConstraint(),
                $this->createFirstNameRegexConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addLastNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_LAST_NAME, TextType::class, [
            'label' => 'Last Name',
            'constraints' => [
                $this->createNotBlankConstraint(),
                $this->createLengthConstraint(),
                $this->createLastNameRegexConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return $this
     */
    protected function addGenderField(FormBuilderInterface $builder, array $choices)
    {
        $builder->add(static::FIELD_GENDER, ChoiceType::class, [
            'label' => 'Gender',
            'placeholder' => 'Select one',
            'choices' => $choices,
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addSendPasswordField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_SEND_PASSWORD_TOKEN, CheckboxType::class, [
            'label' => 'Send password token through email',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addPhoneField(FormBuilderInterface $builder)
    {
        $phoneConstraints = [
            new Length(['max' => 255]),
        ];

        $builder->add(static::FIELD_PHONE, TextType::class, [
            'label' => 'Phone',
            'required' => false,
            'constraints' => $phoneConstraints,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDateOfBirthField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_DATE_OF_BIRTH, DateType::class, [
            'label' => 'Date of birth',
            'widget' => 'single_text',
            'required' => false,
            'attr' => [
                'class' => 'datepicker safe-datetime',
            ],
        ]);

        $builder->get(static::FIELD_DATE_OF_BIRTH)
            ->addModelTransformer($this->createDateTimeModelTransformer());

        return $this;
    }

    /**
     * @return array
     */
    protected function createEmailConstraints(): array
    {
        $emailConstraints = [
            new NotBlank(),
            new Email(),
        ];

        $customerFacade = $this->getFactory()->getCustomerFacade();

        $emailConstraints[] = new Callback([
            'callback' => function ($email, ExecutionContextInterface $context) use ($customerFacade) {
                if ($customerFacade->hasEmail($email)) {
                    $context->addViolation('Email is already used');
                }
            },
        ]);

        return $emailConstraints;
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\NotBlank
     */
    protected function createNotBlankConstraint(): NotBlank
    {
        return new NotBlank();
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\Length
     */
    protected function createLengthConstraint(): Length
    {
        return new Length(['max' => 100]);
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\Regex
     */
    protected function createFirstNameRegexConstraint(): Regex
    {
        return new Regex([
            'pattern' => static::PATTERN_FIRST_NAME,
        ]);
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\Regex
     */
    protected function createLastNameRegexConstraint(): Regex
    {
        return new Regex([
            'pattern' => static::PATTERN_LAST_NAME,
        ]);
    }

    /**
     * @return \Symfony\Component\Form\CallbackTransformer
     */
    protected function createDateTimeModelTransformer(): CallbackTransformer
    {
        return new CallbackTransformer(
            function ($dateAsString) {
                if ($dateAsString !== null) {
                    return new DateTime($dateAsString);
                }
            },
            function ($dateAsObject) {
                return $dateAsObject;
            },
        );
    }
}
