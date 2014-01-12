<?php

namespace Squeeze1_0\Util
{
  use ICanBoogie\Inflector;

  /**
   * @todo Remove external dependancy
   * @todo Add support for i18n.
   */
  abstract class LabelMaker
  {
    protected $defaultLabels = array();
    protected $labels = array();

    /**
     * @since 1.0
     */
    protected function getLabel()
    {
      return (isset($this->label)) ? $this->label : 'Squeeze';
    }

    /**
     * @since 1.0
     */
    protected function createLabels()
    {
      $inflector = Inflector::get();
      $label = array(
        'singular' => $inflector->singularize($this->getLabel()),
        'plural' => $inflector->pluralize($this->getLabel())
      );

      foreach ($this->defaultLabels as $key => $val) {
        if (!array_key_exists($key, $this->labels)) {
          if (!isset($val['inflection'])) {
            $val['inflection'] = 'singular';
          }
          $this->labels[$key] = sprintf($val['value'], $label[$val['inflection']]);
        }
      }
    }
  }
}