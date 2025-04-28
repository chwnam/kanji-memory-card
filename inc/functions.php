<?php

namespace {

    use Bojaghi\Continy\Continy;
    use Bojaghi\Helper\Facades;
    use Bojaghi\Template\Template;

    if (!function_exists('kmc')) {
        function kmc(): Continy
        {
            return Facades::container(dirname(__DIR__) . '/conf/continy.php');
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
            return Facades::get($id);
        }
    }

    if (!function_exists('kmcCall')) {
        /**
         * @template T
         * @param class-string<T> $id
         * @param string $method
         * @param mixed $args
         *
         * @return mixed
         */
        function kmcCall(string $id, string $method, mixed $args = false): mixed
        {
            return Facades::call($id, $method, $args);
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
    /**
     * 설정 업데이트 후 보이는 메시지를 저장
     *
     * @param array $message
     * @return void
     */
    function setSetupMessage(array $message): void
    {
        set_site_transient(KMC_MESSAGE, $message, HOUR_IN_SECONDS);
    }

    /**
     * 설정 업데이트 후 보이는 메시지를 반환
     *
     * @return array|false
     */
    function getSetupMessage(): array|false
    {
        $data = get_site_transient(KMC_MESSAGE);

        if ($data) {
            delete_site_transient(KMC_MESSAGE);
        }

        return $data;
    }
}
