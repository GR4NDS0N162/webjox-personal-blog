<?php

declare(strict_types=1);

namespace Application\Helper;

use Laminas\Form\Element\Collection;
use Laminas\Form\ElementInterface;
use Laminas\Form\FieldsetInterface;
use Laminas\Hydrator\AbstractHydrator;

class FieldsetMapper
{
    public const KEY = 'delimiter_class';

    /**
     * @param ElementInterface $element
     * @param array|string     $config
     *
     * @return void
     */
    public static function setAttributes(ElementInterface $element, array|string $config): void
    {
        if (empty($config)) {
            return;
        }

        if (is_string($config)) {
            $element->setAttribute(self::KEY, $config);
            return;
        }

        if (!empty($config['value']) && is_string($config['value'])) {
            $element->setAttribute(self::KEY, $config['value']);
        }

        if ($element instanceof Collection && !empty($config['target_element'])) {
            self::setAttributes($element->getTargetElement(), $config['target_element']);
            return;
        }

        if (($element instanceof FieldsetInterface) && is_array($config['children'])) {
            foreach ($config['children'] as $childName => $childConfig) {
                if ($element->has($childName)) {
                    self::setAttributes($element->get($childName), $childConfig);
                }
            }
        }
    }

    public static function setDisabled(ElementInterface $element): void
    {
        if ($element instanceof FieldsetInterface) {
            foreach ($element->getFieldsets() as $item) {
                if ($item instanceof Collection) {
                    self::setDisabled($item->getTargetElement());
                } else {
                    self::setDisabled($item);
                }
            }
            foreach ($element->getElements() as $item) {
                $item->setAttribute('disabled', true);
            }
        } else {
            $element->setAttribute('disabled', true);
        }
    }

    public static function setStrategies(AbstractHydrator $hydrator, $config): void
    {
        foreach ($config as $name => $strategy) {
            $hydrator->addStrategy($name, $strategy);
        }
    }
}
