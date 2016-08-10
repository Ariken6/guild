<?php

/**
 * Created by PhpStorm.
 * User: carey
 * Date: 10/08/2016
 * Time: 7:30 PM
 */
class CharacterClass extends DataObject
{
    private static $singular_name = "Class";
    private static $plural_name = "Classes";

    private static $db = array(
        'Title' => 'Varchar(100)'
    );

    private static $has_many = array(
        'CharacterSpecs' => 'CharacterSpec'
    );

    private static $summary_fields = array(
        'Title' => 'Class',
        'Roles' => 'Role'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('CharacterSpecs');
        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('Title', 'Class'),
            GridField::create('CharacterSpecs', 'Specs', $this->CharacterSpecs(), GridFieldConfig_RelationEditor::create())
        ));

        return $fields;
    }

    public function Roles()
    {
        $roles = $this->CharacterSpecs()->map('ID', 'Role')->toArray();
        $uniqueRoles = array_unique($roles);

        if (!empty($uniqueRoles)) {
            return implode(', ', $uniqueRoles);
        }

        return '';
    }
}

class CharacterSpec extends DataObject
{
    private static $singular_name = "Spec";
    private static $plural_name = "Specs";

    private static $db = array(
        'Title' => 'Varchar(100)',
        'Role' => 'enum("Melee DPS,Ranged DPS,Healer,Tank,Hybrid", "Melee DPS")'
    );

    private static $has_one = array(
        'CharacterClass' => 'CharacterClass'
    );

    private static $summary_fields = array(
        'Title' => 'Spec',
        'Role' => 'Role'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('CharacterClassID');
        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('Title', 'Spec'),
            DropdownField::create('Role', 'Role', $this->dbObject('Role')->enumValues())
        ));

        return $fields;
    }
}

class CharacterClassModelAdmin extends ModelAdmin
{
    private static $menu_title = 'Classes & Specs';
    private static $url_segment = 'class-spec-admin';
    private static $managed_models = array('CharacterClass', 'CharacterSpec');
}