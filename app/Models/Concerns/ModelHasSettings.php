<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ModelKeyValueProperty;

trait ModelHasSettings
{

   public function settings()
   {
      return $this->morphMany(ModelKeyValueProperty::class, 'model');
   }

   public function setting($key, $object = false)
   {
      return ($object) ? $this->settings()->where('key', $key)->first() : $this->settings()->where('key', $key)->first()->value;
   }

   public function updateSetting($key, $value, $group = null)
   {
      $this->settings()->updateOrCreate(['key' => $key],[
         'key' => $key,
         'value' => $value,
         'group' => $group ?? 'general'
      ]);
      return $this;;
   }
   
}