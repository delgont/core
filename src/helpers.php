<?php

use Delgont\Core\Repository\OptionRepository;
use Delgont\Core\Entities\Any;


if(!function_exists('option')){
    function option($option_key, $group, $default = null){
        return app(OptionRepository::class)->fromCache()->findOption($option_key, $group)->value ??  $default;
    }
}


if(!function_exists('any')){
    function any($any){
        return new Any($any);
    }
}

