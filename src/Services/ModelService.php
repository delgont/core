<?php
namespace Delgont\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

abstract class ModelService extends BaseModelService
{
    public function create(array $data): Model
    {
        try {
            $this->run('before', 'create', $data);

            $record = $this->model->create($data);

            $this->run('after', 'create', $record);
            $this->afterMutation($record);

            Event::dispatch("model.created", $record);

            return $record;
        } catch (\Throwable $e) {
            $this->runFailure($e);
            throw $e;
        }
    }

    public function update(Model $model, array $data): Model
    {
        try {
            $this->run('before', 'update', $model, $data);

            $model->update($data);

            $this->run('after', 'update', $model);
            $this->afterMutation($model);

            Event::dispatch("model.updated", $model);

            return $model;
        } catch (\Throwable $e) {
            $this->runFailure($e);
            throw $e;
        }
    }

    public function delete(Model $model): bool
    {
        try {
            $this->run('before', 'delete', $model);

            $deleted = $model->delete();

            if ($deleted) {
                $this->run('after', 'delete', $model);
                $this->afterMutation($model);

                Event::dispatch("model.deleted", $model);
            }

            return $deleted;
        } catch (\Throwable $e) {
            $this->runFailure($e);
            throw $e;
        }
    }
}
