<?php

namespace App\Models\Concerns;

use App\Models\Library\LibraryMember;

trait CanBeLibraryMember
{

   public function libraryMember()
   {
      return $this->morpOne(LibraryMember::class, 'member');
   }

   public function scopeIsLibraryMember($query)
   {
      //return $query->whereHasMorph('libraryMember', );
   }
   
   
}