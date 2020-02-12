<?php

namespace dimonka2\flatform\Form\Components;

use dimonka2\flatform\Form\Form;
use Flatform;

class Dropzone extends Form
{
    protected $onSuccess;
    protected $onError;
    protected $onRemovedfile;
    protected $onInit;

    protected const options = ['onSuccess', 'onError', 'onRemovedfile', 'onInit'];

    protected function read(array $element)
    {
        $this->readSettings($element, self::options);
        parent::read($element);
        $this->files = true;
    }

    protected function addAssets()
    {
        if(!Flatform::isIncluded('dropzone')){
            Flatform::include('dropzone');
            if(config('flatform.assets.dropzone', false)) {
                $path = config('flatform.assets.dropzone.path');
                Flatform::addCSS(config('flatform.assets.dropzone.css'), $path);
                Flatform::addJS(config('flatform.assets.dropzone.js'), $path);
                return $this->context->renderView(
                    view(config('flatform.assets.dropzone.view'))
                );
            } else {
                return 'Dropzone component is not configured!';
            }
        }
    }

    protected function render()
    {
        $html = $this->addAssets();

        return $html . parent::render();
    }

    public function getOptions(array $keys)
    {
        return parent::getOptions(array_merge($keys, self::options));
    }

}
