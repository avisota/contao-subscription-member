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

namespace Avisota\Contao\SubscriptionMember;

use Avisota\Contao\Core\DataContainer\OptionsBuilder;
use Avisota\Contao\Entity\Recipient;
use Avisota\Contao\Entity\Subscription;
use Avisota\Contao\Subscription\Event\PrepareSubscriptionEvent;
use Avisota\Contao\Subscription\Event\ResolveRecipientEvent;
use Avisota\Contao\Subscription\Event\SubscriptionAwareEvent;
use Avisota\Contao\Subscription\SubscriptionEvents;
use Avisota\Contao\Subscription\SubscriptionManager;
use Avisota\Contao\SubscriptionNotificationCenterBridge\Event\BuildTokensFromRecipientEvent;
use Avisota\Contao\SubscriptionRecipient\Event\ExportRecipientPropertyEvent;
use Avisota\Contao\SubscriptionRecipient\Event\MigrateRecipientEvent;
use Contao\Doctrine\DBAL\DoctrineDbalEvents;
use Contao\Doctrine\DBAL\Event\InitializeEventManager;
use Contao\Doctrine\ORM\EntityAccessor;
use Contao\Doctrine\ORM\EntityHelper;
use ContaoCommunityAlliance\Contao\Bindings\ContaoEvents;
use ContaoCommunityAlliance\Contao\Bindings\Events\Backend\AddToUrlEvent;
use ContaoCommunityAlliance\Contao\Bindings\Events\Controller\LoadDataContainerEvent;
use ContaoCommunityAlliance\Contao\Bindings\Events\Controller\RedirectEvent;
use ContaoCommunityAlliance\Contao\Bindings\Events\Controller\ReloadEvent;
use ContaoCommunityAlliance\Contao\Bindings\Events\System\LoadLanguageFileEvent;
use ContaoCommunityAlliance\Contao\Events\CreateOptions\CreateOptionsEvent;
use ContaoCommunityAlliance\DcGeneral\Contao\View\Contao2BackendView\Event\GetEditModeButtonsEvent;
use ContaoCommunityAlliance\DcGeneral\Contao\View\Contao2BackendView\Event\GetPropertyOptionsEvent;
use ContaoCommunityAlliance\DcGeneral\DcGeneralEvents;
use ContaoCommunityAlliance\DcGeneral\EnvironmentInterface;
use ContaoCommunityAlliance\DcGeneral\Event\ActionEvent;
use ContaoCommunityAlliance\DcGeneral\Event\EventPropagator;
use ContaoCommunityAlliance\DcGeneral\Factory\DcGeneralFactory;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class EventsSubscriber
 */
class EventsSubscriber implements EventSubscriberInterface
{
	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'avisota.subscription-notification-center-bridge.build-tokens-from-recipient' => 'buildRecipientTokens',
		);
	}

	public function buildRecipientTokens(BuildTokensFromRecipientEvent $event)
	{
		$recipient = $event->getRecipient();

		/*
		if (!preg_match('~^member:(\d+)$~', $recipient, $matches)) {
			return;
		}

		$memberId = $matches[1];
		$member   = \MemberModel::findByPk($memberId);

		// member does not exists (anymore)
		if (!$member) {
			return;
		}

		/** @var \MemberModel $member * /

		$tokens = $event->getTokens();

		foreach ($member->row() as $key => $value) {
			$tokens['recipient_' . $key] = $value;
		}
		*/
	}
}
