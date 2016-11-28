<?php

/**
 * Avisota newsletter and mailing system
 * Copyright © 2016 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision 2016
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @package    avisota/contao-subscription-member
 * @license    LGPL-3.0+
 * @filesource
 */

namespace Avisota\Contao\SubscriptionMember\RecipientSource;

use Avisota\Contao\Core\Service\SuperglobalsService;
use Avisota\Contao\Entity\MailingList;
use Avisota\Recipient\MutableRecipient;
use Avisota\RecipientSource\RecipientSourceInterface;
use ContaoCommunityAlliance\Contao\Bindings\ContaoEvents;
use ContaoCommunityAlliance\Contao\Bindings\Events\System\LoadLanguageFileEvent;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Statement;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class MembersRecipientSource
 * @SuppressWarnings(PHPMD.LongVariables)
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
     * @param null $limit
     * @param null $offset
     *
     * @return array
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
        $eventDispatcher = $container['event-dispatcher'];

        /** @var SuperglobalsService $superglobals */
        $superglobals = $container['avisota.superglobals'];

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

                $row['manage_subscription_link'] = array
                (
                    'url'  => $url,
                    'text' => $superglobals->getLanguage('fe_avisota_member_subscription/manage_subscription')
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

                $row['unsubscribe_link'] = array
                (
                    'url'  => $url,
                    'text' => $superglobals->getLanguage('fe_avisota_member_subscription/unsubscribe_direct')
                );
            }

            $mutableRecipients[] = new MutableRecipient(
                $row['email'],
                $row
            );
        }

        return $mutableRecipients;
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    protected function prepareQuery(QueryBuilder $queryBuilder)
    {
        $expressionBuilder = $queryBuilder->expr();

        $this->addFilteredGroups($queryBuilder, $expressionBuilder);
        $this->addFilteredMailingLists($queryBuilder, $expressionBuilder);
        $this->addFilteredMailingLists($queryBuilder, $expressionBuilder);
    }

    /**
     * @param $queryBuilder
     * @param $expressionBuilder
     */
    protected function addFilteredGroups(QueryBuilder &$queryBuilder, ExpressionBuilder $expressionBuilder)
    {
        if (!count($this->filteredGroups)) {
            return;
        }

        foreach ($this->filteredGroups as $index => $filteredGroup) {
            $condition = $filteredGroup['membersGroupFilter_condition'];
            $group     = $filteredGroup['membersGroupFilter_group'];

            switch ($condition) {
                case 'in':
                    $where = $expressionBuilder->orX();
                    $where->add('m.groups REGEXP :groupPattern_' . $index);
                    break;

                case 'not in':
                    $where = $expressionBuilder->andX();
                    $where->add('m.groups NOT REGEXP :groupPattern_' . $index);
                    break;

                default:
                    continue 2;
            }

            $queryBuilder
                ->andWhere($where)
                ->setParameter(
                    'groupPattern_' . $index,
                    strtr(
                        '^a:[[:digit:]]+:\{([is]:[[:digit:]]+(:"[[:alnum:]]+")?;'
                        . '[is]:[[:digit:]]+(:"[[:alnum:]]+")?;)*[is]:[[:digit:]]+(:"[[:alnum:]]+")?;'
                        . '(s:%length%:"%id%"|i:%id%);',
                        array
                        (
                            '%length%' => strlen($group),
                            '%id%'     => $group,
                        )
                    )
                );
        }
    }

    /**
     * @param $queryBuilder
     * @param $expressionBuilder
     */
    protected function addFilteredMailingLists(QueryBuilder &$queryBuilder, ExpressionBuilder $expressionBuilder)
    {
        if (!count($this->filteredMailingLists)) {
            return;
        }

        $queryBuilder
            ->innerJoin(
                'm',
                'orm_avisota_subscription',
                's',
                's.recipientType = :recipientType AND s.recipientId = m.id'
            );
        $queryBuilder->setParameter('recipientType', 'member');

        $orExpression = $expressionBuilder->orX();
        foreach ($this->filteredMailingLists as $index => $mailingList) {
            $orExpression->add($expressionBuilder->eq('s.mailingList', ':mailingList' . $index));
            $queryBuilder->setParameter('mailingList' . $index, $mailingList->getId());
        }

        $queryBuilder->andWhere($orExpression);
    }

    /**
     * @param $queryBuilder
     * @param $expressionBuilder
     */
    protected function addFilteredProperties(QueryBuilder &$queryBuilder, ExpressionBuilder $expressionBuilder)
    {
        if (!count($this->filteredProperties)) {
            return;
        }

        foreach ($this->filteredProperties as $index => $filteredProperty) {
            $property   = 'm.' . $filteredProperty['membersPropertyFilter_property'];
            $comparator = $filteredProperty['membersPropertyFilter_comparator'];
            $value      = $filteredProperty['membersPropertyFilter_value'];

            switch ($comparator) {
                case 'empty':
                    $queryBuilder->andWhere(
                        $expressionBuilder->orX(
                            $expressionBuilder->eq($property, ':property' . $index),
                            $expressionBuilder->isNull($property)
                        )
                    );
                    $value = '';
                    break;

                case 'not empty':
                    $queryBuilder->andWhere(
                        $expressionBuilder->gt($property, ':property' . $index)
                    );
                    $value = '';
                    break;

                default:
                    if (!method_exists($expressionBuilder, $comparator)) {
                        continue;
                    }

                    $queryBuilder->andWhere(
                        $expressionBuilder->$comparator($property, ':property' . $index)
                    );
                    break;
            }

            $queryBuilder->setParameter(
                ':property' . $index,
                $value
            );
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
        $this->manageSubscriptionUrlPattern =
            empty($manageSubscriptionUrlPattern) ? null : (string) $manageSubscriptionUrlPattern;

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
        $this->unsubscribeUrlPattern =
            empty($unsubscribeUrlPattern) ? null : (string) $unsubscribeUrlPattern;

        return $this;
    }
}
