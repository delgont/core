<?php
namespace Delgont\Core\Concerns;


trait ModelHasMeta {

    public function getMetaAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode($value);
    }

    public function getMeta($key)
    {
        return $this->meta[$key] ?? null;
    }

    public function setMeta($key, $value)
    {
        $meta = $this->meta ?? [];
        $meta[$key] = $value;
        $this->meta = $meta;
        $this->save();
    }
    
}