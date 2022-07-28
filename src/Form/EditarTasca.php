<?php
namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditarTasca extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            //->setAction($this->generateUrl('usuari_save'))
        $builder->add('title',TextType::class,array(
            'attr' => array(
                'placeholder' => 'Titol'
            )
       ))
        
        ->add('content',TextType::class,['attr'=>[
            'placeholder'=>'Contingut'
        ]])
        ->add('priority',TextType::class,['attr'=>[
            'placeholder'=>'Prioritat'
        ]])
        ->add('hours',TextType::class,['attr'=>[
            'placeholder'=>'Hores'
        ]])
        ->add('submit',SubmitType::class,[
            'label'=>'Crear Tasca',
            'attr'=>['class' => 'btn']

        ]);

    }
}
?>