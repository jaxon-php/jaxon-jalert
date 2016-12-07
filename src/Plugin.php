<?php

namespace Jaxon\Jalert;

use Jaxon\Plugin\Response;
use Jaxon\Request\Interfaces\Confirm;

class Plugin extends Response implements Confirm
{
    use \Jaxon\Utils\ContainerTrait;

    public function getName()
    {
        return 'jalert';
    }

    public function generateHash()
    {
        // The version number is used as hash
        return '1.0.0';
    }

    public function getJs()
    {
        if(!$this->includeAssets())
        {
            return '';
        }
        return '<script type="text/javascript" src="https//lib.jaxon-php.org/jAlert/4.5.1/jAlert.min.js"></script>';
    }

    public function getCss()
    {
        if(!$this->includeAssets())
        {
            return '';
        }
        return '<link rel="stylesheet" href="https//lib.jaxon-php.org/jAlert/4.5.1/jAlert.css" />';
    }

    public function getScript()
    {
        return '
jaxon.command.handler.register("jalert.dialog", function(args) {
    $.jAlert({title: args.data.title, content: args.data.content, theme: "blue", btns: args.data.buttons});
});
jaxon.command.handler.register("jalert.alert", function(args) {
    $.jAlert({title: args.data.title, content: args.data.content, theme: args.data.theme});
});
';
    }

    public function modal($title, $content, $buttons, $width = 600)
    {
        // Buttons
        $buttonArray = array();
        foreach($buttons as $button)
        {
            if($button['click'] == 'close')
            {
                $buttonArray[] = array('text' => $button['title'], 'onClick' => 'function(e,b){}', 'closeAlert' => true);
            }
            else
            {
                $buttonArray[] = array('text' => $button['title'], 'class' => $button['class'], 'onClick' => 'function(e,b){' . $button['click'] . '}', 'closeAlert' => false);
            }
        }
        // Dialog
        $this->addCommand(array('cmd' => 'jalert.dialog'), array('title' => $title, 'content' => $content, 'buttons' => $buttonArray, 'theme' => 'blue'));
    }

    public function hide()
    {
        $this->response()->script("$('.jAlert').closeAlert(true, function(){})");
    }

    protected function alert($content, $title, $theme)
    {
        $this->addCommand(array('cmd' => 'jalert.alert'), array('content' => $content, 'title' => $title, 'theme' => $theme));
    }

    public function success($message, $title = null)
    {
        $this->alert($message, $title, 'green');
    }

    public function info($message, $title = null)
    {
        $this->alert($message, $title, 'blue');
    }

    public function warning($message, $title = null)
    {
        $this->alert($message, $title, 'orange');
    }

    public function error($message, $title = null)
    {
        $this->alert($message, $title, 'red');
    }

    /**
     * Get the script which makes a call only if the user answers yes to the given question
     * 
     * This is the implementation of the Jaxon\Request\Interfaces\Confirm interface.
     * 
     * @return string
     */
    public function getScriptWithQuestion($question, $script)
    {
        return '$.jAlert({type: "confirm", confirmQuestion: "' . addslashes($question) . '", onConfirm: function(){' . $script . ';}, onDeny: function(){}});return false;';
    }
}
