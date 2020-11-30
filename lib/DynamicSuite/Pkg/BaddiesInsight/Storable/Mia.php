<?php

namespace DynamicSuite\Pkg\BaddiesInsight\Storable;

use DynamicSuite\Database\Query;
use DynamicSuite\Storable\IStorable;
use DynamicSuite\Storable\Storable;
use Exception;
use PDOException;

class Mia extends Storable implements IStorable
{

    /**
     * @var int|null
     */
    public ?int $mia_id = null;

    /**
     * @var int|null
     */
    public ?int $character_id = null;

    /**
     * @var string|null
     */
    public ?string $date = null;

    /**
     * @var string|null
     */
    public ?string $duration = null;

    /**
     * @var string|null
     */
    public ?string $note = null;

    public function __construct(array $mia = [])
    {
        parent::__construct($mia);
    }

    /**
     * @return Mia
     * @throws Exception|PDOException
     */
    public function create(): Mia
    {

        $this->mia_id = (new Query())
            ->insert([
                'character_id' => $this->character_id,
                'date' => $this->date,
                'duration' => $this->duration,
                'note' => $this->note
            ])
            ->into('wow_bosses_roster_mia')
            ->execute();

        return $this;
    }

    /**
     * @param int|null $id
     * @return bool|Mia
     * @throws Exception|PDOException
     */
    public static function readById(?int $id = null)
    {
        if ($id === null) return false;

        $sale_price = (new Query())
            ->select()
            ->from('wow_bosses_roster_mia')
            ->where('mia_id', '=', $id)
            ->execute(true);

        return $sale_price ? new Mia($sale_price) : false;
    }

    /**
     * @return Mia
     * @throws Exception|PDOException
     */
    public function update(): Mia
    {

        (new Query())
            ->set([
                'duration' => $this->duration,
                'note' => $this->note
            ])
            ->update('wow_bosses_roster_mia')
            ->where('character_id', '=', $this->character_id)
            ->where('date', '=', $this->date)
            ->execute();


        return $this;
    }

    /**
     * @return Mia
     * @throws Exception|PDOException
     */
    public function delete(): Mia
    {

        (new Query())
            ->delete()
            ->from('wow_bosses_roster_mia')
            ->where('character_id', '=', $this->character_id)
            ->where('date', '=', $this->date)
            ->execute();

        return $this;
    }
}