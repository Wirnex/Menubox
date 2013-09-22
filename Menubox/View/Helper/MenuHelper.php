<?php 
/**
 * Menu helper for CakePHP 2.x
 * Version 1.00
 * Igor Pletenev igor@wirnex.ru
 * 
 */
class MenuHelper extends AppHelper
{
	/**
	 * @property HtmlHelper $Html
	 */
	var $helpers = array('Html');
	/**
	 * Creates menu using ul li tags. 
	 * @param array $links Array of menu items. May be nested: array('Menu1'=>array('/company/about'))
	 * @param array $htmlAttributes
	 * @param array $options Possible are: theme, orientation (default "hor", "ver")
	 * @return string html like <ul><li></li></ul>
	 */
    public function menu($links = array(), $htmlAttributes = array(), $options = array())
	{
		static $dep = 0;
		$dep++;
		$out = array();
		//
		// iterate through all menu items
		//
		foreach ($links as $title => $link)
		{
			if(in_array($title, array("%node_url%", "%javascript%")))
				continue;
			// prepare title
			$element = $this->Html->tag('span', $title, array());
			
			// if element is an array and does not contain any link item
			if(is_array($link) && !(isset($link['url'])||isset($link['action'])||isset($link['controller'])||isset($link['%javascript%'])))
			{
				// title of element
				$element = $this->Html->tag('span', $title, array('class'=>'title'));
				$rootNodeActive = false;
				if(isset($link["%node_url%"]))
				{
					// /page:\d+/
					$here = $this->__getHere();
					if (Router::url(Router::currentRoute()->defaults) == Router::url($link["%node_url%"]) ||
						$here == Router::url($link["%node_url%"]))
					{
						$rootNodeActive = true;
					}
					else
						$element = $this->Html->link($element, $link['%node_url%'], array('escape' => false, 'class'=>''));
				}
				// recursive call to render element
				$class = 'submenu';
				$submenu = $this->menu($link);
				// if element is active (see iа some child is active)
				if(preg_match('/class=".*active.*"/', $submenu) || $rootNodeActive)
					$class .= ' active';
				$out[] = $this->Html->tag('li', $element.$submenu, array('class'=>$class));
				continue;
			}
			//
			// automatically detect active menu item
			//
			if(isset($link['url']))
				$link = $link['url'];
			
			$here = $this->__getHere();
			if (Router::url(Router::currentRoute()->defaults) == Router::url($link) ||
				$here == Router::url($link))
			{
				$class = 'active';
				$out[] = $this->Html->tag(
					'li',
					$this->Html->tag('span', $title, array('class'=>'title')),
					array('class' => $class)
				);
			}
			else
			{
				if(isset($link['%javascript%']))
					$link = "javascript:{$link['%javascript%']};";
				$out[] = $this->Html->tag(
					'li',
					$this->Html->link($element, $link, array('escape' => false, 'class'=>'title')),
					array()
				);
			}
		}
		$tmp = join("\n", $out);
		if($dep == 1)
		{
			// add menubox class to the root ul element
			if(isset($htmlAttributes['class']))
				$htmlAttributes['class'] .= ' menubox';
			else
				$htmlAttributes['class'] = 'menubox';
			// theme
			$options['theme'] = isset($options['theme'])?$options['theme']:'default';
			$htmlAttributes['class'] .= ' theme-'.$options['theme'];
			
			if(isset($options['orientation']))
			{
				if($options['orientation'] == 'ver')
					$htmlAttributes['class'] .= ' orient-ver';
			}
		}
		$dep--;
		return $this->Html->tag('ul', $tmp.$this->Html->tag('div', '', array('style'=>'clear: both;')), $htmlAttributes);
	}
	
	private function __getHere()
	{
		$here = Router::getRequest()->here;
		// skip pagination parameters
		$here = preg_replace("/\/page:\d+/", "", $here);
		return $here;
	}
}
?>
