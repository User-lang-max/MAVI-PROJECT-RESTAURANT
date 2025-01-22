<?php
namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom du client'])
            ->add('prenom', TextType::class, ['label' => 'Prénom du client'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('telephone', TextType::class, ['label' => 'Numéro de téléphone'])
            ->add('heure', DateTimeType::class, [
                'label' => 'Heure de réservation',
                'widget' => 'single_text',
                'input' => 'datetime'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
