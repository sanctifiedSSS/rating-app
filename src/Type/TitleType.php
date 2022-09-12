<?php

namespace App\Type;

use App\Entity\Title;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TitleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Film' => 'Film',
                    'Game' => 'Game',
                    'TV series' => 'TV series',
                    'Anime' => 'Anime'
                ]
            ])
            ->add('year', ChoiceType::class, [
                'choices' => $this->buildYearChoices()
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('cover', FileType::class, [
                'label' => 'Cover (jpg or png file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid jpg or png file',
                    ])
                ]
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Title::class,
        ]);
    }

    private function buildYearChoices()
    {
        $currentYear = date("Y");
        return array_combine(range($currentYear, 1878), range($currentYear, 1878));
    }

}