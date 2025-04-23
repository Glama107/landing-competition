<?php

namespace App\Form;

use App\Entity\Aircraft;
use App\Entity\Competitor;
use App\Entity\Judge;
use App\Entity\Scoreline;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScorelineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstnote', ChoiceType::class, [
                'choices' => [
                    'Zone +3' => 300,
                    'Zone +2' => 200,
                    'Zone +1' => 50,
                    'Zone 0' => 0,
                    'Zone -1' => 100,
                    'Zone -2' => 300,
                    'Zone -3' => 500,
                    'Approche interrompue' => 250
                ],
            ])
            ->add('secondscore', ChoiceType::class, [
                'choices' => [
                    'Zone +3' => 300,
                    'Zone +2' => 200,
                    'Zone +1' => 50,
                    'Zone 0' => 0,
                    'Zone -1' => 100,
                    'Zone -2' => 300,
                    'Zone -3' => 500,
                    'Approche interrompue' => 250,
                ],
            ])
            ->add('thirdnote', ChoiceType::class, [
                'choices' => [
                    'Zone +3' => 300,
                    'Zone +2' => 200,
                    'Zone +1' => 50,
                    'Zone 0' => 0,
                    'Zone -1' => 100,
                    'Zone -2' => 300,
                    'Zone -3' => 500,
                    'Approche interrompue' => 250
                ],
            ])
            ->add('savingnote', ChoiceType::class, [
                'choices' => [
                    'Zone +3' => 300,
                    'Zone +2' => 200,
                    'Zone +1' => 50,
                    'Zone 0' => 0,
                    'Zone -1' => 100,
                    'Zone -2' => 300,
                    'Zone -3' => 500,
                    'Approche interrompue' => 250
                ],
                'required' => false,
            ])
            ->add('timeOfPassage', TimeType::class, [])
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
            ->add('judge', EntityType::class, [
                'class' => Judge::class,
                'choice_label' => 'name',
            ])
            ->add('isFlapsUsed', CheckboxType::class, [
                'required' => false,
                'label' => 'Flaps utilisés',
            ])
            ->add('isFlapsUsedReplacing', CheckboxType::class, [
                'required' => false,
                'label' => 'Flaps utilisés (2ème note uniquement)',
            ])
            ->add('comments', TextareaType::class, [
                'required' => false,
                'label' => 'Commentaires',
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Ex: David a fait un appontage...',
                    'maxlength' => 255,
                ],
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
