<?php
/**
 * Translations are managed using Transifex. To create a new translation
 * or to help to maintain an existing one, please register at transifex.com.
 *
 * @link    http://help.transifex.com/intro/translating.html
 * @link    https://www.transifex.com/projects/p/avisota-contao/language/rm/
 *
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 *
 * last-updated: 2014-08-07T04:02:31+02:00
 */

global $TL_LANG;

$ormAvisotaRecipientSource = array(
    'members_legend'
    => 'Configuraziun da commembers',

    'members' => array(
        'Commembers',
        'Utilisar l\'administraziun da commembers da Contao.',
    ),

    'membersGroupFilter' => array(
        'Filter da gruppas',
        'Filtrar ils destinaturs tenor gruppas.',
    ),

    'membersGroupFilter_condition' => array(
        'Cundiziun',
        'in'     => 'en',
        'not in' => 'betg en',
    ),

    'membersGroupFilter_group' => array(
        'Gruppa',
    ),

    'membersManageSubscriptionPage' => array(
        'Pagina d\'administraziun dils abunaments',
        'Tscherna la pagina per l\'administraziun dals abunaments.',
    ),

    'membersPropertyFilter' => array(
        'Filter da caracteristicas',
        'Filtrar ils destinaturs tenor las valurs da caracteristicas.',
    ),

    'membersPropertyFilter_comparator' => array(
        'Cumparegliader',
        'empty'     => 'è vid',
        'eq'        => '==',
        'gt'        => '>',
        'gte'       => '>=',
        'lt'        => '<',
        'lte'       => '<=',
        'neq'       => '!=',
        'not_empty' => 'n\'è betg vid',
    ),

    'membersPropertyFilter_property' => array(
        'Colonnas',
    ),

    'membersPropertyFilter_value' => array(
        'Valur',
    ),

    'membersUnsubscribePage' => array(
        'Pabina per de-abunar',
        'Tscherna la pagina per de-abunar directamain.',
    ),

    'membersUseGroupFilter' => array(
        'Filtrar tenor gruppas',
        'Filtrar ils destinaturs tenor gruppas.',
    ),

    'membersUsePropertyFilter' => array(
        'Filtrar tenor caracteristicas',
        'Filtrar ils destinaturs tenor caracteristicas e valurs.',
    ),
);

$TL_LANG['orm_avisota_recipient_source'] = array_merge(
    $TL_LANG['orm_avisota_recipient_source'],
    $ormAvisotaRecipientSource
);
