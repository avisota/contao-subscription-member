<?php

/**
 * Avisota newsletter and mailing system
 * Copyright © 2015 Sven Baumann
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

$MOD = array(
    'avisota-subscription-member' => array(
        'Avisota - Subscription for members',
        'Contao member subscription for Avisota.'
    ),
);

$TL_LANG['MOD'] = array_merge(
    $TL_LANG['MOD'],
    $MOD
);
