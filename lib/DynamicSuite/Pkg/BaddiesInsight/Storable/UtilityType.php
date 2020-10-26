<?php

namespace DynamicSuite\Pkg\BaddiesInsight\Storable;

use DynamicSuite\Core\Session;
use DynamicSuite\Database\Query;
use DynamicSuite\Storable\IStorable;
use DynamicSuite\Storable\Storable;
use Exception;
use PDOException;

class UtilityType extends Storable implements IStorable
{
    /**
     * @var int|null
     */
    public ?int $utility_id = null;

    /**
     * @var string|null
     */
    public ?string $label = null;

    /**
     * @var int[]
     */
    public const COLUMN_LIMITS = [
        'label' => 50
    ];

    public function __construct(array $utility_type = [])
    {
        parent::__construct($utility_type);
    }

    /**
     * @return UtilityType
     * @throws Exception|PDOException
     */
    public function create(): UtilityType
    {

        $this->validate(self::COLUMN_LIMITS);

        $this->utility_id = (new Query())
            ->insert([
                'label' => $this->label
            ])
            ->into('wow_utility_types')
            ->execute();

        return $this;
    }

    /**
     * @param int|null $id
     * @return bool|UtilityType
     * @throws Exception|PDOException
     */
    public static function readById(?int $id = null)
    {
        if ($id === null) return false;

        $utility_type = (new Query())
            ->select()
            ->from('wow_utility_types')
            ->where('utility_id', '=', $id)
            ->execute(true);

        return $utility_type ? new UtilityType($utility_type) : false;
    }

    /**
     * @return UtilityType
     * @throws Exception|PDOException
     */
    public function update(): UtilityType
    {

        $this->validate(self::COLUMN_LIMITS);

        (new Query())
            ->set([
                'label' => $this->label
            ])
            ->update('wow_utility_types')
            ->where('utility_id', '=', $this->utility_id)
            ->execute();


        return $this;
    }

    /**
     * @return UtilityType
     * @throws Exception|PDOException
     */
    public function delete(): UtilityType
    {

        (new Query())
            ->delete()
            ->from('wow_utility_types')
            ->where('utility_id', '=', $this->utility_id)
            ->execute();


        return $this;
    }
}