<?php

namespace XF\Moderator;

class NodeModerator extends AbstractModerator
{
	/**
	 * Gets the option for the moderator add "choice" page.
	 * @see AbstractModerator::getAddModeratorOption()
	 */
	public function getAddModeratorOption($selectedContentId, $contentType)
	{
		/** @var \XF\Repository\Node $nodeRepo */
		$nodeRepo = \XF::repository('XF:Node');

		$options = [
			'choices' => $nodeRepo->getNodeOptionsData(false),
			'label' => \XF::phrase('forum_moderator') . ':',
			'name' => \XF::escapeString("type_id[$contentType]"),
			'value' => $selectedContentId
		];

		return $options;
	}

	/**
	 * Gets the titles of multiple pieces of content.
	 * @see AbstractModerator::getContentTitles()
	 */
	public function getContentTitles(array $ids)
	{
		/** @var \XF\Repository\Node $nodeRepo */
		$nodeRepo = \XF::repository('XF:Node');

		$nodes = $nodeRepo->getFullNodeList()->toArray();
		$titles = [];
		foreach ($ids AS $key => $id)
		{
			if (isset($nodes[$id]))
			{
				$node = $nodes[$id];
				$titles[$key] = \XF::phrase('node_type.' . $node['node_type_id']) . " - $node[title]";
			}
		}

		return $titles;
	}
} 