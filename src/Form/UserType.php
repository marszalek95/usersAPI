<?php
// src/Form/UserType.php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'male' => 'male',
                    'female' => 'female',
                ]
            ])
            ->add('born', BirthdayType::class)
            ->add('email', EmailType::class)
            ->add('phone', TelType::class)
            ->add('website', TelType::class)
            ->add('address', TextType::class)
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'active' => 'active',
                    'unactive' => 'unactive',
                ]
            ])
            ->add('avatarUrl', UrlType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}