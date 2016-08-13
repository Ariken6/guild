<?php

/**
 * Created by PhpStorm.
 * User: carey
 * Date: 13/08/2016
 * Time: 1:56 PM
 */
class DungeonGroup extends WowGroup
{
    private static $db = array(
        'Difficulty' => 'enum("Normal,Heroic,Mythic","Normal")'
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

        $blog = Blog::get()->filter(array('Title' => 'Dungeons'))->first();
        if($blog){
            $dungeons = $blog->Categories();
            $fields->addFieldsToTab('Root.Main', array(
                DropdownField::create('InstanceID', 'Instance', $dungeons->map()),
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