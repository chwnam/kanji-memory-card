<?php

namespace Chwnam\KanjiMemoryCard\Modules;

use Bojaghi\Contract\Module;
use Bojaghi\Fields\Meta\Meta;
use Bojaghi\Fields\Modules\CustomFields;
use Bojaghi\Helper\Helper;

/**
 * @property-read Meta $cardAnswer
 * @property-read Meta $cardAnswerSupplement
 */
class PostMeta implements Module
{
    private array $cached;

    public function __construct(private CustomFields $cf)
    {
        $this->cached = [];
    }

    public function __get(string $name)
    {
        if (isset($this->cached[$name])) {
            return $this->cached[$name];
        }

        $snake = Helper::prefixed(Helper::toSnakeCase($name), '_kmc_');
        $meta  = $this->cf->getPostMeta($snake);
        if ($meta) {
            $this->cached[$name] = $meta;
            return $meta;
        }

        return null;
    }
}
