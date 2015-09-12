<?php

namespace Auth\EntityManager;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Auth\Entity\User\Repository\Account as AccountRepository;
use Auth\Entity\ACL\Repository\Role as RoleRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\PessimisticLockException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\UnitOfWork;

/**
 *  Nakładka na EnityManager'a z doctrine w celu uspójnienia pobierania encji
 *
 * @package Auth
 */
class EntityManager implements EntityManagerInterface
{
    /**
     *  EntityManager z Doctrine 2
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *  Repozytorium account
     *
     * @return AccountRepository
     */
    public function getAccountRepository()
    {
        return $this->entityManager->getRepository('Auth\Entity\User\Account');
    }

    /**
     *  Zwraca repozytorium ról
     *
     * @return RoleRepository
     */
    public function getRoleRepository()
    {
        return $this->entityManager->getRepository('Auth\Entity\ACL\Role');
    }

    /**
     *  Tworzy nowa instancje encji wiadomosci w mailach
     *
     * @return \Mailer\Entity\Mailer\Message
     */
    public function createMailerMessageEntity()
    {
        //@TODO Dopisać pobieranie z "auth.entity.mailer.message"
        return new \Mailer\Entity\Mailer\Message();
    }

    /**
     *  Tworzy nowa instancje encji odbiorcy w mailach
     *
     * @return \Mailer\Entity\Mailer\Recipient
     */
    public function createMailerRecipientEntity()
    {
        //@TODO Dopisać pobieranie z "auth.entity.mailer.recipient"
        return new \Mailer\Entity\Mailer\Recipient();
    }

    /**
     * Returns the cache API for managing the second level cache regions or NULL if the cache is not enabled.
     *
     * @return \Doctrine\ORM\Cache|null
     */
    public function getCache()
    {
        return $this->entityManager->getCache();
    }

    /**
     * Gets the database connection object used by the EntityManager.
     *
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->entityManager->getConnection();
    }

    /**
     * Gets an ExpressionBuilder used for object-oriented construction of query expressions.
     *
     * Example:
     *
     * <code>
     *     $qb = $em->createQueryBuilder();
     *     $expr = $em->getExpressionBuilder();
     *     $qb->select('u')->from('User', 'u')
     *         ->where($expr->orX($expr->eq('u.id', 1), $expr->eq('u.id', 2)));
     * </code>
     *
     * @return \Doctrine\ORM\Query\Expr
     */
    public function getExpressionBuilder()
    {
        return $this->entityManager->getExpressionBuilder();
    }

    /**
     * Starts a transaction on the underlying database connection.
     *
     * @return void
     */
    public function beginTransaction()
    {
        $this->entityManager->beginTransaction();
    }

    /**
     * Executes a function in a transaction.
     *
     * The function gets passed this EntityManager instance as an (optional) parameter.
     *
     * {@link flush} is invoked prior to transaction commit.
     *
     * If an exception occurs during execution of the function or flushing or transaction commit,
     * the transaction is rolled back, the EntityManager closed and the exception re-thrown.
     *
     * @param callable $func The function to execute transactionally.
     *
     * @return mixed The non-empty value returned from the closure or true instead.
     */
    public function transactional($func)
    {
        return $this->entityManager->transactional($func);
    }

    /**
     * Commits a transaction on the underlying database connection.
     *
     * @return void
     */
    public function commit()
    {
        $this->entityManager->commit();
    }

    /**
     * Performs a rollback on the underlying database connection.
     *
     * @return void
     */
    public function rollback()
    {
        $this->entityManager->rollback();
    }

    /**
     * Creates a new Query object.
     *
     * @param string $dql The DQL string.
     *
     * @return Query
     */
    public function createQuery($dql = '')
    {
        return $this->entityManager->createQuery($dql);
    }

    /**
     * Creates a Query from a named query.
     *
     * @param string $name
     *
     * @return Query
     */
    public function createNamedQuery($name)
    {
        return $this->entityManager->createNamedQuery($name);
    }

    /**
     * Creates a native SQL query.
     *
     * @param string $sql
     * @param ResultSetMapping $rsm The ResultSetMapping to use.
     *
     * @return NativeQuery
     */
    public function createNativeQuery($sql, ResultSetMapping $rsm)
    {
        return $this->entityManager->createNativeQuery($sql, $rsm);
    }

