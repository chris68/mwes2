<?php

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EmailentitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?php
    $out = fopen('php://output', 'w');

    fputcsv($out, [
        "Name",
        "E-mail",
        "Notes",
        "Section 1 - Description", "Section 1 - Email",
        "Section 2 - Description", "Section 2 - Email",
        "Section 3 - Description", "Section 3 - Email",
        "Section 4 - Description", "Section 4 - Email",
        "Section 5 - Description", "Section 5 - Email",
        "Section 6 - Description", "Section 6 - Email"
     ]);

    foreach ($dataProvider->getModels() as $item) {
        /* @var $item frontend\models\Emailentity */
        
        fputcsv($out,[
            $item->sortname,
            $item->getCompleteEmailname(),
            $item->comment,
            isset($item->emailmappings[0])?($item->emailmappings[0]->emailarea->name):'',
            isset($item->emailmappings[0])?($item->emailmappings[0]->target):'',
            isset($item->emailmappings[1])?($item->emailmappings[1]->emailarea->name):'',
            isset($item->emailmappings[1])?($item->emailmappings[1]->target):'',
            isset($item->emailmappings[2])?($item->emailmappings[2]->emailarea->name):'',
            isset($item->emailmappings[2])?($item->emailmappings[2]->target):'',
            isset($item->emailmappings[3])?($item->emailmappings[3]->emailarea->name):'',
            isset($item->emailmappings[3])?($item->emailmappings[3]->target):'',
            isset($item->emailmappings[4])?($item->emailmappings[4]->emailarea->name):'',
            isset($item->emailmappings[4])?($item->emailmappings[4]->target):'',
            isset($item->emailmappings[5])?($item->emailmappings[5]->emailarea->name):'',
            isset($item->emailmappings[5])?($item->emailmappings[5]->target):'',
         ]);
    }
    fclose($out);
?>
