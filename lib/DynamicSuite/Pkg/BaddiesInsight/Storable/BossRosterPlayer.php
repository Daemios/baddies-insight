<?php

namespace DynamicSuite\Pkg\BaddiesInsight\Storable;

use DynamicSuite\Database\Query;
use DynamicSuite\Storable\IStorable;
use DynamicSuite\Storable\Storable;
use Exception;
use PDOException;

class BossRosterPlayer extends Storable implements IStorable
{
    /**
     * @var int|null
     */
    public ?int $boss_character_id = null;
    /**
     * @var int|null
     */
    public ?int $boss_id = null;

    /**
     * @var int|null
     */
    public ?int $character_id = null;

    /**
     * @var string|null
     */
    public ?string $week = null;

    public function __construct(array $boss_player = [])
    {
        parent::__construct($boss_player);
    }

    /**
     * @return BossRosterPlayer
     * @throws Exception|PDOException
     */
    public function create(): BossRosterPlayer
    {

        $this->boss_character_id = (new Query())
            ->insert([
                'boss_id' => $this->boss_id,
                'character_id' => $this->character_id,
                'week' => $this->week
            ])
            ->into('wow_bosses_roster')
            ->execute();

        return $this;
    }

    /**
     * @param int|null $id
     * @return bool|BossRosterPlayer
     * @throws Exception|PDOException
     */
    public static function readById(?int $id = null)
    {
        if ($id === null) return false;

        $boss_player = (new Query())
            ->select()
            ->from('wow_bosses_roster')
            ->where('boss_character_id', '=', $id)
            ->execute(true);

        return $boss_player ? new BossRosterPlayer($boss_player) : false;
    }

    /**
     * @return BossRosterPlayer
     * @throws Exception|PDOException
     */
    public function delete(): BossRosterPlayer
    {

        (new Query())
            ->delete()
            ->from('wow_bosses_roster')
            ->where('boss_id', '=', $this->boss_id)
            ->where('character_id', '=', $this->character_id)
            ->where('week', '=', $this->week)
            ->execute();

        return $this;
    }

    public function update(): Storable
    {
        // TODO: Implement update() method.
    }
}