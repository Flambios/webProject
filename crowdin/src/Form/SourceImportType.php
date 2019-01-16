<?php
/**
 * Created by PhpStorm.
 * User: anwar.benihissa
 * Date: 02/01/2019
 * Time: 10:14
 */

namespace App\Form;

use App\Entity\Source;
use App\Entity\Target;
use phpDocumentor\Reflection\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class SourceImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',FileType::class, array('label' => 'Source (csv file)'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Source'
        ));
    }
}