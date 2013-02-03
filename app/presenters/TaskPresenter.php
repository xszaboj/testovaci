<?php
use Nette\Application\UI\Form;
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
	/** @var @var Todo\UserRepository */
	private $userRepository;
	/** @var Todo\TaskRepository */
	private $taskRepository;

	protected function startup()
	{
		parent::startup();
		$this->taskListRepository = $this->context->taskListRepository;
		$this->userRepository = $this->context->userRepository; // získáme model pro práci s uživateli
		$this->taskRepository = $this->context->taskRepository; // předání potřebné služby
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
	}

	protected function createComponentTaskForm()
	{
		$userPairs = $this->userRepository->findAll()->fetchPairs('id', 'name');

		$form = new Form();
		$form->addText('text', 'Úkol:', 40, 100)
			->addRule(Form::FILLED, 'Je nutné zadat text úkolu.');
		$form->addSelect('userId', 'Pro:', $userPairs)
			->setPrompt('- Vyberte -')
			->addRule(Form::FILLED, 'Je nutné vybrat, komu je úkol přiřazen.');
		$form->addSubmit('create', 'Vytvořit');
		$form->onSuccess[] = $this->taskFormSubmitted;
		return $form;
	}

	public function taskFormSubmitted(Form $form)
	{
		$this->taskRepository->createTask($this->list->id, $form->values->text, $form->values->userId);
		$this->flashMessage('Úkol přidán.', 'success');
		$this->redirect('this');
	}

	//Create component Tasklist
	protected function createComponentTaskList()
	{
		if ($this->list === NULL) {
			$this->error('Wrong action');
		}
		return new Todo\TaskListControl($this->taskListRepository->tasksOf($this->list),  $this->taskRepository);
	}

}