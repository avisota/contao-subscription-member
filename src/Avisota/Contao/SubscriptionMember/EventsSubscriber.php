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
use Avisota\Contao\Subscription\Event\PrepareSubscriptionEvent;
use Avisota\Contao\Subscription\Event\ResolveRecipientEvent;
use Avisota\Contao\Subscription\Event\SubscriptionAwareEvent;
use Avisota\Contao\Subscription\SubscriptionEvents;
use Avisota\Contao\Subscription\SubscriptionManager;
use Avisota\Contao\SubscriptionNotificationCenterBridge\Event\BuildTokensFromRecipientEvent;
use Avisota\Contao\SubscriptionRecipient\Event\ExportRecipientPropertyEvent;
use Avisota\Contao\SubscriptionRecipient\Event\MigrateRecipientEvent;
use ContaoCommunityAlliance\Contao\Bindings\ContaoEvents;
use ContaoCommunityAlliance\Contao\Bindings\Events\Controller\LoadDataContainerEvent;
use ContaoCommunityAlliance\Contao\Bindings\Events\System\LoadLanguageFileEvent;
use ContaoCommunityAlliance\DcGeneral\EnvironmentInterface;
use MenAtWork\MultiColumnWizard\Event\GetOptionsEvent;
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
            GetOptionsEvent::NAME                                                         => 'bypassCreateRecipientPropertiesOptions',
            'avisota.subscription-notification-center-bridge.build-tokens-from-recipient' => 'buildRecipientTokens',
        );
    }

    public function bypassCreateRecipientPropertiesOptions(GetOptionsEvent $event)
    {
        if ($event->getModel()->getProviderName() === 'orm_avisota_recipient_source'
            && !in_array($event->getSubPropertyName(), array('recipientsPropertyFilter_property', 'membersPropertyFilter_property'))
        ) {
            return;
        }

        $options = $event->getOptions();
        $options = $this->getRecipientPropertiesOptions($event->getEnvironment(), $options);
        $event->setOptions($options);
    }

    public function getRecipientPropertiesOptions(EnvironmentInterface $environment, $options = array())
    {
        $eventDispatcher = $environment->getEventDispatcher();

        $loadDataContainerEvent = new LoadDataContainerEvent('tl_member');
        $eventDispatcher->dispatch(ContaoEvents::CONTROLLER_LOAD_DATA_CONTAINER, $loadDataContainerEvent);

        $loadLanguageFileEvent = new LoadLanguageFileEvent('tl_member');
        $eventDispatcher->dispatch(ContaoEvents::SYSTEM_LOAD_LANGUAGE_FILE, $loadLanguageFileEvent);

        foreach ($GLOBALS['TL_DCA']['tl_member']['fields'] as $field => $config) {
            $options[$field] = is_array($config['label'])
                ? $config['label'][0]
                : $field;
        }

        return $options;
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
