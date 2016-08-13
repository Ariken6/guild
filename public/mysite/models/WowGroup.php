<?php

/**
 * Created by PhpStorm.
 * User: carey
 * Date: 10/08/2016
 * Time: 9:34 PM
 */
class WowGroup extends DataObject implements WowGroupInterface
{
    private static $db = array(
        'Title' => 'Varchar(100)',
        'DateTime' => 'SS_DateTime'
    );

    private static $many_many = array(
        'Characters' => 'Character'
    );

    private static $many_many_extraFields = array(
        'Characters' => array('GroupOrder' => 'Int')
    );

    private static $summary_fields = array(
        'Title' => 'Name',
        'DateTime' => 'Date Time'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFields()['DateTime']->getDateField()->setConfig('showcalendar', true);

        $config = GridFieldConfig_RelationEditor::create();
        $config->removeComponentsByType($config->getComponentByType('GridFieldAddNewButton'));
        $characters = $this->getAvailableCharacters();
        $config->getComponentByType('GridFieldAddExistingAutocompleter')->setSearchList($characters);
        $config->addComponents(new GridFieldSortableRows('GroupOrder'));

        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('Title', 'Name'),
            GridField::create('Characters', 'Characters', $this->Characters(), $config)
        ));

        return $fields;
    }

    public function getMembersJoined(){
        $joinedCharacters = $this->Characters()->column('ID');
        if(!empty($joinedCharacters)){
            $members = Member::get()
                ->innerJoin('Character', '"Character"."MemberID" = "Member"."ID"')
                ->where('"Character"."ID" IN (' . implode(', ',$joinedCharacters) . ')');

            return $members;
        }

        return null;
    }

    public function getAvailableCharacters(){
        $membersJoined = $this->getMembersJoined();
        $availableCharacters = Character::get()
            ->innerJoin('Member', '"Character"."MemberID" = "Member"."ID"')
            ->where('"Member"."Active" = 1');

        if($membersJoined->count() > 0){
            $availableCharacters = $availableCharacters->where('"Character"."MemberID" NOT IN (' . implode(", ",$membersJoined->column("ID")) . ')');
        }

        return $availableCharacters;
    }

    public function getMinGroupSize(){
        return Config::inst()->get($this->ClassName, 'min_group_size');
    }

    public function getMaxGroupSize(){
        return Config::inst()->get($this->ClassName, 'max_group_size');
    }
}