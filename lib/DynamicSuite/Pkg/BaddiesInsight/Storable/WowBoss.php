<?php

namespace DynamicSuite\Pkg\BaddiesInsight\Storable;

use DynamicSuite\Core\Session;
use DynamicSuite\Database\Query;
use DynamicSuite\Storable\IStorable;
use DynamicSuite\Storable\Storable;
use Exception;
use PDOException;

class WowBoss extends Storable implements IStorable
{
    /**
     * @var int|null
     */
    public ?int $boss_id = null;

    /**
     * @var string|null
     */
    public ?string $label = null;

    /**
     * @var int
     */
    public ?int $instance_id = null;

    /**
     * @var int[]
     */
    public const COLUMN_LIMITS = [
        'label' => 50
    ];

    public function __construct(array $sale_price = [])
    {
        parent::__construct($sale_price);
    }

    /**
     * @return WowBoss
     * @throws Exception|PDOException
     */
    public function create(): WowBoss
    {

        $this->validate(self::COLUMN_LIMITS);

        $this->boss_id = (new Query())
            ->insert([
                'label' => $this->label,
                'instance_id' => $this->instance_id
            ])
            ->into('wow_bosses')
            ->execute();

        return $this;
    }

    /**
     * @param int|null $id
     * @return bool|WowBoss
     * @throws Exception|PDOException
     */
    public static function readById(?int $id = null)
    {
        if ($id === null) return false;

        $wow_boss = (new Query())
            ->select()
            ->from('wow_bosses')
            ->where('boss_id', '=', $id)
            ->execute(true);

        return $wow_boss ? new WowBoss($wow_boss) : false;
    }

    /**
     * @return WowBoss
     * @throws Exception|PDOException
     */
    public function update(): WowBoss
    {

        $this->validate(self::COLUMN_LIMITS);

        (new Query())
            ->set([
                'label' => $this->label,
                'instance_id' => $this->instance_id
            ])
            ->update('wow_bosses')
            ->where('boss_id', '=', $this->boss_id)
            ->execute();


        return $this;
    }

    /**
     * @return WowBoss
     * @throws Exception|PDOException
     */
    public function delete(): WowBoss
    {

        (new Query())
            ->delete()
            ->from('wow_bosses')
            ->where('boss_id', '=', $this->boss_id)
            ->execute();


        return $this;
    }

}