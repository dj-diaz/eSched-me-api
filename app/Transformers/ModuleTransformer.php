<?php
namespace App\Transformers;

use App\Module;
use League\Fractal;

class ModuleTransformer extends Fractal\TransformerAbstract
{
	/**
     * List of resources possible to include
     *
     * @var array
     */
	protected $availableIncludes = [
		'submodules',
        'tagged',
	];

    protected $defaultIncludes = [
        'submodules',
        'tagged',
    ];

	public function transform(Module $module)
	{
		return [
			'id' => $module->id,
            'activty_id' => $module->activity_id,
            'title' => $module->title,
            'description' => $module->description,
            'status' => $module->status,
            'start' => $module->start,
            'end' => $module->end,
            'priority' => (int) $module->priority,
            'percentage' => (double) $module->percentage,
            'risk' => (double)$module->risk,
            'quality' => (double)$module->quality,
            'links' => [
            	'rel' => 'self',
            	'uri' => '/module/' . $module->id,
            ],
		];
	}

    public function includeSubmodules(Module $module)
    {
        $submodules = $module->submodules;
        return $this->collection($submodules, new SubmoduleTransformer());
    }

    public function includeTagged(Module $module)
    {
        $users = $module->users()->get();
        return $this->collection($users, new UserTransformer());
    }

}