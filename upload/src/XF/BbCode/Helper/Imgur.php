<?php

namespace XF\BbCode\Helper;

class Imgur
{
	public static function matchCallback($url, $matchedId, \XF\Entity\BbCodeMediaSite $site, $siteId)
	{
		if (strpos($url, 'gallery/' . $matchedId) !== false
			|| strpos($url, 'a/' . $matchedId) !== false
		)
		{
			$matchedId = 'a/' . $matchedId;
		}

		return $matchedId;
	}
}