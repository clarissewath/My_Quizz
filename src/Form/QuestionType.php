<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', TextType::class, [
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '100',
                ],
                'label' => 'Ajouter une question : ',
                'constraints' => [
                    new Length(['min' => '2', 'max' => '100']),
                    new NotBlank([
                        'message' => 'Vous devez ajouter une question',
                    ])
                ]
            ])
            ->add('id_categorie', IntegerType::class, [
                'label' => 'Ajouter a une catégorie : 1 pour... 2 pour ... 3 pour ... etc ',
                'required'   => true,
            ])
            // ->add('submit', SubmitType::class, [
            //     'label' => 'Créer'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
