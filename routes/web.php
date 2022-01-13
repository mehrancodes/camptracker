<?php

Route::get('/', 'WelcomeController@index');

Route::get('how-it-works', 'GuestPagesController@howItWorks');
Route::get('pricing', 'GuestPagesController@pricing');

// Terms Of Service...
Route::get('/privacy', 'PrivacyController@show')->name('privacy');

Route::middleware(['auth', 'verified', 'subscribed'])->group(function () {
    Route::get('basecamp/connect', 'BaseCampController@index')->name('basecamp.connect');
    Route::get('basecamp/integrate', 'BaseCampController@redirectToProvider')->name('basecamp.integrate');
    Route::get('basecamp/callback', 'BaseCampController@handleProviderCallback');

    Route::middleware('integrated')->group(function () {
        Route::get('home', 'HomeController@index')->name('home');
        Route::resource('accounts', 'AccountsController')->only(['index', 'create', 'store']);
    });

    Route::prefix('accounts/{account}')->name('accounts.')->group(function () {
        Route::get('projects/{project}/todos', 'TodosController@index')->name('projects.todos.index');
        Route::get('projects/{project}/todos/{todo}', 'TodosController@show')->name('projects.todos.show');
        Route::get('projects/{project}/developers', 'DevelopersController@index')->name('projects.developers.index');

        Route::resource('projects', 'ProjectsController')->only(['index', 'create', 'store', 'show']);

        Route::get('developers/{developer}', 'DevelopersController@show')->name('developers.show');

        Route::get('activities', 'ActivitiesController@index')->name('activities.index');
    });

    // Activities Routes...
    Route::get('developers/{developer}/activities', 'ActivitiesController@activities');
    Route::get('developers/{developer}/activities/projects', 'ActivitiesController@projects');
    Route::get('developers/{developer}/activities/todos', 'ActivitiesController@todos');
});
