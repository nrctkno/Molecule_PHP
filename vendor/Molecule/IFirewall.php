<?php

interface IFirewall {

  function execute(Webapp $app);

  function getExcluded();
}
