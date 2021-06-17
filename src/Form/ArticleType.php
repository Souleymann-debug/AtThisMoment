<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('contenu')
            ->add('image',FileType::class,[
                'label' => 'Image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez importer un fichier JPG ou PNG',
                    ])
                ],
            ])
            ->add('rubrique',ChoiceType::class, array(
                'label' => 'Rubrique', 
                'choices' => array (
                    'World' => 'World', 
                    'U.S' => 'U.S',
                    'Design' => 'Design', 
                    'Culture' => 'Culture', 
                    'Technologie' => 'Technologie', 
                    'Business' => 'Business', 
                    'Politics' => 'Politics', 
                    'Opinion' => 'Opinion', 
                    'Science' => 'Science', 
                    'Health' => 'Health', 
                    'Travel' => 'Travel', 
                    'Style' => 'Style', 
                )
            ))
            ->add('valide')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
