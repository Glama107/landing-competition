<?php

namespace App\Form;

use App\Entity\Aircraft;
use App\Entity\Competitor;
use App\Entity\Scoreline;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScorelineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstnote', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ])
            ->add('secondscore', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ])
            ->add('thirdnote', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ])
            ->add('savingnote', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                ],
                'required' => false,
            ])
            ->add('replacingnote', ChoiceType::class, [
                'choices' => [
                    'Première note' => 1,
                    'Deuxième note' => 2,
                    'Troisième note' => 3,
                ],
                'required' => false,
            ])
            ->add('competitor', EntityType::class, [
                'class' => Competitor::class,
                'choice_label' => 'name',
            ])
            ->add('aircraft', EntityType::class, [
                'class' => Aircraft::class,
                'choice_label' => 'registration',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Scoreline::class,
        ]);
    }
}
