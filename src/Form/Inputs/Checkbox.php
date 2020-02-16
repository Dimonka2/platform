<?php

namespace dimonka2\flatform\Form\Inputs;

use dimonka2\flatform\Form\Input;
use dimonka2\flatform\Form\Contracts\IContext;
use Form;

class Checkbox extends Input
{
    public $label;
    public $checked;
    public $inline;

    protected function render()
    {
        return Form::checkbox($this->name, $this->value, $this->checked,
            $this->getOptions([]));
    }

    protected function read(array $element)
    {
        $this->readSettings($element, ['label', 'checked', 'inline']);
        parent::read($element);
        $this->col = false;
    }
}
