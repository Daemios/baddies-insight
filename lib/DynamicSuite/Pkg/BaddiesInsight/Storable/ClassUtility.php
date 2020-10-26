<?php

namespace DynamicSuite\Pkg\BaddiesInsight\Storable;

use DynamicSuite\Core\Session;
use DynamicSuite\Database\Query;
use DynamicSuite\Storable\IStorable;
use DynamicSuite\Storable\Storable;
use Exception;
use PDOException;

class ClassUtility extends Storable implements IStorable
{
    /**
     * @var int|null
     */
    public ?int $class_utility_id = null;

    /**
     * @var int|null
     */
    public ?int $class_id = null;

    /**
     * @var int|null
     */
    public ?int $utility_id = null;

    /**
     * @var int|null
     */
    public ?int $cooldown = null;

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
     * @return ClassUtility
     * @throws Exception|PDOException
     */
    public function create(): ClassUtility
    {

        $this->validate(self::COLUMN_LIMITS);

        $this->utility_id = (new Query())
            ->insert([
                'class_id' => $this->class_id,
                'utility_id' => $this->utility_id,
                'cooldown' => $this->cooldown
            ])
            ->into('wow_classes_utility')
            ->execute();

        return $this;
    }

    /**
     * @param int|null $id
     * @return bool|ClassUtility
     * @throws Exception|PDOException
     */
    public static function readById(?int $id = null)
    {
        if ($id === null) return false;

        $utility_type = (new Query())
            ->select()
            ->from('wow_classes_utility')
            ->where('class_utility_id', '=', $id)
            ->execute(true);

        return $utility_type ? new ClassUtility($utility_type) : false;
    }

    /**
     * @return ClassUtility
     * @throws Exception|PDOException
     */
    public function update(): ClassUtility
    {

        $this->validate(self::COLUMN_LIMITS);

        (new Query())
            ->set([
                'class_id' => $this->class_id,
                'utility_id' => $this->utility_id,
                'cooldown' => $this->cooldown
            ])
            ->update('wow_classes_utility')
            ->where('class_utility_id', '=', $this->class_utility_id)
            ->execute();


        return $this;
    }

    /**
     * @return ClassUtility
     * @throws Exception|PDOException
     */
    public function delete(): ClassUtility
    {

        (new Query())
            ->delete()
            ->from('wow_classes_utility')
            ->where('class_utility_id', '=', $this->class_utility_id)
            ->execute();


        return $this;
    }
}