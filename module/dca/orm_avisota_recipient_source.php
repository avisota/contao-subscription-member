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

use ContaoCommunityAlliance\Contao\Events\CreateOptions\CreateOptionsEventCallbackFactory;

/**
 * Table orm_avisota_recipient_source
 * Entity Avisota\Contao:RecipientSource
 */
$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['metapalettes']['integrated_member_by_mailing_list'] = array(
	'source'     => array('title', 'alias', 'type'),
	'integrated' => array('mailingLists', 'integratedRecipientManageSubscriptionPage'),
	'details'    => array('integratedDetails', 'salutation'),
	'expert'     => array('disable'),
);

$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['fields']['integratedRecipientManageSubscriptionPage'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['integratedRecipientManageSubscriptionPage'],
	'exclude'   => true,
	'inputType' => 'pageTree',
	'eval'      => array(
		'fieldType' => 'radio',
		'mandatory' => true,
	)
);
