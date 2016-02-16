<?php

namespace qvalent;

use yii\base\BootstrapInterface;
use yii\db\ActiveRecord;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->on(ActiveRecord::EVENT_AFTER_UPDATE, function () {

        });
    }
}
