<?php

namespace App\Form;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class TaskType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, ['label' => 'Nom'])
        ->add('description', TextareaType::class, ['label' => 'Description',
        'required'=>false])

        ->add('dueDate', DateTimeType::class, [
            'label' => "Date d'échéance",
            'required' =>false,
            'widget' =>'single_text',
            'html5' => false,
            'format' => 'MM/dd/yyyy hh:mm a',
            'attr' => [
                'class' => 'form-control input-inline 
                 datetimepicker'
        ]
        ])

        ->add('reminder', NumberType::class, ['label'=>'Rappel (en minutes)',
        'required' =>false])

        ->add('save', SubmitType::class);
    }
}