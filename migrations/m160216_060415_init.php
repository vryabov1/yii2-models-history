<?php

use yii\db\Migration;

class m160216_060415_init extends Migration
{
    const TABLE = 'models_history';
    public function up()
    {
        $this->createTable('{{%' . self::TABLE . '}}', [
            'id' => $this->bigPrimaryKey(),
            'model_class' => $this->string(500)->notNull(),
            'pk' => $this->string()->notNull(),
            'operation_type' => $this->smallInteger(1)->notNull() . ' COMMENT \'1-insert, 2-update, 3-delete\'',
            'attributes_json' => $this->text()->notNull(),
            'created_at' => $this->integer(10)->unsigned()->notNull()
        ]);

        $this->createIndex(self::TABLE . '_model_class_index', '{{%' . self::TABLE . '}}', 'model_class');
    }

    public function down()
    {
        $this->dropTable('{{%' . self::TABLE . '}}');
    }
}
