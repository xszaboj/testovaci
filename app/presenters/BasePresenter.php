<?php
use Nette\Application\UI\Form;
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

	protected function createComponentNewListForm()
	{
		$form = new Form();
		$form->addText('title', 'Název:', 15, 50)
			->addRule(Form::FILLED, 'Musíte zadat název seznamu úkolů.');
		$form->addSubmit('create', 'Vytvořit');
		$form->onSuccess[] = $this->newListFormSubmitted;
		return $form;
	}
	public function newListFormSubmitted(Form $form)
	{
		$list = $this->taskListRepository->createList($form->values->title);
		$this->flashMessage('Seznam úkolů založen.', 'success');
		$this->redirect('Task:default', $list->id);
	}

}
