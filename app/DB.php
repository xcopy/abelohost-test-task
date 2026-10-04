<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;
use PDOStatement;

/**
 * Provides shared access to the application's PDO database connection.
 */
class DB
{
    private static ?PDO $pdo = null;

    /**
     * Get the shared database connection, creating it on first use.
     *
     * This method follows the Singleton pattern: all callers reuse the same
     * PDO instance for the lifetime of the process.
     *
     * @return PDO An instance of the shared database connection.
     */
    public static function connection(): PDO
    {
        if (self::$pdo === null) {
            $config = require BASE_PATH . '/config/db.php';

            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['dbname'],
                $config['charset']
            );

            try {
                self::$pdo = new PDO(
                    $dsn,
                    $config['user'],
                    $config['password'],
                    [
                        // throw exceptions
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        // return each row as an array indexed by column name
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        // use secure prepared statements
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                throw new PDOException('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }

    /**
     * Execute a prepared SQL statement.
     *
     * @param string $sql    SQL query with optional placeholders.
     * @param array  $params Values to bind to the query.
     *
     * @return PDOStatement The executed statement.
     */
    public static function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = self::connection()->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * Fetch all rows returned by a query.
     *
     * @param string $sql    SQL query with optional placeholders.
     * @param array  $params Values to bind to the query.
     *
     * @return array The fetched rows.
     */
    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }

    /**
     * Fetch the first row returned by a query.
     *
     * @param string $sql    SQL query with optional placeholders.
     * @param array  $params Values to bind to the query.
     *
     * @return array|null The fetched row, or null if none exists.
     */
    public static function fetch(string $sql, array $params = []): ?array
    {
        $result = self::query($sql, $params)->fetch();

        return $result ?: null;
    }
}