    /**
     * Creates a NativeQuery from a named native query.
     *
     * @param string $name
     *
     * @return NativeQuery
     */
    public function createNamedNativeQuery($name)
    {
        return $this->entityManager->createNamedNativeQuery($name);
    }

    /**
     * Create a QueryBuilder instance
     *
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        return $this->entityManager->createQueryBuilder();
    }

    /**
     * Gets a reference to the entity identified by the given type and identifier
     * without actually loading it, if the entity is not yet loaded.
     *
     * @param string $entityName The name of the entity type.
     * @param mixed $id The entity identifier.
     *
     * @return object The entity reference.
     *
     * @throws ORMException
     */
    public function getReference($entityName, $id)
    {
        return $this->entityManager->getReference($entityName, $id);
    }

    /**
     * Gets a partial reference to the entity identified by the given type and identifier
     * without actually loading it, if the entity is not yet loaded.
     *
     * The returned reference may be a partial object if the entity is not yet loaded/managed.
     * If it is a partial object it will not initialize the rest of the entity state on access.
     * Thus you can only ever safely access the identifier of an entity obtained through
     * this method.
     *
     * The use-cases for partial references involve maintaining bidirectional associations
     * without loading one side of the association or to update an entity without loading it.
     * Note, however, that in the latter case the original (persistent) entity data will
     * never be visible to the application (especially not event listeners) as it will
     * never be loaded in the first place.
     *
     * @param string $entityName The name of the entity type.
     * @param mixed $identifier The entity identifier.
     *
     * @return object The (partial) entity reference.
     */
    public function getPartialReference($entityName, $identifier)
    {
        return $this->entityManager->getPartialReference($entityName, $identifier);
    }

    /**
     * Closes the EntityManager. All entities that are currently managed
     * by this EntityManager become detached. The EntityManager may no longer
     * be used after it is closed.
     *
     * @return void
     */
    public function close()
    {
        $this->entityManager->close();
    }

    /**
     * Creates a copy of the given entity. Can create a shallow or a deep copy.
     *
     * @param object $entity The entity to copy.
     * @param boolean $deep FALSE for a shallow copy, TRUE for a deep copy.
     *
     * @return object The new entity.
     *
     * @throws \BadMethodCallException
     */
    public function copy($entity, $deep = false)
    {
        return $this->entityManager->copy($entity, $deep);
    }

