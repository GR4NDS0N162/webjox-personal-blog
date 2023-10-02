<?php

declare(strict_types=1);

namespace Application\View\Helper;

use Laminas\Form\ElementInterface;

class FormRow extends \Laminas\Form\View\Helper\FormRow
{
    public const FLOATING_ENABLED = 'floating-enabled';
    public const WRAPPER_CLASS = 'wrapper-class';

    public function __construct()
    {
        $this->setInputErrorClass('is-invalid');
    }

    /**
     * @inheritDoc
     */
    public function render(ElementInterface $element, ?string $labelPosition = null): string
    {
        $floatingEnabled = $element->getOption(self::FLOATING_ENABLED);
        $wrapperClass = $element->getOption(self::WRAPPER_CLASS);

        if ($floatingEnabled) {
            $labelPosition = self::LABEL_APPEND;
        }

        $markup = parent::render($element, $labelPosition);

        if ($floatingEnabled) {
            $markup = sprintf('<div class="form-floating">%1$s</div>', $markup);
        }

        if ($wrapperClass) {
            $markup = sprintf('<div class="%1$s">%2$s</div>', $wrapperClass, $markup);
        }

        return $markup;
    }
}
