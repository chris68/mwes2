<?php

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EmailentitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?php
    $out = fopen('php://output', 'w');
    /*
    *  Name,Given Name,Additional Name,Family Name,Yomi Name,Given Name Yomi,Additional Name Yomi,Family Name Yomi,Name Prefix,Name Suffix,Initials,Nickname,
     * Short Name,Maiden Name,Birthday,Gender,Location,Billing Information,Directory Server,Mileage,Occupation,Hobby,Sensitivity,Priority,Subject,
     * Notes,Group Membership,
     * E-mail 1 - Type,E-mail 1 - Value,E-mail 2 - Type,E-mail 2 - Value,E-mail 3 - Type,E-mail 3 - Value,E-mail 4 - Type,E-mail 4 - Value,E-mail 5 - Type,E-mail 5 - Value,
     * Phone 1 - Type,Phone 1 - Value,Phone 2 - Type,Phone 2 - Value,Phone 3 - Type,Phone 3 - Value,Phone 4 - Type,Phone 4 - Value,
     * Custom Field 1 - Type,Custom Field 1 - Value,Custom Field 2 - Type,Custom Field 2 - Value,Custom Field 3 - Type,Custom Field 3 - Value
    *
    */
    $field_str = 'Name,Given Name,Additional Name,Family Name,Yomi Name,Given Name Yomi,Additional Name Yomi,Family Name Yomi,Name Prefix,Name Suffix,Initials,Nickname,Short Name,Maiden Name,Birthday,Gender,Location,Billing Information,Directory Server,Mileage,Occupation,Hobby,Sensitivity,Priority,Subject,Notes,Group Membership,E-mail 1 - Type,E-mail 1 - Value,E-mail 2 - Type,E-mail 2 - Value,E-mail 3 - Type,E-mail 3 - Value,E-mail 4 - Type,E-mail 4 - Value,E-mail 5 - Type,E-mail 5 - Value,Phone 1 - Type,Phone 1 - Value,Phone 2 - Type,Phone 2 - Value,Phone 3 - Type,Phone 3 - Value,Phone 4 - Type,Phone 4 - Value,Custom Field 1 - Type,Custom Field 1 - Value,Custom Field 2 - Type,Custom Field 2 - Value,Custom Field 3 - Type,Custom Field 3 - Value';

    $fields = explode(',',$field_str);

    fputcsv($out, $fields);

    foreach ($dataProvider->getModels() as $item) {
        /* @var $item frontend\models\Emailentity */

        $tels_count = 0;
        $tels = [];

        // Retrieve the telefon number with tel-xxx tags
        preg_replace_callback(
            '/tel-([a-z]*):([-0-9+ \/]*)/',
            function ($match) use(&$tels_count,&$tels,&$item) {
              ++$tels_count;
              $tels[$tels_count] = ['type'=> $match[1], 'value' => $item->emaildomain->normalizeTel($match[2])];
            },
            $item->comment
        );

        // Add missing tels
        while (++$tels_count <= 4) {
              $tels[$tels_count] = ['type'=> '', 'value' => ''];
        }

        $row = [];
        
        foreach ($fields as $field) {
            switch ($field) {
                case 'Name': $row[] = empty($item->sortname)?$item->getCompleteEmailname():$item->sortname;
                    break;
                case 'Nickname': $row[] = $item->getCompleteEmailname();
                    break;
                case 'Notes': $row[] = $item->comment;
                    break;
                case 'Group Membership': $row[] = $item->emaildomain->getCompleteDomainname();
                    break;

                case 'Phone 1 - Type': $row[] = ucfirst($tels[1]['type']);
                    break;
                case 'Phone 2 - Type': $row[] = ucfirst($tels[2]['type']);
                    break;
                case 'Phone 3 - Type': $row[] = ucfirst($tels[3]['type']);
                    break;
                case 'Phone 4 - Type': $row[] = ucfirst($tels[4]['type']);
                    break;
                
                case 'Phone 1 - Value': $row[] = $tels[1]['value'];
                    break;
                case 'Phone 2 - Value': $row[] = $tels[2]['value'];
                    break;
                case 'Phone 3 - Value': $row[] = $tels[3]['value'];
                    break;
                case 'Phone 4 - Value': $row[] = $tels[4]['value'];
                    break;

                case 'E-mail 1 - Type': $row[] = isset($item->emailmappings[0])?(ucfirst($item->emailmappings[0]->emailarea->name)):'';
                    break;
                case 'E-mail 2 - Type': $row[] = isset($item->emailmappings[1])?(ucfirst($item->emailmappings[1]->emailarea->name)):'';
                    break;
                case 'E-mail 3 - Type': $row[] = isset($item->emailmappings[2])?(ucfirst($item->emailmappings[2]->emailarea->name)):'';
                    break;
                case 'E-mail 4 - Type': $row[] = isset($item->emailmappings[3])?(ucfirst($item->emailmappings[3]->emailarea->name)):'';
                    break;
                case 'E-mail 5 - Type': $row[] = isset($item->emailmappings[4])?(ucfirst($item->emailmappings[4]->emailarea->name)):'';
                    break;

                case 'E-mail 1 - Value': $row[] = isset($item->emailmappings[0])?($item->emailmappings[0]->getResolvedaddress()):'';
                    break;
                case 'E-mail 2 - Value': $row[] = isset($item->emailmappings[1])?($item->emailmappings[1]->getResolvedaddress()):'';
                    break;
                case 'E-mail 3 - Value': $row[] = isset($item->emailmappings[2])?($item->emailmappings[2]->getResolvedaddress()):'';
                    break;
                case 'E-mail 4 - Value': $row[] = isset($item->emailmappings[3])?($item->emailmappings[3]->getResolvedaddress()):'';
                    break;
                case 'E-mail 5 - Value': $row[] = isset($item->emailmappings[4])?($item->emailmappings[4]->getResolvedaddress()):'';
                    break;

                default:
                    $row[]='';
                    break;
            }
            
        }
        fputcsv($out,$row);
    }
    fclose($out);
?>
