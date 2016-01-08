<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2015 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision 2015
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @package    avisota/contao-subscription-recipient
 * @license    LGPL-3.0+
 * @filesource
 */

global $TL_LANG;

/**
 * Table orm_avisota_recipient_source
 * Entity Avisota\Contao:RecipientSource
 */
$ormAvisotaRecipientSource = array(
    'members_legend'
    => 'Members settings',

    'membersManageSubscriptionPage' => array(
        'Subscription management page',
        'Please choose the subscription management page.',
    ),

    'membersUnsubscribePage' => array(
        'Unsubscribe page',
        'Please choose the page for direct unsubscription.',
    ),

    'membersUseGroupFilter' => array(
        'Filter by groups',
        'Filter recipients by group membership.',
    ),

    'membersGroupFilter' => array(
        'Group filter',
        'Filter the recipients by group membership.',
    ),

    'membersGroupFilter_condition' => array(
        'Condition',
    ),

    'membersGroupFilter_group' => array(
        'Group',
    ),

    'membersUsePropertyFilter' => array(
        'Filter by properties',
        'Filter recipients by properties and values.',
    ),

    'membersPropertyFilter' => array(
        'Properties filter',
        'Filter the recipients by property values.',
    ),

    'membersPropertyFilter_property' => array(
        'Column',
    ),

    'membersPropertyFilter_comparator' => array(
        'Comparator',
    ),

    'membersPropertyFilter_value' => array(
        'Value',
    ),


    'members' => array(
        'Members',
        'Use the Contao integrated members management.',
    ),

    'membersGroupFilter_conditions' => array(
        'in'     => 'in',
        'not in' => 'not in',
    ),

    'membersPropertyFilter_comparators' => array(
        'empty'     => 'is empty',
        'not_empty' => 'is not empty',
        'eq'        => '==',
        'neq'       => '!=',
        'gt'        => '>',
        'gte'       => '>=',
        'lt'        => '<',
        'lte'       => '<=',
    ),
);

$TL_LANG['orm_avisota_recipient_source'] = array_merge(
    $TL_LANG['orm_avisota_recipient_source'],
    $ormAvisotaRecipientSource
);
