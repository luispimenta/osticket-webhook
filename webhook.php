<?php

require_once(INCLUDE_DIR . 'class.signal.php');
require_once(INCLUDE_DIR . 'class.plugin.php');
require_once(INCLUDE_DIR . 'class.ticket.php');
require_once(INCLUDE_DIR . 'class.osticket.php');
require_once(INCLUDE_DIR . 'class.config.php');
require_once(INCLUDE_DIR . 'class.format.php');
require_once('config.php');

class WebhookPlugin extends Plugin {

    var $config_class = "WebhookPluginConfig";
    //we use this to save the correct config in the bootstrap method
    //and override the buggy getConfig() from osticket
    static $_correctConfig = null;

    /**
     * We override the getConfig method, because on
     * OsTicket 1.7.5 (at least) the getConfig does only
     * return the correct config in the bootstrap method.
     * On all other occasions, it will return the default
     * config.
     * @param PluginInstance|null $instance
     * @param $defaults
     * @return mixed|null
     */
    public function getConfig(PluginInstance $instance = null, $defaults = [])
    {
        if (self::$_correctConfig) {
            return self::$_correctConfig;
        }
        return parent::getConfig($instance, $defaults);
    }


    /**
     * The entrypoint of the plugin, keep short, always runs.
     */
    function bootstrap() {
        Signal::connect('ticket.created', array($this, 'onTicketCreated'));
        Signal::connect('threadentry.created', array($this, 'onTicketUpdated'));
        //fix: save correct config, which works only here in bootstrap

        self::$_correctConfig = $this->getConfig();
    }

    /**
     * What to do with a new Ticket?
     *
     * @global OsticketConfig $cfg
     * @param Ticket $ticket
     * @return type
     */
    function onTicketCreated(Ticket $ticket) {
        global $cfg;
        if (!$cfg instanceof OsticketConfig) {
            error_log("Webhook plugin called too early.");
            return;
        }
        $status = "created";
        $this->sendToWebhook($ticket, $status);
    }

    /**
     * What to do with an Updated Ticket?
     *
     * @global OsticketConfig $cfg
     * @param ThreadEntry $entry
     * @return type
     */
    function onTicketUpdated(ThreadEntry $entry) {
        global $cfg;
        if (!$cfg instanceof OsticketConfig) {
            error_log("Webhook plugin called too early.");
            return;
        }

        // Need to fetch the ticket from the ThreadEntry
        $ticket = $this->getTicket($entry);
        $status = "updated";
        $this->sendToWebhook($ticket, $status);
    }

    /**
     * A helper function that sends messages to webhook endpoints.
     *
     * @global osTicket $ost
     * @global OsticketConfig $cfg
     * @param Ticket $ticket
     * @param Status $status
     * @throws \Exception
     */
    function sendToWebhook(Ticket $ticket, $status) {
        global $ost, $cfg;
        if (!$ost instanceof osTicket || !$cfg instanceof OsticketConfig) {
            error_log("Webhook plugin called too early.");
            return;
        }
        $url = $this->getConfig()->get('webhook-webhook-url');
        if (!$url) {
            $ost->logError('Webhook Plugin not configured', 'You need to read the Readme and configure a webhook URL before using this.');
        }

        // Build the payload with the formatted data:
        $staff = $ticket->getStaff();
        $payload['body'] = [
            'staff'       => $staff ? $staff->getUsername() : "",
            'title'       => $ticket->getSubject(),
            'number'      => $ticket->getNumber(),
            'status'      => $status,
            'url'         => $cfg->getUrl()
        ];

        // Format the payload:
        $data_string = utf8_encode(json_encode($payload));

        try {
            // Setup curl
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
            );

            // Actually send the payload to webhook:
            if (curl_exec($ch) === false) {
                throw new \Exception($url . ' - ' . curl_error($ch));
            } else {
                $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($statusCode != '200') {
                    throw new \Exception(
                    'Error sending to: ' . $url
                    . ' Http code: ' . $statusCode
                    . ' curl-error: ' . curl_errno($ch));
                }
            }
        } catch (\Exception $e) {
            $ost->logError('Webhook posting issue!', $e->getMessage(), true);
            error_log('Error posting to Webhook. ' . $e->getMessage());
        } finally {
            curl_close($ch);
        }
    }

    /**
     * Fetches a ticket from a ThreadEntry
     *
     * @param ThreadEntry $entry
     * @return Ticket
     */
    function getTicket(ThreadEntry $entry) {
        $ticket_id = Thread::objects()->filter([
                    'id' => $entry->getThreadId()
                ])->values_flat('object_id')->first()[0];

        // Force lookup rather than use cached data..
        // This ensures we get the full ticket, with all
        // thread entries etc..
        return Ticket::lookup(array(
                    'ticket_id' => $ticket_id
        ));
    }
}
