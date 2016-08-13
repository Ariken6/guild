<?php

/**
 * Created by PhpStorm.
 * User: carey
 * Date: 13/08/2016
 * Time: 2:01 PM
 */
class InstanceGroupAdmin extends ModelAdmin
{
    private static $menu_title = 'Groups';
    private static $url_segment = 'instance-groups';
    private static $managed_models = array('DungeonGroup', 'RaidGroup');
}