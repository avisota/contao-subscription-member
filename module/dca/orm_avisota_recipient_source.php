<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2015 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision 2015
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @package    avisota/contao-subscription-recipient
 * @license    LGPL-3.0+
 * @filesource
 */

use \ContaoCommunityAlliance\DcGeneral\DataDefinition as DataDefinition;
use \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property as Property;

global $TL_DCA;

/**
 * Table orm_avisota_recipient_source
 * Entity Avisota\Contao:RecipientSource
 */
$metaPalettes = array(
    'members' => array(
        'source' => array('title', 'alias', 'type'),
        // TODO is this using in future
        // 'members' => array('membersManageSubscriptionPage', 'membersUnsubscribePage'),
        'filter' => array(
            'filter',
            'membersUseGroupFilter',
            // 'filterByMailingLists',
            'membersUsePropertyFilter',
            // TODO evaluate unused parameters
            function (
                $legendName,
                DataDefinition\Palette\Legend $legend,
                DataDefinition\Palette\Palette $palette,
                DataDefinition\Definition\PalettesDefinitionInterface $palettesDefinition
            ) {
                $membersUseGroupFilterProperty = $legend->getProperty('membersUseGroupFilter');
                $visibleCondition              = $membersUseGroupFilterProperty->getVisibleCondition();

                $typeCondition   = new Property\PropertyValueCondition('type', 'members');
                $filterCondition = new Property\PropertyTrueCondition('filter');

                /** @var Property\PropertyConditionInterface|Property\PropertyConditionChain $visibleCondition */
                if (!$visibleCondition
                    || !$visibleCondition instanceof Property\PropertyConditionChain
                    || $visibleCondition->getConjunction()
                       != Property\PropertyConditionChain::OR_CONJUNCTION
                ) {
                    $visibleCondition = new Property\PropertyConditionChain(
                        $visibleCondition ? array($visibleCondition) : array(),
                        Property\PropertyConditionChain::OR_CONJUNCTION
                    );
                }

                $visibleCondition->addCondition(
                    new Property\PropertyConditionChain(
                        array($typeCondition, $filterCondition)
                    )
                );

                $membersUseGroupFilterProperty->setVisibleCondition($visibleCondition);
            },
            /*
            function (
                $legendName,
                DataDefinition\Palette\Legend $legend,
                DataDefinition\Palette\Palette $palette,
                DataDefinition\Definition\PalettesDefinitionInterface $palettesDefinition
            ) {
                $filterByMailingListsProperty = $legend->getProperty('filterByMailingLists');
                $visibleCondition             = $filterByMailingListsProperty->getVisibleCondition();

                $typeCondition   = new Property\PropertyValueCondition(
                    'type', 'members'
                );
                $filterCondition = new Property\PropertyTrueCondition(
                    'filter'
                );

                /** @var Property\PropertyConditionInterface|Property\PropertyConditionChain $visibleCondition * /
                if (
                    !$visibleCondition ||
                    !$visibleCondition instanceof DataDefinition\Palette\Condition\Property\PropertyConditionChain ||
                    $visibleCondition->getConjunction(
                    ) != Property\PropertyConditionChain::OR_CONJUNCTION
                ) {
                    $visibleCondition = new Property\PropertyConditionChain(
                        $visibleCondition ? array($visibleCondition) : array(),
                        Property\PropertyConditionChain::OR_CONJUNCTION
                    );
                }

                $visibleCondition->addCondition(
                    new Property\PropertyConditionChain(
                        array($typeCondition, $filterCondition)
                    )
                );

                $filterByMailingListsProperty->setVisibleCondition($visibleCondition);
            },
            */
            // TODO evaluate unused parameters
            function (
                $legendName,
                DataDefinition\Palette\Legend $legend,
                DataDefinition\Palette\Palette $palette,
                DataDefinition\Definition\PalettesDefinitionInterface $palettesDefinition
            ) {
                $membersUsePropertyFilterProperty = $legend->getProperty('membersUsePropertyFilter');
                $visibleCondition                 = $membersUsePropertyFilterProperty->getVisibleCondition();

                $typeCondition   = new Property\PropertyValueCondition('type', 'members');
                $filterCondition = new Property\PropertyTrueCondition('filter');

                /** @var Property\PropertyConditionInterface|Property\PropertyConditionChain $visibleCondition */
                if (!$visibleCondition
                    || !$visibleCondition instanceof Property\PropertyConditionChain
                    || $visibleCondition->getConjunction() != Property\PropertyConditionChain::AND_CONJUNCTION
                ) {
                    $visibleCondition = new Property\PropertyConditionChain(
                        $visibleCondition ? array($visibleCondition) : array()
                    );
                }

                $visibleCondition->addCondition($typeCondition);
                $visibleCondition->addCondition($filterCondition);

                $membersUsePropertyFilterProperty->setVisibleCondition($visibleCondition);
            },
        ),
    ),

    'expert' => array('disable'),
);

