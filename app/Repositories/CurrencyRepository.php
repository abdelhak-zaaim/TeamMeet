<?php

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CurrencyRepository
 *
 * @version October 7, 2021, 6:57 am UTC
 */
class CurrencyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'currency_name',
        'currency_icon',
        'currency_code',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return Currency::class;
    }

    /**
     * @return mixed
     */
    public function store($input)
    {
        $input['currency_code'] = strtoupper($input['currency_code']);
        $currency = Currency::create($input);

        return $currency;
    }

    /**
     * @return Builder|Currency
     */
    public function update($input, $id)
    {
        $input['currency_code'] = strtoupper($input['currency_code']);

        $currency = Currency::whereId($id);
        $currency->update([
            'currency_code' => $input['currency_code'],
            'currency_icon' => $input['currency_icon'],
            'currency_name' => $input['currency_name'],
        ]);

        return $currency;
    }
}
