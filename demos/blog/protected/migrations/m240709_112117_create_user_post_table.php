<?php

class m240709_112117_create_user_post_table extends CDbMigration
{
	public function up()
    {
        // Create the user_post table
        $this->createTable('user_post', array(
            'id' => 'pk',
            'user_id' => 'int NOT NULL',
            'post_id' => 'int NOT NULL',
        ));
    }

    public function down()
    {
        // Drop the user_post table
        $this->dropTable('user_post');
    }

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}