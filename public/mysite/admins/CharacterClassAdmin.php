<?php

/**
 * Created by PhpStorm.
 * User: carey
 * Date: 13/08/2016
 * Time: 2:01 PM
 */
class CharacterClassAdmin extends ModelAdmin
{
    private static $menu_title = 'Classes & Specs';
    private static $url_segment = 'class-spec-admin';
    private static $managed_models = array('CharacterClass', 'CharacterSpec');
}