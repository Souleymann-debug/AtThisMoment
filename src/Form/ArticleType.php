<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('contenu')
            ->add('image')
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
            ->add('datePoste')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
