<?php

require_once INCLUDE_DIR . 'class.plugin.php';

class TrelloPluginConfig extends PluginConfig {

    // Provide compatibility function for versions of osTicket prior to
    // translation support (v1.9.4)
    function translate() {
        if (!method_exists('Plugin', 'translate')) {
            return array(
                function ($x) {
                    return $x;
                },
                function ($x, $y, $n) {
                    return $n != 1 ? $y : $x;
                }
            );
        }
        return Plugin::translate('webhook');
    }

    function getOptions() {
        list ($__, $_N) = self::translate();

        return array(
            'webhook'                      => new SectionBreakField(array(
                'hint'  => $__('<br>For mobile app osTicket Admin, use this Webhook URL: https://api.osticket.com.br/push_notification<br><br>Readme first: https://github.com/luispimenta/osticket-webhook')
                    )),
            'webhook-webhook-url'          => new TextboxField(array(
                'label'         => $__('Webhook URL'),
                'required'=>true,
                'default'  => 'https://api.trello.com/1/cards',
                'placeholder'   => "For mobile app osTicket Admin, use this Webhook URL: https://api.osticket.com.br/push_notification",
                'configuration' => array(
                    'size'   => 130,
                    'length' => 300
                )
                    )),
            'trello-api-key'          => new TextboxField(array(
                'label'         => $__('Trello API Key'),
                'required'=>false,
                'default'  => '',
                'placeholder'   => "Set Trello API Key",
                'configuration' => array(
                    'size'   => 130,
                    'length' => 300
                )
            )),
            'trello-api-token'          => new TextboxField(array(
                'label'         => $__('Trello API Token'),
                'required'=>false,
                'default'  => '',
                'placeholder'   => "Set Trello API Token",
                'configuration' => array(
                    'size'   => 130,
                    'length' => 300
                )
            )),
            'trello-workspace'          => new TextboxField(array(
                'label'         => $__('Trello Workspace Name'),
                'required'=>false,
                'default'  => '',
                'placeholder'   => "Set Trello Workspace ID",
                'configuration' => array(
                    'size'   => 130,
                    'length' => 300
                )
            )),
            'trello-board'          => new TextboxField(array(
                'label'         => $__('Trello Board'),
                'required'=>false,
                'default'  => '',
                'placeholder'   => "Set Trello Board",
                'configuration' => array(
                    'size'   => 130,
                    'length' => 300
                )
            )),
            'trello-list-id'          => new TextboxField(array(
                'label'         => $__('Trello List ID'),
                'required'=>false,
                'default'  => '652834f49a0e74517d6abf87',
                'placeholder'   => "Set Trello List ID",
                'configuration' => array(
                    'size'   => 130,
                    'length' => 300
                )
            ))
        );
    }

}
