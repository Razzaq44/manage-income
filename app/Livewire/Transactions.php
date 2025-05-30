<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Log;
use Exception;

class Transactions extends Component
{
    public $amountFormatted, $amount, $date, $coa_code, $description, $id;
    public $items = [];

    public function render()
    {
        $chartOfAccounts = ChartOfAccount::select('code', 'name')->get();
        $transactions = Transaction::with('chartOfAccount')->latest()->take(10)->get();
        return view('livewire.transactions', ['transactions' => $transactions, 'chartOfAccounts' => $chartOfAccounts])->layout('layouts.app');
    }

    public function updatedAmountFormatted($value)
    {
        $this->amount = (int) str_replace('.', '', $value);
        $this->amountFormatted = number_format($this->amount, 0, ',', '.');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $this->id = $transaction->id;
        $this->amount = $transaction->debit ?: $transaction->credit;
        $this->date = $transaction->date;
        $this->coa_code = $transaction->coa_code;
        $this->description = $transaction->description;

        $this->amountFormatted = number_format($this->amount, 0, ',', '.');
    }

    public function save()
    {
        $this->validate([
            'date' => 'required|date',
            'coa_code' => 'required|exists:chart_of_accounts,code',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
        ]);

        try {
            $coa = ChartOfAccount::with('category')->where('code', $this->coa_code)->firstOrFail();

            $data = [
                'date' => $this->date,
                'coa_code' => $this->coa_code,
                'description' => $this->description,
                'debit' => $coa->category->type === 'expense' ? $this->amount : 0,
                'credit' => $coa->category->type === 'income' ? $this->amount : 0,
            ];

            Transaction::updateOrCreate(
                ['id' => $this->id],
                $data
            );

            $this->dispatch('toast', type: 'success', message: 'Successfully saving the data.');
            $this->reset(['date', 'coa_code', 'amountFormatted', 'description']);
        } catch (Exception $e) {
            Log::error('Failed saving transaction: ' . $e->getMessage());
            $this->dispatch('toast', type: 'error', message: 'Something went wrong while saving. Please try again.');
        }
    }

    public function delete($id)
    {

    }
}
