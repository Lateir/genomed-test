<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%url}}`.
 */
class m250730_113507_create_url_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('short_url', [
            'id' => $this->primaryKey(),
            'original_url' => $this->text()->notNull(),
            'short_code' => $this->string(10)->notNull()->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'clicks' => $this->integer()->defaultValue(0),
        ]);

        $this->createTable('url_click_log', [
            'id' => $this->primaryKey(),
            'short_url_id' => $this->integer()->notNull(),
            'ip_address' => $this->string(45)->notNull(),
            'clicked_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey('fk_log_url', 'url_click_log', 'short_url_id', 'short_url', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('url_click_log');
        $this->dropTable('short_url');
    }
}
