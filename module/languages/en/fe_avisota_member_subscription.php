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

$feAvisotaMemberSubscription = array(
    'subscribe'
    => 'Subscribe',
    'unsubscribe'
    => 'Unsubscribe',
    'subscribed'
    => 'Thank you very much, you are now subscribed. Please check your inbox for confirmation email.',
    'allreadySubscribed'
    => 'Thank you very much, but you are already subscribed to our newsletter.',
    'subscribeConfirmation'
    => 'Your subscription was successfully activated.',
    'unsubscribed'
    => 'You\'r now unsubscribed from our newsletter.',
    'notSubscribed'
    => 'You\'r not subscribed to our newsletter.',
    'confirm'
    => 'confirm subscriptions',
    'manage_subscription'
    => 'Manage your subscription',
    'unsubscribe_direct'
    => 'Unsubscribe',
);

$GLOBALS['TL_LANG']['fe_avisota_member_subscription'] = array_merge(
    $GLOBALS['TL_LANG']['fe_avisota_member_subscription'],
    $feAvisotaMemberSubscription
);
