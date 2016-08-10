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
        //TODO when a character is selected, other characters from the same player cannot be selected.
        $config->getComponentByType('GridFieldAddExistingAutocompleter')->setSearchList(Character::get());
        $config->addComponents(new GridFieldSortableRows('GroupOrder'));

        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('Title', 'Name'),
            GridField::create('Characters', 'Characters', $this->Characters(), $config)
        ));

        return $fields;
    }

    public function getMinGroupSize(){
        return Config::inst()->get($this->ClassName, 'min_group_size');
    }

    public function getMaxGroupSize(){
        return Config::inst()->get($this->ClassName, 'max_group_size');
    }
}