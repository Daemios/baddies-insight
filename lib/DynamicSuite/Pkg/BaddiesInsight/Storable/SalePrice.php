<?php

namespace DynamicSuite\Pkg\BaddiesInsight\Storable;

use DynamicSuite\Core\Session;
use DynamicSuite\Database\Query;
use DynamicSuite\Storable\IStorable;
use DynamicSuite\Storable\Storable;
use Exception;
use PDOException;

class SalePrice extends Storable implements IStorable
{
    /**
     * @var int|null
     */
    public ?int $sale_price_id = null;

    /**
     * @var string|null
     */
    public ?string $label = null;

    /**
     * @var int
     */
    public int $price = 0;

    /**
     * @var int|null
     */
    public ?int $type = null;

    /**
     * @var string|null
     */
    public ?string $created_by = null;

    /**
     * @var string|null
     */
    public ?string $created_on = null;

    /**
     * @var int[]
     */
    public const COLUMN_LIMITS = [
        'label' => 50,
        'type' => 50,
        'created_by' => 254,
    ];

    public function __construct(array $sale_price = [])
    {
        parent::__construct($sale_price);
    }

    /**
     * @return SalePrice
     * @throws Exception|PDOException
     */
    public function create(): SalePrice
    {

        $this->created_by = Session::$user_name;
        $this->created_on = date('Y-m-d H:i:s');

        $this->validate(self::COLUMN_LIMITS);

        $this->sale_price_id = (new Query())
            ->insert([
                'label' => $this->label,
                'price' => $this->price,
                'type' => $this->type,
                'created_by' => $this->created_by,
                'created_on' => $this->created_on
            ])
            ->into('sale_pricing')
            ->execute();

        return $this;
    }

    /**
     * @param int|null $id
     * @return bool|SalePrice
     * @throws Exception|PDOException
     */
    public static function readById(?int $id = null)
    {
        if ($id === null) return false;

        $sale_price = (new Query())
            ->select()
            ->from('sale_pricing')
            ->where('sale_price_id', '=', $id)
            ->execute(true);

        return $sale_price ? new SalePrice($sale_price) : false;
    }

    /**
     * @return SalePrice
     * @throws Exception|PDOException
     */
    public function update(): SalePrice
    {

        $this->validate(self::COLUMN_LIMITS);

        (new Query())
            ->set([
                'label' => $this->label,
                'price' => $this->price,
                'type' => $this->type
            ])
            ->update('sale_pricing')
            ->where('sale_price_id', '=', $this->sale_price_id)
            ->execute();


        return $this;
    }

    /**
     * @return SalePrice
     * @throws Exception|PDOException
     */
    public function delete(): SalePrice
    {

        (new Query())
            ->delete()
            ->from('sale_pricing')
            ->where('sale_price_id', '=', $this->sale_price_id)
            ->execute();


        return $this;
    }
}