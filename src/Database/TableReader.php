<?php

namespace SebastiaanLuca\Helpers\Database;

use Illuminate\Database\DatabaseManager;

class TableReader
{
    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    protected $database;

    /**
     * @var \Illuminate\Database\Connection
     */
    protected $connection;

    /**
     * The name of the table.
     *
     * @var string
     */
    protected $table;

    /**
     * The table's fields.
     *
     * Consists of a field (its name), type, null (YES or NO), key (PRI, etc), default (its default
     * value), and extra (auto_increment, on update, etc) key.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $fields;

    /**
     * Fields that should be guarded by default.
     *
     * @var array
     */
    protected $defaultGuarded = [
        'id',
        'password',
        'password_hash',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Default casted field types.
     *
     * @var array
     */
    protected $defaultCasts = [
        'int(' => 'integer',
        'tinyint(1)' => 'boolean',
        'json' => 'json',
    ];

    /**
     * Default date field types.
     *
     * @var array
     */
    protected $defaultDates = [
        'timestamp',
        'datetime',
        'date',
        'time',
        'year',
    ];

    /**
     * TableReader constructor.
     *
     * @param \Illuminate\Database\DatabaseManager $database
     */
    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
        $this->connection = $this->database->connection();
    }

    /**
     * Get the database connection.
     *
     * @return \Illuminate\Database\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Set the database connection to use when reading the table.
     *
     * @param string $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $this->database->connection($connection);
    }

    /**
     * Get the name of the table.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get the table's fields and additional raw information.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRawFields()
    {
        return $this->fields;
    }

    /**
     * Get the table's fields.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields->pluck('field')->toArray();
    }

    /**
     * Get all guarded attributes.
     *
     * @return array
     */
    public function getGuarded()
    {
        // Compare default guarded fields with the ones in the table
        return array_values(array_intersect($this->fields->pluck('field')->toArray(), $this->defaultGuarded));
    }

    /**
     * Get all mass-assignable attributes.
     *
     * @return array
     */
    public function getFillable()
    {
        return array_diff($this->fields->pluck('field')->toArray(), $this->defaultGuarded);
    }

    /**
     * Get all cast attributes.
     *
     * @return array
     */
    public function getCasts()
    {
        // Simply match the database types against any natives types and filter out "non-castworthy" fields
        return $this->fields->pluck('type', 'field')->map(function ($type, $field) {
            return $this->getCastType($type);
        })->filter(function ($type, $field) {
            return ! empty($type);
        })->toArray();
    }

    /**
     * Get all date attributes.
     *
     * @return array
     */
    public function getDates()
    {
        return $this->fields->pluck('type', 'field')->filter(function ($type, $field) {
            return $this->isDate($type);
        })->keys()->toArray();
    }

    /**
     * Get all nullable attributes.
     *
     * @return array
     */
    public function getNullableFields()
    {
        return $this->fields->pluck('null', 'field')->filter(function ($nullable, $field) {
            return $nullable === 'YES';
        })->keys()->toArray();
    }

    /**
     * Check if the table contains a given field.
     *
     * @param string $field
     *
     * @return bool
     */
    public function hasField($field)
    {
        return in_array($field, $this->getFields());
    }

    /**
     * Check if the table uses timestamps.
     *
     * @return bool
     */
    public function usesTimestamps()
    {
        return $this->hasField('created_at') && $this->hasField('updated_at');
    }

    /**
     * Check if the table uses soft delete.
     *
     * @return bool
     */
    public function usesSoftDelete()
    {
        return $this->hasField('deleted_at');
    }

    /**
     * Read all information from the table.
     *
     * @param string $table
     *
     * @return \SebastiaanLuca\Helpers\Database\TableReader
     */
    public function read($table)
    {
        $this->table = $table;

        $fields = collect($this->connection->select($this->connection->raw('describe ' . $this->table)));

        // Normalize the output
        $this->fields = $fields->map(function ($field) {
            return array_change_key_case((array)$field, CASE_LOWER);
        });

        return $this;
    }

    /**
     * Get the native cast type of a database field.
     *
     * @param string $type
     *
     * @return string
     */
    protected function getCastType($type)
    {
        foreach ($this->defaultCasts as $character => $cast) {
            if (starts_with($type, $character)) {
                return $cast;
            }
        }

        return '';
    }

    /**
     * Check if a field type is a date.
     *
     * @param string $type
     *
     * @return bool
     */
    protected function isDate($type)
    {
        foreach ($this->defaultDates as $date) {
            return starts_with($type, $date);
        }

        return false;
    }
}
