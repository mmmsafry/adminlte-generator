<?php

namespace App\Repositories;

use App\Models\Configuration;
use App\Repositories\BaseRepository;

/**
 * Class ConfigurationRepository
 * @package App\Repositories
 * @version February 21, 2020, 9:37 am UTC
*/

class ConfigurationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'config_description',
        'config_value',
        'modified_at'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Configuration::class;
    }
}
