<?php
/**
 * Trasa type.
 */

namespace App\Form;

use App\Entity\Trasa;
use App\Entity\Trudnosc;
use App\Entity\Region;
use App\Form\DataTransformer\TagsDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TrasaType.
 */
class TrasaType extends AbstractType
{
    /**
     * Tags data transformer.
     *
     * @var \App\Form\DataTransformer\TagsDataTransformer
     */
    private $tagsDataTransformer;

    /**
     * TrasaType constructor.
     *
     * @param \App\Form\DataTransformer\TagsDataTransformer $tagsDataTransformer Tags data transformer
     */
    public function __construct(TagsDataTransformer $tagsDataTransformer)
    {
        $this->tagsDataTransformer = $tagsDataTransformer;
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label_title',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );
        $builder->add(
            'trudnosc',
            EntityType::class,
            [
                'class' => Trudnosc::class,
                'choice_label' => function ($trudnosc) {
                    return $trudnosc->getName();
                },
                'label' => 'label_trudnosc',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );
        $builder->add(
            'region',
            EntityType::class,
            [
                'class' => Region::class,
                'choice_label' => function ($region) {
                    return $region->getName();
                },
                'label' => 'label_region',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );
        $builder->add(
            'tags',
            TextType::class,
            [
                'label' => 'label_tags',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );

        $builder->add(
            'tags',
            TextType::class,
            [
                'label' => 'label_tags',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );


        $builder->get('tags')->addModelTransformer(
            $this->tagsDataTransformer
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Trasa::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'trasa';
    }
}
