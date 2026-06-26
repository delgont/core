<?php
namespace Delgont\Core\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModelService
{
    protected Model $model;
    protected array $callbacks = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function before(string $action, callable $callback): static
    {
        $this->callbacks["before:$action"][] = $callback;
        return $this;
    }

    public function after(string $action, callable $callback): static
    {
        $this->callbacks["after:$action"][] = $callback;
        return $this;
    }

    public function onFailure(callable $callback): static
    {
        $this->callbacks["failure"][] = $callback;
        return $this;
    }

    /**
     * Run callbacks. If callbacks return a non-null value,
     * propagate it forward (useful for transforming $data).
     */
    protected function run(string $phase, string $action, ...$args)
    {
        foreach ($this->callbacks["$phase:$action"] ?? [] as $callback) {
            $result = $callback(...$args);

            // If callback returns something, update args
            if ($result !== null) {
                // If single value, replace first arg
                if (count($args) === 1) {
                    $args[0] = $result;
                }
                // If array returned, assume replacement of all args
                elseif (is_array($result)) {
                    $args = $result;
                }
            }
        }

        // Return possibly transformed arguments
        return count($args) === 1 ? $args[0] : $args;
    }

    protected function runFailure(\Throwable $e): void
    {
        foreach ($this->callbacks["failure"] ?? [] as $callback) {
            $callback($e);
        }
    }

}
