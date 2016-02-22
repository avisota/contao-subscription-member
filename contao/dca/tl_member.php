<?php

/**
 * Avisota newsletter and mailing system
 * Copyright © 2016 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision 2016
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @package    avisota/contao-subscription-recipient
 * @license    LGPL-3.0+
 * @filesource
 */

#$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = str_replace('firstname', 'salutation, title, firstname', $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);

\Bit3\Contao\MetaPalettes\MetaPalettes::prependFields(
    'tl_member',
    'default',
    'personal',
    array('salutation', 'title')
);

$fields = array
(
    'salutation' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_member']['salutation'],
        'exclude'   => true,
        'search'    => true,
        'sorting'   => true,
        'flag'      => 1,
        'inputType' => 'text',
        'eval'      => array
        (
            'maxlength'  => 255,
            'feEditable' => true,
            'feViewable' => true,
            'feGroup'    => 'personal',
            'tl_class'   => 'w50'
        ),
        'sql'       => "varchar(255) NOT NULL default ''"
    ),
    'title'      => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_member']['title'],
        'exclude'   => true,
        'search'    => true,
        'sorting'   => true,
        'flag'      => 1,
        'inputType' => 'text',
        'eval'      => array
        (
            'maxlength'  => 255,
            'feEditable' => true,
            'feViewable' => true,
            'feGroup'    => 'personal',
            'tl_class'   => 'w50'
        ),
        'sql'       => "varchar(255) NOT NULL default ''"
    ),
);

$GLOBALS['TL_DCA']['tl_member']['fields'] = array_merge($GLOBALS['TL_DCA']['tl_member']['fields'], $fields);

unset($fields);
