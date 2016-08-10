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
        'BattleTag' => 'Varchar(100)'
    );

    private static $has_many = array(
        'Characters' => 'Character'
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root.Main', TextField::create('BattleTag', 'Battle Tag'));

        $fields->addFieldsToTab('Root.Characters', array(
            LiteralField::create('MainCharacterTip', '<p class="message">Drag your main character to the top.</p>'),
            GridField::create('Characters', 'Characters', $this->owner->Characters(), GridFieldConfig_RelationEditor::create()->addComponent(new GridFieldSortableRows('SortOrder'))),
        ));
    }
}