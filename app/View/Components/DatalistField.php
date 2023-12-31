<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DatalistField extends Component
{
  public $type;
  public $label;
  public $name;
  public $id;
  public $ft;
  public $sd;
  public $savev;
  public $showv;
  public $list;
  public $required;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($type, $label, $name, $id, $ft, $sd, $list, $showv, $savev, $required = null)
  {
    $this->$type = $type;
    $this->label = $label;
    $this->name = $name;
    $this->id = $id;
    $this->ft = $ft;
    $this->sd = $sd;
    $this->savev = $savev;
    $this->showv = $showv;
    $this->list = $list;
    $this->required = $required;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.datalist-field');
  }
}
