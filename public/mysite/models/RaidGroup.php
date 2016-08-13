<?php

/**
 * Created by PhpStorm.
 * User: carey
 * Date: 10/08/2016
 * Time: 9:34 PM
 */
class RaidGroup extends WowGroup
{
    private static $db = array(
        'Difficulty' => 'enum("Raid Finder,Normal,Heroic,Mythic","Normal")'
    );

    private static $has_one = array(
        'Instance' => 'BlogCategory'
    );

    private static $summary_fields = array(
        'Title' => 'Name',
        'DateTime' => 'Date Time'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Title');

        $blog = Blog::get()->filter(array('Title' => 'Raids'))->first();
        if($blog){
            $raids = $blog->Categories();
            $fields->addFieldsToTab('Root.Main', array(
                DropdownField::create('InstanceID', 'Instance', $raids->map()),
                DropdownField::create('Difficulty', 'Difficulty', $this->dbObject('Difficulty')->enumValues())
            ));
        }

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if ($this->InstanceID > 0) {
            $this->Title = $this->Instance()->Title . ' - ' . $this->Difficulty . ' - ' . $this->DateTime;
        }
    }
}