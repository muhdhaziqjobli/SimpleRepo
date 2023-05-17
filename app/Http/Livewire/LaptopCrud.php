<?php

namespace App\Http\Livewire;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Laptop;

class LaptopCrud extends Component
{
    use WithPagination;

	public $laptopId;
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
        $laptops = Laptop::where('brand', 'like', '%'.$this->search.'%')
					->orWhere('model', 'like', '%'.$this->search.'%')
					->orderBy('brand')
					->orderBy('year')
					->paginate(3);

		$data = [
			'laptops' => $laptops
		];

		return view('livewire.laptop-crud', $data);
    }
    public function updated($fields)
	{
		$this->validateOnly($fields);
	}

	public function updatingSearch()
    {
        $this->resetPage();
    }

	public function storeLaptop()
	{
		$validatedData = $this->validate();

		Laptop::create($validatedData);
		session()->flash('message','Laptop Added!');
		$this->resetInput();
		$this->dispatchBrowserEvent('close-modal');
	}

	public function editLaptop($id)
	{
		$laptop = Laptop::find($id);
		
		if ($laptop) {
			$this->laptopId = $laptop->id;
			$this->model = $laptop->model;
			$this->brand = $laptop->brand;
			$this->year = $laptop->year;
		} else {
			session()->flash('message','No such record!');
			return redirect()->to('/home');
		}
		
	}

	public function updateLaptop()
	{
		$validatedData = $this->validate();
		Laptop::where('id',$this->laptopId)->update($validatedData);
		session()->flash('message','Laptop Editted!');
		$this->resetInput();
		$this->dispatchBrowserEvent('close-modal');
	}

	public function deleteLaptop($id)
	{
		$laptop = Laptop::find($id);
		
		if ($laptop) {
			$this->laptopId = $laptop->id;
		} else {
			session()->flash('message','No such record!');
			return redirect()->to('/home');
		}
		
	}

	public function destroyLaptop()
	{
		Laptop::destroy($this->laptopId);
		session()->flash('message','Laptop Deleted!');
		$this->dispatchBrowserEvent('close-modal');
	}

	public function resetInput()
	{
		$this->model = '';
		$this->brand = '';
		$this->year = '';
	}
}