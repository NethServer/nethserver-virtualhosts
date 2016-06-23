<?php

/* @var $view \Nethgui\Renderer\Xhtml */

if ($view->getModule()->getIdentifier() == 'update') {
    $keyFlags = $view::STATE_DISABLED | $view::STATE_READONLY;
    $template = 'VirtualHost_Update_Header';
} else {
    $keyFlags = 0;
    $template = 'VirtualHost_Create_Header';
}

echo $view->header('name')->setAttribute('template', $T($template));


echo $view->textInput('name', $keyFlags);
echo $view->textInput('Description');

echo $view->textInput('ServerNames');

if($keyFlags === 0) {
    echo $view->checkBox('CreateHostRecords', '1');
}

echo $view->checkBox('Access', 'private')->setAttribute('uncheckedValue', 'public');
echo $view->fieldsetSwitch('PasswordStatus', 'enabled', $view::FIELDSETSWITCH_CHECKBOX | $view::FIELDSETSWITCH_EXPANDABLE)
        ->setAttribute('uncheckedValue', 'disabled')
        ->insert($view->textInput('PasswordValue', $view::LABEL_NONE))
;

echo $view->checkbox('ForceSslStatus', 'enabled')->setAttribute('uncheckedValue', 'disabled');

echo $view->selector('SslCertificate', $view::SELECTOR_DROPDOWN);

echo $view->fieldsetSwitch('FtpStatus', 'enabled', $view::FIELDSETSWITCH_CHECKBOX | $view::FIELDSETSWITCH_EXPANDABLE)
        ->setAttribute('uncheckedValue', 'disabled')
        ->insert($view->textInput('FtpPassword', $view::LABEL_NONE))
;

echo $view->buttonList($view::BUTTON_SUBMIT | $view::BUTTON_CANCEL | $view::BUTTON_HELP);

