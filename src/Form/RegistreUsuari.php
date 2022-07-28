<?php
namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistreUsuari extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            //->setAction($this->generateUrl('usuari_save'))
        $builder->add('name',TextType::class,array(
            'label' => 'name ',
            'attr' => array(
                'placeholder' => 'Nom'
            )
       ))
        ->add('surname',TextType::class,['attr'=>[
            'placeholder'=>'Cognom'
        ]])
        ->add('email',TextType::class,['attr'=>[
            'placeholder'=>'Email'
        ]])
        ->add('password',TextType::class,['attr'=>[
            'placeholder'=>'Password'
        ]])
        ->add('submit',SubmitType::class,[
            'label'=>'Crear Usuari',
            'attr'=>['class' => 'btn']

        ]);

    }
}
?>