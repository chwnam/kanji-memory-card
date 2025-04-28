<?php

namespace {

    use Bojaghi\Continy\Continy;
    use Bojaghi\Continy\ContinyException;
    use Bojaghi\Continy\ContinyFactory;
    use Bojaghi\Continy\ContinyNotFoundException;
    use Bojaghi\Template\Template;

    if (!function_exists('kmc')) {
        function kmc(): Continy
        {
            static $instance = null;

            if (is_null($instance)) {
                try {
                    $instance = ContinyFactory::create(dirname(__DIR__) . '/conf/continy.php');
                } catch (ContinyException $e) {
                    wp_die($e->getMessage());
                }
            }

            return $instance;
        }
    }

    if (!function_exists('kmcGet')) {
        /**
         * @template T
         * @param class-string<T> $id
         *
         * @return T|object|null
         */
        function kmcGet(string $id): mixed
        {
            try {
                return kmc()->get($id);
            } catch (ContinyException|ContinyNotFoundException $e) {
                return null;
            }
        }
    }

    if (!function_exists('kmcCall')) {
        /**
         * @template T
         * @param class-string<T> $id
         * @param string          $method
         *
         * @return mixed
         */
        function kmcCall(string $id, string $method): mixed
        {
            $instance = kmcGet($id);
            if ($instance && method_exists($instance, $method) && is_callable([$instance, $method])) {
                return $instance->$method();
            }
            return null;
        }
    }

    if (!function_exists('kmcTmpl')) {
        function kmcTmpl(): Template
        {
            return kmcGet(Template::class);
        }
    }
}

namespace Chwnam\KanjiMemoryCard {

}