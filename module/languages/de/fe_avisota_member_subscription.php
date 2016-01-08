<?php
/**
 * Translations are managed using Transifex. To create a new translation
 * or to help to maintain an existing one, please register at transifex.com.
 *
 * @link    http://help.transifex.com/intro/translating.html
 * @link    https://www.transifex.com/projects/p/avisota-contao/language/de/
 *
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 *
 * last-updated: 2014-08-07T04:02:29+02:00
 */

global $TL_LANG;

$feAvisotaMemberSubscription = array
(
    'allreadySubscribed'
    => 'Vielen Dank, aber Sie sind bereits für diesen Newsletter angemeldet.',
    'confirm'
    => 'Abonnement bestätigen',
    'manage_subscription'
    => 'Verwalten Sie Ihr Abonnement',
    'notSubscribed'
    => 'Sie sind für diesen Newsletter nicht angemeldet.',
    'subscribe'
    => 'Anmelden',
    'subscribeConfirmation'
    => 'Ihre Anmeldung wurde erfolgreich aktiviert.',
    'subscribed'
    => 'Vielen Dank, Sie sind nun angemeldet. Bitte sehen Sie in Ihr Postfach, um die Bestätigungs-Mail anzusehen.',
    'unsubscribe'
    => 'Abmelden',
    'unsubscribe_direct'
    => 'Abmelden',
    'unsubscribed'
    => 'Sie sind jetzt von unserem Newsletter abgemeldet.',
);

$TL_LANG['fe_avisota_member_subscription'] = array_merge(
    $TL_LANG['fe_avisota_member_subscription'],
    $feAvisotaMemberSubscription
);
