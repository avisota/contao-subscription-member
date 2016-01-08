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
 * last-updated: 2014-08-07T04:02:31+02:00
 */

global $TL_LANG;

$ormAvisotaRecipientSource = array(
    'members_legend'
    => 'Mitgliedereinstellungen',

    'members' => array(
        'Mitglieder',
        'Das in Contao integrierte Mitgliedermanagement benutzen.',
    ),

    'membersGroupFilter' => array(
        'Gruppenfilter',
        'Filtern Sie die Empfänger nach Zugehörigkeit zu Gruppen.',
    ),

    'membersGroupFilter_condition' => array(
        'Bedingung',
        'in'     => 'enthält',
        'not in' => 'enthält nicht',
    ),

    'membersGroupFilter_group' => array(
        'Gruppe'
    ),

    'membersManageSubscriptionPage' => array(
        'Verwaltungsseite',
        'Bitte wählen Sie die Seite aus, auf der das Abonnement verwaltet wird.',
    ),

    'membersPropertyFilter' => array(
        'Werte-Filter',
        'Abonnenten nach Werten filtern.',
    ),

    'membersPropertyFilter_comparator' => array(
        'Vergleichsoperator',
        'empty'     => 'ist leer',
        'eq'        => '==',
        'gt'        => '>',
        'gte'       => '>=',
        'lt'        => '<',
        'lte'       => '<=',
        'neq'       => '!=',
        'not_empty' => 'Ist nicht leer',
    ),
    'membersPropertyFilter_property'   => array(
        'Spalte',
    ),

    'membersPropertyFilter_value' => array(
        'Wert',
    ),

    'membersUnsubscribePage' => array(
        'Abmeldeseite',
        'Bitte wählen Sie die Seite aus, die für direkte Abbestellungen benutzt werden soll.',
    ),

    'membersUseGroupFilter' => array(
        'Nach Gruppen filtern',
        'Filtern Sie die Empfänger nach Zugehörigkeit zu Gruppen.',
    ),

    'membersUsePropertyFilter' => array(
        'Nach Eigenschaften filtern',
        'Abonnenten nach Eigenschaften und Werten filtern.',
    ),
);

$TL_LANG['orm_avisota_recipient_source'] = array_merge(
    $TL_LANG['orm_avisota_recipient_source'],
    $ormAvisotaRecipientSource
);
