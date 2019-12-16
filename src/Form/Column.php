<?php

namespace dimonka2\flatform\Form;

use dimonka2\flatform\Form\ElementContainer;
use dimonka2\flatform\Form\Contracts\IContext;

// Bootstrap column

class Column extends ElementContainer
{
    protected $col;
    protected $col_md;
    protected $col_lg;
    protected $col_xl;

    protected function read(array $element)
    {
        $this->readSettings($element, ['col', 'col-md', 'col-lg', 'col-xl']);
        parent::read($element);
        if(!is_null($this->col)) $this->addStyle('col-' . $this->col);
        if(!is_null($this->col_md)) $this->addStyle('col-md-' . $this->col_md);
        if(!is_null($this->col_lg)) $this->addStyle('col-lg-' . $this->col_lg);
        if(!is_null($this->col_xl)) $this->addStyle('col-xl-' . $this->col_xl);
        if (
            is_null($this->col) && is_null($this->col_md) && is_null($this->col_md) && is_null($this->col_md)
            ) $this->addStyle(config('flatform.form.col', 'col-6'));

    }


}
