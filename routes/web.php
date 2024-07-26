<?php
$router->get('/', function () use ($router) {
    event(new App\Events\ExampleEvent());
    return $router->app->version();
});


$router->group(
    ['prefix' => 'api/v1'],
    function () use ($router) {
        $router->post('/login', 'AuthController@login');
        $router->delete('/logout', 'AuthController@logout');
        $router->get('/refreshtoken', 'AuthController@refreshToken');
        $router->get('/profile', 'AuthController@profile');
        $router->group(
            [ 'middleware' => 'jwt.auth'],
            function () use ($router) {
                $router->get('/user', 'UsersController@get');
                $router->group(
                    ['prefix' => 'transactions'],
                    function () use ($router) {
                        $router->get('/all', 'TransactionsController@getAll');
                        $router->get('/queue', 'TransactionsController@index');
                        $router->post('/{transaction_id}/cancel', 'TransactionsController@cancelTransaction');
                        $router->post('/{transaction_id}/complete', 'TransactionsController@completeTransaction');
                    }
                );

                $router->group(
                    ['prefix' => 'barangays'],
                    function () use ($router) {
                        $router->get('/', 'BarangayController@index');
                        $router->get('/{barangay_id}', 'BarangayController@show');
                        $router->post('/', 'BarangayController@create');
                        $router->put('/{barangay_id}', 'BarangayController@update');
                    }
                );

                $router->group(
                    ['prefix' => 'residents'],
                    function () use ($router) {
                    $router->get('/', 'ResidentController@getAll');
                        $router->get('/{resident_id}', 'ResidentController@getOne');
                        $router->post('/', 'ResidentController@create');
                        $router->put('/{resident_id}', 'ResidentController@update');

                        $router->group(
                            ['prefix' => '/{resident_id}/complaints'],
                            function () use ($router) {
                                $router->get('/', 'ResidentComplaintController@index');
                                $router->get('/{complaint_id}', 'ResidentComplaintController@show');
                                $router->post('/', 'ResidentComplaintController@store');
                            }
                        );

                        $router->group(
                            ['prefix' => '/{resident_id}/documents'],
                            function () use ($router) {
                                $router->get('/', 'ResidentDocumentController@index');
                                $router->get('/{document_id}', 'ResidentDocumentController@show');
                                $router->post('/', 'ResidentDocumentController@store');
                            }
                        );

                        $router->group(
                            ['prefix' => '/{resident_id}/records'],
                            function () use ($router) {
                                $router->get('/', 'ResidentRecordController@index');
                                $router->get('/{record_id}', 'ResidentRecordController@show');
                                $router->post('/', 'ResidentRecordController@store');
                            }
                        );
                    }
                );
        });
    }
);
