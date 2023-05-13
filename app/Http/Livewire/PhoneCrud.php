<?php

namespace App\Http\Livewire;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Phone;
use DB;

class PhoneCrud extends Component
{
	use WithPagination;

	public $phoneId;
	public $model;
	public $brand;
	public $year;

	public $search = '';


	protected $rules = [
		'model' => 'required',
		'brand' => 'required',
		'year' => 'required|integer',
	];

	protected $paginationTheme = 'bootstrap';


	public function render()
	{
		$phones = Phone::where('brand', 'like', '%'.$this->search.'%')
					->orWhere('model', 'like', '%'.$this->search.'%')
					->orderBy('brand')
					->paginate(3);

		$data = [
			'phones' => $phones
		];

		return view('livewire.phone-crud', $data);
	}

	public function updated($fields)
	{
		$this->validateOnly($fields);
	}

	public function updatingSearch()
    {
        $this->resetPage();
    }

	public function storePhone()
	{
		$validatedData = $this->validate();

		Phone::create($validatedData);
		session()->flash('message','Phone Added!');
		$this->resetInput();
		$this->dispatchBrowserEvent('close-modal');
	}

	public function editPhone($id)
	{
		$phone = Phone::find($id);
		
		if ($phone) {
			$this->phoneId = $phone->id;
			$this->model = $phone->model;
			$this->brand = $phone->brand;
			$this->year = $phone->year;
		} else {
			session()->flash('message','No such record!');
			return redirect()->to('/home');
		}
		
	}

	public function updatePhone()
	{
		$validatedData = $this->validate();
		Phone::where('id',$this->phoneId)->update($validatedData);
		session()->flash('message','Phone Editted!');
		$this->resetInput();
		$this->dispatchBrowserEvent('close-modal');
	}

	public function deletePhone($id)
	{
		$phone = Phone::find($id);
		
		if ($phone) {
			$this->phoneId = $phone->id;
		} else {
			session()->flash('message','No such record!');
			return redirect()->to('/home');
		}
		
	}

	public function destroyPhone()
	{
		Phone::destroy($this->phoneId);
		session()->flash('message','Phone Deleted!');
		$this->dispatchBrowserEvent('close-modal');
	}

	public function resetInput()
	{
		$this->model = '';
		$this->brand = '';
		$this->year = '';
	}
}
