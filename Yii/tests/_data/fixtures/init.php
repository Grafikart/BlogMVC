<?php
/**
 * A simple script to load data in correct order without breaking any fk.
 */
/**
 * @var $this CDbFixtureManager
 */
foreach (array('users', 'categories', 'posts', 'comments') as $table) {
    $this->resetTable($table);
    $this->loadFixture($table);
}