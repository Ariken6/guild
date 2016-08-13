<?php
/**
 * Created by PhpStorm.
 * User: carey
 * Date: 13/08/2016
 * Time: 2:01 PM
 */
class CharacterAdmin extends ModelAdmin
{
    private static $menu_title = 'Roster';
    private static $url_segment = 'character-admin';
    private static $managed_models = array('Character');
}