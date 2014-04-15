<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/4/14
 * Time: 12:22 PM
 */
class SQLiteConnector extends Connector implements ConnectorInterface {


    public function connect() {
        $config=self::$config;
        $options=$this->getOptions($config);
        if($config['database']==':memory:') {
            return $this->createConnection('sqlite::memory:', $config, $options);
        }
        return $this->createConnection($this->getDsn($config), $config, $options);
    }

    protected function getDsn(array $config) {
        $path=realpath($config['database']);
        if($path===FALSE) {
            throw new PDOException ("Database does not exist.");
        }
        return 'sqlite:'.$path;
    }
}