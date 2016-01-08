<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2015 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @package    avisota/contao-core
 * @license    LGPL-3.0+
 * @filesource
 */


MetaPalettes::appendBefore('tl_member', 'default', 'login', array('avisota' => array(':hide', 'avisota_lists', 'avisota_subscriptionAction')));
/*
$GLOBALS['TL_DCA']['tl_member']['config']['onload_callback'][]   = array('AvisotaDCA', 'filterByMailingLists');
$GLOBALS['TL_DCA']['tl_member']['config']['onload_callback'][]   = array('tl_member_avisota', 'onload_callback');
$GLOBALS['TL_DCA']['tl_member']['config']['onsubmit_callback'][] = array('tl_member_avisota', 'onsubmit_callback');
*/
$GLOBALS['TL_DCA']['tl_member']['config']['onsubmit_callback'][] = array('Avisota\Contao\Core\DataContainer\Member', 'onsubmit_callback');

$GLOBALS['TL_DCA']['tl_member']['fields']['avisota_lists'] = array
(
	'label'            => &$GLOBALS['TL_LANG']['tl_member']['avisota_lists'],
	'inputType'        => 'checkbox',
	'options_callback' => \ContaoCommunityAlliance\Contao\Events\CreateOptions\CreateOptionsEventCallbackFactory::createCallback(
		\Avisota\Contao\Core\CoreEvents::CREATE_MAILING_LIST_OPTIONS,
		'Avisota\Contao\Core\Event\CreateOptionsEvent'
	),
	'load_callback'    => array(array('Avisota\Contao\Core\DataContainer\Member', 'loadMailingLists')),
	'save_callback'    => array
	(
		array('Avisota\Contao\Core\DataContainer\Member', 'validateBlacklist'),
		array('Avisota\Contao\Core\DataContainer\Member', 'saveMailingLists')
	),
	'eval'             => array
	(
		'multiple'   => true,
		'feEditable' => true,
		'feGroup'    => 'newsletter'
	)
);

$GLOBALS['TL_DCA']['tl_member']['fields']['avisota_subscriptionAction']    = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_member']['avisota_subscriptionAction'],
	'inputType'     => 'select',
	'options'       => array('sendConfirmation', 'activateSubscription', 'doNothink', 'sendOptIn'),
	'reference'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient'],
	'eval'          => array(
		'doNotSaveEmpty' => false,
		'doNotCopy'      => true,
		'doNotShow'      => true
	),
	'save_callback' => array(array('Avisota\Contao\Core\DataContainer\Member', 'saveSubscriptionAction')),
	'field'         => false,
);

/*
$GLOBALS['TL_DCA']['tl_member']['fields']['avisota_subscribe'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_member']['avisota_subscribe'],
	'inputType' => 'checkbox',
	'eval'      => array
	(
		'feEditable' => true,
		'feGroup'    => 'newsletter'
	)
);
*/
