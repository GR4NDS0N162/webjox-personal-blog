<?php

namespace Application;

use Application\Factory\Form\SignUpFormFactory;

return [
    'aliases'   => [
    ],
    'factories' => [
        Form\Index\SignUpForm::class => SignUpFormFactory::class,
    ],
];