    /**
     * Acquire a lock on the given entity.
     *
     * @param object $entity
     * @param int $lockMode
     * @param int|null $lockVersion
     *
     * @return void
     *
     * @throws OptimisticLockException
     * @throws PessimisticLockException
     */
    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->entityManager->lock($entity, $lockMode, $lockVersion);
    }

    /**
     * Gets the EventManager used by the EntityManager.
     *
     * @return \Doctrine\Common\EventManager
     */
    public function getEventManager()
    {
        return $this->entityManager->getEventManager();
    }

    /**
     * Gets the Configuration used by the EntityManager.
     *
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->entityManager->getConfiguration();
    }

    /**
     * Check if the Entity manager is open or closed.
     *
     * @return bool
     */
    public function isOpen()
    {
        return $this->entityManager->isOpen();
    }

    /**
     * Gets the UnitOfWork used by the EntityManager to coordinate operations.
     *
     * @return UnitOfWork
     */
    public function getUnitOfWork()
    {
        return $this->entityManager->getUnitOfWork();
    }

    /**
     * Gets a hydrator for the given hydration mode.
     *
     * This method caches the hydrator instances which is used for all queries that don't
     * selectively iterate over the result.
     *
     * @deprecated
     *
     * @param int $hydrationMode
     *
     * @return \Doctrine\ORM\Internal\Hydration\AbstractHydrator
     */
    public function getHydrator($hydrationMode)
    {
        return $this->entityManager->getHydrator($hydrationMode);
    }

    /**
     * Create a new instance for the given hydration mode.
     *
     * @param int $hydrationMode
     *
     * @return \Doctrine\ORM\Internal\Hydration\AbstractHydrator
     *
     * @throws ORMException
     */
    public function newHydrator($hydrationMode)
    {
        return $this->entityManager->newHydrator($hydrationMode);
    }

    /**
     * Gets the proxy factory used by the EntityManager to create entity proxies.
     *
     * @return \Doctrine\ORM\Proxy\ProxyFactory
     */
    public function getProxyFactory()
    {
        return $this->entityManager->getProxyFactory();
    }

    /**
     * Gets the enabled filters.
     *
     * @return \Doctrine\ORM\Query\FilterCollection The active filter collection.
     */
    public function getFilters()
    {
        return $this->entityManager->getFilters();
    }

    /**
     * Checks whether the state of the filter collection is clean.
     *
     * @return boolean True, if the filter collection is clean.
     */
    public function isFiltersStateClean()
    {
        return $this->entityManager->isFiltersStateClean();
    }

    /**
     * Checks whether the Entity Manager has filters.
     *
     * @return boolean True, if the EM has a filter collection.
     */
    public function hasFilters()
    {
        return $this->entityManager->hasFilters();
    }

    /**
     * Finds an object by its identifier.
     *
     * This is just a convenient shortcut for getRepository($className)->find($id).
     *
     * @param string $className The class name of the object to find.
     * @param mixed $id The identity of the object to find.
     *
     * @return object The found object.
     */
    public function find($className, $id)
    {
        return $this->entityManager->find($className, $id);
    }

    /**
     * Tells the ObjectManager to make an instance managed and persistent.
     *
     * The object will be entered into the database as a result of the flush operation.
     *
     * NOTE: The persist operation always considers objects that are not yet known to
     * this ObjectManager as NEW. Do not pass detached objects to the persist operation.
     *
     * @param object $object The instance to make managed and persistent.
     *
     * @return void
     */
    public function persist($object)
    {
        $this->entityManager->persist($object);
    }

    /**
     * Removes an object instance.
     *
     * A removed object will be removed from the database as a result of the flush operation.
     *
     * @param object $object The object instance to remove.
     *
     * @return void
     */
    public function remove($object)
    {
        $this->entityManager->remove($object);
    }

    /**
     * Merges the state of a detached object into the persistence context
     * of this ObjectManager and returns the managed copy of the object.
     * The object passed to merge will not become associated/managed with this ObjectManager.
     *
     * @param object $object
     *
     * @return object
     */
    public function merge($object)
    {
        return $this->entityManager->merge($object);
    }

    /**
     * Clears the ObjectManager. All objects that are currently managed
     * by this ObjectManager become detached.
     *
     * @param string|null $objectName if given, only objects of this type will get detached.
     *
     * @return void
     */
    public function clear($objectName = null)
    {
        $this->entityManager->clear($objectName);
    }

    /**
     * Detaches an object from the ObjectManager, causing a managed object to
     * become detached. Unflushed changes made to the object if any
     * (including removal of the object), will not be synchronized to the database.
     * Objects which previously referenced the detached object will continue to
     * reference it.
     *
     * @param object $object The object to detach.
     *
     * @return void
     */
    public function detach($object)
    {
        $this->entityManager->detach($object);
    }

    /**
     * Refreshes the persistent state of an object from the database,
     * overriding any local changes that have not yet been persisted.
     *
     * @param object $object The object to refresh.
     *
     * @return void
     */
    public function refresh($object)
    {
        $this->entityManager->refresh($object);
    }

    /**
     * Flushes all changes to objects that have been queued up to now to the database.
     * This effectively synchronizes the in-memory state of managed objects with the
     * database.
     *
     * @return void
     */
    public function flush()
    {
        $this->entityManager->flush();
    }

    /**
     * Gets the repository for a class.
     *
     * @param string $className
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository($className)
    {
        return $this->entityManager->getRepository($className);
    }

    /**
     * Returns the ClassMetadata descriptor for a class.
     *
     * The class name must be the fully-qualified class name without a leading backslash
     * (as it is returned by get_class($obj)).
     *
     * @param string $className
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    public function getClassMetadata($className)
    {
        return $this->entityManager->getClassMetadata($className);
    }

    /**
     * Gets the metadata factory used to gather the metadata of classes.
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadataFactory
     */
    public function getMetadataFactory()
    {
        return $this->entityManager->getMetadataFactory();
    }

    /**
     * Helper method to initialize a lazy loading proxy or persistent collection.
     *
     * This method is a no-op for other objects.
     *
     * @param object $obj
     *
     * @return void
     */
    public function initializeObject($obj)
    {
        $this->entityManager->initializeObject($obj);
    }

    /**
     * Checks if the object is part of the current UnitOfWork and therefore managed.
     *
     * @param object $object
     *
     * @return bool
     */
    public function contains($object)
    {
        return $this->entityManager->contains($object);
    }


}