<?php

namespace ST\POO\Database;


interface FixtureInterface
{
    public static function load(ObjectManager $manager);
}
