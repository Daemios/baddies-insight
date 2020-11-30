<?php

namespace DynamicSuite\Pkg\BaddiesInsight\Storable;

use DynamicSuite\Core\Session;
use DynamicSuite\Database\Query;
use DynamicSuite\Storable\IStorable;
use DynamicSuite\Storable\Storable;
use Exception;
use PDOException;

class Member extends Storable implements IStorable
{
    /**
     * @var int|null
     */
    public ?int $character_id = null;

    /**
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @var int|null
     */
    public ?int $class_id = null;

    /**
     * @var int|null
     */
    public ?int $specialization_id = null;

    /**
     * @var int|null
     */
    public ?int $main = null;

    /**
     * @var int[]
     */
    public const COLUMN_LIMITS = [
        'name' => 50
    ];

    public function __construct(array $member = [])
    {
        parent::__construct($member);
    }

    /**
     * @return Member
     * @throws Exception|PDOException
     */
    public function create(): Member
    {

        $this->validate(self::COLUMN_LIMITS);

        $this->character_id = (new Query())
            ->insert([
                'name' => $this->name,
                'class_id' => $this->class_id,
                'specialization_id' => $this->specialization_id,
                'main' => $this->main,
                'created_on' => time()
            ])
            ->into('wow_members')
            ->execute();

        return $this;
    }

    /**
     * @param int|null $id
     * @return bool|Member
     * @throws Exception|PDOException
     */
    public static function readById(?int $id = null)
    {
        if ($id === null) return false;

        $member = (new Query())
            ->select()
            ->from('wow_members')
            ->where('character_id', '=', $id)
            ->execute(true);

        return $member ? new Member($member) : false;
    }

    /**
     * @return Member
     * @throws Exception|PDOException
     */
    public function update(): Member
    {

        $this->validate(self::COLUMN_LIMITS);

        (new Query())
            ->set([
                'name' => $this->name,
                'class_id' => $this->class_id,
                'specialization_id' => $this->specialization_id,
                'main' => $this->main
            ])
            ->update('wow_members')
            ->where('character_id', '=', $this->character_id)
            ->execute();


        return $this;
    }

    /**
     * @return Member
     * @throws Exception|PDOException
     */
    public function delete(): Member
    {

        (new Query())
            ->delete()
            ->from('wow_members')
            ->where('character_id', '=', $this->character_id)
            ->execute();


        return $this;
    }
}