<?php

namespace App\Cache;

use Illuminate\Support\Facades\Cache;
use Delgont\Core\Cache\ModelCacheKeys;


class TermCacheKeys extends ModelCacheKeys
{
    const CURRENT_TERM = 'Term:Current';
    const PREVIOUS_TERM = 'Term:Previous';

    const CURRENT_TERM_REGISTRATIONS = 'Term:Current:Registrations';

    const CURRENT_TERM_STUDENTS = 'Term:Current:Students';
}
