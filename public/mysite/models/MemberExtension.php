<?php

/**
 * Created by PhpStorm.
 * User: carey
 * Date: 10/08/2016
 * Time: 7:24 PM
 */
class MemberExtension extends DataExtension
{
    private static $db = array(
        'BattleTag' => 'Varchar(100)',
        'Active' => 'Boolean'
    );

    private static $has_many = array(
        'Characters' => 'Character'
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('Characters');
        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('BattleTag', 'Battle Tag'),
            CheckboxField::create('Active', 'Active')
        ));

        if($this->owner->exists()){
            $config = GridFieldConfig_RelationEditor::create();
            $config->addComponents(new GridFieldSortableRows('SortOrder'));
            $fields->addFieldsToTab('Root.Characters', array(
                LiteralField::create('MainCharacterTip', '<p class="message">Drag the main character to the top.</p>'),
                GridField::create('Characters', 'Characters', $this->owner->Characters(), $config)
            ));
        }
    }
}