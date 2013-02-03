<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @var Todo\TaskListRepository */
private $taskListRepository;

	protected function startup()
	{
		parent::startup();
		$this->taskListRepository = $this->context->taskListRepository;
	}

	public function beforeRender()
	{
		$this->template->lists = $this->taskListRepository->findAll()->order('title ASC');
	}

}
