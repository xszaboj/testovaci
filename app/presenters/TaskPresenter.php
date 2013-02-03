<?php

/**
 * Description of TaskPresenter.php
 *
 * @author jack
 */
/**
 * Presenter, který zajišťuje výpis seznamů úkolů.
 */
class TaskPresenter extends BasePresenter
{
	/** @var @var Todo\TaskListRepository */
	private $taskListRepository;

	protected function startup()
	{
		parent::startup();
		$this->taskListRepository = $this->context->taskListRepository;
	}

	/** @var \Nette\Database\Table\ActiveRow */
	private $list;

	public function actionDefault($id)
	{
		$this->list = $this->taskListRepository->find($id);
	}

	public function renderDefault()
	{
		$this->template->list = $this->list;
		$this->template->tasks = $this->taskListRepository->tasksOf($this->list);
	}
}