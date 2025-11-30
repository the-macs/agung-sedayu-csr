<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    /**
     * Model instance
     *
     * @var [type]
     */
    protected Model $model;

    /**
     * Get the base query builder for the model.
     *
     * @return mixed
     */
    protected function query()
    {
        return $this->model->query();
    }

    /**
     * Get All Data
     *
     * @param array $columns
     * @return mixed
     */
    public function getAllData($columns = ['*'])
    {
        return $this
            ->query()
            ->select($columns)
            ->get();
    }

    /**
     * Store data
     *
     * @param array $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * Update data
     *
     * @param array $data
     * @param string $id
     * @return mixed
     */
    public function update($data,  $id)
    {
        $model = $this->model->findOrFail($id);

        $model->update($data);

        return $model;
    }

    /**
     * Delete data
     *
     * @param string $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
}
