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
 * Define subscription managers
 */

$container['avisota.subscription.member'] = $container->share(
	function ($container) {
		return new \Avisota\Contao\Core\SubscriptionMember\Subscription\MemberSubscriptionManager();
	}
);

$container['avisota.subscription.managers']->append('avisota.subscription.member');
