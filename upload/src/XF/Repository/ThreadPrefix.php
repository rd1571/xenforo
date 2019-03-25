<?php

namespace XF\Repository;

class ThreadPrefix extends AbstractPrefix
{
	protected function getRegistryKey()
	{
		return 'threadPrefixes';
	}

	protected function getClassIdentifier()
	{
		return 'XF:ThreadPrefix';
	}

	public function getVisiblePrefixListData()
	{
		$prefixMap = $this->finder('XF:ForumPrefix')
			->with('Forum', true)
			->with('Forum.Node', true)
			->with('Forum.Node.Permissions|' . \XF::visitor()->permission_combination_id)
			->fetch();

		$isVisibleClosure = function(\XF\Entity\ThreadPrefix $prefix) use ($prefixMap)
		{
			$isVisible = false;

			foreach ($prefixMap AS $forumPrefix)
			{
				/** @var \XF\Entity\ForumPrefix $forumPrefix */
				if ($prefix->prefix_id == $forumPrefix->prefix_id)
				{
					$isVisible = $forumPrefix->Forum->canView();
				}
			}

			return $isVisible;
		};
		return $this->_getVisiblePrefixListData($isVisibleClosure);
	}
}