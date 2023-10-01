<?php

declare(strict_types=1);

namespace Application\View\Helper;

class FormRow extends \Laminas\Form\View\Helper\FormRow
{
    public function __construct()
    {
        $this->setPartial('partial/form-row');
    }
}
