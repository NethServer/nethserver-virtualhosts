<?php

echo $view->panel()
    ->insert($view->textInput('name'))
    ->insert($view->textInput('Description'));
echo $view->fieldsetSwitch('status', 'enabled', $view::FIELDSETSWITCH_CHECKBOX)->setAttribute('uncheckedValue', 'disabled')
    ->insert($view->selector('VirtualHost', $view::SELECTOR_DROPDOWN))
    ->insert(
        $view->fieldset()->setAttribute('template', $T('Alias_label'))
        ->insert($view->radioButton('AliasType', 'default'))
        ->insert($view->radioButton('AliasType', 'root'))
        ->insert($view->fieldsetSwitch('AliasType', 'custom', $view::FIELDSETSWITCH_EXPANDABLE)
            ->insert($view->textInput('AliasCustom', $view::LABEL_NONE))
        )
    )
    ->insert($view->panel()->setAttribute('class', 'generated-url')->setAttribute('tag','ul'))
    ->insert($view->checkBox('Access', 'private')->setAttribute('uncheckedValue', 'public'))
    ->insert(
        $view->fieldsetSwitch('PasswordStatus', 'enabled', $view::FIELDSETSWITCH_CHECKBOX | $view::FIELDSETSWITCH_EXPANDABLE)
        ->setAttribute('uncheckedValue', 'disabled')
        ->insert($view->textInput('PasswordValue', $view::LABEL_NONE))
    )
    ->insert($view->checkbox('ForceSsl', 'enabled')->setAttribute('uncheckedValue', 'disabled'))
    ->insert($view->checkbox('AllowOverride', 'enabled')->setAttribute('uncheckedValue', 'disabled'))
;

echo $view->buttonList($view::BUTTON_SUBMIT | $view::BUTTON_CANCEL | $view::BUTTON_HELP);

