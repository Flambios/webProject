<?php
/**
 * Created by PhpStorm.
 * User: anwar.benihissa
 * Date: 02/01/2019
 * Time: 10:14
 */

namespace App\Form;

use App\Entity\Project;
use App\Entity\Source;
use App\Entity\Target;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Choice;


class SourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('project', EntityType::class, array(
                'class' => Project::class,
                'choice_label' => 'name'
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Source'
        ));
    }
}