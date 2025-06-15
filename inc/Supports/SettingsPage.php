<?php

namespace Chwnam\KMC\Supports;

use Bojaghi\Template\Template;
use WP_Query;

class SettingsPage
{
    public function __construct(private Template $tmpl)
    {
    }

    public function render(): void
    {
        echo $this->tmpl->template('admin-settings');
    }
}
