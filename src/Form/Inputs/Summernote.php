<?php

namespace dimonka2\flatform\Form\Inputs;

use dimonka2\flatform\Form\Input;
use dimonka2\flatform\Form\Contracts\IContext;
use Form;
use Flatform;

class Summernote extends Input
{
    protected function render()
    {
        if(!Flatform::isIncluded('summernote')) {
            Flatform::include('summernote');
            $path = config('flatform.assets.summernote_path');
            Flatform::addCSS(config('flatform.assets.summernote_css'), $path);
            Flatform::addJS(config('flatform.assets.summernote_js'), $path);
        }
        return Form::textarea($this->name, $this->value,
            $this->getOptions([]));
    }
}
