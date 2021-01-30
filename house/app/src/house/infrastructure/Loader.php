<?php
namespace App\house\infrastructure;
/**
 * @template T
 * Interface GenericBootstrap
 */
interface Loader
{
    /**
     * @psalm-return array<T>
     */
    public function load();
}