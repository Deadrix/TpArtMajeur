<?php

namespace App\Form;

use App\Entity\Internaute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'oninvalid' => 'this.setCustomValidity("Veuillez saisir un nom.")',
                    'oninput' => 'this.setCustomValidity("")'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'oninvalid' => 'this.setCustomValidity("Veuillez saisir un email.")',
                    'oninput' => 'this.setCustomValidity("")'
                ]
            ])
            ->add('question', TextareaType::class, [
                'label' => 'Question',
                'mapped' => false,
                'attr' => [
                    'oninvalid' => 'this.setCustomValidity("Veuillez saisir votre demande.")',
                    'oninput' => 'this.setCustomValidity("")'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Internaute::class,
        ]);
    }
}
