<?php
App::uses('Shell', 'Console');

class AppShell extends Shell
{
  protected $memoryStart;
  protected $start;
  protected $maxTime = 0;
  
  protected function __prepare()
  {
    Configure::write('Cache.disable', TRUE);
    $this->memoryStart = memory_get_usage();
    $this->start = time();
  }
  
  protected function __outputEnd()
  {
    $this->out(time()-$this->start.'sec');
    $this->out(formatBytes(memory_get_usage()-$this->memoryStart));
  }
  
  protected function __checkTimeout()
  {
    $sec = time()-$this->start;
    return ($sec <= $this->maxTime);
  }
}

