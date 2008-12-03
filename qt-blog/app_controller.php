<?php
/* SVN FILE: $Id: app_controller.php 6311 2008-01-02 06:33:52Z phpnut $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 6311 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2008-01-02 07:33:52 +0100 (Wed, 02 Jan 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		cake
 * @subpackage	cake.app
 */
class AppController extends Controller {
	var $components = array(
		'RequestHandler',
	);
	/*
	 * @var RequestHandlerComponent
	 */
	var $RequestHandler;

	function beforeFilter() {
		parent::beforeFilter();
		if ($this->isAdmin() && ! $this->RequestHandler->isAjax())
			$this->layout = 'admin';
	}
	function beforeRender() {
		parent::beforeRender();
		QueryTemplates::$fixWebroot = $this->webroot.'templates/';
	}
	protected function isAdmin() {
		$admin = Configure::read('Routing.admin');
		return isset($this->params[$admin]) && $this->params[$admin];
	}

	function latest($amount = 10) {
		if (! $amount)
			$amount = 10;
		$model = Inflector::classify(
			substr(get_class($this), 0, -strlen('Controller'))
		);
		$this->set(
			low(Inflector::pluralize($model)),
			$this->$model->findAll(null, null, 'id DESC', $amount)
		);
	}
	/**
	 * Internal template rendering for requestAction.
	 * Admin section.
	 *
	 * @param string $template
	 */
	function admin_template($template) {
		$this->render('admin_'.$template.'_template');
	}
	/**
	 * Internal template rendering for requestAction.
	 * Client section.
	 *
	 * @param string $template
	 */
	function template($template) {
		$this->render('admin_'.$template.'_template');
	}
}
?>