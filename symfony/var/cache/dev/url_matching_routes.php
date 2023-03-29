<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/doc.json' => [[['_route' => 'app.swagger', '_controller' => 'nelmio_api_doc.controller.swagger'], null, ['GET' => 0], null, false, false, null]],
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/api/register' => [[['_route' => 'api_reg', '_controller' => 'App\\Controller\\APIController::register'], null, ['POST' => 0], null, false, false, null]],
        '/api/login' => [[['_route' => 'api_login', '_controller' => 'App\\Controller\\APIController::login'], null, ['POST' => 0], null, false, false, null]],
        '/api/lastEmprunt' => [[['_route' => 'api_lastEmprunt', '_controller' => 'App\\Controller\\APIController::lastEmprunt'], null, ['POST' => 0], null, false, false, null]],
        '/api/emprunt' => [[['_route' => 'api_emprunt', '_controller' => 'App\\Controller\\APIController::empruntLecteur'], null, ['POST' => 0], null, false, false, null]],
        '/api/amis' => [[['_route' => 'api_amis', '_controller' => 'App\\Controller\\APIController::amisLecteur'], null, ['POST' => 0], null, false, false, null]],
        '/api/amis/delete' => [[['_route' => 'api_amis_delete', '_controller' => 'App\\Controller\\APIController::amisLecteurDelete'], null, ['POST' => 0], null, false, false, null]],
        '/api/api/books' => [[['_route' => 'app_api_books', '_controller' => 'App\\Controller\\APIController::books'], null, null, null, false, false, null]],
        '/api/books/last_posts' => [[['_route' => 'app_api_last_posts', '_controller' => 'App\\Controller\\APIController::lastPosts'], null, null, null, false, false, null]],
        '/api/books/research' => [[['_route' => 'app_api_research', '_controller' => 'App\\Controller\\APIController::research'], null, ['GET' => 0], null, true, false, null]],
        '/api/authors/research' => [[['_route' => 'app_api_research_author', '_controller' => 'App\\Controller\\APIController::researchAuthor'], null, ['GET' => 0], null, true, false, null]],
        '/api/recommandation' => [[['_route' => 'app_api_recommandation', '_controller' => 'App\\Controller\\APIController::recommandation'], null, ['POST' => 0], null, false, false, null]],
        '/hello' => [[['_route' => 'app_hello', '_controller' => 'App\\Controller\\HelloController::index'], null, null, null, false, false, null]],
        '/register' => [[['_route' => 'app_register', '_controller' => 'App\\Controller\\RegistrationController::register'], null, null, null, false, false, null]],
        '/api/doc' => [[['_route' => 'app.swagger_ui', '_controller' => 'nelmio_api_doc.controller.swagger_ui'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/api/books/category/([^/]++)(*:197)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        197 => [
            [['_route' => 'app_api_books_category', '_controller' => 'App\\Controller\\APIController::booksCategory'], ['id'], ['GET' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
