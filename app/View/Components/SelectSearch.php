<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class SelectSearch extends Component
{
    /**
     * El array de opciones ya procesado para Alpine.
     * @var array
     */
    public array $options;

    /**
     * El array de valores seleccionados.
     * @var array
     */
    public array $processedSelected;

    /**
     * Crea una nueva instancia del componente.
     *
     * @param Collection|array $items La colección de datos (e.g., User::all()).
     * @param string $name El atributo 'name' para el input del formulario.
     * @param string $id El ID del componente.
     * @param string $valueField El nombre del campo a usar como valor (e.g., 'id').
     * @param string $labelField El nombre del campo a usar como etiqueta (e.g., 'name').
     * @param bool $multiple Si el select es de selección múltiple.
     * @param string $placeholder El texto a mostrar cuando no hay nada seleccionado.
     * @param mixed $selected El valor o array de valores seleccionados por defecto.
     */
    public function __construct(
        public Collection|array $items,
        public string $name,
        public string $id,
        public string $valueField = 'id',
        public string $labelField = 'name',
        public bool $multiple = false,
        public string $placeholder = 'Selecciona una opción',
        public mixed $selected = null,
    ) {
        $this->options = $this->processItems($items);
        $this->processedSelected = $this->processSelected($selected);
    }

    /**
     * Transforma la colección de entrada en un array simple [valor => etiqueta].
     */
    private function processItems(Collection|array $items): array
    {
        $options = [];
        foreach ($items as $item) {
            $item = (object) $item; // Asegura que podamos acceder a las propiedades como objeto
            $value = $item->{$this->valueField};
            $label = $item->{$this->labelField};
            $options[$value] = $label;
        }
        return $options;
    }

    /**
     * Asegura que los valores seleccionados estén siempre en formato de array.
     */
    private function processSelected(mixed $selected): array
    {
        if (is_null($selected)) {
            return [];
        }
        // Si el valor seleccionado es un objeto o array asociativo, extrae el valor del campo correcto
        if (is_object($selected) || (is_array($selected) && !empty($selected) && !is_numeric(array_keys($selected)[0]))) {
            $selected = data_get($selected, $this->valueField);
        } elseif ($selected instanceof Collection) {
            $selected = $selected->pluck($this->valueField)->toArray();
        } elseif (is_array($selected) && !empty($selected) && (is_object($selected[0]) || is_array($selected[0]))) {
             $selected = collect($selected)->pluck($this->valueField)->toArray();
        }

        return is_array($selected) ? array_map('strval', $selected) : [strval($selected)];
    }

    /**
     * Obtiene la vista / contenido que representa el componente.
     */
    public function render(): View
    {
        return view('components.select-search');
    }
}
