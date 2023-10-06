<?php

declare(strict_types=1);

namespace Application\View\Helper;

use Laminas\Form\ElementInterface;

class FormCollection extends \Laminas\Form\View\Helper\FormCollection
{
    public function __construct()
    {
        $this->setTemplateWrapper('<span data-template="%s" class="d-none"></span>');
        $this->setWrapper('<fieldset%4$s>%2$s%3$s' .
            '<style>.list-notification { display: none; } .list-notification:last-child { display: block; }</style>' .
            '<div class="list-notification">The list is empty.</div>' .
            '%1$s</fieldset>');
    }

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
