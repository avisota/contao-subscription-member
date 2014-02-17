<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2013 Tristan Lins
 *
 * PHP version 5
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    avisota/contao-subscription-member
 * @license    LGPL-3.0+
 * @filesource
 */


/**
 * Entities
 */
$GLOBALS['DOCTRINE_ENTITIES'][] = 'orm_avisota_member_subscription';


/**
 * Recipient sources
 */
$GLOBALS['AVISOTA_RECIPIENT_SOURCE']['integrated_member_by_mailing_list'] = 'Avisota\Contao\Core\RecipientSource\IntegratedRecipientsAndMembersByMailingListFactory';
