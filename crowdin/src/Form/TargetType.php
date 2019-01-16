<?php
/**
 * Created by PhpStorm.
 * User: anwar.benihissa
 * Date: 02/01/2019
 * Time: 10:14
 */

namespace App\Form;

use App\Entity\Target;
use phpDocumentor\Reflection\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TargetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Target'
        ));
    }
}