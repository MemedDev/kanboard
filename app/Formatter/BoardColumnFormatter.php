<?php

namespace Kanboard\Formatter;

use Kanboard\Core\Filter\FormatterInterface;

/**
 * Board Column Formatter
 *
 * @package formatter
 * @author  Frederic Guillot
 */
class BoardColumnFormatter extends BaseFormatter implements FormatterInterface
{
    protected $swimlaneId = 0;
    protected $swimlaneTitle = '';
    protected $columns = array();
    protected $tasks = array();
    protected $tags = array();

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
     * Set columns
     *
     * @access public
     * @param  array $columns
     * @return $this
     */
    public function withColumns(array $columns)
    {
        $this->columns = $columns;
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
     * Apply formatter
     *
     * @access public
     * @return array
     */
    public function format()
    {
        foreach ($this->columns as &$column) {
            $column['tasks'] = $this->boardTaskFormatter
                ->withTasks($this->tasks)
                ->withTags($this->tags)
                ->withSwimlaneTitle($this->swimlaneTitle)
                ->withColumnTitle($column['title'])
                ->format();

            $column['nb_tasks'] = count($column['tasks']);
            $column['score'] = (int) array_column_sum($column['tasks'], 'score');
        }

        return $this->columns;
    }
}
