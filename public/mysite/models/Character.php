<?php

/**
 * Created by PhpStorm.
 * User: carey
 * Date: 10/08/2016
 * Time: 8:18 PM
 */
class Character extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar(100)',
        'ItemLevel' => 'Int',
        'WowArmoryLink' => 'Text',
        'SortOrder' => 'Int'
    );

    private static $has_one = array(
        'Member' => 'Member',
        'CharacterClass' => 'CharacterClass'
    );

    private static $summary_fields = array(
        'Title' => 'Name',
        'ItemLevel' => 'Item Level',
        'SelectedClass' => 'Class',
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('SortOrder');
        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('Title', 'Name'),
            NumericField::create('ItemLevel', 'Item Level'),
            TextField::create('WowArmoryLink', 'WowArmory Link'),
            DropdownField::create('CharacterClassID', 'Class', CharacterClass::get()->map()),
            DropdownField::create('MemberID', 'Member', Member::get()->map('ID', 'FirstName')),
        ));

        return $fields;
    }

    public function SelectedClass()
    {
        if ($this->CharacterClassID > 0) {
            return $this->CharacterClass()->Title;
        }

        return '';
    }
}