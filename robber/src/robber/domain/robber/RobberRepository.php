<?php
namespace App\robber\domain\robber;

use App\robber\domain\EventStore;

/**
 * @extends WriteRepository<Robber>
 * Interface RobberRepository
 */
interface RobberRepository extends EventStore
{
}