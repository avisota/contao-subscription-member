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


/**
 * Module
 */
$modAvisotaSubscriptionMember = array(
    'Avisota - Subscription for members',
    'Contao member subscription for Avisota.'
);

$GLOBALS['TL_LANG']['MOD']['avisota-subscription-member'] = array_merge(
    $GLOBALS['TL_LANG']['MOD']['avisota-subscription-member'],
    $modAvisotaSubscriptionMember
);
