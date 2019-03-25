<?php

namespace XF\Job;

use XF\Mvc\Entity\Entity;

abstract class AbstractEmbedMetadataJob extends AbstractJob
{
	protected $defaultData = [
		'steps' => 0,
		'start' => 0,
		'batch' => 1000,
		'types' => []
	];

	abstract protected function getIdsToRebuild(array $types);
	abstract protected function getRecordToRebuild($id);
	abstract protected function getPreparerContext();
	abstract protected function getMessageContent(Entity $record);
	abstract protected function getActionDescription();

	public function run($maxRunTime)
	{
		$startTime = microtime(true);

		if (!is_array($this->data['types']))
		{
			$this->data['types'] = [$this->data['types']];
		}

		$this->data['steps']++;

		$ids = $this->getIdsToRebuild($this->data['types']);
		if (!$ids)
		{
			return $this->complete();
		}

		$done = 0;
		$preparer = $this->getMessagePreparer($this->data['types']);

		foreach ($ids AS $id)
		{
			if (microtime(true) - $startTime >= $maxRunTime)
			{
				break;
			}

			$this->data['start'] = $id;

			$record = $this->getRecordToRebuild($id);
			if (!$record)
			{
				continue;
			}

			$preparer->setMessageEntity($record);

			$embedMetadata = $this->getExistingMetadata($record);
			if (!is_array($embedMetadata))
			{
				$embedMetadata = [];
			}

			$message = $this->getMessageContent($record);
			$preparer->prepare($message, false);

			foreach ($this->data['types'] AS $type)
			{
				$method = 'rebuild' . \XF\Util\Php::camelCase($type);
				if (method_exists($this, $method))
				{
					$this->{$method}($record, $preparer, $embedMetadata);
				}
			}

			$this->saveMetadata($record, $embedMetadata);

			$done++;
		}

		$this->data['batch'] = $this->calculateOptimalBatch($this->data['batch'], $done, $startTime, $maxRunTime, 1000);

		return $this->resume();
	}

	protected function getExistingMetadata(Entity $record)
	{
		return $record->embed_metadata;
	}

	protected function saveMetadata(Entity $record, array $embedMetadata)
	{
		$record->embed_metadata = $embedMetadata;
		$record->save();
	}

	/**
	 * @param array $types
	 *
	 * @return \XF\Service\Message\Preparer
	 */
	protected function getMessagePreparer(array $types)
	{
		/** @var \XF\Service\Message\Preparer $preparer */
		$preparer = $this->app->service('XF:Message\Preparer', $this->getPreparerContext());
		$preparer->disableAllFilters();

		return $preparer;
	}

	public function getStatusMessage()
	{
		$description = $this->getActionDescription();
		return sprintf('%s (%s)', $description, $this->data['start']);
	}

	public function canCancel()
	{
		return true;
	}

	public function canTriggerByChoice()
	{
		return true;
	}
}