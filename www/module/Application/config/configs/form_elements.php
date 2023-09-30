<?php

declare(strict_types=1);

namespace Application;

use Application\Factory\Form\SignUpFormFactory;

return [
    'aliases'   => [
    ],
    'factories' => [
        Form\Index\SignUpForm::class => SignUpFormFactory::class,
    ],
];
