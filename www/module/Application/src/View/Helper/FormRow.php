<?php

declare(strict_types=1);

namespace Application\View\Helper;

use Laminas\Form\ElementInterface;

class FormRow extends \Laminas\Form\View\Helper\FormRow
{
    /**
     * @inheritDoc
     */
    public function render(ElementInterface $element, ?string $labelPosition = null): string
    {
        return ''; // TODO: Implement render() method.
    }
}
