<?php

namespace dimonka2\flatform\Form\Inputs;

use dimonka2\flatform\Form\Input;
use dimonka2\flatform\Form\Contracts\IContext;
use Form;

class Radio extends Input
{
    protected function render(IContext $context, $aroundHTML)
    {
        return Form::radio($this->name, $this->name, $this->value,
            $this->getOptions(['id', 'class', 'style']));
    }
}
