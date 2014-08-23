<?php
namespace App\Presenters;

use CMS;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    protected function createComponentTellAFriend()
    {
        return new CMS\TellAFriend();
    }
}