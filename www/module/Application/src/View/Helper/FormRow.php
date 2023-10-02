<?php

declare(strict_types=1);

namespace Application\View\Helper;

use Laminas\Form\ElementInterface;

class FormRow extends \Laminas\Form\View\Helper\FormRow
{
    public const FLOATING_ENABLED = 'floating-enabled';

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

        if ($floatingEnabled) {
            $labelPosition = self::LABEL_APPEND;
        }

        $markup = parent::render($element, $labelPosition);

        if ($floatingEnabled) {
            $markup = '<div class="form-floating">' . $markup . '</div>';
        }

        return $markup;
    }
}
