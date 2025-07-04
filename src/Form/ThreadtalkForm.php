<?php

namespace App\Form;

use App\Entity\Threadtalk;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ThreadtalkForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
           // ->add('created_at', null, ['widget' => 'single_text',])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Create',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Threadtalk::class,
        ]);
    }
}
