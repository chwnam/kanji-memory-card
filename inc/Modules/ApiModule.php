<?php

namespace Chwnam\KMC\Modules;

use Bojaghi\Contract\Module;
use Chwnam\KMC\Supports\ApiParamFilter as F;
use Chwnam\KMC\Supports\CardSupport;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

class ApiModule implements Module
{
    public function __construct()
    {
        /** @uses getCard() */
        register_rest_route(
            'kmc/v1',
            '/get-card',
            [
                'callback'            => [$this, 'getCard'],
                'methods'             => ['GET', 'POST'],
                'permission_callback' => fn() => is_user_logged_in(),
                'args'                => [
                    'course'   => [
                        'required'          => true,
                        'sanitize_callback' => [F::class, 'sanitizeCourse'],
                    ],
                    'tier'     => [
                        'required'          => true,
                        'sanitize_callback' => [F::class, 'sanitizeTier'],
                    ],
                    'excludes' => [
                        'sanitize_callback' => [F::class, 'sanitizeIntArray'],
                    ],
                ],
            ],
        );

        /** @uses getNumCards() */
        register_rest_route(
            'kmc/v1',
            '/get-num-cards/(?P<course>[^/]+)/(?P<tier>\d)',
            [
                'callback'            => [$this, 'getNumCards'],
                'methods'             => ['GET'],
                'permission_callback' => fn() => is_user_logged_in(),
                'args'                => [
                    'course' => [
                        'required'          => true,
                        'sanitize_callback' => [F::class, 'sanitizeCourse'],
                    ],
                    'tier'   => [
                        'required'          => true,
                        'sanitize_callback' => [F::class, 'sanitizeTier'],
                    ],
                ],
            ],
        );

        /** @uses judgeCard() */
        register_rest_route(
            'kmc/v1',
            '/judge-card',
            [
                'callback'            => [$this, 'judgeCard'],
                'methods'             => 'POST',
                'permission_callback' => fn() => is_user_logged_in(),
                'args'                => [
                    'card_id' => [
                        'required'          => true,
                        'sanitize_callback' => [F::class, 'sanitizeCardId'],
                    ],
                    'result'  => [
                        'required'          => true,
                        'sanitize_callback' => [F::class, 'sanitizeResult'],
                    ],
                ],
            ],
        );
    }

    /**
     * @uses CardSupport::getCard()
     */
    public function getCard(WP_REST_Request $request): WP_REST_Response
    {
        $data = kmcCall(
            CardSupport::class,
            'getCard',
            [
                [
                    ...$request->get_params(),
                    'user_id' => get_current_user_id(),
                ],
            ],
        );

        if (is_wp_error($data)) {
            /** @var WP_Error $data */
            return new WP_REST_Response($data->get_error_message(), 400);
        }

        return new WP_REST_Response($data, 200);
    }

    /**
     * @uses CardSupport::getNumCards
     */
    public function getNumCards(WP_REST_Request $request): WP_REST_Response
    {
        $data = kmcCall(
            CardSupport::class,
            'getNumCards',
            [
                [
                    ...$request->get_params(),
                    'user_id' => get_current_user_id(),
                ],
            ],
        );

        if (is_wp_error($data)) {
            /** @var WP_Error $data */
            return new WP_REST_Response($data->get_error_message(), 400);
        }

        return new WP_REST_Response($data, 200);
    }

    /**
     * @uses CardSupport::judgeCard()
     */
    public function judgeCard(WP_REST_Request $request): WP_REST_Response
    {
        $data = kmcCall(
            CardSupport::class,
            'judgeCard',
            [
                [
                    ...$request->get_params(),
                    'user_id' => get_current_user_id(),
                ],
            ],
        );

        if (is_wp_error($data)) {
            /** @var WP_Error $data */
            return new WP_REST_Response($data->get_error_message(), 400);
        }

        return new WP_REST_Response($data, 200);
    }
}
