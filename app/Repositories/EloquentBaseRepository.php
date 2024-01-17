<?php

namespace App\Repositories;

use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EloquentBaseRepository implements BaseRepositoryInterface
{
    /**
     * Name of the Model with absolute namespace
     *
     * @var string
     */
    protected $modelName;

    /**
     * Instance that extends Illuminate\Database\Eloquent\Model
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get Model instance
     *
     * @return Model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get Model instance
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param array $relations
     * @inheritdoc
     */
    public function all(array $relations = [])
    {
        $model = $this->model;

        if($relations) {
            $model = $model->with($relations);
        }
        return $model->get();
    }

    /**
     * @inheritdoc
     */
    public function findOne($id)
    {
        return $this->findOneBy(["id" => $id]);
    }

    /**
     * @inheritdoc
     */
    public function findOneBy(array $criteria)
    {
        return $this->model->where($criteria)->first();
    }

    /**
     * Find records using search criteria
     *
     * @param array $searchCriteria
     * @param boolean $paginate
     * @param boolean $returnQueryBuilder
     * @return mixed $result
     */
    public function findBy(
        array $searchCriteria = [],
        $paginate = false,
        $returnQueryBuilder = false
    ) {
        $limit = !empty($searchCriteria["per_page"]) ? (int)$searchCriteria["per_page"] : 15; // it's needed for pagination

        $queryBuilder = $this->model->where(function ($query) use ($searchCriteria) {
            $this->applySearchCriteriaInQueryBuilder($query, $searchCriteria);
        });

        if (!$returnQueryBuilder) {
            $result = $paginate ? $queryBuilder->paginate($limit) : $queryBuilder->get();
        } else {
            $result = $queryBuilder;
        }

        return $result;
    }


    /**
     * Apply condition on query builder based on search criteria
     *
     * @param Object $queryBuilder
     * @param array $searchCriteria
     * @return mixed
     */
    protected function applySearchCriteriaInQueryBuilder($queryBuilder, array $searchCriteria = [])
    {

        foreach ($searchCriteria as $key => $value) {
            //skip pagination related query params
            if (in_array($key, ["page", "per_page"])) {
                continue;
            }

            //we can pass multiple params for a filter with commas
            $allValues = explode(",", $value);

            if (count($allValues) > 1) {
                $queryBuilder->whereIn($key, $allValues);
            } else {
                $operator = "=";
                $queryBuilder->where($key, $operator, $value);
            }
        }

        return $queryBuilder;
    }

    /**
     * @inheritdoc
     */
    public function save(array $data)
    {
        // generate id
        $data["id"] = (string) Str::uuid();

        return $this->model->create($data);
    }

    /**
     * @inheritdoc
     */
    public function update(Model $model, array $data)
    {
        $fillAbleProperties = $this->model->getFillable();

        foreach ($data as $key => $value) {
            // update only fillAble properties
            if (in_array($key, $fillAbleProperties)) {
                $model->$key = $value;
            }
        }

        // update the model
        $model->save();

        // get updated model from database
        $model = $this->findOne($model->id);

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function upsert(array $columnIdentifiers, array $columnsToUpdate)
    {
        $result = $this->model->updateOrCreate(
            $columnIdentifiers,
            $columnsToUpdate
        );

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function findIn($key, array $values)
    {
        return $this->model->whereIn($key, $values)->get();
    }

    /**
     * @inheritdoc
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }
}