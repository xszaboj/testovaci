<?php
namespace Todo;
use Nette;

/**
 * Tabulka list
 */
class TaskListRepository extends Repository
{
	public function tasksOf(Nette\Database\Table\ActiveRow $list)
	{
		return $list->related('task')->order('created');
	}
	public function createList($title)
	{
		return $this->getTable()->insert(array(
			'title' => $title
		));
	}
}