<?php

namespace Delgont\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Delgont\Core\Concerns\ModelHasMeta;

class Option extends Model
{
    use ModelHasMeta;

    protected $guarded = [];

    /**
     * Get a single setting by key and group.
     */
    public static function getOption(string $key, string $group, mixed $default = null) : mixed
    {
        return static::where('key', $key)->where('group', $group)->value('value') ?? $default;
    }

    /**
     * Set or update a single setting.
     */
    public static function setOption(string $key, mixed $value, string $group): void
    {
        static::updateOrCreate(
            ['key' => $key, 'group' => $group],
            ['value' => $value]
        );
    }

    /**
     * Get all settings in a group as key-value array.
     */
    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
                     ->pluck('value', 'key')
                     ->toArray();
    }

    /**
     * Save multiple settings to a group.
     */
    public static function setGroup(array $settings, string $group): void
    {
        foreach ($settings as $key => $value) {
            static::setOption($key, $value, $group);
        }
    }
}
