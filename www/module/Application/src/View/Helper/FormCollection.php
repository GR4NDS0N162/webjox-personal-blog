<?php

declare(strict_types=1);

namespace Application\View\Helper;

use Laminas\Form\ElementInterface;

class FormCollection extends \Laminas\Form\View\Helper\FormCollection
{
    /**
     * @inheritDoc
     */
    public function render(ElementInterface $element): string
    {
        $markup = parent::render($element);

        $wrapperClass = $element->getOption(FormRow::WRAPPER_CLASS);
        if (!empty($wrapperClass)) {
            $markup = sprintf('<div class="%1$s">%2$s</div>', $wrapperClass, $markup);
        }

        return $markup;
    }
}
