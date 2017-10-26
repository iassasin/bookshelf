<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use AppBundle\Entity\Book;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isNew = $builder->getData() == null || $builder->getData()->getId() == null;

        $builder->add('name');
        $builder->add('author');
        $builder->add('readDate');

        $builder->add('coverFile', null, ['required' => false]);
        if (!$isNew) {
            $builder->add('deleteCoverFile', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
            ]);
        }

        $builder->add('bookFile', null, ['required' => false]);
        if (!$isNew) {
            $builder->add('deleteBookFile', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
            ]);
        }

        $builder->add('isDownloadable', null, ['label' => 'Is book download available']);

        if ($isNew) {
            $builder->add('add', SubmitType::class);
        } else {
            $builder->add('save', SubmitType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
