<?php

namespace Chwnam\KMC\Supports;

use Bojaghi\Contract\Support;
use WP_Post;

class MetaBox implements Support
{
    public function __construct()
    {
        // Remove course meta-box
        remove_meta_box(KMC_TAX_COURSE .'div', null, 'side');
    }
}
