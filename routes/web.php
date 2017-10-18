<?php

Route::get('/', 'IndexController@index')->name('index');
Route::get('/datastatistics', 'IndexController@dataStatistics')->name('dataStatistics');

Route::post('/user', 'IndexController@user')->name('user');
Route::post('/trades', 'IndexController@trades')->name('trades');

Route::get('/holdingcost_view', 'HoldingCostController@view')->name('holdingcost_view');
Route::get('/holdingcost_symbol', 'HoldingCostController@getSymbol')->name('holdingcost_symbol');
Route::get('/holdingcost_value/{symbol}', 'HoldingCostController@getValue')->name('holdingcost_value');

Route::get('/holdingsymbol_view', 'HoldingSymbolController@view')->name('holdingsymbol_view');
Route::post('/holdingsymbol_value/{symbol}', 'HoldingSymbolController@getValue')->name('holdingsymbol_value');

Route::get('/ranking_list', 'RankingListController@view')->name('ranking_list');

Route::get('/profit_history/{login}', 'ProfitHistoryController@view')->name('profit_history');
Route::post('/profit_history/{login}', 'ProfitHistoryController@get');

Route::get('/current_trade', 'CurrentTradeContrller@index')->name('current_trade');