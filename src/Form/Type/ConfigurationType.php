<?php
/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusAdyenPlugin\Form\Type;

use BitBag\SyliusAdyenPlugin\Client\AdyenClientInterface;
use BitBag\SyliusAdyenPlugin\Provider\AdyenClientProviderInterface;
use BitBag\SyliusAdyenPlugin\Validator\Constraint\AdyenCredentials;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('environment', ChoiceType::class, [
                'choices' => [
                    'bitbag_sylius_adyen_plugin.ui.test_platform' => AdyenClientInterface::TEST_ENVIRONMENT,
                    'bitbag_sylius_adyen_plugin.ui.live_platform' => AdyenClientInterface::LIVE_ENVIRONMENT,
                ],
                'label' => 'bitbag_sylius_adyen_plugin.ui.platform',
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag_sylius_adyen_plugin.environment.not_blank',
                        'groups' => ['sylius'],
                    ]),
                ],
            ])
            ->add('merchantAccount', TextType::class, [
                'label' => 'bitbag_sylius_adyen_plugin.ui.merchant_account',
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag_sylius_adyen_plugin.merchant_account.not_blank',
                        'groups' => ['sylius'],
                    ]),
                ],
            ])
            ->add('apiKey', CredentialType::class, [
                'label' => 'bitbag_sylius_adyen_plugin.ui.api_key',
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag_sylius_adyen_plugin.api_key.not_blank',
                        'groups' => ['sylius'],
                    ]),
                ],
            ])
            ->add('clientKey', CredentialType::class, [
                'label' => 'bitbag_sylius_adyen_plugin.ui.client_key',
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag_sylius_adyen_plugin.merchant_account.not_blank',
                        'groups' => ['sylius'],
                    ]),
                ],
            ])
            ->add('hmacKey', CredentialType::class, [
                'label' => 'bitbag_sylius_adyen_plugin.ui.hmac_key',
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag_sylius_adyen_plugin.hmac_key.not_blank',
                        'groups' => ['sylius'],
                    ]),
                ],
            ])
            ->add('authUser', CredentialType::class, [
                'label' => 'bitbag_sylius_adyen_plugin.ui.auth_user',
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag_sylius_adyen_plugin.auth_user.not_blank',
                        'groups' => ['sylius'],
                    ]),
                ],
            ])
            ->add('authPassword', CredentialType::class, [
                'label' => 'bitbag_sylius_adyen_plugin.ui.auth_password',
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag_sylius_adyen_plugin.auth_password.not_blank',
                        'groups' => ['sylius'],
                    ]),
                ],
            ])
            ->add(AdyenClientProviderInterface::FACTORY_NAME, HiddenType::class, [
                'data' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('constraints', [
            new AdyenCredentials([
                'groups' => ['sylius'],
            ]),
        ]);
    }
}
