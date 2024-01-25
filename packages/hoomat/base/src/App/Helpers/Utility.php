<?php

namespace Hoomat\Base\App\Helpers;

class Utility
{
    public static function convertDate($date)
    {
        if (empty($date)) {
            return '';
        }
        if (app()->getLocale() !== 'fa') {
            return $date;
        }

        return verta($date);
    }


    public static function getAuthorizeMessage($action, $model)
    {
        return __('authorize.message', ['action'=> __('actions.'.$action), 'model'=>__('models.'.$model)]);
    }
}
