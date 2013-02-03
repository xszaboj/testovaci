<?php

namespace Todo;
use Nette;

/**
 * Tabulka task
 */
class TaskRepository extends Repository
{
	public function findIncomplete()
	{
		return $this->findBy(array('done' => false))->order('created ASC');
	}
	public function createTask($listId, $task, $assignedUser)
	{
		return $this->getTable()->insert(array(
			'text' => $task,
			'user_id' => $assignedUser,
			'created' => new \DateTime(),
			'tasklist_id' => $listId
		));
	}
}