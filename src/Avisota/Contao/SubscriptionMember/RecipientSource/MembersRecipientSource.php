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

use Avisota\Contao\Entity\MailingList;
use Avisota\Recipient\MutableRecipient;
use Avisota\RecipientSource\RecipientSourceInterface;
use ContaoCommunityAlliance\Contao\Bindings\ContaoEvents;
use ContaoCommunityAlliance\Contao\Bindings\Events\System\LoadLanguageFileEvent;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\DBAL\Statement;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class MembersRecipientSource
 */
class MembersRecipientSource implements RecipientSourceInterface
{
	/**
	 * @var array
	 */
	protected $filteredGroups = array();

	/**
	 * @var MailingList[]
	 */
	protected $filteredMailingLists = array();

	/**
	 * @var array
	 */
	protected $filteredProperties = array();

	/**
	 * @var string
	 */
	protected $manageSubscriptionUrlPattern = null;

	/**
	 * @var string
	 */
	protected $unsubscribeUrlPattern = null;

	/**
	 * Count the recipients.
	 *
	 * @return int
	 */
	public function countRecipients()
	{
		global $container;

		/** @var Connection $connection */
		$connection = $container['doctrine.connection.default'];

		$queryBuilder = $connection->createQueryBuilder();
		$queryBuilder
			->select('COUNT(m.id)')
			->from('tl_member', 'm')
            ->where('email IS NOT NULL')
            ->andWhere('LENGTH(email) > 0');
		$this->prepareQuery($queryBuilder);

		/** @var Statement $stmt */
		$stmt = $queryBuilder->execute();

		return (int) $stmt->fetchColumn();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRecipients($limit = null, $offset = null)
	{
		global $container;

		/** @var Connection $connection */
		$connection = $container['doctrine.connection.default'];

		$queryBuilder = $connection->createQueryBuilder();
		$queryBuilder
			->select('m.*')
			->from('tl_member', 'm')
            ->where('email IS NOT NULL')
            ->andWhere('LENGTH(email) > 0');
		$this->prepareQuery($queryBuilder);

		if ($limit > 0) {
			$queryBuilder->setMaxResults($limit);
		}
		if ($offset > 0) {
			$queryBuilder->setFirstResult($offset);
		}

		$queryBuilder->orderBy('m.id');

		/** @var PDOStatement $stmt */
		$stmt = $queryBuilder->execute();

		$mutableRecipients = array();

		/** @var EventDispatcherInterface $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		foreach ($stmt as $row) {
			if ($this->manageSubscriptionUrlPattern) {
				$loadLanguageEvent = new LoadLanguageFileEvent('fe_avisota_member_subscription');
				$eventDispatcher->dispatch(ContaoEvents::SYSTEM_LOAD_LANGUAGE_FILE, $loadLanguageEvent);

				$url = $this->manageSubscriptionUrlPattern;
				$url = preg_replace_callback(
					'~##([^#]+)##~',
					function ($matches) use ($row) {
						if (isset($row[$matches[1]])) {
							return $row[$matches[1]];
						}
						return $matches[0];
					},
					$url
				);

				$row['manage_subscription_link'] = array(
					'url'  => $url,
					'text' => &$GLOBALS['TL_LANG']['fe_avisota_member_subscription']['manage_subscription']
				);
			}

			if ($this->unsubscribeUrlPattern) {
				$loadLanguageEvent = new LoadLanguageFileEvent('fe_avisota_member_subscription');
				$eventDispatcher->dispatch(ContaoEvents::SYSTEM_LOAD_LANGUAGE_FILE, $loadLanguageEvent);

				$url = $this->unsubscribeUrlPattern;
				$url = preg_replace_callback(
					'~##([^#]+)##~',
					function ($matches) use ($row) {
						if (isset($row[$matches[1]])) {
							return $row[$matches[1]];
						}
						return $matches[0];
					},
					$url
				);

				$row['unsubscribe_link'] = array(
					'url'  => $url,
					'text' => &$GLOBALS['TL_LANG']['fe_avisota_member_subscription']['unsubscribe_direct']
				);
			}

			$mutableRecipients[] = new MutableRecipient(
				$row['email'],
				$row
			);
		}

		return $mutableRecipients;
	}

	protected function prepareQuery(QueryBuilder $queryBuilder)
	{
		$expr = $queryBuilder->expr();

		if (count($this->filteredGroups)) {
			foreach ($this->filteredGroups as $index => $filteredGroup) {
				$condition = $filteredGroup['membersGroupFilter_condition'];
				$group     = $filteredGroup['membersGroupFilter_group'];

				switch ($condition) {
					case 'in':
						$where = $expr->orX();
						$where->add($expr->like('m.groups', ':groupPattern1_' . $index));
						$where->add($expr->like('m.groups', ':groupPattern2_' . $index));
						break;

					case 'not in':
						$where = $expr->andX();
						$where->add($expr->notLike('m.groups', ':groupPattern1_' . $index));
						$where->add($expr->notLike('m.groups', ':groupPattern2_' . $index));
						break;

					default:
						continue 2;
				}

				$queryBuilder
					->andWhere($where)
					// serialized int value
					->setParameter('groupPattern1_' . $index, sprintf('%%i:%d;%%', $group))
					// serialized string value
					->setParameter('groupPattern2_' . $index, sprintf('%%s:%d:"%d";%%', strlen($group), $group));
			}
		}

		if (count($this->filteredMailingLists)) {
			$queryBuilder
				->innerJoin('m', 'orm_avisota_subscription', 's', 's.recipientType = :recipientType AND s.recipientId = m.id')
				->setParameter('recipientType', 'member');

			$or = $expr->orX();
			foreach ($this->filteredMailingLists as $index => $mailingList) {
				$or->add($expr->eq('s.mailingList', ':mailingList' . $index));
				$queryBuilder->setParameter('mailingList' . $index, $mailingList->getId());
			}

			$queryBuilder->andWhere($or);
		}

		if (count($this->filteredProperties)) {
			foreach ($this->filteredProperties as $index => $filteredProperty) {
				$property   = 'm.' . $filteredProperty['membersPropertyFilter_property'];
				$comparator = $filteredProperty['membersPropertyFilter_comparator'];
				$value      = $filteredProperty['membersPropertyFilter_value'];

				switch ($comparator) {
					case 'empty':
						$queryBuilder->andWhere(
							$expr->orX(
								$expr->eq($property, ':property' . $index),
								$expr->isNull($property)
							)
						);
						$value = '';
						break;

					case 'not empty':
						$queryBuilder->andWhere(
							$expr->gt($property, ':property' . $index)
						);
						$value = '';
						break;

					case 'eq':
						$queryBuilder->andWhere(
							$expr->eq($property, ':property' . $index)
						);
						break;

					case 'neq':
						$queryBuilder->andWhere(
							$expr->neq($property, ':property' . $index)
						);
						break;

					case 'gt':
						$queryBuilder->andWhere(
							$expr->gt($property, ':property' . $index)
						);
						break;

					case 'gte':
						$queryBuilder->andWhere(
							$expr->gte($property, ':property' . $index)
						);
						break;

					case 'lt':
						$queryBuilder->andWhere(
							$expr->lt($property, ':property' . $index)
						);
						break;

					case 'lte':
						$queryBuilder->andWhere(
							$expr->lte($property, ':property' . $index)
						);
						break;
				}

				$queryBuilder->setParameter(
					':property' . $index,
					$value
				);
			}
		}
	}

	/**
	 * @param array $filteredGroups
	 *
	 * @return static
	 */
	public function setFilteredGroups(array $filteredGroups)
	{
		$this->filteredGroups = $filteredGroups;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getFilteredGroups()
	{
		return $this->filteredGroups;
	}

	/**
	 * @return \Avisota\Contao\Entity\MailingList[]
	 */
	public function getFilteredMailingLists()
	{
		return $this->filteredMailingLists;
	}

	/**
	 * @param MailingList[] $filteredMailingLists
	 *
	 * @return static
	 */
	public function setFilteredMailingLists(array $filteredMailingLists)
	{
		$this->filteredMailingLists = array_values($filteredMailingLists);
		return $this;
	}

	/**
	 * @return array
	 */
	public function getFilteredProperties()
	{
		return $this->filteredProperties;
	}

	/**
	 * @param array $filteredProperties
	 *
	 * @return static
	 */
	public function setFilteredProperties(array $filteredProperties)
	{
		$this->filteredProperties = $filteredProperties;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getManageSubscriptionUrlPattern()
	{
		return $this->manageSubscriptionUrlPattern;
	}

	/**
	 * @param string $manageSubscriptionUrlPattern
	 *
	 * @return static
	 */
	public function setManageSubscriptionUrlPattern($manageSubscriptionUrlPattern)
	{
		$this->manageSubscriptionUrlPattern = empty($manageSubscriptionUrlPattern) ? null : (string) $manageSubscriptionUrlPattern;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUnsubscribeUrlPattern()
	{
		return $this->unsubscribeUrlPattern;
	}

	/**
	 * @param string $unsubscribeUrlPattern
	 *
	 * @return static
	 */
	public function setUnsubscribeUrlPattern($unsubscribeUrlPattern)
	{
		$this->unsubscribeUrlPattern = empty($unsubscribeUrlPattern) ? null : (string) $unsubscribeUrlPattern;
		return $this;
	}
}
