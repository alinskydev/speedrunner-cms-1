<?php

use yii\db\Schema;

class m140428_105041_db_translation extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }


        $this->createTable('TranslationSource', [
            'id' => Schema::TYPE_PK,
            'category' => Schema::TYPE_STRING . '(32) NOT NULL',
            'message' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->createTable('TranslationMessage', [
            'id' => Schema::TYPE_INTEGER,
            'language_id' => Schema::TYPE_INTEGER,
            'translation' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->addPrimaryKey('PRIM','TranslationMessage',['id','language_id']);

        $this->addForeignKey('fk_message_TranslationSource', 'TranslationMessage', 'id', 'TranslationSource', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('TranslationMessage');
        $this->dropTable('TranslationSource');
    }
}