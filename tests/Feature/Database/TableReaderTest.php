<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Classes;

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Mockery;
use SebastiaanLuca\Helpers\Database\TableReader;
use SebastiaanLuca\Helpers\Tests\TestCase;

class TableReaderTest extends TestCase
{
    /**
     * @var array
     */
    protected $structure;

    /**
     * @var \Illuminate\Database\Connection
     */
    protected $connection;

    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    protected $manager;
    /**
     * @var \SebastiaanLuca\Helpers\Database\TableReader
     */
    protected $reader;

    public function test it can read a table()
    {
        $this->assertInstanceOf(
            TableReader::class,
            $this->reader->read('table')
        );
    }

    public function test it can return a list of raw fields()
    {
        $this->assertSame(
            $this->structure,
            $this->reader->read('table')->getRawFields()->toArray()
        );
    }

    public function test it can return a list of fields()
    {
        $this->assertSame(
            [
                'id',
                'facebook_id',
                'name',
                'email',
                'password',
                'street',
                'postal_code',
                'city',
                'country',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            $this->reader->read('table')->getFields()
        );
    }

    public function test it can return a list of guarded fields()
    {
        $this->assertSame(
            [
                'id',
                'password',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            $this->reader->read('table')->getGuarded()
        );
    }

    public function test it can return a list of fillable fields()
    {
        $this->assertSame(
            [
                'facebook_id',
                'name',
                'email',
                'street',
                'postal_code',
                'city',
                'country',
                'is_active',
            ],
            $this->reader->read('table')->getFillable()
        );
    }

    public function test it can return a list of castable fields()
    {
        $this->assertSame(
            [
                'id' => 'integer',
                'is_active' => 'boolean',
            ],
            $this->reader->read('table')->getCasts()
        );
    }

    public function test it can return a list of date fields()
    {
        $this->assertSame(
            [
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            $this->reader->read('table')->getDates()
        );
    }

    public function test it can return a list of nullable fields()
    {
        $this->assertSame(
            [
                'facebook_id',
                'password',
                'street',
                'postal_code',
                'city',
                'country',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            $this->reader->read('table')->getNullableFields()
        );
    }

    public function test it can detect if a given field exists()
    {
        $this->assertTrue(
            $this->reader->read('table')->hasField('postal_code')
        );
    }

    public function test it can detect if a given field does not exist()
    {
        $this->assertFalse(
            $this->reader->read('table')->hasField('non_existent_field')
        );
    }

    public function test it can detect if a table uses timestamps()
    {
        $this->assertTrue(
            $this->reader->read('table')->usesTimestamps()
        );
    }

    public function test it can detect if a table uses soft delete()
    {
        $this->assertTrue(
            $this->reader->read('table')->usesSoftDelete()
        );
    }

    public function test it can return the table()
    {
        $this->assertSame(
            'table',
            $this->reader->read('table')->getTable()
        );
    }

    public function test it can return the connection()
    {
        $this->assertSame(
            $this->connection,
            $this->reader->read('table')->getConnection()
        );
    }

    public function test it can set the connection()
    {
        $secondaryConnection = Mockery::mock(Connection::class);

        $this->manager = Mockery::mock(DatabaseManager::class)
            ->shouldReceive('connection')->withNoArgs()->andReturn($this->connection)
            ->shouldReceive('connection')->with('secondary')->andReturn($secondaryConnection)
            ->getMock();

        $this->reader = new TableReader($this->manager);

        $this->assertSame(
            $secondaryConnection,
            $this->reader->read('table')->setConnection('secondary')->getConnection()
        );
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->structure = [
            [
                "field" => "id",
                "type" => "int(10) unsigned",
                "null" => "NO",
                "key" => "PRI",
                "default" => null,
                "extra" => "auto_increment",
            ],
            [
                "field" => "facebook_id",
                "type" => "bigint(20) unsigned",
                "null" => "YES",
                "key" => "UNI",
                "default" => null,
                "extra" => "",
            ],
            [
                "field" => "name",
                "type" => "varchar(191)",
                "null" => "NO",
                "key" => "",
                "default" => null,
                "extra" => "",
            ],
            [
                "field" => "email",
                "type" => "varchar(191)",
                "null" => "NO",
                "key" => "UNI",
                "default" => null,
                "extra" => "",
            ],
            [
                "field" => "password",
                "type" => "varchar(191)",
                "null" => "YES",
                "key" => "",
                "default" => null,
                "extra" => "",
            ],
            [
                "field" => "street",
                "type" => "varchar(191)",
                "null" => "YES",
                "key" => "",
                "default" => null,
                "extra" => "",
            ],
            [
                "field" => "postal_code",
                "type" => "varchar(10)",
                "null" => "YES",
                "key" => "",
                "default" => null,
                "extra" => "",
            ],
            [
                "field" => "city",
                "type" => "varchar(191)",
                "null" => "YES",
                "key" => "",
                "default" => null,
                "extra" => "",
            ],
            [
                "field" => "country",
                "type" => "varchar(191)",
                "null" => "YES",
                "key" => "",
                "default" => null,
                "extra" => "",
            ],
            [
                "field" => "is_active",
                "type" => "tinyint(1)",
                "null" => "NO",
                "key" => "",
                "default" => "1",
                "extra" => "",
            ],
            [
                "field" => "created_at",
                "type" => "timestamp",
                "null" => "YES",
                "key" => "",
                "default" => null,
                "extra" => "",
            ],
            [
                "field" => "updated_at",
                "type" => "timestamp",
                "null" => "YES",
                "key" => "",
                "default" => null,
                "extra" => "",
            ],
            [
                "field" => "deleted_at",
                "type" => "timestamp",
                "null" => "YES",
                "key" => "",
                "default" => null,
                "extra" => "",
            ],
        ];

        $this->connection = Mockery::mock(Connection::class)
            ->shouldReceive('raw')
            ->shouldReceive('select')->andReturn($this->structure)
            ->getMock();

        $this->manager = Mockery::mock(DatabaseManager::class)
            ->shouldReceive('connection')->andReturn($this->connection)
            ->getMock();

        $this->reader = new TableReader($this->manager);
    }
}
