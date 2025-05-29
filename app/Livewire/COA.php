<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CoaCategory;
use App\Models\ChartOfAccount;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;

class COA extends Component
{
    use WithPagination;

    public $code, $coa_name, $category_id, $category_name, $selected_coa, $coa_category_id, $type_category;
    public $isEdit = false;

    public function render()
    {
        $coa = ChartOfAccount::with('category:id,name')->orderBy('code')->paginate(15);
        $categories = CoaCategory::select('id', 'name')->get();
        return view('livewire.c-o-a', ['coa' => $coa, 'categories' => $categories])->layout('layouts.app');
    }

    public function mount()
    {

    }

    public function resetForm()
    {
        $this->isEdit = false;
        $this->reset(['code', 'coa_name', 'category_id', 'category_name', 'selected_coa', 'coa_category_id', 'type_category']);
    }

    public function editCOA($code)
    {
        $this->isEdit = true;
        $coa = ChartOfAccount::findOrFail($code);
        $this->selected_coa = $coa->code;
        $this->code = $coa->code;
        $this->coa_name = $coa->name;
        $this->coa_category_id = $coa->category_id;
    }
    
    public function saveCOA()
    {
        $this->validate([
            'code' => [
                'required',
                'integer',
                Rule::unique('chart_of_accounts', 'code')->ignore($this->selected_coa, 'code'),
            ],
            'coa_name' => 'required|string',
            'coa_category_id' => 'required|exists:coa_categories,id',
        ]);

        $data = [
            'code' => $this->code,
            'name' => $this->coa_name,
            'category_id' => $this->coa_category_id,
        ];

        try {
            ChartOfAccount::updateOrCreate(
                ['code' => $this->selected_coa],
                $data
            );
            
            $this->dispatch('toast', type: 'success', message: 'Successfully saving the data.');
            $this->resetForm();
        } catch (Exception $e) {
            Log::error('Failed saving COA: ' . $e->getMessage());
            $this->dispatch('toast', type: 'error', message: 'Something went wrong while saving. Please try again.');
        }
    }

    public function deleteCOA($code)
    {
        try {
            $coa = ChartOfAccount::where('code', $code)->firstOrFail();
            $coa->delete();

            $this->dispatch('toast', type: 'success', message: 'COA deleted successfully.');
        } catch (Exception $e) {
            Log::error('Failed deleting COA: ' . $e->getMessage());
            $this->dispatch('toast', type: 'error', message: 'Something went wrong while deleting. Please try again.');
        }
    }

    public function editCategory($id)
    {
        $this->isEdit = true;
        $category = CoaCategory::findOrFail($id);
        $this->category_id = $category->id;
        $this->type_category = $category->type;
        $this->category_name = $category->name;
    }

    public function saveCategory()
    {
        $this->validate([
            'category_name' => [
                'required',
                'string',
                Rule::unique('coa_categories', 'name')->ignore($this->category_id),
            ],
            'type_category' => 'required|string|in:income,expense',
        ]);

        $data = [
            'name' => $this->category_name,
            'type' => $this->type_category,
        ];

        try {
            CoaCategory::updateOrCreate(
                ['id' => $this->category_id],
                $data
            );
            
            $this->dispatch('toast', type: 'success', message: 'Successfully saving the data.');
            $this->resetForm();
        } catch (Exception $e) {
            Log::error('Failed saving COA: ' . $e->getMessage());
            $this->dispatch('toast', type: 'error', message: 'Something went wrong while saving. Please try again.');
        }
    }

    public function deleteCategory($id)
    {
        try {
            $category = CoaCategory::findOrFail($id);
            $category->delete();

            $this->dispatch('toast', type: 'success', message: 'Category deleted successfully.');
        } catch (Exception $e) {
            Log::error('Failed deleting category: ' . $e->getMessage());
            $this->dispatch('toast', type: 'error', message: 'Something went wrong while deleting. Please try again.');
        }
    }
}
