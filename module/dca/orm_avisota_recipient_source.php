<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2013 Tristan Lins
 *
 * PHP version 5
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    avisota/contao-subscription-recipient
 * @license    LGPL-3.0+
 * @filesource
 */


/**
 * Table orm_avisota_recipient_source
 * Entity Avisota\Contao:RecipientSource
 */
$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['metapalettes']['members'] = array(
	'source'  => array('title', 'alias', 'type'),
	// 'members' => array('membersManageSubscriptionPage', 'membersUnsubscribePage'),
	'filter'  => array(
		'filter',
		'membersUseGroupFilter',
		// 'filterByMailingLists',
		'membersUsePropertyFilter',
		function (
			$legendName,
			\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Legend $legend,
			\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Palette $palette,
			\ContaoCommunityAlliance\DcGeneral\DataDefinition\Definition\PalettesDefinitionInterface $palettesDefinition
		) {
			$membersUseGroupFilterProperty = $legend->getProperty('membersUseGroupFilter');
			$visibleCondition              = $membersUseGroupFilterProperty->getVisibleCondition();

			$typeCondition   = new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyValueCondition(
				'type', 'members'
			);
			$filterCondition = new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyTrueCondition(
				'filter'
			);

			/** @var \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionInterface|\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain $visibleCondition */
			if (
				!$visibleCondition ||
				!$visibleCondition instanceof \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain ||
				$visibleCondition->getConjunction()
				!= \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain::OR_CONJUNCTION
			) {
				$visibleCondition = new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain(
					$visibleCondition ? array($visibleCondition) : array(),
					\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain::OR_CONJUNCTION
				);
			}

			$visibleCondition->addCondition(
				new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain(
					array($typeCondition, $filterCondition)
				)
			);

			$membersUseGroupFilterProperty->setVisibleCondition($visibleCondition);
		},
		/*
		function (
			$legendName,
			\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Legend $legend,
			\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Palette $palette,
			\ContaoCommunityAlliance\DcGeneral\DataDefinition\Definition\PalettesDefinitionInterface $palettesDefinition
		) {
			$filterByMailingListsProperty = $legend->getProperty('filterByMailingLists');
			$visibleCondition             = $filterByMailingListsProperty->getVisibleCondition();

			$typeCondition   = new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyValueCondition(
				'type', 'members'
			);
			$filterCondition = new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyTrueCondition(
				'filter'
			);

			/** @var \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionInterface|\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain $visibleCondition * /
			if (
				!$visibleCondition ||
				!$visibleCondition instanceof \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain ||
				$visibleCondition->getConjunction(
				) != \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain::OR_CONJUNCTION
			) {
				$visibleCondition = new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain(
					$visibleCondition ? array($visibleCondition) : array(),
					\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain::OR_CONJUNCTION
				);
			}

			$visibleCondition->addCondition(
				new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain(
					array($typeCondition, $filterCondition)
				)
			);

			$filterByMailingListsProperty->setVisibleCondition($visibleCondition);
		},
		*/
		function (
			$legendName,
			\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Legend $legend,
			\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Palette $palette,
			\ContaoCommunityAlliance\DcGeneral\DataDefinition\Definition\PalettesDefinitionInterface $palettesDefinition
		) {
			$membersUsePropertyFilterProperty = $legend->getProperty('membersUsePropertyFilter');
			$visibleCondition                 = $membersUsePropertyFilterProperty->getVisibleCondition();

			$typeCondition   = new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyValueCondition(
				'type', 'members'
			);
			$filterCondition = new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyTrueCondition(
				'filter'
			);

			/** @var \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionInterface|\ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain $visibleCondition */
			if (
				!$visibleCondition ||
				!$visibleCondition instanceof \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain ||
				$visibleCondition->getConjunction(
				) != \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain::AND_CONJUNCTION
			) {
				$visibleCondition = new \ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property\PropertyConditionChain(
					$visibleCondition ? array($visibleCondition) : array()
				);
			}

			$visibleCondition->addCondition($typeCondition);
			$visibleCondition->addCondition($filterCondition);

			$membersUsePropertyFilterProperty->setVisibleCondition($visibleCondition);
		},
	),
	'expert'  => array('disable'),
);

$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['metasubpalettes']['membersUsePropertyFilter'] = array(
	'membersPropertyFilter',
);
$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['metasubpalettes']['membersUseGroupFilter']    = array(
	'membersGroupFilter',
);

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

$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['fields']['membersUseGroupFilter'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersUseGroupFilter'],
	'inputType' => 'checkbox',
	'eval'      => array(
		'submitOnChange' => true,
	),
	'field'     => array(
		'nullable' => true,
	),
);

$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['fields']['membersGroupFilter'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter'],
	'inputType' => 'multiColumnWizard',
	'eval'      => array(
		'mandatory'    => true,
		'columnFields' => array(
			'membersGroupFilter_condition' => array(
				'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter_condition'],
				'inputType' => 'select',
				'options'   => array('in', 'not in'),
				'reference' => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter_conditions'],
				'eval'      => array(
					'style' => 'width:60px'
				),
			),
			'membersGroupFilter_group'     => array(
				'label'      => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersGroupFilter_group'],
				'inputType'  => 'select',
				'foreignKey' => 'tl_member_group.name',
				'eval'       => array(
					'style' => 'width:340px'
				),
			),
		),
	),
	'field'     => array(
		'type'     => 'json_array',
		'nullable' => true,
	),
);

$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['fields']['membersUsePropertyFilter'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersUsePropertyFilter'],
	'inputType' => 'checkbox',
	'eval'      => array(
		'submitOnChange' => true,
	),
	'field'     => array(
		'nullable' => true,
	),
);

$GLOBALS['TL_DCA']['orm_avisota_recipient_source']['fields']['membersPropertyFilter'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter'],
	'inputType' => 'multiColumnWizard',
	'eval'      => array(
		'mandatory'    => true,
		'columnFields' => array(
			'membersPropertyFilter_property'   => array(
				'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_property'],
				'inputType' => 'select',
				'reference' => &$GLOBALS['TL_LANG']['orm_avisota_recipient'],
				'eval'      => array(
					'style' => 'width:200px'
				),
			),
			'membersPropertyFilter_comparator' => array(
				'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparator'],
				'inputType' => 'select',
				'options'   => array('empty', 'not empty', 'eq', 'neq', 'gt', 'gte', 'lt', 'lte'),
				'reference' => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_comparators'],
				'eval'      => array(
					'style' => 'width:100px'
				),
			),
			'membersPropertyFilter_value'      => array(
				'label'     => &$GLOBALS['TL_LANG']['orm_avisota_recipient_source']['membersPropertyFilter_value'],
				'inputType' => 'text',
				'eval'      => array(
					'style' => 'width:200px'
				),
			),
		),
	),
	'field'     => array(
		'type'     => 'json_array',
		'nullable' => true,
	),
);
