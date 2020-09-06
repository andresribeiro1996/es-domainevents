<?php
namespace App\house\persistence;
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