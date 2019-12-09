<?php

namespace dimonka2\platform\Form;

use dimonka2\platform\Form\Element;
use dimonka2\platform\Form\ElementContainer;
use dimonka2\platform\Form\Contracts\IContainer;
use \ReflectionClass;

class ElementFactory
{
    private $binds = [
        'text' => Inputs\Text::class,
        
        'div' => ElementContainer::class,
        'span' => ElementContainer::class,
        'i' => ElementContainer::class,
        'b' => ElementContainer::class,
        'u' => ElementContainer::class,
        '_text' => Element::class,
    ];

    public function createElement(array $element, $context)
    {
        $def_type = config('platform.form.default-type');
        $type = $element['type'] ?? $def_type;
        $class = isset($this->binds[$type]) ? $this->binds[$type] : $this->binds[$def_type];
        // make class
        $reflection = new ReflectionClass($class);
        return $reflection->newInstanceArgs([$element, $context]);
    }

}