$TL_DCA['orm_avisota_recipient_source']['metapalettes'] = array_merge(
    $TL_DCA['orm_avisota_recipient_source']['metapalettes'],
    $metaPalettes
);

$metaSubPalettes = array(
    'membersUsePropertyFilter' => array(
        'membersPropertyFilter',
    ),

    'membersUseGroupFilter' => array(
        'membersGroupFilter',
    ),
);

$TL_DCA['orm_avisota_recipient_source']['metasubpalettes'] = array_merge(
    $TL_DCA['orm_avisota_recipient_source']['metasubpalettes'],
    $metaSubPalettes
);

// TODO is this using in future
/*
$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['fields']['membersManageSubscriptionPage'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersManageSubscriptionPage'],
	'inputType' => 'pageTree',
	'eval'      => array(
		'mandatory' => false,
		'nullable'  => true,
	),
);

$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['fields']['membersUnsubscribePage'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersUnsubscribePage'],
	'inputType' => 'pageTree',
	'eval'      => array(
		'mandatory' => false,
		'nullable'  => true,
	),
);
*/

$fields = array(
    'membersUseGroupFilter' => array
    (
        'label'     =>
            &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersUseGroupFilter'],
        'inputType' => 'checkbox',
        'eval'      => array(
            'submitOnChange' => true,
        ),
        'field'     => array(
            'nullable' => true,
        ),
    ),

    'membersGroupFilter' => array(
        'label'     =>
            &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter'],
        'inputType' => 'multiColumnWizard',
        'eval'      => array(
            'mandatory'    => true,
            'columnFields' => array(
                'membersGroupFilter_condition' => array(
                    'label'     =>
                        &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter_condition'],
                    'inputType' => 'select',
                    'options'   => array(
                        'in',
                        'not in',
                    ),
                    'reference' =>
                        &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter_conditions'],
                    'eval'      => array(
                        'style' => 'width:60px',
                    ),
                ),
                'membersGroupFilter_group'     => array(
                    'label'      =>
                        &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter_group'],
                    'inputType'  => 'select',
                    'foreignKey' => 'tl_member_group.name',
                    'eval'       => array(
                        'style' => 'width:340px',
                    ),
                ),
            ),
        ),
        'field'     => array(
            'type'     => 'json_array',
            'nullable' => true,
        ),
    ),

    'membersUsePropertyFilter' => array(
        'label'     =>
            &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersUsePropertyFilter'],
        'inputType' => 'checkbox',
        'eval'      => array(
            'submitOnChange' => true,
        ),
        'field'     => array(
            'nullable' => true,
        ),
    ),

    'membersPropertyFilter' => array(
        'label'     =>
            &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter'],
        'inputType' => 'multiColumnWizard',
        'eval'      => array(
            'mandatory'    => true,
            'columnFields' => array(
                'membersPropertyFilter_property'   => array(
                    'label'     =>
                        &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_property'],
                    'inputType' => 'select',
                    'reference' =>
                        &$GLOBALS['TL_LANG']['orm_avisota_recipient'],
                    'eval'      => array(
                        'style' => 'width:200px',
                    ),
                ),
                'membersPropertyFilter_comparator' => array(
                    'label'     =>
                        &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparator'],
                    'inputType' => 'select',
                    'options'   => array(
                        'empty',
                        'not empty',
                        'eq',
                        'neq',
                        'gt',
                        'gte',
                        'lt',
                        'lte'
                    ),
                    'reference' =>
                        &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparators'],
                    'eval'      => array(
                        'style' => 'width:100px',
                    ),
                ),
                'membersPropertyFilter_value'      => array(
                    'label'     =>
                        &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_value'],
                    'inputType' => 'text',
                    'eval'      => array(
                        'style' => 'width:200px',
                    ),
                ),
            ),
        ),
        'field'     => array(
            'type'     => 'json_array',
            'nullable' => true,
        ),
    ),
);

$TL_DCA['orm_avisota_recipient_source']['fields'] = array_merge(
    $TL_DCA['orm_avisota_recipient_source']['fields'],
    $fields
);
