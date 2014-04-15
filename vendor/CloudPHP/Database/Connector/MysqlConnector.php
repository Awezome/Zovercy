<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/4/14
 * Time: 12:00 PM
 */
class MysqlConnector extends Connector implements ConnectorInterface {
    public function connect() {
        $config=self::$config;
        $dsn=$this->getDsn($config);
        $c=$this->createConnector($dsn, $config, $this->option);
        $collation=$config['collation'];
        $charset=$config['charset'];
        $names="set names '$charset'".(!is_null($collation) ? " collate '$collation'" : '');
        $c->prepare($names)->execute();
        if(isset($config['strict'])&&$config['strict']) {
            $c->prepare("set session sql_mode='STRICT_ALL_TABLES'")->execute();
        }
        return $c;
    }

    protected function getDsn(array $config) {
        $dsn="mysql:host={$config['host']};dbname={$config['database']}";
        if(isset($config['port'])) {
            $dsn.=";port={$config['port']}";
        }
        if(isset($config['unix_socket'])) {
            $dsn.=";unix_socket={$config['unix_socket']}";
        }
        return $dsn;
    }
}