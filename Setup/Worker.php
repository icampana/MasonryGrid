<?php

/**
 * User: icampana
 * Date: 3/3/15
 * Time: 00:00 AM
 */

namespace Plugin\MasonryGrid\Setup;

class Worker
{

    public function activate()
    {
        $sql = '
        CREATE TABLE IF NOT EXISTS
           ' . ipTable(\Plugin\MasonryGrid\Config::TABLE_NAME) . '
        (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `itemOrder` double,
        `widgetId` int(11),
        `title` varchar(255),
        `image` varchar(255),
		`description` text,
		`url` varchar(255),
        `isVisible` int(1),
        PRIMARY KEY (`id`)
        )';

        ipDb()->execute($sql);

    }

    public function deactivate()
    {

    }

    public function remove()
    {

    }

}
