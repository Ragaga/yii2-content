<?php

use yii\db\Schema;
use yii\db\Migration;

class m150211_045719_create_content_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('content', [
            "id"            => Schema::TYPE_PK,
            "header"        => Schema::TYPE_STRING      . ' not null',
            "title"         => Schema::TYPE_STRING      . ' default null',
            "image_file"    => Schema::TYPE_STRING      . ' default null',
            "short_text"    => Schema::TYPE_TEXT        . ' null',
            "text"          => Schema::TYPE_TEXT        . ' null',
            "code"          => Schema::TYPE_TEXT        . ' null',
            "url"           => Schema::TYPE_TEXT        . ' null',
            "description"   => Schema::TYPE_TEXT        . ' default null',
            "visible"       => Schema::TYPE_BOOLEAN     . ' default true',
            "tree_left"     => Schema::TYPE_INTEGER     . ' null',
            "tree_right"    => Schema::TYPE_INTEGER     . ' null',
            "level"         => Schema::TYPE_INTEGER     . ' null',
            "create_time"   => Schema::TYPE_TIMESTAMP   . ' null default null',
            "update_time"   => Schema::TYPE_TIMESTAMP   . ' null default null',
        ], $tableOptions);
        $this->createIndex('unique_key_url','content','url',true);
        $this->createIndex('unique_key_code','content','code',true);
    }

    public function down()
    {
        echo "m150211_045719_create_content_table cannot be reverted.\n";
        $this->dropTable('content');
        return true;
    }
}
