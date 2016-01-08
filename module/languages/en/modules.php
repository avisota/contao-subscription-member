<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2015 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision
 * @author     Sven Baumann <baumann.sv@gmil.com>
 * @package    avisota/contao-subscription-member
 * @license    LGPL-3.0+
 * @filesource
 */

global $TL_LANG;

/**
 * Module
 */
$modAvisotaSubscriptionMember = array(
    'Avisota - Subscription for members',
    'Contao member subscription for Avisota.'
);

$TL_LANG['MOD']['avisota-subscription-member'] = array_merge(
    $TL_LANG['MOD']['avisota-subscription-member'],
    $modAvisotaSubscriptionMember
);
