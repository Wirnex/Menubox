Menubox Plugin for CakePHP 2.x
=======
by Igor Pletenev
igor@wirnex.ru
http://menubox.wirnex.ru

Menubox allows you to create navigation menu on your CakePHP site. It doesn't have any external dependencies. It's main feature is automatically detection of active menu item based on CakePHP request information. It's possible to create nested drop down menus. No deep limit.

1. Requirements
	CakePHP 2.1+

2. Download and Install:

	2.1. Download plugin Menubox and copy it to app/Plugin.

	2.2. In the file app/Config/bootstrap.php add the following code

		CakePlugin::load('Menubox');

	2.3. In the file app/Controller/AppController.php add the following code

		var $helpers = array('Menubox.Menu');

	2.4. In layout file (normally "View/Layouts/default.ctp") add the following code before css block

		// this line before css block
		echo $this->element('Menubox.bootstrap');

		// css block
		echo $this->fetch('css');

3. Usage

	3.1 Prepare array with menu items
```
	$memuitems = array(
		'Microsoft' => array(
			'Windows' => array(
				'XP, Vista' => array('controller'=>'microsoft', 'action'=>'xpvista'),
				'Live' => array(
					'Mail'		=> array('controller'=>'microsoft', 'action'=>'live', 'mail'),
					'Hotmail'	=> array('controller'=>'microsoft', 'action'=>'live', 'hotmail'),
					'Search'	=> array('controller'=>'microsoft', 'action'=>'live', 'search'),
					'Expo'		=> array('controller'=>'microsoft', 'action'=>'live', 'expo'),
					'Messenger'	=> array('controller'=>'microsoft', 'action'=>'live', 'messenger'),
					'Spaces'	=> array('controller'=>'microsoft', 'action'=>'live', 'spaces'),
					'OneCare'	=> array('controller'=>'microsoft', 'action'=>'live', 'onecare')
				)
			),
			'Office' => array(
				'2003, 2007' => array('controller'=>'microsoft', 'action'=>'office', '20032007'),
				'Live' => array(
					'Basics'		=> array('controller'=>'microsoft', 'action'=>'office', 'basic'),
					'Essentials'	=> array('controller'=>'microsoft', 'action'=>'office', 'essentials'),
					'Premium'		=> array('controller'=>'microsoft', 'action'=>'office', 'premium')
				)
			)
		),
		'MSN' => array(
			'entertainment'	=> array('controller'=>'msn', 'action'=>'entertainment'),
			'movies'		=> array('controller'=>'msn', 'action'=>'movies'),
			'music'			=> array('controller'=>'msn', 'action'=>'music'),
			'tv'			=> array('controller'=>'msn', 'action'=>'tv'),
			'etc'			=> array('controller'=>'msn', 'action'=>'etc')
		)
	);
```
	3.2 Render menu
```
	echo $this->Menu->menu($memuitems, array('class'=>'menu'), array());
```	