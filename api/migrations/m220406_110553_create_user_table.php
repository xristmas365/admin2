<?php

use app\models\Role;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m220406_110553_create_user_table extends Migration
{

    public string $tableUser = '{{%users}}';

    public function safeUp()
    {
        $this->createTable($this->tableUser, [
            'id'            => $this->primaryKey(),
            'email'         => $this->string()->notNull()->unique(),
            'password'      => $this->string(60),
            'blocked'       => $this->boolean()->notNull()->defaultValue(false),
            'confirmed'     => $this->boolean()->notNull()->defaultValue(false),
            'auth_key'      => $this->string(32),
            'role'          => $this->integer()->notNull()->defaultValue(Role::USER),
            'name'          => $this->string(32),
            'slug'          => $this->string(),
            'phone'         => $this->string(16),
            'address'       => $this->string(60),
            'city'          => $this->string(32),
            'state'         => $this->string(2),
            'zip'           => $this->string(5),
            'created_at'    => $this->integer(10),
            'updated_at'    => $this->integer(10),
            'last_login_at' => $this->integer(10),
        ]);

        $this->createIndex('idx-user-auth', $this->tableUser, 'auth_key');

        $this->insert($this->tableUser, [
            'email'      => 'dev@ax.com',
            'password'   => Yii::$app->security->generatePasswordHash('axdev*&'),
            'auth_key'   => Yii::$app->security->generateRandomString(),
            'name'       => 'AX',
            'slug'       => 'dev',
            'zip'        => '90025',
            'state'      => 'CA',
            'city'       => 'Los Angeles',
            'phone'      => '(123) 123-1234',
            'role'       => Role::DEVELOPER,
            'created_at' => time(),
            'updated_at' => time(),
            'confirmed'  => true,
        ]);

        $this->insert($this->tableUser, [
            'email'      => 'admin@ax.com',
            'password'   => Yii::$app->security->generatePasswordHash('axadmin*&'),
            'auth_key'   => Yii::$app->security->generateRandomString(),
            'name'       => 'Admin',
            'slug'       => 'admin',
            'zip'        => '90025',
            'state'      => 'CA',
            'city'       => 'Los Angeles',
            'phone'      => '(123) 123-1234',
            'role'       => Role::ADMIN,
            'created_at' => time(),
            'updated_at' => time(),
            'confirmed'  => true,
        ]);

        $this->insert($this->tableUser, [
            'email'      => 'user@ax.com',
            'password'   => Yii::$app->security->generatePasswordHash('axuser*&'),
            'auth_key'   => Yii::$app->security->generateRandomString(),
            'name'       => 'User',
            'zip'        => '90025',
            'slug'       => 'user',
            'state'      => 'CA',
            'city'       => 'Los Angeles',
            'phone'      => '(123) 123-1234',
            'role'       => Role::USER,
            'created_at' => time(),
            'updated_at' => time(),
            'confirmed'  => true,
        ]);

        $this->insert($this->tableUser, [
            'email'      => 'customer@ax.com',
            'password'   => Yii::$app->security->generatePasswordHash('axcustomer*&'),
            'auth_key'   => Yii::$app->security->generateRandomString(),
            'name'       => 'Customer',
            'slug'       => 'customer',
            'zip'        => '90025',
            'state'      => 'CA',
            'city'       => 'Los Angeles',
            'phone'      => '(123) 123-1234',
            'role'       => Role::CUSTOMER,
            'created_at' => time(),
            'updated_at' => time(),
            'confirmed'  => true,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
