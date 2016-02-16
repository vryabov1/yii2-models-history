<?php

namespace qvalent;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Bootstrap implements BootstrapInterface
{
    const INSERT = 1;
    const UPDATE = 2;
    const DELETE = 3;

    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, function ($event) {
            $this->insertHistory($event->sender, self::INSERT);
        });
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_UPDATE, function ($event) {
            $this->insertHistory($event->sender, self::UPDATE);
        });
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_DELETE, function ($event) {
            $this->insertHistory($event->sender, self::DELETE);
        });
    }

    /**
     * @param $model ActiveRecord
     * @param $type
     * @throws \yii\db\Exception
     */
    private function insertHistory($model, $type)
    {
        Yii::$app->db->createCommand()
            ->insert('{{%models_history}}', [
                'model_class' => $model::className(),
                'pk' => is_array($model->getPrimaryKey())
                    ? json_encode($model->getPrimaryKey()) // if pk is composite
                    : $model->getPrimaryKey(),
                'operation_type' => $type,
                'attributes_json' => json_encode(ArrayHelper::toArray($model)),
                'created_at' => time()
            ])
            ->execute();
    }
}
