<?php

require_once INCLUDE_DIR . 'class.plugin.php';

class WebhookPluginConfig extends PluginConfig {

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
                'placeholder'   => "For mobile app osTicket Admin, use this Webhook URL: https://api.osticket.com.br/push_notification",
                'configuration' => array(
                    'size'   => 130,
                    'length' => 300
                ),
                    ))
        );
    }

}
