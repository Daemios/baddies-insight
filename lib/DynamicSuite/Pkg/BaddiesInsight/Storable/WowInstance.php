<?php

namespace DynamicSuite\Pkg\BaddiesInsight\Storable;

use DynamicSuite\Core\Session;
use DynamicSuite\Database\Query;
use DynamicSuite\Storable\IStorable;
use DynamicSuite\Storable\Storable;
use Exception;
use PDOException;

class WowInstance extends Storable implements IStorable
{
    /**
     * @var int|null
     */
    public ?int $instance_id = null;

    /**
     * @var int|null
     */
    public ?int $type = null;

    /**
     * @var string|null
     */
    public ?string $label = null;

    /**
     * @var int
     */
    public int $tier = 0;

    /**
     * @var int[]
     */
    public const COLUMN_LIMITS = [
        'label' => 50,
    ];

    public function __construct(array $sale_price = [])
    {
        parent::__construct($sale_price);
    }

    /**
     * @return SalePrice
     * @throws Exception|PDOException
     */
    public function create(): WowInstance
    {

        $this->validate(self::COLUMN_LIMITS);

        $this->instance_id = (new Query())
            ->insert([
                'type' => $this->type,
                'label' => $this->label,
                'tier' => $this->tier
            ])
            ->into('wow_instances')
            ->execute();

        return $this;
    }

    /**
     * @param int|null $id
     * @return bool|WowInstance
     * @throws Exception|PDOException
     */
    public static function readById(?int $id = null)
    {
        if ($id === null) return false;

        $instance = (new Query())
            ->select()
            ->from('wow_instances')
            ->where('instance_id', '=', $id)
            ->execute(true);

        return $instance ? new WowInstance($instance) : false;
    }

    /**
     * @return WowInstance
     * @throws Exception|PDOException
     */
    public function update(): WowInstance
    {

        $this->validate(self::COLUMN_LIMITS);

        (new Query())
            ->set([
                'type' => $this->type,
                'label' => $this->label,
                'tier' => $this->tier
            ])
            ->update('wow_instances')
            ->where('instance_id', '=', $this->instance_id)
            ->execute();


        return $this;
    }

    /**
     * @return WowInstance
     * @throws Exception|PDOException
     */
    public function delete(): WowInstance
    {

        (new Query())
            ->delete()
            ->from('wow_instances')
            ->where('instance_id', '=', $this->instance_id)
            ->execute();


        return $this;
    }
}