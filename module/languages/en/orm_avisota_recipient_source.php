<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2013 Tristan Lins
 *
 * PHP version 5
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    avisota/contao-subscription-recipient
 * @license    LGPL-3.0+
 * @filesource
 */


/**
 * Table orm_avisota_recipient_source
 * Entity Avisota\Contao:RecipientSource
 */
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersManageSubscriptionPage']    = array(
	'Subscription management page',
	'Please choose the subscription management page.'
);
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersUnsubscribePage']           = array(
	'Unsubscribe page',
	'Please choose the page for direct unsubscription.'
);
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersUseGroupFilter']            = array(
	'Filter by groups',
	'Filter recipients by group membership.'
);
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter']               = array(
	'Group filter',
	'Filter the recipients by group membership.'
);
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter_condition']     = array('Condition');
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter_group']         = array('Group');
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersUsePropertyFilter']         = array(
	'Filter by properties',
	'Filter recipients by properties and values.'
);
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter']            = array(
	'Properties filter',
	'Filter the recipients by property values.'
);
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_property']   = array('Column');
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparator'] = array('Comparator');
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_value']      = array('Value');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['members_legend'] = 'Members settings';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['members'] = array(
	'Members',
	'Use the Contao integrated members management.'
);

$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter_conditions']['in']     = 'in';
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter_conditions']['not in'] = 'not in';

$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparators']['empty']     = 'is empty';
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparators']['not_empty'] = 'is not empty';
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparators']['eq']        = '==';
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparators']['neq']       = '!=';
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparators']['gt']        = '>';
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparators']['gte']       = '>=';
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparators']['lt']        = '<';
$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparators']['lte']       = '<=';
