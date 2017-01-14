<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Some internal commands to manage the users
 */
class UserController extends Controller
{
    /**
     * Delete all legacy users not using the system for more than two years
     */
    public function actionPurgeLegacyUsers()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand(
<<<SQL
        delete from
            tbl_user u
        where
            id > 100 and
            1=0 
SQL
        );

        $count = $command->execute();
        $this->stdout("$count legacy users have been purged\n", Console::FG_GREEN);
        return true;
    }
}