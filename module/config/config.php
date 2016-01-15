<?php

/**
 * Avisota newsletter and mailing system
 * Copyright © 2016 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision 2016
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @package    avisota/contao-subscription-member
 * @license    LGPL-3.0+
 * @filesource
 */

/**
 * Recipient sources
 */
$GLOBALS['AVISOTA_RECIPIENT_SOURCE']['members'] =
    'Avisota\Contao\SubscriptionMember\RecipientSource\MembersRecipientSourceFactory';

/**
 * Event subscribers
 */
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Avisota\Contao\SubscriptionMember\EventsSubscriber';
