<?php
namespace console\Controllers;

use Yii;
use yii\console\Controller;

/**
 * Command to initialize the rbac configuration
 */
class RbacController extends Controller
{
	/**
	 * Initialize the rbac configuration
	 */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

		// Need to remove all at the beginning since we want to build it up anew each time
        $auth->removeAll();
		
		$objectownerrule = new \common\rbac\ObjectOwnerRule(); 
		$auth->add($objectownerrule);

		$userrule = new \common\rbac\UserRoleRule(); 
		$auth->add($userrule);

        $isObjectOwner = $auth->createPermission('isObjectOwner');
		$isObjectOwner->ruleName = $objectownerrule->name;
        $isObjectOwner->description = \Yii::t('common', 'Is the user the owner of the object?');
        $auth->add($isObjectOwner);

		$user = $auth->createRole('user');
		$user->ruleName = $userrule->name;
		$user->description = \Yii::t('common', 'User');
		$auth->add($user); 
		$auth->addChild($user, $isObjectOwner); 

		$anonymous = $auth->createRole('anonymous');
		$anonymous->ruleName = $userrule->name;
		$anonymous->description = \Yii::t('common', 'Anonymous User');
		$auth->add($anonymous); 
		$auth->addChild($anonymous, $user); 

		$admin = $auth->createRole('admin');
		$admin->ruleName = $userrule->name;
		$admin->description = \Yii::t('common', 'Administrator');
		$auth->add($admin); 
		$auth->addChild($admin, $user); 
    }
}