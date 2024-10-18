<?php

namespace ProcessWire;

class ProcessPageListVersionsCounter extends WireData implements Module
{

  public static function getModuleInfo()
  {
    return array(

      'title' => 'Pagelist Versions Counter',
      'version' => 001,
      'summary' => 'Shows number of versions of page, if any are found',
      'singular' => true,
      'autoload' => true,
      'author' => 'Eelke Feenstra',
      'requires' => array(
        'ProcessWire>=3.0.235'
      )
    );
  }

  public function init()
  {
    $this->addHookAfter('ProcessPageListRender::getPageLabel', $this, 'addVersionsCounter');
    $this->config->styles->add($this->config->urls->ProcessPageListVersionsCounter . "$this.css");
  }

  public function addVersionsCounter($event)
  {
    /** @var Page $page */
    $page = $event->arguments('page');

    /** @var PagesVersions $versions  */
    $versions = wire('pagesVersions');

    $pageVersions = $versions->getPageVersionInfos($page);
    if (count($pageVersions)) {

      $event->return = $event->return . "<span class='pagelist-versions-counter'><i class='fa fa-files-o'></i> " . count($pageVersions) . "</span>";
    }
  }
}
