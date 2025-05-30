<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Transactions;
use App\Livewire\COA;

Route::get('/', Home::class)->name('home');
Route::get('/transaction', Transactions::class)->name('transaction');
Route::get('/coa', COA::class)->name('coa');