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

namespace Avisota\Contao\SubscriptionMember\RecipientSource;

use Avisota\Contao\Core\CoreEvents;
use Avisota\Contao\Core\Event\CreateRecipientSourceEvent;
use Avisota\Contao\Core\RecipientSource\RecipientSourceFactoryInterface;
use Avisota\Contao\Entity\RecipientSource;
use ContaoCommunityAlliance\Contao\Bindings\ContaoEvents;
use ContaoCommunityAlliance\Contao\Bindings\Events\Controller\GenerateFrontendUrlEvent;
use ContaoCommunityAlliance\Contao\Bindings\Events\Controller\GetPageDetailsEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MembersRecipientSourceFactory implements RecipientSourceFactoryInterface
{
	public function createRecipientSource(RecipientSource $recipientSourceEntity)
	{
		$recipientSource = new MembersRecipientSource();

		if ($recipientSourceEntity->getFilter()) {
			if ($recipientSourceEntity->getMembersUseGroupFilter()) {
				$recipientSource->setFilteredGroups($recipientSourceEntity->getMembersGroupFilter());
			}
			/*
			if ($recipientSourceEntity->getFilterByMailingLists()) {
				$recipientSource->setFilteredMailingLists($recipientSourceEntity->getMailingLists()->toArray());
			}
			*/
			if ($recipientSourceEntity->getRecipientsUsePropertyFilter()) {
				$recipientSource->setFilteredProperties($recipientSourceEntity->getMembersPropertyFilter());
			}
		}

		/** @var EventDispatcherInterface $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		/*
		if ($recipientSourceEntity->getMembersManageSubscriptionPage()) {
			$getPageDetailsEvent = new GetPageDetailsEvent($recipientSourceEntity->getMembersManageSubscriptionPage());
			$eventDispatcher->dispatch(ContaoEvents::CONTROLLER_GET_PAGE_DETAILS, $getPageDetailsEvent);

			$generateFrontendUrlEvent = new GenerateFrontendUrlEvent($getPageDetailsEvent->getPageDetails());
			$eventDispatcher->dispatch(ContaoEvents::CONTROLLER_GENERATE_FRONTEND_URL, $generateFrontendUrlEvent);

			$url = $generateFrontendUrlEvent->getUrl();
			$url .= (strpos($url, '?') !== false ? '&' : '?') . 'avisota_subscription_email=##email##';

			if (!preg_match('~^\w+:~', $url)) {
				$environment = \Environment::getInstance();
				$url         = rtrim($environment->base, '/') . '/' . ltrim($url, '/');
			}

			$recipientSource->setManageSubscriptionUrlPattern($url);
		}
		*/

		/*
		if ($recipientSourceEntity->getMembersUnsubscribePage()) {
			$getPageDetailsEvent = new GetPageDetailsEvent($recipientSourceEntity->getMembersUnsubscribePage());
			$eventDispatcher->dispatch(ContaoEvents::CONTROLLER_GET_PAGE_DETAILS, $getPageDetailsEvent);

			$generateFrontendUrlEvent = new GenerateFrontendUrlEvent($getPageDetailsEvent->getPageDetails());
			$eventDispatcher->dispatch(ContaoEvents::CONTROLLER_GENERATE_FRONTEND_URL, $generateFrontendUrlEvent);

			$url = $generateFrontendUrlEvent->getUrl();
			$url .= (strpos($url, '?') !== false ? '&' : '?') . 'avisota_subscription_email=##email##';

			if (!preg_match('~^\w+:~', $url)) {
				$environment = \Environment::getInstance();
				$url         = rtrim($environment->base, '/') . '/' . ltrim($url, '/');
			}

			$recipientSource->setUnsubscribeUrlPattern($url);
		}
		*/

		$event = new CreateRecipientSourceEvent($recipientSourceEntity, $recipientSource);
		$eventDispatcher->dispatch(CoreEvents::CREATE_RECIPIENT_SOURCE, $event);

		return $event->getRecipientSource();
	}
}
