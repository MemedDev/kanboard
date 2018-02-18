<?php

namespace Kanboard\Formatter;

use Kanboard\Core\Filter\FormatterInterface;

/**
 * Board Task Formatter
 *
 * @package formatter
 * @author  Frederic Guillot
 */
class BoardTaskFormatter extends BaseFormatter implements FormatterInterface
{
    protected $tasks = array();
    protected $tags = array();
    protected $columnId = 0;
    protected $swimlaneId = 0;
    protected $columnTitle = null;
    protected $swimlaneTitle = null;

    /**
     * Set tags
     *
     * @access public
     * @param  array $tags
     * @return $this
     */
    public function withTags(array $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Set tasks
     *
     * @access public
     * @param  array $tasks
     * @return $this
     */
    public function withTasks(array $tasks)
    {
        $this->tasks = $tasks;
        return $this;
    }

    /**
     * Set columnId
     *
     * @access public
     * @param  integer $columnId
     * @return $this
     */
    public function withColumnId($columnId)
    {
        $this->columnId = $columnId;
        return $this;
    }

    /**
     * Set columnTitle
     *
     * @access public
     * @param  string $columnTitle
     * @return $this
     */
    public function withColumnTitle($columnTitle)
    {
        $this->columnTitle = $columnTitle;
        return $this;
    }

    /**
     * Set swimlaneId
     *
     * @access public
     * @param  integer $swimlaneId
     * @return $this
     */
    public function withSwimlaneId($swimlaneId)
    {
        $this->swimlaneId = $swimlaneId;
        return $this;
    }

    /**
     * Set swimlaneTitle
     *
     * @access public
     * @param  integer $swimlaneTitle
     * @return $this
     */
    public function withSwimlaneTitle($swimlaneTitle)
    {
        $this->swimlaneTitle = $swimlaneTitle;
        return $this;
    }

    /**
     * Apply formatter
     *
     * @access public
     * @return array
     */
    public function format()
    {
        $tasks = array_values(array_filter($this->tasks, array($this, 'filterTasks')));
        array_merge_relation($tasks, $this->tags, 'tags', 'id');

        foreach ($tasks as &$task) {
            $task['is_draggable'] = $this->helper->projectRole->isDraggable($task);
        }


        return $tasks;
    }

    /**
     * Keep only tasks of the given column and swimlane
     *
     * @access protected
     * @param  array $task
     * @return bool
     */
    protected function filterTasks(array $task)
    {
        if ($task['column_name'] == $this->columnTitle && $task['swimlane_name'] == $this->swimlaneTitle) {
            return $task['column_id'];
        }
    }
}
