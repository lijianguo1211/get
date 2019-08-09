### laravel-database

* pdo连接

1. `class ConnectionFactory` 暴露在外提供服务

2. `class Connector` 定义一个父类

3. `interface ConnectorInterface` 定义一个连接方法

* 数据库连接提供四种不同的数据库,所有的连接继承和实现上面2，3

1. `class MySqlConnector extends Connector implements ConnectorInterface`

2. `class PostgresConnector extends Connector implements ConnectorInterface`

3. `class SQLiteConnector extends Connector implements ConnectorInterface`

4. `class SqlServerConnector extends Connector implements ConnectorInterface`







































