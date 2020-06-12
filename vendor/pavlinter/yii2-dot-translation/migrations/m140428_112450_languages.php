<?php

use yii\db\Schema;

class m140428_112450_languages extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('SystemLanguage', [
            'id' => Schema::TYPE_PK,
            'code' => Schema::TYPE_STRING . '(16) NOT NULL',
            'name' => Schema::TYPE_STRING . '(20) NOT NULL',
            'image' => Schema::TYPE_STRING . '(250) NULL',
            'weight' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 10',
            'active' => Schema::TYPE_BOOLEAN . '(1) NOT NULL DEFAULT 1',
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);


        $this->insert('SystemLanguage', [
            'code' => 'en',
            'name' => 'English',
            'weight'=> 1,
            'updated_at' => time(),
        ]);

        $this->insert('SystemLanguage', [
            'code' => 'ru',
            'name' => 'Russian',
            'weight'=> 2,
            'updated_at' => time(),
        ]);
    }

    public function down()
    {
        $this->dropTable('SystemLanguage');
    }
}
